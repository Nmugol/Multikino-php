<?php
declare(strict_types=1);
session_start();
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
                <h1 style='text-align:center'>Lista seansów</h1><br>
                <table id="filmsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Film</th>
                            <th>Sala</th>
                            <th>Data</th>
                            <th>Godzina</th>
                            <th>Cena</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4'); // Ustawienie kodowania na UTF-8

// Pobranie danych z tabeli 'seans' i dołączenie danych o filmie z tabeli 'repertuar'
$query = "SELECT seans.*, repertuar.tytul AS tytul_filmu FROM seans
          JOIN repertuar ON seans.ID_Film = repertuar.id
          ORDER BY seans.data DESC";
$wynik = mysqli_query($polaczenie, $query);

// Wyświetlenie wyników w tabeli
while ($row = mysqli_fetch_assoc($wynik)) {
    // Określenie, jaka sala (ID_Sala) ma być wyświetlana jako tekst
    switch ($row['ID_Sala']) {
        case 1:
            $sala = 'C - mała';
            break;
        case 2:
            $sala = 'B - średnia';
            break;
        case 3:
            $sala = 'A - duża';
            break;
        default:
            $sala = 'Nieznana sala';
    }

    echo "<tr>";
    echo "<td>{$row['tytul_filmu']}</td>";  // Wyświetlenie tytułu filmu
    echo "<td>{$sala}</td>";  // Wyświetlenie nazwy sali
    echo "<td>{$row['data']}</td>";  // Data seansu
    echo "<td>{$row['godzina']}</td>";  // Godzina seansu
    echo "<td>{$row['cena']} zł</td>";  // Cena biletu
    echo "</tr>";
}

// Zamknięcie połączenia
mysqli_close($polaczenie);
?>


                    </tbody>
                </table>
            </div>
</section>
    </main>
    <script>
    $(document).ready(function () {
        $('.table').DataTable({
            "order": [], // domyślnie brak sortowania — użytkownik może kliknąć nagłówki
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Polish.json"
            }
        });
    });
</script>

    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>

