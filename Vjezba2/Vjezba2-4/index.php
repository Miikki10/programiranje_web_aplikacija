<?php
// vjezba1d.php — Logika na početku
$naslov = "PHP dokument — vježba2-4 - izračun varijable c";
$autor  = "Bruno Miličević";
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($naslov); ?></title>
</head>
<body>

    <form method="POST" action="">
        <label for="a">Vrijednost a:</label>
        <input type="number" name="a" id="a" required>
        <br><br>
        
        <label for="b">Vrijednost b:</label>
        <input type="number" name="b" id="b" required>
        <br><br>
        
        <input type="submit" name="izracunaj" value="Pošalji">
    </form>

    <hr>

    <?php
    if (isset($_POST['izracunaj'])) {
        // Dohvaćanje podataka iz forme
        $a = $_POST['a'];
        $b = $_POST['b'];

        // Izračun prema formuli: c = (3a - b) / 2
        $c = (3 * $a - $b) / 2;

        // Prikaz rezultata
        echo "<h3>Rezultat:</h3>";
        echo "Za a = $a i b = $b, vrijednost <strong>c iznosi: $c</strong>";
    }
    ?>

</body>
</html>