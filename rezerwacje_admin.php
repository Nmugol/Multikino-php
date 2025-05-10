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
$query = "SELECT r.ID_Rezerwacja, s.data, u.username, s.godzina, f.tytul, r.status, sa.ID_Sala, r.miejsce, s.cena 
          FROM rezerwacja r
          JOIN seans s ON r.ID_Seans = s.ID
          JOIN repertuar f ON s.ID_Film = f.id
          JOIN sala sa ON s.ID_Sala = sa.ID_Sala
          JOIN users u ON r.ID_Klient = u.id
          ORDER BY r.status DESC, s.data DESC, s.godzina DESC"; // Sortowanie: najpierw opłacone, potem data, godzina

$result = mysqli_query($polaczenie, $query);
if (!$result) {
    die("Błąd zapytania: " . mysqli_error($polaczenie));
}

// Usuwanie rezerwacji
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];
    $delete_query = "DELETE FROM rezerwacja WHERE ID_Rezerwacja = '$delete_id' AND status = 1";
    if (mysqli_query($polaczenie, $delete_query)) {
        header('Location: rezerwacje_admin.php?error=zwrot');
    } else {
        header('Location: rezerwacje_admin.php?error=blad');
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body onload="myLoadHeader()">
<div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
    <section class="sekcja3">
    <div class="container mt-5">
    <h1 style='text-align:center'>Wszystkie rezerwacje</h1><br>
        <?php
    if (isset($_GET['error']) && $_GET['error'] === 'zwrot') {
      echo "<div class='alert alert-warning'>Użytkownik zrezygnował z rezerwacji. Zwrócono pieniądze.</div>";
    }else if (isset($_GET['error']) && $_GET['error'] === 'blad') {
        echo "<div class='alert alert-danger'>Błąd podczas zwrotu kosztów!</div>";
    }
    ?>
        <table class="table table-striped">
            <thead>
                <tr>
                <th>Użytkownik</th>
                    <th>Film</th>
                    <th>Data</th>
                    <th>Godzina</th>
                    <th>Sala</th>
                    <th>Zajęte miejsca</th>
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
                    <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['tytul']) ?></td>
                        <td><?= htmlspecialchars($row['data']) ?></td>
                        <td><?= htmlspecialchars($row['godzina']) ?></td>
                        <td><?= htmlspecialchars($salaNazwa) ?></td>
                        <td><?= htmlspecialchars($row['miejsce']) ?></td>
                        <td><?= number_format($cenaZaRezerwacje, 2) ?> zł</td> <!-- Wyświetlanie łącznej ceny -->
                        <td>
                            <?= $row['status'] == 0 ? 'Nieopłacona' : 'Opłacona' ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 1): ?>
                                <!-- Przycisk Usuń dla opłaconych rezerwacji -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= $row['ID_Rezerwacja'] ?>">
                                    <button type="submit" class="btn btn-warning">Zwrot pieniędzy</button>
                                </form>
                            <?php else: ?>
                                <!-- Informacja o nieopłaceniu -->
                                <span class="text-muted">Nieopłacona</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
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
    <?php require_once 'footer.php'; ?>
</body>


</html>

