<?php
if (isset($_POST['submit'])) {
    // Połączenie z bazą danych
    $polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
    if (!$polaczenie) {
        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
    }
    mysqli_set_charset($polaczenie, 'utf8mb4');

    // Pobranie danych z formularza
    $tytul = mysqli_real_escape_string($polaczenie, $_POST['tytul']);
    $gatunek = ($_POST['gatunek'] === 'inny') ? mysqli_real_escape_string($polaczenie, $_POST['inny_gatunek']) : mysqli_real_escape_string($polaczenie, $_POST['gatunek']);
    $dlugosc = (int)$_POST['dlugosc'];

    // Obsługa przesyłania pliku
    $obraz = $_FILES['obraz']['name'];
    $obrazTmp = $_FILES['obraz']['tmp_name'];
    $obrazFolder = '../image/';
    $sciezkaObrazu = $obrazFolder . basename($obraz);

    // Sprawdzenie, czy plik już istnieje w bazie
    $checkQuery = "SELECT COUNT(*) AS liczba FROM repertuar WHERE obraz = ?";
    $stmt = mysqli_prepare($polaczenie, $checkQuery);
    mysqli_stmt_bind_param($stmt, "s", $sciezkaObrazu);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['liczba'] > 0) {
        header('Location: film.php?error=Plik już istnieje. Zmień nazwę pliku!');
        exit();
    }

    // Przenoszenie pliku do folderu docelowego
    if (move_uploaded_file($obrazTmp, $sciezkaObrazu)) {
        // Wstawienie danych do bazy
        $query = "INSERT INTO repertuar (tytul, gatunek, dlugosc, obraz) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($polaczenie, $query);
        mysqli_stmt_bind_param($stmt, "ssis", $tytul, $gatunek, $dlugosc, $sciezkaObrazu);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: film.php?success=1');
        } else {
            header('Location: film.php?error=Błąd podczas dodawania filmu.');
        }
    } else {
        header('Location: film.php?error=Błąd przy przesyłaniu zdjęcia.');
    }

    // Zamknięcie połączenia z bazą
    mysqli_close($polaczenie);
}
?>
