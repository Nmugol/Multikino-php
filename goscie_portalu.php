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

    <script>
        // Funkcja do zbierania szczegółowych informacji o przeglądarce
        function sendBrowserDetails() {
            var screenRes = window.screen.width + "x" + window.screen.height;
            var windowRes = window.innerWidth + "x" + window.innerHeight;
            var colors = window.screen.colorDepth;
            var cookies = navigator.cookieEnabled ? 'true' : 'false';
            var javaEnabled = navigator.javaEnabled() ? 'true' : 'false';
            var language = navigator.language;

            // Użycie formy POST do przesłania danych
            $.post("<?php echo $_SERVER['PHP_SELF']; ?>", {
                screenRes: screenRes,
                windowRes: windowRes,
                colors: colors,
                cookies: cookies,
                javaEnabled: javaEnabled,
                language: language
            });
        }

        window.onload = function () {
            sendBrowserDetails(); // Wywołaj funkcję przy załadowaniu strony
            setupThemeToggle();
        };
    </script>
</head>

<body onload="myLoadHeader()">
<div id="animatedBackground"></div>

    <div id='myHeader'></div>
    <main>
        <section class="sekcja1">
            <?php
            // Ponownie połącz się z bazą danych
            $link = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2"); 
            if (!$link) {
                echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
                exit();
            }
            mysqli_query($link, "SET NAMES 'utf8'");

            // Pobranie wszystkich wizyt z tabeli goscieportalu
            $query = "SELECT * FROM goscieportalu ORDER BY datetime DESC LIMIT 5";
            $result = mysqli_query($link, $query);

            // Funkcja do uzyskiwania lokalizacji na podstawie IP
            function ip_details($ip)
            {
                $json = @file_get_contents("http://ip-api.com/json/{$ip}"); // Zmiana na ip-api.com
                if ($json === false) {
                    return null; // Zwróć null w przypadku błędu
                }
                return json_decode($json);
            }

            // Funkcja, która przetwarza User-Agent i zwraca przydatne informacje
            function parseUserAgent($userAgent)
            {
                // Definicje podstawowych przeglądarek i wzorców dla wersji
                $browsers = [
                    'OPR' => 'Opera',  // Dodajemy Opera przed Chrome
                    'Edg' => 'Microsoft Edge',
                    'Firefox' => 'Firefox',
                    'MSIE' => 'Internet Explorer',
                    'Trident/7' => 'Internet Explorer', // IE 11+
                    'Chrome' => 'Chrome',
                    'Safari' => 'Safari',
                    'Opera' => 'Opera'
                ];

                // Definicje podstawowych systemów operacyjnych
                $platforms = [
                    'Windows' => 'Windows',
                    'Macintosh' => 'Mac OS',
                    'iPhone' => 'iOS',
                    'iPad' => 'iOS',
                    'Android' => 'Android',
                    'Linux' => 'Linux'
                ];

                $browser = 'Unknown browser';
                $version = '';
                $platform = 'Unknown platform';

                // Szukanie informacji o przeglądarce
                foreach ($browsers as $key => $value) {
                    if (strpos($userAgent, $key) !== false) {
                        $browser = $value;
                        // Wyciągnięcie wersji przeglądarki
                        preg_match('/' . $key . '[\/\s](\d+(\.\d+)*)/', $userAgent, $matches);
                        if (isset($matches[1])) {
                            $version = $matches[1];
                        }
                        break;
                    }
                }

                // Szukanie informacji o systemie operacyjnym
                foreach ($platforms as $key => $value) {
                    if (strpos($userAgent, $key) !== false) {
                        $platform = $value;
                        break;
                    }
                }

                // Zwracanie sformatowanego wyniku
                return "{$browser} {$version} <br> {$platform}";
            }

            // Wyświetlenie tabeli
            if (mysqli_num_rows($result) > 0) {
                echo "<h1 style='text-align:center; margin-top: 63px'>Goście portalu</h1>";
                echo "<div class='table-responsive'>"; // Dodaj ten kontener
                echo "<table class='table table-striped table-custom'>";
                echo "<thead><tr><th>Data</th><th>Adres IP</th><th>Lokalizacja</th><th>Współrzędne</th><th>Mapy&nbsp;Google'a</th><th>Przeglądarka</th><th>Ekran</th><th>Okno</th><th>Kolory</th><th>Ciasteczka</th><th>Java</th><th>Język</th></tr></thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $ip = $row['ipaddress'];
                    $details = ip_details($ip);

                    $region = $details->regionName ?? 'Nieznany';
                    $country = $details->country ?? 'Nieznany';
                    $city = $details->city ?? 'Nieznany';
                    $loc = $details->lat . ',' . $details->lon ?? 'Nieznany'; // Współrzędne geograficzne
            
                    $location = "$country, $region,";
                    $coordinates = $loc ? $loc : 'Nieznane'; // Współrzędne
                    $mapLink = $loc ? "<a href='https://www.google.pl/maps/place/{$loc}' target='_blank'>Link</a>" : 'Brak';
                    // Przykładowy ciąg User-Agent
                    $userAgent = $row['browser'];  // User-Agent pobrany z bazy danych
            
                    echo "<tr>";
                    echo "<td style='white-space: nowrap;'>" . date('Y-m-d', strtotime($row['datetime'])) . "<br>" . date('H:i:s', strtotime($row['datetime'])) . "</td>";
                    echo "<td>" . $ip . "</td>";
                    echo "<td  style='white-space: nowrap;'>" . $location . "<br>" . $city . "</td>";
                    echo "<td>" . $coordinates . "</td>";
                    echo "<td>" . $mapLink . "</td>";
                    // echo "<td>" . $row['browser'] . "</td>";
                    echo "<td style='white-space: nowrap;'>" . parseUserAgent($userAgent) . "</td>";
                    echo "<td>" . $row['screenRes'] . "</td>";
                    echo "<td>" . $row['windowRes'] . "</td>";
                    echo "<td>" . $row['colors'] . "</td>";
                    echo "<td>" . $row['cookies'] . "</td>";
                    echo "<td>" . $row['javaEnabled'] . "</td>";
                    echo "<td>" . $row['language'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
                echo "</div>"; // Zakończ kontener
            } else {
                echo "Brak wizyt w bazie danych.";
            }

            mysqli_close($link);
            ?>
        </section>
    </main>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>

</html>