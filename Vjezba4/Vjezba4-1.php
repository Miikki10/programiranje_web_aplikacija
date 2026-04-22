<?php
// 1. Definiramo polje automobila
$cars = array("Audi", "BMW", "Renault", "Citroen");

// 2. Provjeravamo je li forma poslana
$selectedCar = "";
if (isset($_POST['car_choice'])) {
    $selectedCar = $_POST['car_choice'];
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Vježba 4-1</title>
</head>
<body>

    <h3>Označi vozilo:</h3>
    <form method="POST" action="">
        <?php
        // Dinamičko generiranje radio gumba pomoću foreach petlje
        foreach ($cars as $car) {
            echo '<input type="radio" name="car_choice" value="' . $car . '"> ' . $car . '<br>';
        }
        ?>
        <br>
        <button type="submit">POŠALJI</button>
    </form>

    <hr>

    <?php
    // 3. Ispis rezultata nakon slanja forme
    if ($selectedCar != "") {
        echo "<p>Vaš izbor je: <strong>$selectedCar</strong></p>";
        
        echo "<ul>";
        foreach ($cars as $car) {
            // Ako je trenutni auto onaj koji je korisnik odabrao, podebljamo ga
            if ($car == $selectedCar) {
                echo "<li><strong>$car (ODABRANO)</strong></li>";
            } else {
                echo "<li>$car</li>";
            }
        }
        echo "</ul>";
    }
    ?>

</body>
</html>