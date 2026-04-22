<?php

/**
 * Funkcija provjerava je li proslijeđeni broj prost.
 * Prost broj je veći od 1 i djeljiv je samo sa 1 i samim sobom.
 */
function jeLiProst($broj) {
    // Prema definiciji, prosti brojevi moraju biti veći od 1
    if ($broj <= 1) {
        return false;
    }

    // Provjeravamo djeljivost od broja 2 do korijena broja
    // (Optimizacija: ako nema djelitelja do korijena, neće ga biti ni nakon)
    for ($i = 2; $i <= sqrt($broj); $i++) {
        if ($broj % $i == 0) {
            return false; // Broj je djeljiv s nečim drugim, nije prost
        }
    }

    return true; // Ako nismo našli djelitelja, broj je prost
}

// Ispis svih prostih brojeva manjih od 100
echo "Prosti brojevi manji od 100 su:\n";

for ($n = 2; $n < 100; $n++) {
    if (jeLiProst($n)) {
        echo $n . " ";
    }
}

?>