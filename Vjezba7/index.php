<?php
$ispis = "";
$klasa = "";

if (isset($_POST['izracunaj'])) {
    // Spremanje ocjena u polje (Array)
    $ocjene = [
        "kolokvij1" => (int)$_POST['ocjena1'],
        "kolokvij2" => (int)$_POST['ocjena2']
    ];

    $o1 = $ocjene["kolokvij1"];
    $o2 = $ocjene["kolokvij2"];

    // Provjera uvjeta: ocjene moraju biti između 1 i 5
    if (($o1 < 1 || $o1 > 5) || ($o2 < 1 || $o2 > 5)) {
        $ispis = "Greška: Ocjene moraju biti u rasponu od 1 do 5.";
        $klasa = "negativno";
    } else {
        // Izračun prosjeka
        $prosjek = ($o1 + $o2) / 2;
        
        // Provjera ako je ijedan kolokvij negativan (1)
        if ($o1 == 1 || $o2 == 1) {
            $konacna_ocjena = 1;
            $ispis = "Prosjek: $prosjek <br> Konačna ocjena: $konacna_ocjena (jedan kolokvij je negativan)";
            $klasa = "negativno";
        } else {
            // Zaokruživanje prosjeka za konačnu ocjenu
            $konacna_ocjena = round($prosjek);
            $ispis = "Prosjek: $prosjek <br> <strong>Konačna ocjena: $konacna_ocjena</strong>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Prosjek Ocjena - Array</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Unos ocjena kolokvija</h2>
    
    <form method="POST" action="">
        <label for="ocjena1">I. kolokvij (1-5):</label>
        <input type="number" name="ocjena1" id="ocjena1" required min="1" max="5">
        
        <label for="ocjena2">II. kolokvij (1-5):</label>
        <input type="number" name="ocjena2" id="ocjena2" required min="1" max="5">
        
        <button type="submit" name="izracunaj">Izračunaj prosjek</button>
    </form>

    <?php if ($ispis != ""): ?>
        <div class="rezultat-box <?php echo $klasa; ?>">
            <?php echo $ispis; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>