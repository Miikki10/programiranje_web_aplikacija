<?php
// PHP LOGIKA NA POČETKU
$poruka = "";
$zamisljeniBroj = null;

if (isset($_POST['posalji'])) {
    $uneseniBroj = (int)$_POST['korisnikov_broj'];
    $zamisljeniBroj = rand(1, 9);

    if ($uneseniBroj === $zamisljeniBroj) {
        $poruka = "<div class='rezultat pogodak'>Pogodak, probaj ponovo!</div>";
    } else {
        $poruka = "<div class='rezultat promasaj'>Krivo, probaj ponovo!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Igra (pogodi broj)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h3>Igra (pogodi broj)</h3>
    
    <form method="POST" action="">
        <label for="broj">Upiši jedan broj od 1 do 9:</label>
        <input type="number" name="korisnikov_broj" id="broj" min="1" max="9" required>
        <br><br>
        <input type="submit" name="posalji" value="Pogodi!">
    </form>

    <?php 
    // ISPIS REZULTATA ISPOD FORME
    if ($zamisljeniBroj !== null) {
        echo $poruka;
        echo "<div class='info'>Zamišljeni broj je $zamisljeniBroj</div>";
    }
    ?>

</body>
</html>