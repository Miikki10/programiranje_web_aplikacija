<?php
// Spajanje na bazu
$con = mysqli_connect("localhost", "root", "", "vjezbe_pwa");

// Dohvat podatka iz forme
$unos = mysqli_real_escape_string($con, $_POST['unos']);

// SQL upit za pretraživanje (koristeći LIKE za djelomično podudaranje)
$query = "SELECT name, lastname FROM users 
          WHERE name LIKE '$unos%' OR lastname LIKE '$unos%'";

$result = mysqli_query($con, $query);

// Ispis rezultata
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        echo "<p>" . $row['name'] . " " . $row['lastname'] . "</p>";
    }
} else {
    echo "Nema pronađenih korisnika.";
}

mysqli_close($con);
?>