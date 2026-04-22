<?php
// PHP LOGIKA NA POČETKU
$rezultat = "";

if (isset($_POST['operacija'])) {
    $broj1 = (float)$_POST['broj1'];
    $broj2 = (float)$_POST['broj2'];
    $operacija = $_POST['operacija'];

    switch ($operacija) {
        case '+':
            $izracun = $broj1 + $broj2;
            $rezultat = "Rezultat: $izracun";
            break;
        case '-':
            $izracun = $broj1 - $broj2;
            $rezultat = "Rezultat: $izracun";
            break;
        case '*':
            $izracun = $broj1 * $broj2;
            $rezultat = "Rezultat: $izracun";
            break;
        case '/':
            if ($broj2 != 0) {
                $izracun = $broj1 / $broj2;
                $rezultat = "Rezultat: $izracun";
            } else {
                $rezultat = "Greška: Dijeljenje s nulom!";
            }
            break;
        default:
            $rezultat = "Nepoznata operacija.";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator (Switch naredba)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="kalkulator-kontejner">
        <p>Kalkulator (Switch naredba)</p>
        
        <form method="POST" action="">
            <label>Upiši prvi broj *</label>
            <input type="number" name="broj1" step="any" required>
            
            <label>Upiši drugi broj *</label>
            <input type="number" name="broj2" step="any" required>
            
            <p>Rezultat: <?php echo $rezultat; ?></p>

            <div class="gumbi-grupa">
                <button type="submit" name="operacija" value="+">+</button>
                <button type="submit" name="operacija" value="-">-</button>
                <button type="submit" name="operacija" value="*">*</button>
                <button type="submit" name="operacija" value="/">/</button>
            </div>
        </form>
    </div>

</body>
</html>