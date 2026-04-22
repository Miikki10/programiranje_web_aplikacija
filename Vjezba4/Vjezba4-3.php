<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Zadatak str_word_count</title>
</head>
<body>

    <h2>Zadatak str_word_count</h2>
    <p>U zadatku se traži da se ispiše koliko je riječi u rečenici. Koristite naredbu <code>str_word_count</code></p>

    <form method="POST" action="">
        <label for="ulazni_niz">Ulazni niz:</label><br>
        <input type="text" id="ulazni_niz" name="ulazni_niz" style="width: 400px;" 
               value="<?php echo isset($_POST['ulazni_niz']) ? htmlspecialchars($_POST['ulazni_niz']) : ''; ?>">
        <br><br>
        <input type="submit" value="ispiši broj riječi">
    </form>

    <br>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Preuzimanje teksta iz forme
        $tekst = $_POST['ulazni_niz'];

        if (!empty($tekst)) {
            // Korištenje str_word_count funkcije
            $broj_rijeci = str_word_count($tekst);

            // Ispis rezultata
            echo "<strong>ulazni niz:</strong> " . htmlspecialchars($tekst) . " <strong>sadrži $broj_rijeci riječi.</strong>";
        } else {
            echo "Molimo unesite neki tekst.";
        }
    }
    ?>

</body>
</html>