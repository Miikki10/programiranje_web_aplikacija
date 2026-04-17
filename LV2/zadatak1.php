<?php
// Inicijalizacija zadane boje pozadine (bijela)
$bojaPozadine = "#ffffff";

// Provjera je li forma poslana putem POST metode
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Provjera je li checkbox označen i je li boja poslana
    // Koristimo isset() da izbjegnemo "Undefined index" grešku
    if (isset($_POST['primijeni']) && isset($_POST['boja'])) {
        $bojaPozadine = $_POST['boja'];
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Promjena boje pozadine</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>

<div class="kontejner">
    <form action="" method="post">
        <h3>Odaberite boju pozadine</h3>
        <br><br>
        <a href="https://github.com/Miikki10/programiranje_web_aplikacija.git">GitHub repozitorij</a>
        <br><br>
        <label for="boja">Boja:</label>
        <input type="color" id="boja" name="boja" value="<?php echo htmlspecialchars($bojaPozadine); ?>">
        <br><br>
        
        <input type="checkbox" id="primijeni" name="primijeni">
        <label for="primijeni">Potvrdi promjenu boje</label>
        <br><br>
        
        <button type="submit">Pošalji</button>
    </form>
</div>

</body>
</html>