<?php 
require_once 'function.php';
$connect = get_sql();

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['thisIDSeans'])) {
    $_SESSION['thisIDSeans'] = $_POST['thisIDSeans'];
}

$thisIDSeans = $_SESSION['thisIDSeans'] ?? null;
if (!is_null($thisIDSeans)) {

    $id_klienta = $_COOKIE['id'];

    // Pobranie informacji o sali i seansie
    $sala_query = "SELECT s.ID_Sala, s.data, s.godzina, s.cena, sa.ilosc_miejsc, f.tytul 
                   FROM seans s 
                   JOIN sala sa ON s.ID_Sala = sa.ID_Sala 
                   JOIN repertuar f ON s.ID_Film = f.ID_Film
                   WHERE s.ID_Seans = '$thisIDSeans'";
    $result_s = mysqli_query($connect, $sala_query);
    $sala_row = mysqli_fetch_assoc($result_s);

    $sala_id = $sala_row['ID_Sala'];
    $data = $sala_row['data'];
    $godzina = $sala_row['godzina'];
    $cena = $sala_row['cena'];
    $ilosc_miejsc = $sala_row['ilosc_miejsc'];
    $tytul_filmu = $sala_row['tytul'];

    // Pobranie zajętych miejsc z tabeli rezerwacja
    $zajete_miejsca_query = "SELECT miejsce FROM rezerwacja WHERE ID_Seans = '$thisIDSeans'";
    $result_zajete = mysqli_query($connect, $zajete_miejsca_query);
    $zajete_miejsca = [];
    while ($row = mysqli_fetch_assoc($result_zajete)) {
        $zajete_miejsca = array_merge($zajete_miejsca, explode(',', $row['miejsce']));
    }

    // Utworzenie pełnej listy miejsc od 1 do ilosc_miejsc
    $wszystkie_miejsca = range(1, $ilosc_miejsc);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['thisIDMiejsca'])) {
    $selectedPlaces = $_POST['thisIDMiejsca'];
    $selectedPlacesString = implode(",", $selectedPlaces);

    $add = "INSERT INTO rezerwacja (ID_Klient, ID_Seans, ID_Sala, data, godzina, ilosc_biletow, miejsce, cena) 
            VALUES ('$id_klienta', '$thisIDSeans', '$sala_id', '$data', '$godzina', '" . count($selectedPlaces) . "', '$selectedPlacesString', '$cena')";
    mysqli_query($connect, $add);

    // Wyświetlamy komunikat o sukcesie i przekierowujemy po 5 sekundach
    echo "
    <div style='text-align: center; padding: 50px;'>
        <h2>Rezerwacja zakończona sukcesem!</h2>
        <p>Twoja rezerwacja została pomyślnie dokonana. Za chwilę zostaniesz przekierowany na stronę główną.</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 5000); // Po 5 sekundach przekierowanie na index.php
    </script>
    ";
    exit(); // Zapobiegamy dalszemu wykonywaniu skryptu
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miejsce</title>
    <link rel="stylesheet" href="miejsce.css">
</head>

<body>
    <div class="naglowek">
        <ul>
            <li><a href="index.php">Strona główna </a></li>
            <li style="float:right"><a href="wyloguj.php">Wyloguj się</a></li>
        </ul>
    </div>
    <div class="container">
        <?php if (!is_null($thisIDSeans)) { ?>
            <!-- Sekcja prezentująca dane filmu, sali i seansu -->
            <div class="seans-info">
                <h2>Informacje o seansie</h2>
                <div class="info-item">
                    <strong>Film:</strong> <span><?= $tytul_filmu ?></span>
                </div>
                <div class="info-item">
                    <strong>Data:</strong> <span><?= $data ?></span>
                </div>
                <div class="info-item">
                    <strong>Godzina:</strong> <span><?= $godzina ?></span>
                </div>
                <div class="info-item">
                    <strong>Sala:</strong> <span><?= $sala_id ?></span>
                </div>
                <div class="info-item">
                    <strong>Cena biletu:</strong> <span><?= $cena ?> PLN</span>
                </div>
            </div>

            <h1>Wybierz miejsce</h1>
            <form method='post' action='miejsce.php' id="seatsForm">
                <div class="seats-grid">
                    <?php 
                    $counter = 0;
                    foreach ($wszystkie_miejsca as $miejsce) { 
                        $is_taken = in_array($miejsce, $zajete_miejsca);
                    ?>
                        <label class="seat <?= $is_taken ? 'taken' : '' ?>" data-seat="<?= $miejsce ?>">
                            <?= $miejsce ?>
                            <?php if (!$is_taken) { ?>
                                <input type="checkbox" name="thisIDMiejsca[]" value="<?= $miejsce ?>" hidden>
                            <?php } ?>
                        </label>
                    <?php 
                    } 
                    ?>
                </div>
                <input type='submit' value='Zatwierdź' class="confirm-btn">
            </form>
        <?php } else { ?>
            <h2>Brak dostępnych miejsc, przepraszamy!</h2>
        <?php } ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const seats = document.querySelectorAll(".seat:not(.taken)");

            seats.forEach(seat => {
                seat.addEventListener("click", function() {
                    const checkbox = this.querySelector("input[type='checkbox']");
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;
                        this.classList.toggle("selected", checkbox.checked);
                    }
                });
            });
        });
    </script>
</body>
</html>
