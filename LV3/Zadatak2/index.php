<?php
// Postavke baze podataka
$host = 'localhost';
$db   = 'vjezbe_pwa';
$user = 'root';
$pass = '';

// Povezivanje na bazu
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Veza nije uspjela: " . $conn->connect_error);
}

$sql = "SELECT id, ime, prezime, spol, telefon, email, godine, hobi FROM korisnik";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Prikaz korisnika</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .blue { background-color: blue; color: black; }
        .red { background-color: red; color: black; }
        header { margin-bottom: 20px; }
    </style>
</head>
<body>

    <header>
        <p>GitHub repozitorij: <a href="https://github.com/Miikki10/programiranje_web_aplikacija">Miikki10 - Programiranje web aplikacija</a></p>
    </header>

    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>ime</th>
                <th>Prezime</th>
                <th>spol</th>
                <th>telefon</th>
                <th>email</th>
                <th>godine</th>
                <th>hobi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Logika za bojanje: mlađi od 33 = plava, ostali (33 i više) = crvena
                    $klasa = ($row["godine"] < 33) ? "blue" : "red";
                    
                    echo "<tr class='$klasa'>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["ime"] . "</td>";
                    echo "<td>" . $row["prezime"] . "</td>";
                    echo "<td>" . $row["spol"] . "</td>";
                    echo "<td>" . $row["telefon"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["godine"] . "</td>";
                    echo "<td>" . $row["hobi"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Nema podataka u tablici.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
$conn->close();
?>