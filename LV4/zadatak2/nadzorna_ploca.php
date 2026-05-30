<?php
// Nastavak session-a kako bismo imali pristup varijablama
session_start();

// Sigurnosna provjera: Ako session varijabla ne postoji, korisnik se nije prijavio
if (!isset($_SESSION['korisnik'])) {
    die("Pristup odbijen. Molimo <a href='prijava.php'>prijavite se</a>.");
}

$korisnicko_ime = $_SESSION['korisnik'];
$razina = $_SESSION['razina'];
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Nadzorna Ploča</title>
</head>
<body>

    <h2>Status Prijave</h2>

    <div style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">
        <?php
        // Provjera razine dozvole iz sessiona i ispis poruke
        if ($razina == 2) {
            echo "Dobro došli $korisnicko_ime. Vaša razina je administrator.";
        } else {
            echo "Dobro došli $korisnicko_ime.";
        }
        ?>
    </div>

    <p><a href="prijava.php">Povratak na prijavu</a></p>

    <hr style="margin-top: 30px;">
    <div>
        <p>Projekt je dostupan na: 
            <a href="https://github.com/Miikki10/programiranje_web_aplikacija" target="_blank" rel="noopener noreferrer">
                GitHub Repozitorij
            </a>
        </p>
    </div>

</body>
</html>