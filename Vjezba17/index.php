<?php
// ==========================================
// 1. POVEZIVANJE NA BAZU (vjezba17)
// ==========================================
$host    = 'localhost';
$db      = 'vjezba17';
$user    = 'root';
$pass    = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Greška u povezivanju na bazu: " . $e->getMessage());
}

// ==========================================
// 2. DOHVAĆANJE PODATAKA POMOĆU RELACIJE (JOIN)
// ==========================================
try {
    // Spajamo tablicu users i countries preko vanjskog ključa country_id
    $query = "SELECT u.first_name, u.last_name, c.country_name 
              FROM users u 
              INNER JOIN countries c ON u.country_id = c.id
              ORDER BY u.id ASC";
              
    $stmt = $pdo->query($query);
    $users = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("Greška pri izvršavanju upita: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prikaz korisnika i država - Vježba 17</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            max-width: 500px;
            margin: 0 auto;
        }
        h2 {
            font-size: 20px;
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 10px;
        }
        .user-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .user-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            font-size: 14px;
            color: #555;
            border-bottom: 1px solid #fafafa;
        }
        .user-icon {
            color: #aaa;
            margin-right: 10px;
            font-size: 16px;
        }
        .user-name {
            font-weight: bold;
            color: #2b8a3e; /* Zelena boja za prezime/ime prema slici */
            margin-right: 5px;
        }
        .country-name {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Popis korisnika po državama (Vježba 17)</h2>
    
    <ul class="user-list">
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <li class="user-item">
                    <span class="user-icon">&#128100;</span> 
                    
                    <span class="user-name">
                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                    </span>
                    
                    <span class="country-name">
                        (<?php echo htmlspecialchars($user['country_name']); ?>)
                    </span>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="user-item">Nema pronađenih korisnika u bazi.</li>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>