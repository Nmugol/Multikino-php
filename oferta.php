<?php declare(strict_types=1);  /* Ta linia musi byc pierwsza */ ?>
<?php
session_start(); // Zawsze zaczynamy sesję na początku pliku
?>
<?php
// Połączenie z bazą danych
// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2"); 
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}

// Ustawienie kodowania znaków
mysqli_set_charset($polaczenie, 'utf8mb4');

// Zapytanie do bazy danych o 3 ostatnio dodane filmy
$rezultat = mysqli_query($polaczenie, "SELECT * FROM repertuar ORDER BY ID DESC LIMIT 3");

$filmy = [];
while ($wiersz = mysqli_fetch_array($rezultat)) {
    $filmy[] = $wiersz;
}

mysqli_close($polaczenie);

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Twój Opis">
    <meta name="author" content="Twoje dane">
    <meta name="keywords" content="Twoje słowa kluczowe">
    <title>Multikino</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <style type="text/css" class="init"></style>
    <link rel="stylesheet" href="twoj_css.css">
    <link rel="stylesheet" href="oferta.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"
        integrity="sha384w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="twoj_js.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ikona wylogowania -->
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>

<body onload="myLoadHeader()">
<div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
    <div class="container text-center my-5">
    <h1 class="display-4">🍿 Kinowe przekąski 🍿</h1>
 
        <!-- Oferta dnia -->
        <div class="offer-banner cien">
            <div>
            <h2>✨ Oferta dnia: ✨</h2>
            <p> ❗ Popcorn "Karmelowy" w rozmiarze XL teraz w promocji! ❗</p>
                <p class="old-price">Cena: 25 PLN</p>
                <p class="offer-price">Cena promocyjna: 19.99 PLN</p>
            </div>
            <img src="../image/pocorn-size.png" alt="Popcorn" title="Popcorn na każdą okazję!">
        </div>

        <!-- Karuzela popcornu -->
        <h1 style="margin-top: 30px; font-size: 1.8rem;">Na jaki popcorn masz dziś ochotę?</h1>
       <!-- Karuzela popcornu (tylko dla dużych ekranów) -->
<div class="popcorn-carousel d-none d-md-flex">
    <div class="popcorn-item">
        <img src="../image/popcorn.png" alt="Masłowy" />
        <h3>🧈 Masłowy</h3>
        <p>Mały - 14 PLN</p>
        <p>Średni - 16 PLN</p>
        <p>Duży - 18 PLN</p>
    </div>
    <div class="popcorn-item">
        <img src="../image/popcorn.png" alt="Orzechowy" />
        <h3>🥜 Orzechowy</h3>
        <p>Mały - 18 PLN</p>
        <p>Średni - 20 PLN</p>
        <p>Duży - 22 PLN</p>
    </div>
    <div class="popcorn-item">
        <img src="../image/popcorn.png" alt="Serowy" />
        <h3>🧀 Serowy</h3>
        <p>Mały - 16 PLN</p>
        <p>Średni - 18 PLN</p>
        <p>Duży - 20 PLN</p>
    </div>
</div>

<!-- Siatka popcornu (tylko dla urządzeń mobilnych) -->
<div class="popcorn-grid d-md-none">
   
    <img src="../image/popcorn.png" style="width:25%; height:25%; margin: 25px;" />
    <p><strong>🧈 Masłowy</strong><br><span style="font-size: 14px;">S: 14 PLN | M: 16 PLN | L: 18 PLN</span></p>
        <p><strong>🥜 Orzechowy</strong><br><span style="font-size: 14px;">S: 18 PLN | M: 20 PLN | L: 22 PLN</span></p>
        <p><strong>🧀 Serowy</strong><br><span style="font-size: 14px;">S: 16 PLN | M: 18 PLN | L: 20 PLN</span></p>
        <p><strong>🍯 Karmelowy</strong><br><span style="font-size: 14px;">S: 16 PLN | M: 18 PLN | L: 20 PLN</span></p>
        <p><strong>🍫 M&M's</strong><br><span style="font-size: 14px;">S: 19 PLN | M: 21 PLN | L: 23 PLN</span></p>
</div>

        <!-- Sekcja Zestawy -->
<div class="set-section cien">
    <h2>Wybierz zestaw!</h2>
    <p>U nas znajdziesz najlepsze zestawy, które zaspokoją każdy głód filmowy!</p>
    <p><span class="czerwony">Najlepsza część?</span> <br>Za zestaw zapłacisz mniej! Wybierz zestaw i zaoszczędź na kolejnej paczce popcornu.<br>
    <span class="czerwony">Chcesz więcej?</span><br> Zestawy to nasza specjalność – zjedz więcej, zapłać mniej!</p>
    <img src="../image/zestaw.jpg" alt="Popcorn" title="Popcorn na każdą okazję!">

</div>


    <!-- JS dla karuzeli -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector(".popcorn-carousel");
    let items = Array.from(document.querySelectorAll(".popcorn-item"));
    let index = 0;

    function moveCarousel() {
        // 1. Ukrywamy pierwszy element, który znika
        items[index].classList.add("hidden");

        // 2. Przesuwamy całą karuzelę w lewo o 33.33%
        carousel.style.transition = "transform 1s ease-in-out";
        carousel.style.transform = `translateX(-33.33%)`;

        // 3. Po zakończeniu animacji (1s), przestawiamy elementy w DOM
        setTimeout(() => {
            // 4. Przenosimy pierwszy element na koniec
            let firstItem = items.shift(); // Usuwamy pierwszy element z listy
            items.push(firstItem); // Dodajemy go na koniec

            // 5. Resetujemy przesunięcie, aby nie przeskakiwało
            carousel.style.transition = "none";
            carousel.style.transform = "translateX(0)";

            // 6. Przełączamy klasy: usuwamy 'hidden' z 3. elementu
            items[2].classList.add("active");
            firstItem.classList.remove("active", "hidden"); // Resetujemy stan pierwszego elementu
            carousel.appendChild(firstItem); // Przesuwamy element na koniec w HTML-u
        }, 1000); // Dopasowane do czasu animacji
    }

    setInterval(moveCarousel, 7000); // Co 3 sekundy przesunięcie
});

    </script>
    </main>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>