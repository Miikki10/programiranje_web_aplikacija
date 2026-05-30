<?php
// 1. Spajanje na bazu podataka
$host = "localhost";
$db_user = "root";      // Prilagodi tvojim postavkama (češće je 'root')
$db_pass = "";          // Prilagodi tvojim postavkama (na XAMPP-u je prazno)
$db_name = "pwa_lv4";

$dbc = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (!$dbc) {
    die("Pogreška pri spajanju na bazu podataka: " . mysqli_connect_error());
}

// 2. Provjera je li forma poslana
if (isset($_POST['submit'])) {
    
    // Uzimanje podataka iz forme
    $username = trim($_POST['korisnicko_ime']);
    $password = $_POST['lozinka'];
    $razina_dozvole = 1; // Proizvoljna početna razina dozvole

    // 3. PROVJERA: Postoji li već korisničko ime u bazi?
    // Koristimo Prepared Statement radi sigurnosti
    $query_check = "SELECT id FROM users WHERE korisnicko_ime = ?";
    $stmt_check = mysqli_prepare($dbc, $query_check);
    
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    // Ako je broj redaka veći od 0, korisničko ime već postoji
    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        echo "<h3>Korisničko ime se već koristi</h3>";
        mysqli_stmt_close($stmt_check);
    } else {
        mysqli_stmt_close($stmt_check); // Zatvaramo prethodni statement

        // 4. HASHIRANJE LOZINKE
        // DEFAULT algoritam automatski koristi trenutno najbolji i najsigurniji algoritam u PHP-u (trenutno najčešće bcrypt)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 5. UNOS KORISNIKA U BAZU
        $query_insert = "INSERT INTO users (korisnicko_ime, lozinka, razina_dozvole) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($dbc, $query_insert);
        
        // "ssi" označava tipove podataka: string, string, integer
        mysqli_stmt_bind_param($stmt_insert, "ssi", $username, $hashed_password, $razina_dozvole);

        if (mysqli_stmt_execute($stmt_insert)) {
            echo "<h3>Registracija je uspješna</h3>";
        } else {
            echo "Greška prilikom registracije: " . mysqli_error($dbc);
        }
        
        mysqli_stmt_close($stmt_insert);
    }
}

// Zatvaranje veze s bazom
mysqli_close($dbc);
?>