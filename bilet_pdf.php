<?php

require('fpdf186/fpdf.php');

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['id'])) {
    die("Błąd: Nie jesteś zalogowany.");
}

// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

// Pobranie ID rezerwacji z URL
$id_rezerwacji = $_GET['id'] ?? null;
if (!$id_rezerwacji) {
    die("Błąd: Brak ID rezerwacji.");
}

// Pobranie danych rezerwacji
$query = "SELECT r.ID_Rezerwacja, s.data, s.godzina, f.tytul, r.miejsce, sa.ID_Sala, s.cena
          FROM rezerwacja r
          JOIN seans s ON r.ID_Seans = s.ID
          JOIN repertuar f ON s.ID_Film = f.id
          JOIN sala sa ON s.ID_Sala = sa.ID_Sala
          WHERE r.ID_Rezerwacja = '$id_rezerwacji' AND r.status = 1"; // Tylko opłacone bilety

$result = mysqli_query($polaczenie, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    die("Błąd: Nie znaleziono biletu lub bilet nie został opłacony.");
}

$rezerwacja = mysqli_fetch_assoc($result);
mysqli_close($polaczenie);

// Funkcja do zamiany polskich znaków na ich odpowiedniki bez diakrytycznych
function zamienPolskieZnaki($tekst) {
    $zamiana = [
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n',
        'ó' => 'o', 'ś' => 's', 'ż' => 'z', 'ź' => 'z', 'ą' => 'a',
        'ę' => 'e', 'ó' => 'o', 'ś' => 's', 'ł' => 'l', 'ż' => 'z',
        'ź' => 'z'
    ];
    return strtr($tekst, $zamiana);
}

// Tworzenie PDF
$pdf = new FPDF();
$pdf->AddPage();

// Dodanie czcionki, która obsługuje polskie znaki
$pdf->SetFont('Arial', '', 12);

// Treść dokumentu PDF
$pdf->Cell(190, 10, 'Bilet do kina', 0, 1, 'C');
$pdf->Ln(10);

// Użycie Write() do dodania tekstu z obsługą polskich znaków
$pdf->Write(10, zamienPolskieZnaki('Film: ' . $rezerwacja['tytul']));
$pdf->Ln(5);
$pdf->Write(10, zamienPolskieZnaki('Data: ' . $rezerwacja['data']));
$pdf->Ln(5);
$pdf->Write(10, zamienPolskieZnaki('Godzina: ' . $rezerwacja['godzina']));
$pdf->Ln(5);
$pdf->Write(10, zamienPolskieZnaki('Sala: Sala ' . $rezerwacja['ID_Sala']));
$pdf->Ln(5);
$pdf->Write(10, zamienPolskieZnaki('Miejsce: ' . $rezerwacja['miejsce']));
$pdf->Ln(5);
$pdf->Write(10, zamienPolskieZnaki('Cena: ' . $rezerwacja['cena'] . ' zł'));
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Write(10, zamienPolskieZnaki('Miłe%%&&^&^go seansu!'));

// Pobieranie PDF (zamiast wyświetlania)
$pdf->Output('D', 'bilet.pdf'); // 'D' oznacza, że plik będzie pobrany. 'bilet.pdf' to nazwa pliku
?>
