<?php
// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';

$poruka = "";

// ==========================================
// FUNKCIONALNOST 1: BRISANJE VIJESTI (DELETE)
// ==========================================
if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    
    // Prvo možemo dohvatiti ime slike ako je želimo obrisati iz mape 'img'
    $query_img = "SELECT slika FROM vijesti WHERE id = $id";
    $result_img = mysqli_query($dbc, $query_img);
    if ($row_img = mysqli_fetch_array($result_img)) {
        $slika_za_brisati = 'img/' . $row_img['slika'];
        if (file_exists($slika_za_brisati) && !empty($row_img['slika'])) {
            unlink($slika_za_brisati); // Briše sliku s diska
        }
    }

    $query = "DELETE FROM vijesti WHERE id = $id";
    $result = mysqli_query($dbc, $query);
    
    if ($result) {
        $poruka = "<p style='color: #28a745; font-weight: bold; text-align: center;'>Vijest je uspješno obrisana!</p>";
    } else {
        $poruka = "<p style='color: #dc3545; font-weight: bold; text-align: center;'>Greška pri brisanju vijesti.</p>";
    }
}

// ==========================================
// FUNKCIONALNOST 2: IZMJENA VIJESTI (UPDATE)
// ==========================================
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $naslov = mysqli_real_escape_string($dbc, $_POST['title']);
    $sazetak = mysqli_real_escape_string($dbc, $_POST['about']);
    $tekst = mysqli_real_escape_string($dbc, $_POST['content']);
    $kategorija = mysqli_real_escape_string($dbc, $_POST['category']);
    
    // Provjera kvačice za arhivu (ako nije označena, u $_POST neće postojati, pa stavljamo 0)
    $arhiva = isset($_POST['archive']) ? 1 : 0;

    // Rukovanje slikom (ako je prenesena nova slika)
    if (!empty($_FILES['pphoto']['name'])) {
        $slika = $_FILES['pphoto']['name'];
        $target_dir = 'img/' . $slika;
        move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);
        
        // Upit s novom slikom
        $query = "UPDATE vijesti SET naslov='$naslov', sazetak='$sazetak', tekst='$tekst', 
                  kategorija='$kategorija', slika='$slika', arhiva='$arhiva' WHERE id=$id";
    } else {
        // Upit bez mijenjanja slike
        $query = "UPDATE vijesti SET naslov='$naslov', sazetak='$sazetak', tekst='$tekst', 
                  kategorija='$kategorija', arhiva='$arhiva' WHERE id=$id";
    }

    $result = mysqli_query($dbc, $query);
    if ($result) {
        $poruka = "<p style='color: #28a745; font-weight: bold; text-align: center;'>Vijest je uspješno ažurirana!</p>";
    } else {
        $poruka = "<p style='color: #dc3545; font-weight: bold; text-align: center;'>Greška pri ažuriranju vijesti.</p>";
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
        
        <h1 style="margin-bottom: 30px; text-align: center;">Upravljanje vijestima (Administracija)</h1>
        
        <?php echo $poruka; ?>

        <?php
        // Dohvaćanje svih vijesti iz baze kako bismo izgenerirali formu za svaku
        $query_all = "SELECT * FROM vijesti ORDER BY id DESC";
        $result_all = mysqli_query($dbc, $query_all);

        if (mysqli_num_rows($result_all) > 0) {
            while ($row = mysqli_fetch_array($result_all)) {
                ?>
                <div class="admin-form-block">
                    <form action="administrator.php" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                        <div class="admin-form-group">
                            <label for="title">Naslov vijesti:</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($row['naslov']); ?>" required>
                        </div>

                        <div class="admin-form-group">
                            <label for="about">Kratki sažetak:</label>
                            <textarea name="about" rows="3" required><?php echo htmlspecialchars($row['sazetak']); ?></textarea>
                        </div>

                        <div class="admin-form-group">
                            <label for="content">Sadržaj vijesti:</label>
                            <textarea name="content" rows="8" required><?php echo htmlspecialchars($row['tekst']); ?></textarea>
                        </div>

                        <div class="admin-form-group">
                            <label for="category">Kategorija:</label>
                            <select name="category" required>
                                <option value="vijesti" <?php if ($row['kategorija'] == 'vijesti') echo 'selected'; ?>>ZG Vijesti</option>
                                <option value="sport" <?php if ($row['kategorija'] == 'sport') echo 'selected'; ?>>ZG-Sport</option>
                                <option value="kultura" <?php if ($row['kategorija'] == 'kultura') echo 'selected'; ?>>Kultura & Đir</option>
                            </select>
                        </div>

                        <div class="admin-form-group">
                            <label for="pphoto">Slika (odaberite novu ako želite zamijeniti trenutnu):</label>
                            <input type="file" name="pphoto" accept="image/*">
                            <div style="margin-top: 10px;">
                                <small>Trenutna slika: <strong><?php echo htmlspecialchars($row['slika']); ?></strong></small><br>
                                <img src="img/<?php echo htmlspecialchars($row['slika']); ?>" alt="Trenutna slika" style="max-height: 80px; margin-top: 5px; border: 1px solid #ccc;">
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label>
                                <input type="checkbox" name="archive" value="1" <?php if ($row['arhiva'] == 1) echo 'checked'; ?>>
                                Arhiviraj ovu vijest (neće se prikazivati na početnoj i kategorijama)
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

    </main>

    <?php
    // Zatvaranje veze s bazom podataka na kraju stranice
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