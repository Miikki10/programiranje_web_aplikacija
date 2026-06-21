<?php
// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';

// 2. Provjera je li proslijeđen ID preko URL-a
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Inicijalizacija objekta pripremljenog upita
    $stmt = mysqli_stmt_init($dbc);
    
    // Priprema upita s upitnikom (?) kao zamjenskim parametrom
    $query = "SELECT naslov, kategorija, sazetak, tekst, slika FROM vijesti WHERE id = ?";
    
    if (mysqli_stmt_prepare($stmt, $query)) {
        // Povezivanje parametara (i = integer)
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        // Izvršavanje upita
        mysqli_stmt_execute($stmt);
        
        // Pohrana rezultata kako bismo mogli koristiti funkciju mysqli_stmt_num_rows()
        mysqli_stmt_store_result($stmt);
        
        // Provjera postoji li točno jedna vijest s tim ID-jem u bazi
        if (mysqli_stmt_num_rows($stmt) == 1) {
            // Vezanje stupaca iz rezultata za lokalne varijable
            mysqli_stmt_bind_result($stmt, $title, $category, $about, $content, $image);
            
            // Dohvaćanje (čitanje) vrijednosti
            mysqli_stmt_fetch($stmt);
        } else {
            // Ako ID ne postoji u bazi
            $error_message = "Tražena vijest ne postoji u bazi podataka.";
        }
        
        // Zatvaranje pripremljenog upita
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Došlo je do pogreške prilikom komunikacije s bazom.";
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
    // Zatvaranje veze s bazom podataka na samom kraju
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