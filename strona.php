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
</head>

<body onload="myLoadHeader()">
    <div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
        <!-- Sekcja powitalna z ostatnio dodanymi filmami -->
        <section class="sekcja1">
            <div class="container text-center my-5">
                <h1 class="display-4">Witamy w Multikinie!</h1>
                <p class="lead">Zanurz się w niesamowitym świecie filmów i emocji!</p><br>
                <p class="lead"><b>Nasze ostatnie nowości!</b></p>
                <div class="row">
                    <?php foreach ($filmy as $film): ?>
                        <div class="col-4"> <!-- Zmieniamy na col-4, aby zawsze były 3 kolumny -->
                            <div class="card mb-4 shadow-sm">
                                <img src="<?= $film['obraz']; ?>" class="card-img-top" alt="<?= $film['tytul']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 1.6vw;"><?= str_replace(' ', '&nbsp;', $film['tytul']); ?></h5>
                                    <p class="card-text" style="font-size: 1.2vw;"><?= $film['gatunek']; ?>&nbsp;|&nbsp;<?= $film['dlugosc']; ?>&nbsp;min</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
        <!-- Sekcja opinii użytkowników -->
        <section class="sekcja3 my-5">
            <div class="container text-center">
                <h2 class="display-4">Co mówią nasi widzowie?</h2>
                <div class="row">
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

    <!-- Przycisk do zmiany motywu -->
    <div class="dropdown position-fixed bottom-0 end-0 m-4" style="z-index:10;">
        <button class="btn btn-primary dropdown-toggle" type="button" id="themeDropdown" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i id="themeIcon" class="bi bi-sun-fill"></i> <!-- Ikona motywu -->
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
            <li><button class="dropdown-item" id="lightMode"><i class="bi bi-sun-fill"></i> Jasny</button></li>
            <li><button class="dropdown-item" id="darkMode"><i class="bi bi-moon-fill"></i> Ciemny</button></li>
            <li><button class="dropdown-item" id="autoMode"><i class="bi bi-circle-half"></i> Auto</button></li>
        </ul>
    </div>

    <?php require_once 'footer.php'; ?>
</body>


</html>