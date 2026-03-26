<?php 
    $naslov = "Vježba 2.1";
    $autor = "Bruno Miličević";
    $link_href = "https://hr.wikipedia.org/wiki/PHP";
    $link_text = "Saznaj više o PHP-u";
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($naslov); ?></title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="wrap">
        <h1><?php echo htmlspecialchars($naslov); ?></h1>

        <p>Ovu stranicu izradio je <strong><?php echo htmlspecialchars($autor); ?>.</p>

        <p>Razdvajanje CSS-a u zasebnu datoteku omogućuje pregledniji kod i brže učitavanje stranice (cache).</p>

        <p>
            <a class="btn" href="<?php echo htmlspecialchars($link_href); ?>" target="_blank" rel="noopener">
                <?php echo htmlspecialchars($link_text); ?>
            </a>
        </p>

        <footer>
            &copy; <?php echo date("Y"); ?>
        </footer>
    </main>
</body>
</html>