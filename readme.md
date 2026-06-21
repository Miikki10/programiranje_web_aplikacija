# Zg-Priče — Blog s najnovijim vijestima iz Zagreba

**Zg-Priče** je web aplikacija osmišljena kao lokalni blog i portal za praćenje najnovijih vijesti, događanja i priča iz grada Zagreba. Projekt je izrađen u PHP-u i koristi MySQL bazu podataka za pohranu članaka, korisnika i komentara.

Ovaj dokument sadrži detaljne upute o tome kako preuzeti, konfigurirati i pokrenuti projekt na lokalnom razvojnom okruženju.

---

## 📋 Preduvjeti

Prije nego što započnete, provjerite imate li instalirano sljedeće:
- **XAMPP** (s PHP 7.4+ i MySQL/MariaDB)
- Web preglednik (Chrome, Firefox, Edge, itd.)
- Git (opcionalno, ako preuzimate kod izravno s Git repozitorija)

---

## 🚀 Upute za pokretanje projekta

Slijedite korake u nastavku kako biste uspješno postavili i pokrenuli aplikaciju na svom računalu.

### Korak 1: Preuzimanje projekta
Projekt možete preuzeti na jedan od dva načina:
1. **Preko GitHub-a:** Klonirajte cijeli korijenski repozitorij ili preuzmite ZIP datoteku izravno s GitHub stranice projekta. Zatim je potrebno otvoriti sadržaj direktorija Porjektni zadatak - tamo se nalaze sve potrebne datoteke.
2. **Preko LMS-a:** Preuzmite priloženu ZIP datoteku s LMS sustava.

*Napomena:* Ako ste preuzeli ZIP datoteku (bilo s Git-a ili LMS-a), raspakirajte (unzip) njezin sadržaj na svoje računalo.

### Korak 2: Pregled projektnog zadatka
 Pronađite i otvorite datoteku **`Projektni zadatak`** kako biste se upoznali s detaljnim zahtjevima, arhitekturom i specifikacijama samog rada.

### Korak 3: Pokretanje XAMPP-a
1. Otvorite **XAMPP Control Panel** na svom računalu.
2. Pokrenite **Apache** modul klikom na gumb **Start**.
3. Pokrenite **MySQL** modul klikom na gumb **Start**.
4. Provjerite jesu li oba modula pozelenila, što označava da uspješno rade u pozadini.

### Korak 4: Uvoz baze podataka (phpMyAdmin)
1. Otvorite web preglednik i idite na adresu: [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
2. S lijeve strane kliknite na **New** kako biste kreirali novu bazu podataka.
3. Nazovite bazu podataka **`zg_price`** i kliknite **Create**.
4. Odaberite novoizrađenu bazu podataka s popisa, a zatim u gornjem izborniku kliknite na karticu **Import**.
5. Kliknite na gumb **Choose File** (Odaberi datoteku).
6. Navigirajte do direktorija vašeg preuzetog projekta, uđite u mapu baze podataka i odaberite datoteku **`zg_price.sql`**.
7. Skrolajte do dna stranice i kliknite na gumb **Import** (ili **Go**). Pričekajte poruku o uspješnom uvozu svih tablica.

### Korak 5: Prebacivanje datoteka u `htdocs`
1. Kopirajte cijeli direktorij s PHP datotekama projekta (sve osim dokumentacije i SQL datoteke, ili kompletan preuzeti folder aplikacije).
2. Navigirajte do mape gdje vam je instaliran XAMPP (uobičajeno `C:\xampp`).
3. Unutar XAMPP mape pronađite direktorij **`htdocs`**.
4. Zalijepite (Paste) kopirani folder unutar `htdocs` mape. Preporučuje se da folder preimenujete u jednostavan naziv, npr. **`zg-price`**.

### Korak 6: Pokretanje i testiranje aplikacije
1. Otvorite svoj web preglednik.
2. U adresnu traku upišite sljedeći URL:
   ```
   http://localhost/zg-price/index.php
   ```
   *(Ako ste mapu u htdocs nazvali drugačije, prilagodite zadnji dio URL-a).*
3. Web stranica **Zg-Priče** trebala bi se uspješno učitati i prikazati najnovije vijesti iz Zagreba!

---

## 🛠️ Tehnologije i struktura
- **Frontend:** HTML5, CSS3, JavaScript (opcionalno Bootstrap za responzivnost)
- **Backend:** PHP (proceduralni ili OOP)
- **Baza podataka:** MySQL (povezivanje putem PDO ili mysqli proširenja)
