<?php
if (isset($_POST['submit'])) {
    // Połączenie z bazą danych
    $polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
    if (!$polaczenie) {
        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
    }
    mysqli_set_charset($polaczenie, 'utf8mb4');

    // Pobranie danych z formularza
    $film = (int)$_POST['film'];
    $sala = (int)$_POST['sala'];
    echo "Film ID: " . $_POST['film'] . "<br>";
echo "Sala ID: " . $_POST['sala'] . "<br>";
    
    $data = mysqli_real_escape_string($polaczenie, $_POST['data']);
    $godzina = mysqli_real_escape_string($polaczenie, $_POST['godzina']);
    $cena = mysqli_real_escape_string($polaczenie, $_POST['cena']);

    // Wstawienie danych do bazy
    $query = "INSERT INTO seans (ID_Sala, ID_Film, data, godzina, cena) VALUES ('$sala', '$film', '$data', '$godzina', '$cena')";
    if (mysqli_query($polaczenie, $query)) {
        // Przekierowanie do strony seans.php po dodaniu seansu
        header('Location: dodaj_seans.php?error=done');
        exit;
    } else {
        header('Location: dodaj_seans.php?error=blad');
    }

    // Zamknięcie połączenia z bazą
    mysqli_close($polaczenie);
}
?>
