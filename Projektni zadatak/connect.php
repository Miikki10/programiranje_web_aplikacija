<?php
// Definirovanje parametara za spajanje na bazu podataka
$servername = "localhost";
$username = "root";       // Zadano korisničko ime u XAMPP-u
$password = "";           // Lozinka je u XAMPP-u zadano prazna
$basename = "zg_price";   // Naziv baze podataka koju ste kreirali

// 1. Uspostavljanje veze s bazom podataka
$dbc = mysqli_connect($servername, $username, $password, $basename);

// 2. Provjera uspješnosti spajanja
if (!$dbc) {
    die("Pogreška pri spajanju na MySQL bazu podataka: " . mysqli_connect_error());
}

// 3. Postavljanje ispravnog skupa znakova za hrvatski jezik (UTF-8)
mysqli_set_charset($dbc, "utf8mb4");
?>