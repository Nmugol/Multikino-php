<?php

declare(strict_types=1);
session_start();

// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

// Pobranie ID klienta z sesji
$id_klienta = $_SESSION['id'] ?? null;
if (!$id_klienta) {
    die("Błąd: Nie znaleziono ID klienta.");
}

// Pobranie rezerwacji użytkownika z dodatkowymi informacjami o sali, cenie
$query = "SELECT r.ID_Rezerwacja, s.data, s.godzina, f.tytul, r.status, sa.ID_Sala, r.miejsce, s.cena 
          FROM rezerwacja r
          JOIN seans s ON r.ID_Seans = s.ID
          JOIN repertuar f ON s.ID_Film = f.id
          JOIN sala sa ON s.ID_Sala = sa.ID_Sala
          WHERE r.ID_Klient = '$id_klienta'
          ORDER BY r.status DESC, s.data DESC, s.godzina DESC"; // Sortowanie: najpierw opłacone, potem data, godzina

$result = mysqli_query($polaczenie, $query);
if (!$result) {
    die("Błąd zapytania: " . mysqli_error($polaczenie));
}

// Aktualizacja statusu rezerwacji na opłacony
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_id'])) {
    $payment_id = (int) $_POST['payment_id'];
    $blik_code = $_POST['blik_code'] ?? null;

    if (strlen($blik_code) == 6 && ctype_digit($blik_code)) {
        $stmt = $polaczenie->prepare("UPDATE rezerwacja SET status = 1 WHERE ID_Rezerwacja = ?");
        $stmt->bind_param("i", $payment_id);
        if ($stmt->execute()) {
            header('Location: modyfikuj.php?error=done');
        } else {
            header('Location: modyfikuj.php?error=blad');
        }
        $stmt->close();
    } else {
        header('Location: modyfikuj.php?error=blik');
    }
}

// Usuwanie rezerwacji
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];
    $delete_query = "DELETE FROM rezerwacja WHERE ID_Rezerwacja = '$delete_id' AND status = 0";
    if (mysqli_query($polaczenie, $delete_query)) {
        header('Location: modyfikuj.php?error=usun');
    } else {
        header('Location: modyfikuj.php?error=busun');
    }
}

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
    <script src="https://cdn.jsdelivr.net/npm/qr-code-styling/lib/qr-code-styling.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        section{
            padding: 0px;
        }
        
        section h1{
            margin-top: -30px;

        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }

        .table thead {
            background-color: #343a40;
            color: white;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .btn-smaller {
            font-size: 14px;
            padding: 8px 10px;
        }
   .modal-backdrop {
            display: none !important;
}

        /* Responsywność */
        @media (max-width: 768px) {

            .table td,
            .table th {
                font-size: 15px;
                padding: 8px;
            }

            .btn-smaller {
                font-size: 12px;
                padding: 5px 8px;
            }
        }

        @media (max-width: 480) {

            .table td,
            .table th {
                font-size: 12px;
                padding: 8px;
            }

            .btn-smaller {
                font-size: 12px;
                padding: 5px 8px;
            }
        }

        
[data-bs-theme="blue"] .modal-content{
    color: white;
    text-shadow: black 0.1em 0.1em 0.2em;
}
[data-bs-theme="dark"] .modal-content {
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

    </style>
</head>

<body onload="myLoadHeader()">
    <div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
        <section class="sekcja3 my-5">
            <div class="container mt-5">
                <h1 style='text-align:center'>Twoje rezerwacje</h1><br>
                <?php
                if (isset($_GET['error']) && $_GET['error'] === 'busun') {
                    echo "<div class='alert alert-danger'>Błąd podczas usuwania rezerwacji!</div>";
                } else if (isset($_GET['error']) && $_GET['error'] === 'blik') {
                    echo "<div class='alert alert-danger'>Niepoprawny kod BLIK!</div>";
                } else if (isset($_GET['error']) && $_GET['error'] === 'blad') {
                    echo "<div class='alert alert-danger'>Błąd podczas aktualizacji statusu rezerwacji!</div>";
                } else if (isset($_GET['error']) && $_GET['error'] === 'done') {
                    echo "<div class='alert alert-success'>Rezerwacja opłacona!</div>";
                } else if (isset($_GET['error']) && $_GET['error'] === 'usun') {
                    echo "<div class='alert alert-success'>Rezerwacja została usunięta!</div>";
                }
                ?>
                <form method="POST">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Film</th>
                                    <th>Data</th>
                                    <th>Godzina</th>
                                    <th>Sala</th>
                                    <th>Zarezerwowane miejsca</th>
                                    <th>Cena</th>
                                    <th>Status</th>
                                    <th>Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)):
                                    // Przypisanie nazwy sali do ID
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
                                       // Pobranie numerów miejsc
        $miejsca = explode(',', $row['miejsce']);  // Rozdzielamy numery miejsc po przecinku
        $liczbaMiejsc = count($miejsca);  // Liczba miejsc to długość tablicy

        $cenaZaMiejsce = (float) $row['cena'];  // Cena za jedno miejsce

        // Obliczenie łącznej ceny
        $cenaZaRezerwacje = $liczbaMiejsc * $cenaZaMiejsce;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['tytul']) ?></td>
                                        <td><?= htmlspecialchars($row['data']) ?></td>
                                        <td><?= htmlspecialchars($row['godzina']) ?></td>
                                        <td><?= htmlspecialchars($salaNazwa) ?></td>
                                        <td>
    <?php 
    $miejsca = explode(',', $row['miejsce']); // Rozdzielamy miejsca po przecinku
    $liczbaMiejsc = count($miejsca);
    
    foreach ($miejsca as $index => $miejsce) {
        echo htmlspecialchars($miejsce); // Wyświetlamy miejsce
        
        // Jeśli to nie ostatnie miejsce, dodaj przecinek
        if ($index < $liczbaMiejsc - 1) {
            echo ", ";
        }
        
        // Nowa linia co 5 miejsc
        if (($index + 1) % 5 == 0) {
            echo "<br>";
        }
    }
    ?>
