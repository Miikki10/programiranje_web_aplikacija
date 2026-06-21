<?php
session_start();

// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';

$poruka = "";
$login_poruka = "";

// ==========================================
// FUNKCIONALNOST: ODJAVA (LOGOUT)
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['username']);
    unset($_SESSION['ime']);
    unset($_SESSION['level']);
    session_destroy();
    header("Location: administrator.php");
    exit();
}

// ==========================================
// FUNKCIONALNOST: PRIJAVA (LOGIN)
// ==========================================
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Inicijalizacija i priprema (Prepared Statement)
    $stmt = mysqli_stmt_init($dbc);
    $sql = "SELECT korisnicko_ime, lozinka, razina, ime FROM korisnik WHERE korisnicko_ime = ?";
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_array($result)) {
            if (password_verify($password, $row['lozinka'])) {
                $_SESSION['username'] = $row['korisnicko_ime'];
                $_SESSION['ime'] = $row['ime'];
                $_SESSION['level'] = $row['razina'];
            } else {
                $login_poruka = "Neispravno korisničko ime ili lozinka. Ako nemate račun, morate se <a href='registracija.php' style='color: #721c24; font-weight: bold;'>registrirati</a>.";
            }
        } else {
            $login_poruka = "Korisnik ne postoji u sustavu. Morate se prvo <a href='registracija.php' style='color: #721c24; font-weight: bold;'>registrirati</a>.";
        }
        mysqli_stmt_close($stmt);
    }
}

$is_logged_in = isset($_SESSION['username']);
$is_admin = isset($_SESSION['level']) && $_SESSION['level'] > 0;

