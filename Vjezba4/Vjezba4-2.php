<?php
// 1. POSTAVKE I LOGIKA (Sve radimo na vrhu)
date_default_timezone_set('Europe/Zagreb');

// Funkcija se definira samo JEDNOM
function ducan($stanje = "otvoren") {
    $klasa = ($stanje == "otvoren") ? "otvoreno" : "zatvoreno";
    return "<div class='$klasa'>Dućan je $stanje</div>";
}

$sat = (int)date('G'); 
$dan = (int)date('N');
$datum = date('d.m.'); 
$praznici = ['01.01.', '06.01.', '01.05.', '30.05.', '22.06.', '05.08.', '15.08.', '01.11.', '18.11.', '25.12.', '26.12.'];

// Određujemo status prije nego krenemo s HTML-om
$statusPoruka = "";

if (in_array($datum, $praznici) || $dan == 7) {
    $statusPoruka = ducan("zatvoren");
} elseif ($dan == 6) {
    $statusPoruka = ($sat >= 9 && $sat < 14) ? ducan() : ducan("zatvoren");
} else {
    $statusPoruka = ($sat >= 8 && $sat < 20) ? ducan() : ducan("zatvoren");
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Status Dućana</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f4; margin: 0; }
        .kartica { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; border-top: 5px solid #ff4500; min-width: 300px; }
        .otvoreno { color: green; font-weight: bold; font-size: 1.5rem; }
        .zatvoreno { color: red; font-weight: bold; font-size: 1.5rem; }
        h1 { margin-bottom: 1rem; color: #333; font-size: 1.2rem; }
    </style>
</head>
<body>

<div class="kartica">
    <h1>Trenutni status dućana:</h1>
    
    <?php echo $statusPoruka; ?>

    <p style="font-size: 0.8rem; color: #666; margin-top: 20px; border-top: 1px solid #eee; pt: 10px;">
        Danas je: <?php echo date('d.m.Y.'); ?><br>
        Trenutno vrijeme: <?php echo date('H:i'); ?>h
    </p>
</div>

</body>
</html>