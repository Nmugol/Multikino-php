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

// Pobranie ID rezerwacji z URL
$reservationId = $_GET['id'] ?? null;
if (!$reservationId) {
    die("Błąd: Brak ID rezerwacji.");
}

// Pobranie danych rezerwacji
$query = "SELECT r.ID_Rezerwacja, s.data, s.godzina, f.tytul, r.status, sa.ID_Sala, r.miejsce, s.cena 
          FROM rezerwacja r
          JOIN seans s ON r.ID_Seans = s.ID
          JOIN repertuar f ON s.ID_Film = f.id
          JOIN sala sa ON s.ID_Sala = sa.ID_Sala
          WHERE r.ID_Rezerwacja = '$reservationId' AND r.ID_Klient = '$id_klienta'";

$result = mysqli_query($polaczenie, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    die("Błąd: Nie znaleziono rezerwacji.");
}

$row = mysqli_fetch_assoc($result);

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
        $salaNazwa = 'nieznana';
        break;
}

mysqli_close($polaczenie);

// Funkcja generująca kod QR
require_once 'qrlib.php';

function generateQrCode($reservationId) {
    $tempDir = 'qr_codes/'; // Ścieżka do katalogu, gdzie zapisujemy QR kody
    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0777, true);
    }
    $fileName = $tempDir . "ticket_$reservationId.png";
    $content = "https://yourwebsite.com/ticket.php?id=$reservationId"; // Link do biletu

    // Generowanie QR kodu i zapisanie go do pliku
    QRcode::png($content, $fileName);

    return $fileName; // Ścieżka do wygenerowanego pliku QR
}

// Generowanie kodu QR
$qrCodeFile = generateQrCode($reservationId);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bilet - Multikino</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Twój bilet</h1>
        <div class="row">
            <div class="col-md-6">
                <h4>Film: <?= htmlspecialchars($row['tytul']) ?></h4>
                <p><strong>Data:</strong> <?= htmlspecialchars($row['data']) ?></p>
                <p><strong>Godzina:</strong> <?= htmlspecialchars($row['godzina']) ?></p>
                <p><strong>Sala:</strong> <?= htmlspecialchars($salaNazwa) ?></p>
                <p><strong>Miejsca:</strong> <?= htmlspecialchars($row['miejsce']) ?></p>
                <p><strong>Cena:</strong> <?= htmlspecialchars($row['cena']) ?> zł</p>
                <p><strong>Status:</strong> <?= $row['status'] == 1 ? 'Opłacona' : 'Nieopłacona' ?></p>
            </div>
            <div class="col-md-6 text-center">
                <h4>Twój kod QR:</h4>
                <img src="<?= $qrCodeFile ?>" alt="Kod QR" class="img-fluid">
                <p><strong>Możesz pobrać swój bilet:</strong></p>
                <a href="<?= $qrCodeFile ?>" class="btn btn-primary" download>Pobierz bilet</a>
            </div>
        </div>
    </div>
</body>

</html>
