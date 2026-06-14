<?php
$poruka = ""; 


if (isset($_POST['submit'])) {
    

    $host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "fakultet_baza";

    $dbc = mysqli_connect($host, $db_user, $db_pass, $db_name);

    if (!$dbc) {
        die("Pogreška pri spajanju na bazu podataka: " . mysqli_connect_error());
    }

    // 2. Preuzimanje podataka iz forme i osnovno čišćenje praznih prostora
    $sifra = intval($_POST['sifra']); // Pretvaramo u int radi dodatne sigurnosti
    $naziv = trim($_POST['naziv']);
    $ects = intval($_POST['ects']);


    $query = "INSERT INTO predmeti (sifra, naziv, ects) VALUES (?, ?, ?)";
    

    $stmt = mysqli_prepare($dbc, $query);
    
    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "isi", $sifra, $naziv, $ects);
        
        // Izvršavanje upita
        if (mysqli_stmt_execute($stmt)) {
            $poruka = "<span style='color: green; font-weight: bold;'>Predmet je uspješno unesen u bazu podataka!</span>";
        } else {
            $poruka = "<span style='color: red;'>Greška prilikom upisa u bazu: " . mysqli_stmt_error($stmt) . "</span>";
        }
        
        // Zatvaranje statementa
        mysqli_stmt_close($stmt);
    } else {
        $poruka = "<span style='color: red;'>Greška pri pripremi upita: " . mysqli_error($dbc) . "</span>";
    }

    // Zatvaranje veze s bazom
    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Unos Predmeta</title>
</head>
<body>

    <h2>Unos novog predmeta</h2>
    
    <form action="unos_predmeta.php" method="POST">
        <label for="sifra">Šifra predmeta (broj):</label><br>
        <input type="number" id="sifra" name="sifra" required><br><br>
        
        <label for="naziv">Naziv predmeta:</label><br>
        <input type="text" id="naziv" name="naziv" required><br><br>
        
        <label for="ects">Broj ECTS bodova:</label><br>
        <input type="number" id="ects" name="ects" required><br><br>
        
        <button type="submit" name="submit">Spremi predmet</button>
    </form>

    <?php if (!empty($poruka)): ?>
        <div style="margin-top: 20px;">
            <?php echo $poruka; ?>
        </div>
    <?php endif; ?>

    <hr style="margin-top: 40px;">
    <div>
        <p>Projekt je dostupan na: 
            <a href="https://github.com/Miikki10/programiranje_web_aplikacija" target="_blank" rel="noopener noreferrer">
                GitHub Repozitorij
            </a>
        </p>
    </div>

</body>
</html>