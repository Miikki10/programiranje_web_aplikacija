<?php
// 1. Uključivanje skripte za spajanje na bazu podataka
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZG Priče — Zagrebački blog</title>
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
            <li><a href="#">ZG VIJESTI</a></li>
            <li><a href="#">ZG-SPORT</a></li>
            <li><a href="#">KULTURA & ĐIR</a></li>
            <li><a href="unos.php">ADMINISTRACIJA</a></li>
        </ul>
    </nav>

    <main class="container">
        
        <section class="news-section">
            <h2 class="section-title title-vijesti">
                <a href="#">ZG VIJESTI &rsaquo;</a>
            </h2>
            
            <div class="news-grid">
                <?php
                // Dohvaćanje vijesti iz kategorije 'vijesti' koje NISU arhivirane, poredane od najnovije
                $query_vijesti = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = 'vijesti' ORDER BY id DESC";
                $result_vijesti = mysqli_query($dbc, $query_vijesti);
                
                if (mysqli_num_rows($result_vijesti) > 0) {
                    while ($row = mysqli_fetch_array($result_vijesti)) {
                        echo '<article class="news-card">';
                        echo '  <div class="card-image">';
                        echo '      <img src="img/' . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                        echo '  </div>';
                        echo '  <div class="card-content">';
                        echo '      <span class="card-tag tag-vijesti">' . htmlspecialchars($row['sazetak']) . '</span>';
                        echo '      <h3 class="card-heading">';
                        echo '          <a href="vijest.php?id=' . $row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a>';
                        echo '      </h3>';
                        echo '  </div>';
                        echo '</article>';
                    }
                } else {
                    echo '<p style="padding-left: 15px;">Trenutno nema objavljenih vijesti u ovoj kategoriji.</p>';
                }
                ?>
            </div>
        </section>

        <section class="news-section">
            <h2 class="section-title title-sport">
                <a href="#">ZG-SPORT &rsaquo;</a>
            </h2>
            
            <div class="news-grid">
                <?php
                // Dohvaćanje vijesti iz kategorije 'sport' koje NISU arhivirane
                $query_sport = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = 'sport' ORDER BY id DESC";
                $result_sport = mysqli_query($dbc, $query_sport);
                
                if (mysqli_num_rows($result_sport) > 0) {
                    while ($row = mysqli_fetch_array($result_sport)) {
                        echo '<article class="news-card">';
                        echo '  <div class="card-image">';
                        echo '      <img src="img/' . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                        echo '  </div>';
                        echo '  <div class="card-content">';
                        echo '      <span class="card-tag tag-sport">' . htmlspecialchars($row['sazetak']) . '</span>';
                        echo '      <h3 class="card-heading">';
                        echo '          <a href="vijest.php?id=' . $row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a>';
                        echo '      </h3>';
                        echo '  </div>';
                        echo '</article>';
                    }
                } else {
                    echo '<p style="padding-left: 15px;">Trenutno nema objavljenih sportskih vijesti.</p>';
                }
                ?>
            </div>
        </section>

        <section class="news-section">
            <h2 class="section-title title-kultur">
                <a href="#">KULTURA & ĐIR</a>
            </h2>
            
            <div class="news-grid">
                <?php
                // Dohvaćanje vijesti iz kategorije 'kultura' koje NISU arhivirane
                $query_kultura = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = 'kultura' ORDER BY id DESC";
                $result_kultura = mysqli_query($dbc, $query_kultura);
                
                if (mysqli_num_rows($result_kultura) > 0) {
                    while ($row = mysqli_fetch_array($result_kultura)) {
                        echo '<article class="news-card">';
                        echo '  <div class="card-image">';
                        echo '      <img src="img/' . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                        echo '  </div>';
                        echo '  <div class="card-content">';
                        echo '      <span class="card-tag tag-kultur">' . htmlspecialchars($row['sazetak']) . '</span>';
                        echo '      <h3 class="card-heading">';
                        echo '          <a href="vijest.php?id=' . $row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a>';
                        echo '      </h3>';
                        echo '  </div>';
                        echo '</article>';
                    }
                } else {
                    echo '<p style="padding-left: 15px;">Trenutno nema objavljenih vijesti iz kulture.</p>';
                }
                ?>
            </div>
        </section>

    </main>

    <?php
    // Zatvaranje veze s bazom podataka na samom kraju stranice
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