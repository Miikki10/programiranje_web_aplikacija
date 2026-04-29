<?php
// session_start() je obavezan i ovdje da bismo pristupili podacima
session_start();

// Provjera postoji li podatak u sjednici
$ispis = "Sjednica je prazna ili podatak nije postavljen.";

if (isset($_SESSION['zadnja_vijest'])) {
    $ispis = $_SESSION['zadnja_vijest'];
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Ispis Sjednice - Index</title>
</head>
<body>
    <header>
        <h1>Početna stranica</h1>
    </header>
    <main>
        <h3>Sadržaj iz sjednice:</h3>
        <div style="padding: 15px; border: 2px solid green; display: inline-block;">
            <strong><?php echo $ispis; ?></strong>
        </div>
        <br><br>
        <p><a href="news.php">Vrati se na news.php (ponovno postavi podatak)</a></p>
    </main>
    <footer>
        <p>Vježba: Rad sa sjednicama u PHP-u</p>
    </footer>
</body>
</html>