</td>

                                        <td><?= number_format($cenaZaRezerwacje, 2) ?> zł</td> <!-- Wyświetlanie łącznej ceny -->
                                        </td>
                                        <td>
    <?php if ($row['status'] == 0): ?>
        <button type="button" class="btn btn-success btn-smaller" data-bs-toggle="modal" data-bs-target="#paymentModal" onclick="setPaymentId(<?= $row['ID_Rezerwacja'] ?>)">Opłać</button>
    <?php else: ?>
        <button type="button" class="btn btn-primary btn-smaller" onclick="generateQR('<?= htmlspecialchars($row['tytul']) ?>', '<?= htmlspecialchars($row['data']) ?>', '<?= htmlspecialchars($row['godzina']) ?>', '<?= htmlspecialchars($row['miejsce']) ?>', '<?= htmlspecialchars($row['cena']) ?>', '<?= htmlspecialchars($salaNazwa) ?>')">Pobierz bilet</button>
        <!-- Modal QR Code
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Twój Bilet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrcode"></div>
                <p class="mt-3">Pokaż ten kod QR przy wejściu na seans.</p>

                <a href="bilet_pdf.php?id=<?= $row['ID_Rezerwacja'] ?>" class="btn btn-warning btn-smaller">
        Pobierz PDF <i class="fas fa-file-pdf"></i>
    </a>
            </div>
        </div>
    </div>
</div> -->

    <?php endif; ?>
</td>

                                        <td>
                                            <?php if ($row['status'] == 0): ?>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="delete_id" value="<?= $row['ID_Rezerwacja'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-smaller">Usuń</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">Kontakt z obsługą</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                </form>
            </div>
<!-- Modal QR Code -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Twój Bilet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrcode"></div>
                <p class="mt-3">Pokaż ten kod QR przy wejściu na seans.</p>
                
            </div>
            
        </div>
        
    </div>
    
</div>

            <!-- Modal płatności -->
            <div class="modal fade" id="paymentModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Wpisz kod <strong style="color:green">BLIK</strong></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="blik_code" class="form-label">Kod BLIK (6 cyfr)</label>
                                    <input type="text" class="form-control" id="blik_code" name="blik_code" maxlength="6" pattern="\d{6}" required>
                                </div>
                                <input type="hidden" name="payment_id" id="payment_id">
                                <button type="submit" class="btn btn-success">Zapłać</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function setPaymentId(paymentId) {
                    document.getElementById('payment_id').value = paymentId;
                }

                function generateQR(title, date, time, seat, price, sala) {
    // Zamiana miejsc w formie '14,15' na tablicę numerów miejsc
    const miejsca = seat.split(','); // Dzielimy miejsca po przecinku
    const liczbaMiejsc = miejsca.length;  // Liczymy liczbę zarezerwowanych miejsc

    // Obliczamy łączną cenę (cena * liczba miejsc)
    const cenaZaMiejsce = parseFloat(price);  // Cena za jedno miejsce
    const cenaZaRezerwacje = (liczbaMiejsc * cenaZaMiejsce).toFixed(2);  // Obliczamy łączną cenę

    // Tworzenie tekstu do wyświetlenia w QR, uwzględniając nazwę sali
    let qrData = `Film: ${title}\nData: ${date}\nGodzina: ${time}\nSala: ${sala}\nMiejsce: ${seat}\nCena [PLN]: ${cenaZaRezerwacje}`;

    // Zamiana polskich znaków na ich odpowiedniki bez ogonków
    const polishChars = {
        'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ż': 'z', 'ź': 'z',
        'Ą': 'A', 'Ć': 'C', 'Ę': 'E', 'Ł': 'L', 'Ń': 'N', 'Ó': 'O', 'Ś': 'S', 'Ż': 'Z', 'Ź': 'Z'
    };

    qrData = qrData.split('').map(char => polishChars[char] || char).join('');

    // Czyszczenie starego QR
    document.getElementById("qrcode").innerHTML = ""; 

    // Generowanie nowego QR
    const qr = new QRCodeStyling({
        width: 200,
        height: 200,
        data: qrData,
        dotsOptions: { color: "#000", type: "rounded" },
        backgroundOptions: { color: "#fff" },
        imageOptions: { crossOrigin: "anonymous", margin: 10 }
    });

    // Wyświetlanie QR w modal
    qr.append(document.getElementById("qrcode"));

    new bootstrap.Modal(document.getElementById('qrModal')).show();

}


            </script>
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
</body>
<?php require_once 'footer.php'; ?>


</html>