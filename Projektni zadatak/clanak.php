<?php
// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';

// 2. Provjera je li proslijeđen ID preko URL-a i je li brojčan
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Dohvaćanje točno određene vijesti prema ID-ju
    $query = "SELECT * FROM vijesti WHERE id = $id";
    $result = mysqli_query($dbc, $query);
    
    // Provjera postoji li vijest s tim ID-jem u bazi
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        
        $title = $row['naslov'];
        $category = $row['kategorija'];
        $about = $row['sazetak'];
        $content = $row['tekst'];
        $image = $row['slika'];
    } else {
        // Ako ID ne postoji u bazi
        $error_message = "Tražena vijest ne postoji u bazi podataka.";
    }
} else {
    // Ako u URL-u uopće nema parametra ?id=
    $error_message = "Nije odabran ispravan ID vijesti.";
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) . " — ZG Priče" : "Greška — ZG Priče"; ?></title>
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
            <li><a href="kategorija.php?id=vijesti" class="<?php echo (isset($category) && $category == 'vijesti') ? 'active' : ''; ?>">ZG VIJESTI</a></li>
            <li><a href="kategorija.php?id=sport" class="<?php echo (isset($category) && $category == 'sport') ? 'active' : ''; ?>">ZG-SPORT</a></li>
            <li><a href="kategorija.php?id=kultura" class="<?php echo (isset($category) && $category == 'kultura') ? 'active' : ''; ?>">KULTURA & ĐIR</a></li>
            <li><a href="administrator.php">ADMINISTRACIJA</a></li>
        </ul>
    </nav>

    <main class="container">
        <?php if (isset($error_message)): ?>
            <section style="padding: 50px 20px; text-align: center;">
                <h2 style="color: #dc3545;"><?php echo $error_message; ?></h2>
                <p style="margin-top: 20px;"><a href="index.php" style="color: #005cbf; font-weight: bold;">&lsaquo; Povratak na početnu</a></p>
            </section>
        <?php else: ?>
            <article class="single-news">
                
                <span class="card-tag tag-<?php echo htmlspecialchars($category); ?> single-tag">
                    <?php 
                        if ($category == 'vijesti') echo 'ZG Vijesti';
                        elseif ($category == 'sport') echo 'Sport';
                        elseif ($category == 'kultura') echo 'Kultura';
                        else echo htmlspecialchars($category);
                    ?>
                </span>
                
                <h1 class="single-title"><?php echo htmlspecialchars($title); ?></h1>
                
                <div style="font-size: 13px; color: #666; margin-bottom: 20px;">
                    <span>AUTOR: Bruno Miličević</span> | <span>OBJAVLJENO: 2026.</span>
                </div>
                
                <div class="single-img-container">
                    <img src="img/<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($title); ?>">
                </div>
                
                <div class="single-content">
                    <p class="lead-paragraph"><strong><?php echo nl2br(htmlspecialchars($about)); ?></strong></p>
                    
                    <p><?php echo nl2br(htmlspecialchars($content)); ?></p>
                </div>
            </article>
        <?php endif; ?>
    </main>

    <?php
    // Zatvaranje veze s bazom podataka
    mysqli_close($dbc);
    ?>

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