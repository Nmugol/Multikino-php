<?php declare(strict_types=1);
session_start();

$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

// Sprawdzenie, czy użytkownik wybrał gatunek
$gatunek = isset($_GET['gatunek']) ? $_GET['gatunek'] : '';

// Pobranie unikalnych gatunków z bazy danych
$gatunkiQuery = "SELECT DISTINCT gatunek FROM repertuar ORDER BY gatunek";
$gatunkiResult = mysqli_query($polaczenie, $gatunkiQuery);
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
 .card-img-top {
    width: 100%;
    height: auto;
    max-height: 450px; /* Maksymalna wysokość */
    height: 450px;
    object-fit: cover;
    transition: opacity 0.3s ease;
}

.card-body {
    position: relative;
    background-color: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 1rem; /* Zapewnia skalowanie */
    text-align: center;
    width: 100%;
    box-sizing: border-box; /* Zapewnia, że padding nie będzie wychodził poza granice */
    overflow: hidden;  /* Zapobiega wychodzeniu treści poza granice */
}

.card-title {
    font-size: 0.9rem; /* Skalowanie zależnie od ekranu */
    margin: 5px;
    white-space: normal;  /* Zezwala na zawijanie tekstu */
    word-wrap: break-word;  /* Zawija długie słowa */
}

.card-text {
    font-size: 0.9rem; /* Skalowanie zależnie od ekranu */
    margin:0px;
    white-space: normal;  /* Zezwala na zawijanie tekstu */
    word-wrap: break-word;  /* Zawija długie słowa */
}

.card {
    width: 100%;
    max-width: 400px; /* Ograniczenie maksymalnej szerokości */
    border: none;
    border-radius: 1vw;
    box-shadow: 0 1vw 1vw rgba(0, 0, 0, 0.1);
    background-color: rgba(0, 0, 0, 0.9);
    color: white;
    margin: 1vw auto; /* Wyśrodkowanie */
    position: relative;
    align-items: center;
    overflow: hidden;
}

/* Dodatkowe style przycisku */
.info-btn {
    width: 100%;
    border-radius: 1px;
    box-shadow: 0 1vw 1vw rgba(0, 0, 0, 0.1);
}


.modal-backdrop {
    display: none !important;
}

.modal {
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
}

.modal-dialog {
    max-width: 500px;
    margin: 10% auto;
}

.modal-content {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
}

.modal-footer {
    border-top: 1px solid #ddd;
}

.modal-footer .btn {
    padding: 10px 20px;
}


/* Responsywność */
@media (max-width: 768px) {
    .card-img-top {
    width: 100%;
    height: 450px;
    object-fit: cover;
    transition: opacity 0.3s ease;
}
    .card {
        max-width: 90%; /* Zmniejszenie karty na mniejszych ekranach */
    }

    .card-title, .card-text {
        margin-left: -10px;
        margin-right: -10px;
        font-size: 8px; /* Mniejsza czcionka na telefonach */
    }
 
    .info-btn {
    width: 100%;
    font-size: 10px;
    border-radius: 1px;
    box-shadow: 0 1vw 1vw rgba(0, 0, 0, 0.1);

    .modal-backdrop {
    display: none !important;
}

.modal {
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
}

.modal-dialog {
    max-width: 500px;
    margin: 10% auto;
}

.modal-content {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
}

.modal-footer {
    border-top: 1px solid #ddd;
}

.modal-footer .btn {
    padding: 10px 20px;
}
}

}

@media (max-width: 480px) {
    .card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: opacity 0.3s ease;
}
   
    .card {
        max-width: 95%; /* Jeszcze mniejsze karty na telefonach */
    }


    .card-title, .card-text {
        margin-left: -10px;
        margin-right: -10px;
        font-size: 8px; /* Mniejsza czcionka na telefonach */
    }

  
    /* Dodatkowe style przycisku */
.info-btn {
    width: 100%;
    font-size: 10px;
    border-radius: 1px;
    box-shadow: 0 1vw 1vw rgba(0, 0, 0, 0.1);
}

}

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
}

.card img:hover {
    opacity: 60%;
    transition: opacity 0.3s ease-in-out;
    cursor: pointer;
}
    </style>
