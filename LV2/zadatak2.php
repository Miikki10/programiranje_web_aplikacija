<?php
// 1. PHP LOGIKA NA POČETKU
$brojRedova = 0;
$brojKolona = 0;
$prikaziTablicu = false;

// Provjera je li forma poslana
if (isset($_POST['submit'])) {
    // Dohvaćanje podataka uz provjeru postojanja indeksa (isset)
    $brojRedova = isset($_POST['redovi']) ? (int)$_POST['redovi'] : 0;
    $brojKolona = isset($_POST['kolone']) ? (int)$_POST['kolone'] : 0;

    // Ako su uneseni ispravni brojevi, dajemo dopuštenje za ispis
    if ($brojRedova > 0 && $brojKolona > 0) {
        $prikaziTablicu = true;
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <link rel="stylesheet" href="style2.css">
    <meta charset="UTF-8">
    <title>Generator HTML Tablice</title>
</head>
<body>
    <h2>Generator HTML Tablice</h2>
    <br><br>
    <h3><a href="https://github.com/Miikki10/programiranje_web_aplikacija.git">GitHub repozitorij</a></h3>
    <br><br>

    <div class="forma-kontejner">
        <form action="" method="post">
            <label for="redovi">Upišite broj redaka</label>
            <input type="number" id="redovi" name="redovi" value="<?php echo $brojRedova > 0 ? $brojRedova : ''; ?>" required>
            
            <label for="kolone">Upišite broj kolona</label>
            <input type="number" id="kolone" name="kolone" value="<?php echo $brojKolona > 0 ? $brojKolona : ''; ?>" required>
            
            <button type="submit" name="submit">NAPRAVI TABLICU</button>
        </form>
    </div>

    <?php if ($prikaziTablicu): ?>
        <p>Ispis tablice:</p>
        <table>
            <?php for ($i = 0; $i < $brojRedova; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < $brojKolona; $j++): ?>
                        <td>&nbsp;</td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>
    <?php endif; ?>

</body>
</html>