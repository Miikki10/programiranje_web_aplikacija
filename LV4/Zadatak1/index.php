

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Registracija Korisnika</title>
</head>
<body>

    <h2>Registracija novog korisnika</h2>
    <form action="registracija.php" method="POST">
        <label for="username">Korisničko ime:</label><br>
        <input type="text" id="username" name="korisnicko_ime" required><br><br>
        
        <label for="password">Lozinka:</label><br>
        <input type="password" id="password" name="lozinka" required><br><br>
        
        <button type="submit" name="submit">Registriraj se</button>
    </form>

    <hr> <div style="margin-top: 20px;">
        <p>Projekt je dostupan na: 
            <a href="https://github.com/Miikki10/programiranje_web_aplikacija" target="_blank" rel="noopener noreferrer">
                GitHub Repozitorij
            </a>
        </p>
    </div>

</body>
</html>