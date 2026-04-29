<?php
// Postavljanje kolačića (naziv, vrijednost, vrijeme isteka - 1 sat, putanja)
setcookie("zadnja_vijest", "Uvod u PHP kolačiće", time() + 3600, "/");
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Novosti</title>
</head>
<body>
    <h1>Stranica s vijestima</h1>
    <p>Kolačić je uspješno postavljen!</p>
    <a href="index.php">Povratak na naslovnicu (ispis kolačića)</a>
</body>
</html>