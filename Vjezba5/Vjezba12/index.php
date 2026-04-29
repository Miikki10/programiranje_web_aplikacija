<?php
// Dohvaćanje vrijednosti kolačića ako postoji
$vrijednost = "Kolačić nije postavljen.";

if(isset($_COOKIE["zadnja_vijest"])) {
    $vrijednost = $_COOKIE["zadnja_vijest"];
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Početna stranica</title>
</head>
<body>
    <header>
        <h2>Vježba 12: PHP Kolačići</h2>
    </header>
    
    <main>
        <h3>Zadnja posjećena vijest:</h3>
        <div style="border: 1px solid #ccc; padding: 10px; width: fit-content;">
            <strong><?php echo $vrijednost; ?></strong>
        </div>
        <br>
        <a href="news.php">Idi na stranicu vijesti (postavi kolačić)</a>
    </main>

    <footer>
        <p>Copyright © 2024 - Vježba 12</p>
    </footer>
</body>
</html>