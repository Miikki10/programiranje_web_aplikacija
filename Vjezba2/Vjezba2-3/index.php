<?php
// vjezba1d.php — Logika na početku
$naslov = "PHP dokument — vježba 1d";
$autor  = "Bruno Miličević";
$opis   = "Ova stranica demonstrira rad s GET parametrima, promjenu tema i dinamički prikaz slika.";

// 1. Postavke slika
$dozvoljeneSlike = [
    "php"    => "img/php.jpg",
    "server" => "img/server.jpg",
    "code"   => "img/code.jpg"
];

// 2. Prihvat GET parametara (moderniji pristup s ?? operatorom)
$temaKey     = $_GET["tema"] ?? "dark";
$slikaKey    = $_GET["slika"] ?? "php";
$prikaziOpis = isset($_GET["opis"]);

// 3. Određivanje boja na temelju teme
if ($temaKey === "light") {
    $bg = "#f8fafc"; $card = "#ffffff"; $text = "#1e293b"; $accent = "#2563eb"; $muted = "#64748b";
} else {
    $bg = "#0f172a"; $card = "#ffffff"; $text = "#111827"; $accent = "#3b82f6"; $muted = "#6b7280";
}

$slikaPath = $dozvoljeneSlike[$slikaKey] ?? $dozvoljeneSlike["php"];

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($naslov); ?></title>
  
  <link rel="stylesheet" href="../vjezba2-1/style.css">
  
  <style>
    :root {
      --bg: <?php echo $bg; ?>;
      --card: <?php echo $card; ?>;
      --text: <?php echo $text; ?>;
      --accent: <?php echo $accent; ?>;
      --muted: <?php echo $muted; ?>;
    }
  </style>
</head>
<body>

<main class="wrap">
  <h1><?php echo h($naslov); ?></h1>
  <p>Autor: <strong><?php echo h($autor); ?></strong></p>

  <div class="figure">
    <img src="<?php echo h($slikaPath); ?>" alt="Vizual vježbe">
  </div>

  <?php if ($prikaziOpis): ?>
    <p><em><?php echo h($opis); ?></em></p>
  <?php endif; ?>

  <form method="GET" action="index.php">
    <fieldset>
      <legend>Izgled stranice</legend>
      <label><input type="radio" name="tema" value="dark" <?php if($temaKey=="dark") echo "checked"; ?>> Tamna tema</label><br>
      <label><input type="radio" name="tema" value="light" <?php if($temaKey=="light") echo "checked"; ?>> Svijetla tema</label>
    </fieldset>

    <fieldset>
      <legend>Sadržaj kartice</legend>
      <label for="slika">Odaberi sliku:</label>
      <select name="slika" id="slika">
        <option value="php" <?php if($slikaKey=="php") echo "selected"; ?>>PHP Logo</option>
        <option value="server" <?php if($slikaKey=="server") echo "selected"; ?>>Server Architecture</option>
        <option value="code" <?php if($slikaKey=="code") echo "selected"; ?>>Coding Hands</option>
      </select>
      <br><br>
      <label><input type="checkbox" name="opis" <?php if($prikaziOpis) echo "checked"; ?>> Prikaži dodatni opis</label>
    </fieldset>

    <div class="row">
      <button type="submit" class="btn">Primijeni postavke</button>
      <a href="../Vjezba2-2/index.php" class="btn">Povratak na 1c</a>
    </div>
  </form>

  <footer>
    &copy; <?php echo date("Y"); ?> — PHP Interaktivna vježba
  </footer>
</main>

</body>
</html>