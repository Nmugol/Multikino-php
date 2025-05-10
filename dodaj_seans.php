<?php
declare(strict_types=1);
session_start();

// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
// Ustawienie kodowania na UTF-8
mysqli_set_charset($polaczenie, 'utf8mb4');

// Pobranie listy filmów
$queryFilmy = "SELECT ID, tytul FROM repertuar";
$resultFilmy = mysqli_query($polaczenie, $queryFilmy);

// Pobranie listy sal (teraz tylko ID_Sala)
$querySale = "SELECT ID_Sala FROM sala";
$resultSale = mysqli_query($polaczenie, $querySale);

// Pobranie bieżącej daty i godziny serwera
date_default_timezone_set('Europe/Warsaw');
$dzisiaj = date('Y-m-d');
$teraz = date('H:i');

// Zamknięcie połączenia z bazą danych
mysqli_close($polaczenie);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Multikino</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <style type="text/css" class="init"></style>
    <link rel="stylesheet" href="twoj_css.css">
    <link rel="stylesheet" href="strona.css">
    <!-- <link rel="stylesheet" href="miejsce.css"> -->
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
        <section class="sekcja3">
            <div class="container mt-5">
                <h1 style='text-align:center'>Dodaj seans</h1><br>
                <?php
    if (isset($_GET['error']) && $_GET['error'] === 'blad') {
        echo "<div class='alert alert-danger'>Błąd podczas dodawania seansu!</div>";
    }else if (isset($_GET['error']) && $_GET['error'] === 'done') {
        echo "<div class='alert alert-success'>Seans został dodany pomyślnie!</div>";
    }
    ?>
                <form action="seans_add.php" method="POST">
                    <div class="mb-3">
                        <label for="film" class="form-label">Wybierz Film</label>
                        <select class="form-control" id="film" name="film" required>
                            <?php
                            // Sprawdzanie dostępnych filmów
                            if (mysqli_num_rows($resultFilmy) > 0) {
                                while ($row = mysqli_fetch_assoc($resultFilmy)) {
                                    echo "<option value='" . $row['ID'] . "'>" . htmlspecialchars($row['tytul'], ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                            } else {
                                echo "<option disabled>Brak dostępnych filmów</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sala" class="form-label">Wybierz Salę</label>
                        <select class="form-control" id="sala" name="sala" required>
                            <?php
                            // Sprawdzanie dostępnych sal (teraz tylko ID_Sala)
                            if (mysqli_num_rows($resultSale) > 0) {
                                while ($row = mysqli_fetch_assoc($resultSale)) {
                                    $salaNazwa = '';

                                    // Przypisanie nazwy sali w zależności od ID
                                    switch ($row['ID_Sala']) {
                                        case 1:
                                            $salaNazwa = 'C - mała';
                                            break;
                                        case 2:
                                            $salaNazwa = 'B - średnia';
                                            break;
                                        case 3:
                                            $salaNazwa = 'A - duża';
                                            break;
                                        default:
                                            $salaNazwa = 'nieznana'; // Obsługa innych ID
                                            break;
                                    }

                                    echo "<option value='" . $row['ID_Sala'] . "'>" . $salaNazwa . "</option>";
                                }
                            } else {
                                echo "<option disabled>Brak dostępnych sal</option>";
                            }
                            ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="data" class="form-label">Data seansu</label>
                        <input type="date" class="form-control" id="data" name="data" value="<?php echo $dzisiaj; ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="godzina" class="form-label">Godzina seansu</label>
                        <input type="time" class="form-control" id="godzina" name="godzina"
                            value="<?php echo $teraz; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="cena" class="form-label">Cena  [PLN]</label>
                        <input type="number" class="form-control" id="cena" name="cena" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Dodaj Seans</button>
                </form>
            </div>
        </section>
    </main>

    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>