<?php
// Uključivanje pomoćne skripte za spajanje na bazu podataka
include 'connect.php';

// Prihvat tekstualnih podataka iz forme uz provjeru postojanja
if (isset($_POST['title'])) {
    $title = $_POST['title'];
} else {
    $title = "Nije unesen naslov";
}

if (isset($_POST['about'])) {
    $about = $_POST['about'];
} else {
    $about = "";
}

if (isset($_POST['content'])) {
    $content = $_POST['content'];
} else {
    $content = "";
}

if (isset($_POST['category'])) {
    $category = $_POST['category'];
} else {
    $category = "vijesti";
}

// Ispravan prihvat i spremanje datoteke (slike) na server
if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] == 0) {
    $image = $_FILES['pphoto']['name']; // Uzimamo naziv slike (npr. slika.jpg)
    $target = "img/" . basename($image); // Putanja do mape na serveru
    
    // Premještanje datoteke iz privremenog foldera u mapu "img"
    move_uploaded_file($_FILES['pphoto']['tmp_name'], $target);
} else {
    $image = "placeholder.jpg"; // Ako slika nije učitana, koristi se zadana slika
}

// Provjera za arhivu (checkbox): 1 za bazu ako je kvačica stavljena, 0 ako nije
if (isset($_POST['archive'])) {
    $archive_db = 1;
    $archive_text = "Da, vijest je arhivirana.";
} else {
    $archive_db = 0;
    $archive_text = "Ne, vijest je javna.";
}

// ==========================================
// IMPLEMENTACIJA PREPARED STATEMENTA (SIGURAN UPIS)
// ==========================================

// 1. Defoniranje SQL upita s upitnicima (?) kao placeholderima
$query = "INSERT INTO vijesti (naslov, sazetak, tekst, slika, kategorija, arhiva) 
          VALUES (?, ?, ?, ?, ?, ?)";

// 2. Inicijalizacija objekta upita (mysqli_stmt_init)
$stmt = mysqli_stmt_init($dbc);

// 3. Priprema upita na poslužitelju (mysqli_stmt_prepare)
if (mysqli_stmt_prepare($stmt, $query)) {
    
    /* 4. Povezivanje parametara (mysqli_stmt_bind_param)
       Tipovi podataka: 
       s = string (naslov, sazetak, tekst, slika, kategorija)
       i = integer (archive_db)
       Ukupno: 5 stringova i 1 integer -> "sssssi"
    */
    mysqli_stmt_bind_param($stmt, "sssssi", $title, $about, $content, $image, $category, $archive_db);
    
    // 5. Izvršavanje upita (mysqli_stmt_execute)
    $result = mysqli_stmt_execute($stmt);
    
    if (!$result) {
        echo "Došlo je do pogreške prilikom izvršavanja upita: " . mysqli_stmt_error($stmt);
    }
    
    // Zatvaranje statementa nakon izvršavanja
    mysqli_stmt_close($stmt);
    
} else {
    echo "Došlo je do pogreške prilikom pripreme upita: " . mysqli_error($dbc);
}

// Zatvaranje veze s bazom podataka
mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> — ZG Priče</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="main-header">
        <div class="logo">
            <span class="logo-text">ZG priče.</span>
        </div>
    </header>

<nav class="main-nav">
    <ul>
        <li><a href="index.php">POČETNA</a></li>
        <li><a href="kategorija.php?id=vijesti">ZG VIJESTI</a></li>
        <li><a href="kategorija.php?id=sport">ZG-SPORT</a></li>
        <li><a href="kategorija.php?id=kultura">KULTURA & ĐIR</a></li>
        <li><a href="administrator.php">ADMINISTRACIJA</a></li>
    </ul>
</nav>

    <main class="container">
        <section role="main">
            <div class="row">
                <p class="category"><?php echo htmlspecialchars($category); ?></p>
                <h1 class="title"><?php echo htmlspecialchars($title); ?></h1>
                <p>AUTOR: Bruno Miličević</p>
                <p>OBJAVLJENO: 2026.</p>
                <p style="font-size: 12px; color: #666;">Arhiva status: <?php echo $archive_text; ?></p>
            </div>
            
            <section class="slika">
                <img src="img/<?php echo htmlspecialchars($image); ?>" alt="Slika članka">
            </section>
            
            <section class="about">
                <p><?php echo nl2br(htmlspecialchars($about)); ?></p>
            </section>
            
            <section class="sadrzaj">
                <p><?php echo nl2br(htmlspecialchars($content)); ?></p>
            </section>
        </section>
    </main>

    <footer class="main-footer">
        <div class="footer-top">
            <p>Nezavisni blog o zbivanjima u gradu Zagrebu.</p>
        </div>
        <div class="footer-bottom">
            <p>Autor: Bruno Miličević | E-mail: <a href="mailto:bmilicev1@tvz.hr">bmilicev1@tvz.hr</a> | Godina: 2026.</p>
        </div>
    </footer>

</body>
</html>