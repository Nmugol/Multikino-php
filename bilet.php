<?php
require_once 'function.php';
$connect = get_sql();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['thisIDRezerwacja'])) {
    $rezerwacjaId = $_POST['thisIDRezerwacja'];
    
    // Aktualizuj status biletu na 1 (wydrukowany)
    $updateQuery = "UPDATE rezerwacja SET bilety = 1 WHERE ID_Rezerwacja = ?";
    if ($stmt = $connect->prepare($updateQuery)) {
        $stmt->bind_param('i', $rezerwacjaId);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wydruk biletów</title>
    <link rel="stylesheet" href="bilet.css">
</head>
<body>
    <div class="naglowek">
        <ul>
            <li><a href="index.php">Strona główna </a></li>
            <li style="float:right"><a href="wyloguj.php">Wyloguj się</a></li>
        </ul>
    </div>

    <div class="container">
        <h1>Wydruk biletów</h1>
        <form action="index.php" method="post" class="print-form">
            <label for="copies">Ile kopii:</label>
            <input type="number" id="copies" name="copies" min="1" max="10" required>
            <button type="submit">Drukuj</button>
        </form>
    </div>
</body>
</html>
