<?php
// Pokretanje session-a na samom početku
session_start();

$poruka = ""; // Varijabla za ispis poruke korisniku

// Provjera je li forma poslana
if (isset($_POST['submit'])) {
    
    // Spajanje na bazu podataka
    $host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "pwa_lv4";

    $dbc = mysqli_connect($host, $db_user, $db_pass, $db_name);

    if (!$dbc) {
        die("Pogreška pri spajanju na bazu podataka: " . mysqli_connect_error());
    }

    $username = trim($_POST['korisnicko_ime']);
    $password = $_POST['lozinka'];

    // Dohvaćanje korisnika iz baze preko pripremljenog upita
    $query = "SELECT korisnicko_ime, lozinka, razina_dozvole FROM users WHERE korisnicko_ime = ?";
    $stmt = mysqli_prepare($dbc, $query);
    
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Ako korisnik postoji u bazi
    if ($row = mysqli_fetch_assoc($result)) {
        
        // Provjera lozinke pomoću password_verify
        if (password_verify($password, $row['lozinka'])) {
            
            // Postavljanje SESSION varijabli nakon uspješne prijave
            $_SESSION['korisnik'] = $row['korisnicko_ime'];
            $_SESSION['razina'] = $row['razina_dozvole'];

            // Provjera je li administrator (npr. razina 2 je admin)
            if ($_SESSION['razina'] == 2) {
                $poruka = "Dobro došli. Vaša razina je administrator. <a href='nadzorna_ploca.php'>NEXT</a>";
            } else {
                $poruka = "Dobro došli. <a href='nadzorna_ploca.php'>NEXT</a>";
            }
            
        } else {
            $poruka = "<span style='color:red;'>Pogrešna lozinka!</span>";
        }
    } else {
        $poruka = "<span style='color:red;'>Korisnik ne postoji!</span>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Prijava Korisnika</title>
</head>
<body>

    <h2>Prijava u sustav</h2>
    <form action="prijava.php" method="POST">
        <label for="username">Korisničko ime:</label><br>
        <input type="text" id="username" name="korisnicko_ime" required><br><br>
        
        <label for="password">Lozinka:</label><br>
        <input type="password" id="password" name="lozinka" required><br><br>
        
        <button type="submit" name="submit">Prijavi se</button>
    </form>

    <?php if (!empty($poruka)): ?>
        <div style="margin-top: 15px; font-weight: bold;">
            <?php echo $poruka; ?>
        </div>
    <?php endif; ?>

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