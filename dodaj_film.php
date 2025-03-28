<?php
session_set_cookie_params(3600);
session_start();
require_once 'function.php';
$connect = get_sql();

$zalogowany = isset($_COOKIE['zalogowany']) ? $_COOKIE['zalogowany'] : 0;

if ($zalogowany != 2) {
    echo "<p>Brak uprawnień do dodawania filmów!</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tytul = mysqli_real_escape_string($connect, $_POST['tytul']);
    $gatunek = mysqli_real_escape_string($connect, $_POST['gatunek']);
    $dlugosc = (int)$_POST['dlugosc'];
    
    // Pobranie aktualnej liczby filmów, aby utworzyć nowy F_index
    $query = "SELECT COUNT(*) AS liczba FROM repertuar";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    $zmienna = $row['liczba'] + 1;
    $film_id = "F_" . $zmienna;
    
    // Dodanie filmu do bazy danych
    $insertQuery = "INSERT INTO repertuar (ID_Film, Tytul, Gatunek, Dlugosc) VALUES ('$film_id', '$tytul', '$gatunek', '$dlugosc')";
    if (mysqli_query($connect, $insertQuery)) {
        echo "<p>Film dodany pomyślnie!</p>";
    } else {
        echo "<p>Błąd: " . mysqli_error($connect) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Film</title>
</head>
<body>
    <h1>Dodaj nowy film</h1>
    <form action="dodaj_film.php" method="POST">
        <label for="tytul">Tytuł:</label>
        <input type="text" name="tytul" id="tytul" required><br>
        
        <label for="gatunek">Gatunek:</label>
        <input type="text" name="gatunek" id="gatunek" required><br>
        
        <label for="dlugosc">Długość (minuty):</label>
        <input type="number" name="dlugosc" id="dlugosc" required><br>
        
        <button type="submit">Dodaj film</button>
    </form>
</body>
</html>