<?php
// PHP logika
$naslov      = "PHP dokument — vježba 1c";
$autor       = "Bruno Miličević";
$opis        = "Ova stranica nastavlja vježbu 1b i služi za uvježbavanje varijabli, ispisa i vanjskog CSS-a.";
$linkInfo    = "https://www.php.net";
$linkNatrag  = "../Vjezba2-1/index.php";
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($naslov); ?></title>
  
  <link rel="stylesheet" href="../vjezba2-1/style.css">
</head>
<body>

  <main class="wrap">
    <h1><?php echo htmlspecialchars($naslov); ?></h1>
    
    <p>Autor: <strong><?php echo htmlspecialchars($autor); ?></strong></p>
    <p><?php echo htmlspecialchars($opis); ?></p>
    
    <div class="row">
      <a class="btn" href="<?php echo htmlspecialchars($linkInfo); ?>" target="_blank" rel="noopener">Saznaj više o PHP-u</a>
      <a class="btn" href="<?php echo htmlspecialchars($linkNatrag); ?>">Natrag na vježba 1b</a>
    </div>

    <footer>
      &copy; <?php echo date('Y'); ?> — <?php echo htmlspecialchars($autor); ?>
    </footer>
  </main>

</body>
</html>