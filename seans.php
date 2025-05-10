<?php
declare(strict_types=1);
session_start();

// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

// ✅ Pobierz ID filmu z URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Błąd: Niepoprawne ID filmu.");
}

$filmId = (int) $_GET['id']; // Konwersja na int dla bezpieczeństwa

// ✅ Pobierz tytuł filmu z tabeli repertuar
$queryFilm = "SELECT tytul FROM repertuar WHERE ID = $filmId LIMIT 1";
$resultFilm = mysqli_query($polaczenie, $queryFilm);
if (!$resultFilm || mysqli_num_rows($resultFilm) === 0) {
    die("Błąd: Nie znaleziono filmu o podanym ID.");
}
$film = mysqli_fetch_assoc($resultFilm);
$tytulFilmu = htmlspecialchars($film['tytul']); // Zabezpieczenie przed XSS

// ✅ Pobierz seanse dla danego filmu, posortowane od najnowszych do najstarszych
$querySeanse = "
    SELECT seans.*, sala.ilosc_miejsc, 
           (SELECT COALESCE(SUM(ilosc_biletow), 0) FROM rezerwacja WHERE rezerwacja.ID_Seans = seans.ID) AS zajete_miejsca
    FROM seans
    JOIN sala ON seans.ID_Sala = sala.ID_Sala
    WHERE seans.ID_Film = $filmId
    ORDER BY seans.data DESC, seans.godzina ASC";
$resultSeanse = mysqli_query($polaczenie, $querySeanse);
if (!$resultSeanse) {
    die("Błąd zapytania: " . mysqli_error($polaczenie));
}

$seanse = mysqli_fetch_all($resultSeanse, MYSQLI_ASSOC);

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
        section {
            padding: 30px;
            border-radius: 8px;
        }


        h2 {
            text-align: center;
            color: #333;
            font-size: 2rem;

            margin-top: -30px;
            margin-bottom: 40px;

        }        

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn-primary {
            background-color: #28a745; /* Zmieniono kolor na zielony */
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838; /* Zmiana koloru na ciemniejszy przy hover */
            border-color: #1e7e34;
        }

        .no-data {
            font-size: 1.2rem;
            color: #dc3545; /* Czerwony dla braku danych */
            text-align: center;
        }

        .btn {
            font-size: 1rem;
            border-radius: 5px;
        }

        .emoji {
            font-size: 1.5rem;
            margin-right: 5px;
        }

        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: center;
        }

      

        /* Styl przycisku powrotu */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
        }

        /* Responsywność tabeli */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table-striped{
                width: 600px;
            }
        }
         /* Responsywność tabeli */
         @media (max-width: 480px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table-striped{
                width: 600px;
            }
        }

        body[data-bs-theme="dark"] h2, body[data-bs-theme="blue"] h2{
    color: #f8f9fa;
}

    </style>
</head>

<body onload="myLoadHeader()">
<div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>

    <section class="sekcja3 my-5">
    <div class="container mt-5">
        <h2>Seanse dla filmu: <br>"<?= $tytulFilmu ?>"</h2>

        <?php 
        $wolne_seanse = array_filter($seanse, function($seans) {
            return ($seans['ilosc_miejsc'] - $seans['zajete_miejsca']) > 0;
        });

        if (count($wolne_seanse) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>📅 Data</th>
                            <th>⏰ Godzina</th>
                            <th>🎥 Sala</th>
                            <th>💸 Cena</th>
                            <th>🪑 Wolne miejsca</th>
                            <th>🔒 Rezerwacja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seanse as $seans): 
                            // Obliczenie wolnych miejsc
                            $wolne_miejsca = $seans['ilosc_miejsc'] - $seans['zajete_miejsca'];

                            // Pominięcie rekordu, jeśli nie ma wolnych miejsc
                            if ($wolne_miejsca <= 0) {
                                continue;
                            }

                            // Przypisanie nazwy sali do ID
                            switch ($seans['ID_Sala']) {
                                case 1: $salaNazwa = 'C - mała'; break;
                                case 2: $salaNazwa = 'B - średnia'; break;
                                case 3: $salaNazwa = 'A - duża'; break;
                                default: $salaNazwa = 'nieznana'; break;
                            }
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($seans['data']) ?></td>
                            <td><?= htmlspecialchars($seans['godzina']) ?></td>
                            <td><?= htmlspecialchars($salaNazwa) ?></td>
                            <td><?= htmlspecialchars($seans['cena']) ?> zł</td>
                            <td>
                                <?php if ($wolne_miejsca > 0 && $wolne_miejsca <= 10): ?>
                                    <span class="lead3">Tylko
                                <?php endif; ?>
                                <?= $wolne_miejsca ?></span>
                                <?php if ($wolne_miejsca > 0 && $wolne_miejsca <= 10): ?>
                                    <span class="lead3">!!!</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="miejsce.php?seans_id=<?= $seans['ID'] ?>" class="btn btn-primary">Rezerwuj</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">Brak wolnych miejsc!<br>Zarezerwowano wszystkie miejsca dla wszystkich dostępnych seansów!<br>Spróbuj wybrać inny film z podobnej kategorii.</p>
        <?php endif; ?>
    </div>
</section>
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

</main>
<?php require_once 'motyw.php'; ?>
<?php require_once 'footer.php'; ?>
</body>

</html>