// ==========================================
// SIGURNI PREPARED STATEMENTS ZA ADMINISTRATORA
// ==========================================
if ($is_logged_in && $is_admin) {

    // 1. BRISANJE VIJESTI (DELETE)
    if (isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        
        // Sigurno dohvaćanje slike prije brisanja
        $stmt_img = mysqli_stmt_init($dbc);
        $query_img = "SELECT slika FROM vijesti WHERE id = ?";
        
        if (mysqli_stmt_prepare($stmt_img, $query_img)) {
            mysqli_stmt_bind_param($stmt_img, "i", $id);
            mysqli_stmt_execute($stmt_img);
            
            // Pohrana rezultata u međuspremnik kako bismo koristili mysqli_stmt_num_rows()
            mysqli_stmt_store_result($stmt_img);
            
            if (mysqli_stmt_num_rows($stmt_img) > 0) {
                // Vezanje rezultata za varijable i dohvat
                mysqli_stmt_bind_result($stmt_img, $slika_ime);
                mysqli_stmt_fetch($stmt_img);
                
                $slika_za_brisati = 'img/' . $slika_ime;
                if (file_exists($slika_za_brisati) && !empty($slika_ime)) {
                    unlink($slika_za_brisati);
                }
            }
            mysqli_stmt_close($stmt_img);
        }

        // Sigurno brisanje zapisa iz baze
        $stmt_del = mysqli_stmt_init($dbc);
        $query_del = "DELETE FROM vijesti WHERE id = ?";
        
        if (mysqli_stmt_prepare($stmt_del, $query_del)) {
            mysqli_stmt_bind_param($stmt_del, "i", $id);
            $result = mysqli_stmt_execute($stmt_del);
            
            if ($result) {
                $poruka = "<p style='color: #28a745; font-weight: bold; text-align: center;'>Vijest je uspješno obrisana!</p>";
            } else {
                $poruka = "<p style='color: #dc3545; font-weight: bold; text-align: center;'>Greška pri brisanju vijesti.</p>";
            }
            mysqli_stmt_close($stmt_del);
        }
    }

    // 2. IZMJENA VIJESTI (UPDATE)
    if (isset($_POST['update'])) {
        $id = intval($_POST['id']);
        $naslov = trim($_POST['title']);
        $sazetak = trim($_POST['about']);
        $tekst = trim($_POST['content']);
        $kategorija = trim($_POST['category']);
        $arhiva = isset($_POST['archive']) ? 1 : 0;

        $stmt_upd = mysqli_stmt_init($dbc);

        if (!empty($_FILES['pphoto']['name'])) {
            $slika = $_FILES['pphoto']['name'];
            $target_dir = 'img/' . $slika;
            move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);
            
            // Upit s izmjenom slike
            $query_upd = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, slika=?, arhiva=? WHERE id=?";
            if (mysqli_stmt_prepare($stmt_upd, $query_upd)) {
                mysqli_stmt_bind_param($stmt_upd, "sssssii", $naslov, $sazetak, $tekst, $kategorija, $slika, $arhiva, $id);
                $result = mysqli_stmt_execute($stmt_upd);
            }
        } else {
            // Upit bez izmjene slike
            $query_upd = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=? WHERE id=?";
            if (mysqli_stmt_prepare($stmt_upd, $query_upd)) {
                mysqli_stmt_bind_param($stmt_upd, "ssssii", $naslov, $sazetak, $tekst, $kategorija, $arhiva, $id);
                $result = mysqli_stmt_execute($stmt_upd);
            }
        }

        if ($result) {
            $poruka = "<p style='color: #28a745; font-weight: bold; text-align: center;'>Vijest je uspješno ažurirana!</p>";
        } else {
            $poruka = "<p style='color: #dc3545; font-weight: bold; text-align: center;'>Greška pri ažuriranju vijesti.</p>";
        }
        mysqli_stmt_close($stmt_upd);
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracija — ZG Priče</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="main-header">
        <div class="logo">
            <span class="logo-text">ZG priče.</span>
        </div>
    </header>

    <nav class="main-nav">
        <ul>
            <li><a href="index.php">POČETNA</a></li>
            <li><a href="kategorija.php?id=vijesti">ZG VIJESTI</a></li>
            <li><a href="kategorija.php?id=sport">ZG-SPORT</a></li>
            <li><a href="kategorija.php?id=kultura">KULTURA & ĐIR</a></li>
            <li><a href="administrator.php" class="active">ADMINISTRACIJA</a></li>
        </ul>
    </nav>

    <main class="container" style="padding-top: 30px; padding-bottom: 50px;">
        
        <?php if (!$is_logged_in): ?>
            <section class="form-section" style="max-width: 400px; margin: 40px auto; padding: 20px; border: 1px solid #ccc; border-radius: 4px;">
                <h2 style="text-align: center; margin-bottom: 20px;">Prijava u administraciju</h2>
                
                <?php if (!empty($login_poruka)): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 4px; font-size: 0.95em; line-height: 1.4; border: 1px solid #f5c6cb;">
                        <?php echo $login_poruka; ?>
                    </div>
                <?php endif; ?>

                <form action="administrator.php" method="POST">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Korisničko ime:</label>
                        <input type="text" name="username" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Lozinka:</label>
                        <input type="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>
                    <button type="submit" name="login" style="background-color: #28a745; color: white; border: none; padding: 10px; cursor: pointer; font-weight: bold; width: 100%;">Prijava</button>
                    
                    <div style="margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 15px; font-size: 0.95em;">
                        Nemate korisnički račun? 
                        <a href="registracija.php" style="color: #007bff; text-decoration: none; font-weight: bold;">Registrirajte se ovdje</a>
                    </div>
                </form>
            </section>

        <?php elseif ($is_logged_in && !$is_admin): ?>
            <div style="max-width: 600px; margin: 50px auto; text-align: center; padding: 30px; border: 1px solid #ffeeba; background-color: #fff3cd; color: #856404; border-radius: 4px;">
                <h2>Pristup odbijen!</h2>
                <p style="margin: 15px 0; font-size: 1.1em;">
                    Bok <strong><?php echo htmlspecialchars($_SESSION['ime']); ?></strong>! Uspješno ste prijavljeni, ali niste administrator.
                </p>
                <p><a href="administrator.php?action=logout" style="background-color: #dc3545; color: white; padding: 8px 15px; text-decoration: none; font-weight: bold; border-radius: 4px; display: inline-block; margin-top: 15px;">Odjavi se</a></p>
            </div>

        <?php else: ?>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: #e2e3e5; padding: 12px 20px; border-radius: 4px; border: 1px solid #d6d8db;">
                <span>Dobrodošli natrag, administrator <strong><?php echo htmlspecialchars($_SESSION['ime']); ?></strong>!</span>
                <div>
                    <a href="unos.php" style="background-color: #007bff; color: white; padding: 5px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.9em; margin-right: 10px;">Unos nove vijesti</a>
                    <a href="administrator.php?action=logout" style="background-color: #6c757d; color: white; padding: 5px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.9em;">Odjava</a>
                </div>
            </div>

            <h1 style="margin-bottom: 30px; text-align: center;">Upravljanje vijestima (Administracija)</h1>
            
            <?php echo $poruka; ?>

            <?php
            // Za potrebe ispisa liste koristi se običan fiksni query jer nema korisničkog unosa
            $query_all = "SELECT * FROM vijesti ORDER BY id DESC";
            $result_all = mysqli_query($dbc, $query_all);

            if (mysqli_num_rows($result_all) > 0) {
                while ($row = mysqli_fetch_array($result_all)) {
                    ?>
                    <div class="admin-form-block">
                        <form action="administrator.php" method="POST" enctype="multipart/form-data">
                            
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="admin-form-group">
                                <label>Naslov vijesti:</label>
                                <input type="text" name="title" value="<?php echo htmlspecialchars($row['naslov']); ?>" required>
                            </div>

                            <div class="admin-form-group">
                                <label>Kratki sažetak:</label>
                                <textarea name="about" rows="3" required><?php echo htmlspecialchars($row['sazetak']); ?></textarea>
                            </div>

                            <div class="admin-form-group">
                                <label>Sadržaj vijesti:</label>
                                <textarea name="content" rows="8" required><?php echo htmlspecialchars($row['tekst']); ?></textarea>
                            </div>

                            <div class="admin-form-group">
                                <label>Kategorija:</label>
                                <select name="category" required>
                                    <option value="vijesti" <?php if ($row['kategorija'] == 'vijesti') echo 'selected'; ?>>ZG Vijesti</option>
                                    <option value="sport" <?php if ($row['kategorija'] == 'sport') echo 'selected'; ?>>ZG-Sport</option>
                                    <option value="kultura" <?php if ($row['kategorija'] == 'kultura') echo 'selected'; ?>>Kultura & Đir</option>
                                </select>
                            </div>

                            <div class="admin-form-group">
                                <label>Slika:</label>
                                <input type="file" name="pphoto" accept="image/*">
                                <div style="margin-top: 10px;">
                                    <small>Trenutna slika: <strong><?php echo htmlspecialchars($row['slika']); ?></strong></small><br>
                                    <img src="img/<?php echo htmlspecialchars($row['slika']); ?>" alt="Trenutna slika" style="max-height: 80px; margin-top: 5px; border: 1px solid #ccc;">
                                </div>
                            </div>

                            <div class="admin-form-group">
                                <label>
                                    <input type="checkbox" name="archive" value="1" <?php if ($row['arhiva'] == 1) echo 'checked'; ?>>
                                    Arhiviraj ovu vijest
                                </label>
                            </div>

                            <div style="margin-top: 20px;">
                                <button type="submit" name="update" class="btn-admin btn-update">Izmjeni (Update)</button>
                                <button type="submit" name="delete" class="btn-admin btn-delete" onclick="return confirm('Jeste li sigurni da želite trajno obrisati ovu vijest?');">Izbriši (Delete)</button>
                            </div>

                        </form>
                    </div>
                    <?php
                }
            } else {
                echo '<p style="text-align: center;">U bazi trenutno nema unesenih vijesti.</p>';
            }
            ?>
        <?php endif; ?>

    </main>

    <?php
    mysqli_close($dbc);
    ?>

    <footer class="main-footer">
        <div class="footer-top">
            <p>Nezavisni blog o zbivanjima u gradu Zagrebu.</p>
        </div>
        <div class="footer-bottom">
            <p>Autor: Bruno Miličević | E-mail: <a href="mailto:bmilicev1@tvz.hr">bmilicev1@tvz.hr</a> | Godina: 2026.</p>
        </div>
    </footer>

</body>
</html>