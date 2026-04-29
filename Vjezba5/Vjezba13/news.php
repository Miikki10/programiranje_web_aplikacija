<?php
// session_start() mora biti pozvan prije bilo kakvog HTML ispisa
session_start();

// Postavljanje podatka u sjednicu
$_SESSION['zadnja_vijest'] = "Ovo je vijest spremljena u session!";
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Inicijalizacija Sjednice - Novosti</title>
</head>
<body>
    <header>
        <h1>Novosti</h1>
    </header>
    <main>
        <p>Podatak je uspješno spremljen u sjednicu.</p>
        <p><a href="index.php">Pogledaj ispis na početnoj stranici (index.php)</a></p>
    </main>
</body>
</html>