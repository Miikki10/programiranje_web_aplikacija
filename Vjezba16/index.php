<?php
// ==========================================
// 1. KONFIGURACIJA I POVEZIVANJE NA BAZU
// ==========================================
$host    = 'localhost';
$db      = 'vjezba16';
$user    = 'root';
$pass    = ''; // Ako imaš lozinku za MySQL, upiši je ovdje
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
// 2. OBRADA FORME I VALIDACIJA
// ==========================================
$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dohvaćanje i čišćenje podataka iz POST zahtjeva
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName  = trim($_POST['last_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $password  = $_POST['password'] ?? '';
    $country   = $_POST['country'] ?? '';

    // Validacijska pravila prema zahtjevima sa slike
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    }
    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid E-mail is required.";
    }
    
    // Username: min 5, max 10 znakova
    $usernameLength = strlen($username);
    if ($usernameLength < 5 || $usernameLength > 10) {
        $errors[] = "Username must have min 5 and max 10 characters.";
    }
    
    // Password: min 4 znaka
    if (strlen($password) < 4) {
        $errors[] = "Password must have min 4 characters.";
    }

    // Ako nema pogrešaka, provjeri jedinstvenost i zapiši u bazu
    if (empty($errors)) {
        try {
            // Provjera postoje li već email ili username
            $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $checkStmt->execute([$email, $username]);
            
            if ($checkStmt->rowCount() > 0) {
                $errors[] = "Username or Email is already taken.";
            } else {
                // Hashiranje lozinke
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // SQL upis
                $sql = "INSERT INTO users (first_name, last_name, email, username, password, country) 
                        VALUES (:first_name, :last_name, :email, :username, :password, :country)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':first_name' => $firstName,
                    ':last_name'  => $lastName,
                    ':email'      => $email,
                    ':username'   => $username,
                    ':password'   => $hashedPassword,
                    ':country'    => !empty($country) ? $country : null
                ]);

                $successMessage = "User successfully registered and saved to the database!";
            }
        } catch (\PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form - Vježba 16</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #444;
        }
        .note {
            color: red;
            font-size: 11px;
            font-weight: normal;
            display: inline;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 8px 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: #fde8e8;
            color: #e53e3e;
            border: 1px solid #f8b4b4;
        }
        .alert-success {
            background-color: #def7ec;
            color: #03543f;
            border: 1px solid #bcf0da;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Registration Form</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <div class="form-group">
            <label>First Name *</label>
            <input type="text" name="first_name" placeholder="Your name." value="<?php echo htmlspecialchars($firstName ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Last Name *</label>
            <input type="text" name="last_name" placeholder="Your last name." value="<?php echo htmlspecialchars($lastName ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Your E-mail *</label>
            <input type="email" name="your_email" name="email" placeholder="Your e-mail." value="<?php echo htmlspecialchars($email ?? ''); ?>">
            </div>

        <div class="form-group">
            <label>Username * <span class="note">(Username must have min 5 and max 10 char)</span></label>
            <input type="text" name="username" placeholder="Username." value="<?php echo htmlspecialchars($username ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Password * <span class="note">(Password must have min 4 char)</span></label>
            <input type="password" name="password" placeholder="Password.">
        </div>

        <div class="form-group">
            <label>Country</label>
            <select name="country">
                <option value="">molimo odaberite</option>
                <option value="Croatia" <?php if(($country ?? '') == 'Croatia') echo 'selected'; ?>>Croatia</option>
                <option value="Slovenia" <?php if(($country ?? '') == 'Slovenia') echo 'selected'; ?>>Slovenia</option>
                <option value="Austria" <?php if(($country ?? '') == 'Austria') echo 'selected'; ?>>Austria</option>
            </select>
        </div>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>