</head>

<body onload="myLoadHeader()">
    <div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
        <section class="sekcja3 my-5">
            <div class="container mt-5"><br>
                <h1 style='text-align:center'>Lista filmów</h1>
                <!-- Formularz filtra -->
        <form method="GET" action="" class="mb-4">
            <label for="gatunek">Wybierz gatunek:</label>
            <select name="gatunek" id="gatunek" class="form-select w-auto d-inline-block">
                <option value="">Wszystkie</option>
                <?php
                // Wyświetlanie dostępnych gatunków w opcji select
                while ($row = mysqli_fetch_assoc($gatunkiResult)) {
                    $selected = ($row['gatunek'] == $gatunek) ? 'selected' : ''; // Jeśli gatunek jest wybrany, dodajemy atrybut 'selected'
                    echo "<option value='" . htmlspecialchars($row['gatunek']) . "' $selected>" . htmlspecialchars($row['gatunek']) . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary">Filtruj</button>
        </form>
                <div class="row">
                <?php
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

// Sprawdzenie, czy użytkownik wybrał gatunek
$gatunek = isset($_GET['gatunek']) ? $_GET['gatunek'] : '';

// Modyfikacja zapytania w zależności od wybranego gatunku
if ($gatunek) {
    $query = "SELECT * FROM repertuar WHERE gatunek = '$gatunek' ORDER BY id DESC";
} else {
    $query = "SELECT * FROM repertuar ORDER BY id DESC";
}

$result = mysqli_query($polaczenie, $query);
mysqli_close($polaczenie);

while ($film = mysqli_fetch_assoc($result)): ?>
    <div class="col-lg-3 col-md-4 col-4 mb-4">
    <div class="card" style="position: relative;">
        <img src="<?= htmlspecialchars($film['obraz']) ?>" class="card-img-top" onclick="openModal(<?= $film['id'] ?>)" alt="<?= htmlspecialchars($film['tytul']) ?>">
        <button class="btn btn-primary info-btn" onclick="toggleInfo(<?= $film['id'] ?>)">Informacje o filmie</button>
        <div class="card-body overlay" id="info-<?= $film['id'] ?>" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 35%; background: rgba(0, 0, 0, 0.8); color: white; text-align: center; padding: 1rem; box-sizing: border-box;">
            <h5 class="card-title"><?= str_replace(' ', '&nbsp;', $film['tytul']); ?></h5>
            <p class="card-title"><strong>Gatunek:</strong> <?= htmlspecialchars($film['gatunek']) ?></p>
            <p class="card-title"><strong>Czas:</strong> <?= htmlspecialchars($film['dlugosc']) ?>&nbsp;min</p>
        </div>
    </div>
</div>

<?php endwhile; ?>
</div>
 <!-- MODAL -->
<!-- Modal z pytaniem, czy przejść do harmonogramu -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Czy przejść do harmonogramu seansu?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Chcesz przejść do harmonogramu seansu dla tego filmu?</p>
                <p>Dzięki temu będziesz mógł szybko zobaczyć dostępne godziny oraz zarezerwować bilety na seans.</p>
    <p><em>Nie czekaj, wybierz najlepszy termin i ciesz się filmem na dużym ekranie!</em></p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-success" id="confirmBtn">Przejdź</button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedFilmId = null;

// Otwieranie modalu
function openModal(filmId) {
    selectedFilmId = filmId;
    $('#confirmModal').modal('show');  // Używamy jQuery, by otworzyć modal
}

// Zatwierdzenie akcji po kliknięciu 'Zatwierdź'
document.getElementById("confirmBtn").addEventListener("click", function () {
    if (selectedFilmId !== null) {
        window.location.href = "seans.php?id=" + selectedFilmId; // Przekierowanie do harmonogramu
    }
});

// Zamykanie modalu
function closeModal() {
    $('#confirmModal').modal('hide');
}


function toggleInfo(filmId) {
        var cardBody = document.getElementById("info-" + filmId);
        if (cardBody.style.display === "none" || cardBody.style.display === "") {
            cardBody.style.display = "block";
        } else {
            cardBody.style.display = "none";
        }
    }
</script>

</div>
 </section>
    </main>
<?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>