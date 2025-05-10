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
    <link rel="stylesheet" href="strona.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"
        integrity="sha384w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="twoj_js.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        [data-bs-theme="blue"] .modal-dialog{
    color: white;
    text-shadow: black 0.1em 0.1em 0.2em;
}
[data-bs-theme="dark"] .modal-dialog {
    color: white;
    text-shadow: black 0.1em 0.1em 0.2em;
}

[data-bs-theme="dark"] .btn-close, [data-bs-theme="blue"] .btn-close  {
    --bs-btn-close-color: white;
        --bs-btn-close-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e");
    }

[data-bs-theme="light"] .btn-close, [data-bs-theme="yellow"] .btn-close, [data-bs-theme="auto"] .btn-close {
    --bs-btn-close-color: #000;
    --bs-btn-close-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e");
    }

[data-bs-theme="blue"] .modal-content, [data-bs-theme="dark"] .modal-content {
    background-color: #212529;
    color: white;
}

.card-main img:hover {
    opacity: 60%;
    transition: opacity 0.3s ease-in-out;
}

    </style>
</head>

<body onload="myLoadHeader()">
    <div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
        <!-- Sekcja powitalna z ostatnio dodanymi filmami -->
        <section class="sekcja1">
    <div class="container text-center my-5">
        <h1 class="logo-title">🎥 MULTIKINO 🎬</h1>
        <p class="lead">Zanurz się w niesamowitym świecie filmów i emocji! 📽️</p><br>
        <p class="lead2"><b>Nasze ostatnie nowości!</b></p>
        
        <!-- Modal potwierdzenia -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Interesuje Cię ten film?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Zobacz harmonogram seansu dla tego filmu aby zdobyć więcej szczegółów.</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-success" id="confirmBtn">Zobacz</button>
            </div>
        </div>
    </div>
</div>

        <div class="row justify-content-center">
            <?php foreach ($filmy as $film): ?>
                <div class="col-md-4 d-flex flex-column align-items-center"> 
                    <!-- Opakowanie dla obrazka -->
                    <div class="card-main mb-4 shadow-sm">
                        <img src="<?= $film['obraz']; ?>" class="card-img-top" alt="<?= $film['tytul']; ?>" 
                             onclick="showModal(<?= $film['id']; ?>, '<?= addslashes($film['tytul']); ?>')" style="cursor: pointer;">
                    </div>
                    <!-- Oddzielna sekcja na tytuł i opis -->
                    <div class="card-info">
                        <h5 class="card-title"><?= str_replace(' ', '&nbsp;', $film['tytul']); ?></h5>
                        <p class="card-text"><?= $film['gatunek']; ?>&nbsp;|&nbsp;<?= $film['dlugosc']; ?>&nbsp;min</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- Modal logowania -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Musisz być zalogowany!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Musisz się zalogować, aby zakupić bilet na film <b><span id="filmTitle"></span></b>.</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <a href="login.php">
                    <button type="button" class="btn btn-success">Zaloguj się</button>
                </a>
            </div>
        </div>
    </div>
</div>


<script>
   // Funkcja otwierająca modal
function showModal(filmId, filmTitle) {
    // Sprawdzenie, czy użytkownik jest zalogowany
    <?php if (!isset($_SESSION['user'])): ?>
        // Wyświetlenie tytułu filmu w modalu
        document.getElementById("tytul").textContent = filmTitle;
        document.getElementById("myModal").style.display = "block";
    <?php else: ?>
        // Jeśli użytkownik jest zalogowany, przekieruj na stronę seans.php z ID filmu
        window.location.href = "seans.php?id=" + filmId;
    <?php endif; ?>
}

// Funkcja zamykająca modal
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}
</script>
<section class="premiere-section">
    <div class="container d-flex align-items-center">
        <!-- Obraz filmu -->
        <div class="premiere-image">
            <img src="/image/film5.jpg" alt="Premiera filmu" class="img-fluid">
        </div>
    <!-- Tekst promocyjny i licznik -->
<div class="premiere-text">
    <h2 class="premiere-title">Premiera:</h2>
    <p class="premiere-description">
        Już wkrótce wielka premiera! Przygotuj się na niezwykłą podróż w świat emocji, niesamowitych efektów specjalnych i wciągającej fabuły! Nie przegap tego wydarzenia!
       <div class="premiera-kiedy">
        <br><span class="question">Kiedy?</span><br>
        <span>13.06.2025!</span>
        <br><span class="question" >Gdzie?</span><br>
        <span>Tylko u nas!</span>
</div>        
    </p>

    <!-- Licznik odliczający czas -->
    <div class="countdown" id="countdown"></div>
</div>

    </div>
</section>
        <!-- Sekcja opinii użytkowników -->
        <section class="sekcja3 my-5">
            <div class="container text-center">
                <h2 class="display-4">Co mówią nasi widzowie?</h2>
                <div class="row2">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                                <p class="card-text"><i>"Multikino to moje ulubione miejsce! Zawsze świetna atmosfera i
                                        filmy na najwyższym poziomie!"</i></p>
                                <h5 class="card-title">Anna K.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                                <p class="card-text"><i>"Kocham Multikino! Wygodne fotele, doskonały dźwięk i świetna
                                        jakość obrazu!"</i></p>
                                <h5 class="card-title">Michał P.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <p class="card-text"><i>"Fantastyczne miejsce na spotkanie z przyjaciółmi! Ceny są
                                        przystępne, a filmy zawsze na czasie!"</i></p>
                                <h5 class="card-title">Katarzyna W.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="far fa-star"></i>
                                <p class="card-text"><i>"Bardzo przytulna atmosfera i wygodne fotele. Obsługa miła, choć
                                        mogłoby być więcej przekąsek."</i></p>
                                <h5 class="card-title">Michał R.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                                <p class="card-text"><i>"Najlepsze kino w mieście! Duży wybór filmów i świetna jakość
                                        dźwięku. Zawsze tu wracam!"</i></p>
                                <h5 class="card-title">Anna L.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="far fa-star"></i>
                                <p class="card-text"><i>"Fajne miejsce na randkę, ale trochę za drogie bilety. Mimo to
                                        polecam dla kinomanów!"</i></p>
                                <h5 class="card-title">Tomasz K.</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>   
    </main>

<script>
// Ustawienie daty premiery
const premiereDate = new Date("June 13, 2025 00:00:00").getTime();

// Aktualizacja co sekundę
const countdownFunction = setInterval(function() {
    const now = new Date().getTime();
    const timeLeft = premiereDate - now;

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    document.getElementById("countdown").innerHTML = `Pozostało: ${days}d ${hours}h ${minutes}m ${seconds}s`;

    if (timeLeft < 0) {
        clearInterval(countdownFunction);
        document.getElementById("countdown").innerHTML = "Premiera już się odbyła!";
    }
}, 1000);

document.addEventListener("DOMContentLoaded", function() {
    let selectedFilmId = null;

    window.showModal = function(filmId, filmTitle) {
        selectedFilmId = filmId;

        <?php if (!isset($_SESSION['user'])): ?>
            // Jeśli użytkownik nie jest zalogowany, pokaż modal logowania
            document.getElementById("filmTitle").textContent = filmTitle;
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        <?php else: ?>
            // Jeśli użytkownik jest zalogowany, pokaż modal potwierdzenia
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();
        <?php endif; ?>
    };

    // Obsługa kliknięcia przycisku "Przejdź" w modalu potwierdzenia
    document.getElementById("confirmBtn").addEventListener("click", function() {
        if (selectedFilmId) {
            window.location.href = "seans.php?id=" + selectedFilmId;
        }
    });
});


</script>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>
