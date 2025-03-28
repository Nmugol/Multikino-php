<?php
session_set_cookie_params(3600);
session_start();
require_once 'function.php';
$connect = get_sql();

$zalogowany = isset($_COOKIE['zalogowany']) ? $_COOKIE['zalogowany'] : 0;

if ($zalogowany != 2) {
    echo "Brak dostępu!";
    exit;
}

// Pobranie listy filmów
$filmy_query = "SELECT ID_Film, tytul FROM repertuar";
$filmy_result = mysqli_query($connect, $filmy_query);

// Pobranie listy sal
$sale_query = "SELECT ID_Sala, ilosc_miejsc FROM sala";
$sale_result = mysqli_query($connect, $sale_query);

// Pobranie nowego ID dla seansu
$id_query = "SELECT COUNT(*) AS liczba FROM seans";
$id_result = mysqli_query($connect, $id_query);
$row = mysqli_fetch_assoc($id_result);
$zmienna = $row['liczba'] + 1;
$seans_id = "SE_" . $zmienna;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pobieranie danych z formularza
    $film_id = $_POST['film']; // Zmieniamy na 'film' zgodnie z nazwą w formularzu
    $sala_id = $_POST['sala']; // Zmieniamy na 'sala' zgodnie z nazwą w formularzu
    $data = $_POST['data'];
    $godzina = $_POST['godzina'];
    $cena = $_POST['cena'];

    // Zapytanie SQL do dodania seansu
    $insert_query = "INSERT INTO seans (ID_Seans, ID_Film, ID_Sala, Data, Godzina, Cena) 
                     VALUES ('$seans_id', '$film_id', '$sala_id', '$data', '$godzina', '$cena')";
    
    if (mysqli_query($connect, $insert_query)) {
        echo "Seans dodany pomyślnie.";
    } else {
        echo "Błąd: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Seans</title>
</head>
<body>
    <h1>Dodaj nowy seans</h1>
    <form method="POST">
        <label for="film">Wybierz film:</label>
        <select name="film" id="film" required>
            <?php while ($film = mysqli_fetch_assoc($filmy_result)) { ?>
                <option value="<?php echo $film['ID_Film']; ?>"><?php echo $film['tytul']; ?></option>
            <?php } ?>
        </select>
        <br>
        
        <label for="sala">Wybierz salę:</label>
        <select name="sala" id="sala" required>
            <?php while ($sala = mysqli_fetch_assoc($sale_result)) { ?>
                <option value="<?php echo $sala['ID_Sala']; ?>">sala: <?php echo $sala['ID_Sala']; ?> </option>
            <?php } ?> 
        </select>
        <br>
        
        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required>
        <br>
        
        <label for="godzina">Godzina:</label>
        <input type="time" name="godzina" id="godzina" required>
        <br>
        
        <label for="cena">Cena biletu:</label>
        <input type="number" name="cena" id="cena" step="0.01" required>
        <br>
        
        <button type="submit">Dodaj seans</button>
    </form>
</body>
</html>
