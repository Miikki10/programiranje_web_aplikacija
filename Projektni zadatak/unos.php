<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos Nove Vijesti — ZG Priče</title>
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
            <li><a href="administrator.php" style="font-weight: bold; color: #005cbf;">← POVRATAK NA ADMINISTRACIJSKU PLOČU</a></li>
            <li><a href="index.php">POČETNA</a></li>
            <li><a href="#">ZG VIJESTI</a></li>
            <li><a href="#">ZG-SPORT</a></li>
            <li><a href="#">KULTURA & ĐIR</a></li>
            <li><a href="unos.php">ADMINISTRACIJA</a></li>
        </ul>
    </nav>

    <main class="container">
        <section class="news-section" style="padding: 20px;">
            <h2 style="margin-bottom: 20px; color: #005cbf;">Unos nove vijesti</h2>
            
            <form action="skripta.php" method="POST" name="nova_vijest" enctype="multipart/form-data">
                
                <div class="form-item" style="margin-bottom: 15px;">
                    <label for="title" style="display:block; font-weight:bold; margin-bottom: 5px;">Naslov vijesti</label>
                    <div class="form-field">
                        <input type="text" name="title" id="title" class="form-field-textual" style="width: 100%; padding: 8px; border: 1px solid #ddd;" required autofocus>
                    </div>
                </div>

                <div class="form-item" style="margin-bottom: 15px;">
                    <label for="about" style="display:block; font-weight:bold; margin-bottom: 5px;">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                        <textarea name="about" id="about" cols="30" rows="3" class="form-field-textual" style="width: 100%; padding: 8px; border: 1px solid #ddd;" required></textarea>
                    </div>
                </div>

                <div class="form-item" style="margin-bottom: 15px;">
                    <label for="content" style="display:block; font-weight:bold; margin-bottom: 5px;">Sadržaj vijesti</label>
                    <div class="form-field">
                        <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual" style="width: 100%; padding: 8px; border: 1px solid #ddd;" required></textarea>
                    </div>
                </div>

                <div class="form-item" style="margin-bottom: 15px;">
                    <label for="category" style="display:block; font-weight:bold; margin-bottom: 5px;">Kategorija vijesti</label>
                    <div class="form-field">
                        <select name="category" id="category" class="form-field-textual" style="width: 100%; padding: 8px; border: 1px solid #ddd;">
                            <option value="vijesti">ZG Vijesti</option>
                            <option value="sport">Sport</option>
                            <option value="kultura">Kultura</option>
                        </select>
                    </div>
                </div>

                <div class="form-item" style="margin-bottom: 15px;">
                    <label for="pphoto" style="display:block; font-weight:bold; margin-bottom: 5px;">Slika: </label>
                    <div class="form-field">
                        <input type="file" name="pphoto" id="pphoto" accept="image/jpg,image/gif,image/jpeg,image/png" required>
                    </div>
                </div>

                <div class="form-item" style="margin-bottom: 15px;">
                    <label style="font-weight:bold;">
                        <input type="checkbox" name="archive" value="1"> Spremiti u arhivu (sakrij s naslovnice)
                    </label>
                </div>

                <div class="form-item" style="margin-top: 20px;">
                    <button type="reset" value="Poništi" style="padding: 10px 20px; background: #666; color: #fff; border: none; cursor: pointer;">Poništi</button>
                    <button type="submit" value="Prihvati" style="padding: 10px 20px; background: #005cbf; color: #fff; border: none; cursor: pointer;">Prihvati</button>
                </div>

            </form>
        </section>
    </main>

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