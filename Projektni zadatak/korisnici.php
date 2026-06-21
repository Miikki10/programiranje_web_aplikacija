<?php
session_start();

// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';

$poruka = "";

$is_logged_in = isset($_SESSION['username']);
$is_admin = isset($_SESSION['level']) && $_SESSION['level'] > 0;

// SIGURNOSNA PROVJERA: Ako korisnik nije ulogiran ili nije admin, nema pristup!
if (!$is_logged_in || !$is_admin) {
    header("Location: administrator.php");
    exit();
}

// ==========================================
// FUNKCIONALNOST: AŽURIRANJE PRAVA KORISNIKA
// ==========================================
if (isset($_POST['update_users'])) {
    $current_admin = $_SESSION['username'];
    
    // Dohvaćamo sve ID-ove osim trenutno ulogiranog administratora
    $query_u = "SELECT id FROM korisnik WHERE korisnicko_ime != ?";
    $stmt_u = mysqli_stmt_init($dbc);
    
    if (mysqli_stmt_prepare($stmt_u, $query_u)) {
        mysqli_stmt_bind_param($stmt_u, "s", $current_admin);
        mysqli_stmt_execute($stmt_u);
        $res_u = mysqli_stmt_get_result($stmt_u);
        
        $stmt_upd_user = mysqli_stmt_init($dbc);
        $query_upd_user = "UPDATE korisnik SET razina = ? WHERE id = ?";
        
        if (mysqli_stmt_prepare($stmt_upd_user, $query_upd_user)) {
            while ($user_row = mysqli_fetch_array($res_u)) {
                $user_id = $user_row['id'];
                // Ako je ID u polju označenih kvačica, razina postaje 1, inače je 0
                $nova_razina = (isset($_POST['admin_users']) && in_array($user_id, $_POST['admin_users'])) ? 1 : 0;
                
                mysqli_stmt_bind_param($stmt_upd_user, "ii", $nova_razina, $user_id);
                mysqli_stmt_execute($stmt_upd_user);
            }
            $poruka = "<p style='color: #28a745; font-weight: bold; text-align: center; margin-bottom: 20px;'>Prava korisnika su uspješno ažurirana!</p>";
            mysqli_stmt_close($stmt_upd_user);
        }
        mysqli_stmt_close($stmt_u);
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje korisnicima — ZG Priče</title>
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
        
        <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 4px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Upravljanje pravima korisnika</h2>
                <a href="administrator.php" style="text-decoration: none; color: #007bff; font-weight: bold;">&larr; Povratak na administraciju vijesti</a>
            </div>

            <?php echo $poruka; ?>

            <form action="korisnici.php" method="POST">
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; text-align: left;">
                    <thead>
                        <tr style="background-color: #f2f2f2; border-bottom: 2px solid #ddd;">
                            <th style="padding: 10px;">Ime</th>
                            <th style="padding: 10px;">Prezime</th>
                            <th style="padding: 10px;">Korisničko ime</th>
                            <th style="padding: 10px; text-align: center;">Administrator (Kvačica = DA)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $current_user = $_SESSION['username'];
                        // Dohvati sve korisnike OSIM samog sebe
                        $query_users = "SELECT id, ime, prezime, korisnicko_ime, razina FROM korisnik WHERE korisnicko_ime != ?";
                        $stmt_users = mysqli_stmt_init($dbc);

                        if (mysqli_stmt_prepare($stmt_users, $query_users)) {
                            mysqli_stmt_bind_param($stmt_users, "s", $current_user);
                            mysqli_stmt_execute($stmt_users);
                            $result_users = mysqli_stmt_get_result($stmt_users);

                            if (mysqli_num_rows($result_users) > 0) {
                                while ($user = mysqli_fetch_array($result_users)) {
                                    ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 10px;"><?php echo htmlspecialchars($user['ime']); ?></td>
                                        <td style="padding: 10px;"><?php echo htmlspecialchars($user['prezime']); ?></td>
                                        <td style="padding: 10px;"><strong><?php echo htmlspecialchars($user['korisnicko_ime']); ?></strong></td>
                                        <td style="padding: 10px; text-align: center;">
                                            <input type="checkbox" name="admin_users[]" value="<?php echo $user['id']; ?>" <?php if ($user['razina'] > 0) echo 'checked'; ?> style="transform: scale(1.2); cursor: pointer;">
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="4" style="padding: 15px; text-align: center;">Nema drugih registriranih korisnika u bazi.</td></tr>';
                            }
                            mysqli_stmt_close($stmt_users);
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" name="update_users" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer; font-weight: bold; border-radius: 4px; float: right;">Spremi promjene</button>
                <div style="clear: both;"></div>
            </form>
        </div>

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