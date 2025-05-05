<?php declare(strict_types=1);  /* Ta linia musi byc pierwsza */ ?>
<?php
session_start(); // Zawsze zaczynamy sesję na początku pliku

// Sprawdzamy, czy użytkownik jest zalogowany
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jeśli nie jest zalogowany, przekierowujemy na stronę logowania
    header('Location: login.php');
    exit(); // Zakończ skrypt po przekierowaniu, żeby uniknąć dalszego renderowania
}
?>
<!DOCTYPE html>
<html lang="pl" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Twój Opis">
    <meta name="author" content="Twoje dane">
    <meta name="keywords" content="Twoje słowa kluczowe">
    <title>Piszczek Przemysław</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <style type="text/css" class="init"></style>
    <link rel="stylesheet" href="twoj_css.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"
        integrity="sha384w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="twoj_js.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ikona wylogowania -->
</head>

<body onload="myLoadHeader()">
    <div id='myHeader'></div>
    <main>
        <section class="sekcja1">
            <br><br>
            <h1 style='text-align:center'>Tabela pomiarów</h1><br>
            <?php
            $polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2"); 
            $rezultat = mysqli_query($polaczenie, "SELECT * FROM pomiary");

            echo "<table class='table table-striped table-custom'>";
            echo "<tr><td>id</td><td>x1</td><td>x2</td><td>x3</td><td>x4</td><td>x5</td><td>Pożar</td><td>Wyciek wody</td><td>Włamanie</td><td>Wyciek CO</td><td>Wentylacja</td><td>Data/Godzina</td></tr>\n";

            // Mapa wartości do wyświetlanych tekstów
            $map_pozar = [0 => "Brak", 1 => "Wykryto pożar"];
            $map_woda = [0 => "Brak", 1 => "Wykryto wyciek"];
            $map_wlamanie = [0 => "Brak", 1 => "Alarm włamaniowy"];
            $map_co = [0 => "Brak", 1 => "Wykryto CO"];
            $map_wentylacja = [0 => "Brak", 1 => "Standard", 2 => "Turbo"];

            while ($wiersz = mysqli_fetch_array($rezultat)) {
                $id = $wiersz[0];
                $x1 = $wiersz[1];
                $x2 = $wiersz[2];
                $x3 = $wiersz[3];
                $x4 = $wiersz[4];
                $x5 = $wiersz[5];
                $pozar = $map_pozar[$wiersz[7]] ?? "Nieznany";
                $woda = $map_woda[$wiersz[8]] ?? "Nieznany";
                $wlamanie = $map_wlamanie[$wiersz[9]] ?? "Nieznany";
                $co = $map_co[$wiersz[10]] ?? "Nieznany";
                $wentylacja = $map_wentylacja[$wiersz[11]] ?? "Nieznany";
                $datetime = $wiersz[6];

                echo "<tr><td>$id</td><td>$x1</td><td>$x2</td><td>$x3</td><td>$x4</td><td>$x5</td><td>$pozar</td><td>$woda</td><td>$wlamanie</td><td>$co</td><td>$wentylacja</td><td>$datetime</td></tr>\n";
            }
            echo "</table>";

            mysqli_close($polaczenie);
            ?>

        </section>
    </main>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>

</html>