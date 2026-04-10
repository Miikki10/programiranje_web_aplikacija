<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Zadatak2</title>
</head>
<body>
    <form method="GET">
        <label>Ocjena 1:</label> <input type="number" step="0.1" name="ocjena1" required><br>
        <label>Ocjena 2:</label> <input type="number" step="0.1" name="ocjena2" required><br>
        <label>Ocjena 3:</label> <input type="number" step="0.1" name="ocjena3" required><br>
        <label>Ocjena 4:</label> <input type="number" step="0.1" name="ocjena4" required><br>
        <button type="submit">Izračunaj prosjek</button>
    </form>
</body>
</html>

<?php
if (isset($_GET['ocjena1'], $_GET['ocjena2'], $_GET['ocjena3'], $_GET['ocjena4'])) {

    $ocjena_predmet1 = (float)$_GET['ocjena1'];
    $ocjena_predmet2 = (float)$_GET['ocjena2'];
    $ocjena_predmet3 = (float)$_GET['ocjena3'];
    $ocjena_predmet4 = (float)$_GET['ocjena4'];

    $prosjek = ($ocjena_predmet1 + $ocjena_predmet2 + $ocjena_predmet3 + $ocjena_predmet4) / 4;

    if ($prosjek < 1.5) {
        $opis = "nedovoljan";
    } else {
        if ($prosjek < 2.5) {
            $opis = "dovoljan";
        } else {
            if ($prosjek < 3.5) {
                $opis = "dobar";
            } else {
                if ($prosjek < 4.5) {
                    $opis = "vrlo dobar";
                } else {
                    $opis = "odličan";
                }
            }
        }
    }

    echo "<h3>Vaš prosjek je $prosjek ($opis)</h3>";
}
else{
    echo "<h3>Molimo unesite sve ocjene.</h3>";
}
?>