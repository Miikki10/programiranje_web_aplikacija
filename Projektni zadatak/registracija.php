<?php
// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';

// Definiranje varijabli za poruke o greškama ili uspjehu
$msg = "";
$msg_class = "";

// 2. Obrada podataka nakon slanja forme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Čišćenje unosa od potencijalnih zlonamjernih znakova (XSS i SQL Injection zaštita)
    $ime = mysqli_real_escape_string($dbc, trim($_POST['ime']));
    $prezime = mysqli_real_escape_string($dbc, trim($_POST['prezime']));
    $korisnicko_ime = mysqli_real_escape_string($dbc, trim($_POST['korisnicko_ime']));
    $lozinka = $_POST['lozinka'];
    $lozinka_potvrda = $_POST['lozinka_potvrda'];
    $razina = 0; // Zadana razina za sve nove korisnike

    // Provjera jesu li sva polja popunjena
    if (empty($ime) || empty($prezime) || empty($korisnicko_ime) || empty($lozinka) || empty($lozinka_potvrda)) {
        $msg = "Sva polja su obavezna za unos.";
        $msg_class = "error-msg";
    } 
    // Provjera podudaraju li se lozinke
    elseif ($lozinka !== $lozinka_potvrda) {
        $msg = "Lozinke se ne podudaraju.";
        $msg_class = "error-msg";
    } 
    else {
        // Provjera postoji li već korisnik s istim korisničkim imenom
        $sql_check = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt_check = mysqli_prepare($dbc, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $korisnicko_ime);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $msg = "Korisničko ime već postoji. Molimo odaberite drugo.";
            $msg_class = "error-msg";
            mysqli_stmt_close($stmt_check);
        } else {
            mysqli_stmt_close($stmt_check);

            // Kriptiranje lozinke algoritmom PASSWORD_BCRYPT (koristi CRYPT_BLOWFISH pod haubom)
            $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);

            // Upis novog korisnika u bazu pomoću pripremljenih upita (Prepared Statements)
            $sql_insert = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($dbc, $sql_insert);
            
            if ($stmt_insert) {
                mysqli_stmt_bind_param($stmt_insert, "ssssi", $ime, $prezime, $korisnicko_ime, $hashed_password, $razina);
                
                if (mysqli_stmt_execute($stmt_insert)) {
                    $msg = "Registracija je uspješno provedena! Sada se možete prijaviti.";
                    $msg_class = "success-msg";
                } else {
                    $msg = "Došlo je do greške prilikom registracije. Pokušajte ponovno.";
                    $msg_class = "error-msg";
                }
                mysqli_stmt_close($stmt_insert);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija — ZG Priče</title>
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
            <li><a href="administrator.php">ADMINISTRACIJA</a></li>
        </ul>
    </nav>

    <main class="container">
        <section class="form-section" style="max-width: 500px; margin: 40px auto; padding: 20px;">
            <h2 class="section-title" style="margin-bottom: 20px;">Registracija novog korisnika</h2>
            
            <?php if (!empty($msg)): ?>
                <div class="<?php echo $msg_class; ?>" style="padding: 10px; margin-bottom: 20px; border-radius: 4px; font-weight: bold; <?php echo $msg_class === 'error-msg' ? 'background-color: #f8d7da; color: #721c24;' : 'background-color: #d4edda; color: #155724;'; ?>">
                    <?php echo htmlspecialchars($msg); ?>
                </div>
            <?php endif; ?>

            <form action="registracija.php" method="POST" class="reg-form">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Ime:</label>
                    <input type="text" name="ime" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Prezime:</label>
                    <input type="text" name="prezime" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Korisničko ime:</label>
                    <input type="text" name="korisnicko_ime" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Lozinka:</label>
                    <input type="password" name="lozinka" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Ponovite lozinku:</label>
                    <input type="password" name="lozinka_potvrda" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <button type="submit" style="background-color: #0056b3; color: white; border: none; padding: 10px 20px; cursor: pointer; font-weight: bold; width: 100%;">Registriraj se</button>
            </form>
        </section>
    </main>

    <?php
    // Zatvaranje veze s bazom podataka
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