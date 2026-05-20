<?php
// 1. Postavke za spajanje na bazu (proizvoljne prema zadatku)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vjezbe_pwa";

// 2. Kreiranje konekcije
$conn = new mysqli($servername, $username, $password, $dbname);

// 3. Provjera konekcije
if ($conn->connect_error) {
    die("Konekcija nije uspjela: " . $conn->connect_error);
}

// 4. Prikupljanje podataka iz forme (uz pretpostavku da su name atributi u formi odgovarajući)
// Koristimo provjeru 'isset' da skripta ne baca grešku ako se pokrene direktno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ime = $_POST['ime_zaposlenika'];
    $prezime = $_POST['prezime_zaposlenika'];
    $oib = $_POST['OIB'];
    $email = $_POST['e_mail'];

    // 5. Priprema SQL upita
    // 'id' ne navodimo u INSERT-u jer je postavljen na 'auto increment'
    $sql = "INSERT INTO Zaposlenik (ime_zaposlenika, prezime_zaposlenika, OIB, e_mail)
            VALUES ('$ime', '$prezime', '$oib', '$email')";

    // 6. Izvršavanje upita i provjera uspješnosti
    if ($conn->query($sql) === TRUE) {
        echo "Novi zaposlenik je uspješno spremljen u bazu!";
    } else {
        echo "Greška prilikom spremanja: " . $conn->error;
    }
}

// 7. Zatvaranje konekcije
$conn->close();
?>