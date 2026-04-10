<?php


    $moje_godine = $_GET["godine"];

    $mjeseci = $moje_godine * 12;
    $dana = $moje_godine * 365;


    echo "$moje_godine godina ima $mjeseci mjeseci i $dana dana.";

?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak1</title>
</head>
<body>
    <form>
        <label for="godine">Unesite svoje godine:</label>
        <input type="number" id="godine" name="godine" value="<?php echo isset($_GET['godine']) ? htmlspecialchars($_GET['godine']) : ''; ?>" required>
        <button type="submit">Izračunaj</button>
    </form>
</body>
</html>