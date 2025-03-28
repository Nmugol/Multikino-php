<?php
session_set_cookie_params(3600);
session_start();
require_once 'function.php';
$connect = get_sql();

$zalogowany = isset($_COOKIE['zalogowany']) ? $_COOKIE['zalogowany'] : 0;
$id_klienta = isset($_COOKIE['id']) ? $_COOKIE['id'] : null;

if ($zalogowany == 1 && $id_klienta) {
    $kto = "SELECT imie FROM klient WHERE ID_Klient = '$id_klienta'";
    $result = mysqli_query($connect, $kto);
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - Multikino</title>
    <link rel="stylesheet" href="styl.css"> <!-- Odnośnik do arkusza stylów -->
    <script src="scripts.js" defer></script> <!-- Odnośnik do pliku JavaScript -->
    <style>
        html, body {
    height: 100%; /* Upewniamy się, że wysokość jest na 100% */
    overflow-x: hidden; /* Ukrywanie poziomego suwaka */
    overflow-y: auto; /* Pokazanie pionowego suwaka, gdy zawartość przekroczy wysokość ekranu */
}
body {
            background: url('image/tlo3.jpg') no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cambria', 'Cochin', 'Georgia', 'Times', 'Times New Roman', serif;
            
        }

        /* Dodajemy animację do całego body */
body {
    opacity: 0; /* Ustalamy początkową przezroczystość na 0 */
    transform: translateY(20px); /* Element zaczyna z lekkim przesunięciem w dół */
    animation: fadeIn 2s forwards; /* Ustalamy nazwę animacji, czas trwania i tryb */
}

/* Animacja stopniowego pojawiania się i przesuwania */
@keyframes fadeIn {
    0% {
        opacity: 0; /* Na początku jest przezroczysty */
        transform: translateY(20px); /* Na początku przesunięty w dół */
    }
    100% {
        opacity: 1; /* Na końcu pełna widoczność */
        transform: translateY(0); /* Na końcu wraca do pierwotnej pozycji */
    }
}

 /* Sekcja Zestawy */
 .set-section {
            margin-top: 0vw;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 1vw;
            border-radius: 1vw;
            text-align: center;
            color: white;
            margin-bottom: 2vw;
            width: 40%;
        }

        .set-section h2 {
            font-size: 2vw;
            margin-bottom: 2vw;
        }

        .set-section img {
            max-width: 20vw;
    max-height: 12vw;
    min-width: 20vw;
    min-height: 12vw;
            border-radius: 8vw;
            margin: 1vw 0;
        }

        .set-section p {
            font-size: 1.2vw;
            margin: 1vw 0;
        }

        </style>
</head>

<body>
<div class="naglowek">
    <ul>
        <li><a href="index.php">Strona główna</a></li>
        <li><a href="oferta.php">Kinowe przekąski</a></li>
        <li><a href="kontakt.php">Kontakt</a></li>

        <?php if ($zalogowany == 1 || $zalogowany == 2): ?>
            <li style="float:right"><a href="wyloguj.php">Wyloguj się</a></li>
        <?php elseif ($zalogowany == 0): ?>
            <li style="float:right"><a href="login.php">Zaloguj się</a></li>
            <li style="float:right"><a href="register.php">Zarejestruj się</a></li>
        <?php endif; ?>
    </ul>
</div>

        <div class="container" style="color:#333; margin-left:5vw">
        <h1 style="color: black; margin-left:-58vw;">Kontakt</h1>
            <div class="set-section cien">
            <p style="font-size:1.2vw;">Masz pytania lub sugestie? Skontaktuj się z nami!</p>
            <div class="content" style="font-size:1vw;">
    <div class="contact-details">
        <p>Email: kontakt@multikino.pl</p>
        <p>Telefon: +48 123 456 789</p>
        <p>Adres: ul. Kino 1, 00-001 New York</p>
    </div>
    <div class="contact-image" style="text-align: right;">
        <img src="image/kontakt.jpg" alt="Kontakt" style="max-width: 15vw; max-height: 12vw; min-width: 15vw; min-height: 12vw; margin-top: 10%; margin-right: 30%; opacity: 0.8;">
    </div></div>
</div>
            <!-- Mapa -->
            <div class="map" style="margin-right:-40vw; margin-top:-35.2vw">
                <h1 style="color: black">Nasza lokalizacja</h1>
                <center><iframe style="max-width: 40vw; max-height: 29vw; min-width: 40vw; min-height: 29vw;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d243648.11450869716!2d-74.00601524983088!3d40.712728091563245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDLCsDQyJzU3LjgiTiA3NMKwMDBCJzM0LjIiVw!5e0!3m2!1sen!2sus!4v1619184261895!5m2!1sen!2sus"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe></center>
            </div>
        </div>
    

    <!-- JS dla karuzeli -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <div class="naglowek cien" style="justify-content: center; align-items: center; position: fixed; bottom: 0; width:100%"><ul style="display: flex; justify-content: center; align-items: center;">
<li style="padding:0.5vw; text-align:center;">© 2025 Multikino</li>
            
        </ul></div>
</body>




</html>
