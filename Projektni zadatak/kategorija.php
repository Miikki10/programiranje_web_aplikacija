<?php
// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';

// 2. Provjera je li parametar 'id' proslijeđen kroz URL (GET metoda)
if (isset($_GET['id'])) {
    $kategorija = mysqli_real_escape_string($dbc, $_GET['id']);
} else {
    // Ako parametar nije poslan, preusmjeri na početnu ili postavi zadano
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo strtoupper(htmlspecialchars($kategorija)); ?> — ZG Priče</title>
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
            <li><a href="kategorija.php?id=vijesti" class="<?php echo $kategorija == 'vijesti' ? 'active' : ''; ?>">ZG VIJESTI</a></li>
            <li><a href="kategorija.php?id=sport" class="<?php echo $kategorija == 'sport' ? 'active' : ''; ?>">ZG-SPORT</a></li>
            <li><a href="kategorija.php?id=kultura" class="<?php echo $kategorija == 'kultura' ? 'active' : ''; ?>">KULTURA & ĐIR</a></li>
            <li><a href="administrator.php">ADMINISTRACIJA</a></li>
        </ul>
    </nav>

    <main class="container">
        
        <section class="news-section">
            <h2 class="section-title title-<?php echo htmlspecialchars($kategorija); ?>">
                <span>ZG-<?php echo strtoupper(htmlspecialchars($kategorija)); ?></span>
            </h2>
            
            <div class="news-grid">
                <?php
                // Dohvaćanje SVIH vijesti iz odabrane kategorije koje NISU arhivirane (bez LIMIT-a)
                $query = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = '$kategorija' ORDER BY id DESC";
                $result = mysqli_query($dbc, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<article class="news-card">';
                        echo '  <div class="card-image">';
                        echo '      <img src="img/' . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                        echo '  </div>';
                        echo '  <div class="card-content">';
                        echo '      <span class="card-tag tag-' . htmlspecialchars($kategorija) . '">' . htmlspecialchars($row['sazetak']) . '</span>';
                        echo '      <h3 class="card-heading">';
                        echo '          <a href="vijest.php?id=' . $row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a>';
                        echo '      </h3>';
                        echo '  </div>';
                        echo '</article>';
                    }
                } else {
                    echo '<p style="padding-left: 15px;">Trenutno nema objavljenih vijesti u kategoriji "' . htmlspecialchars($kategorija) . '".</p>';
                }
                ?>
            </div>
        </section>

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