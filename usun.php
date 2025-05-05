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
$query = "SELECT r.ID_Rezerwacja, s.data, s.godzina, f.tytul, r.status, sa.ID_Sala, r.miejsce, s.cena 
          FROM rezerwacja r
          JOIN seans s ON r.ID_Seans = s.ID
          JOIN repertuar f ON s.ID_Film = f.id
          JOIN sala sa ON s.ID_Sala = sa.ID_Sala
          WHERE r.ID_Klient = '$id_klienta'
          ORDER BY r.status DESC, s.data DESC, s.godzina DESC"; // Sortowanie: najpierw opłacone, potem data, godzina

$result = mysqli_query($polaczenie, $query);
if (!$result) {
    die("Błąd zapytania: " . mysqli_error($polaczenie));
}

// Usuwanie rezerwacji
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];
    $delete_query = "DELETE FROM rezerwacja WHERE ID_Rezerwacja = '$delete_id' AND status = 0";
    if (mysqli_query($polaczenie, $delete_query)) {
        echo "<script>alert('Rezerwacja została usunięta.'); window.location.href = 'usun.php';</script>";
    } else {
        echo "<script>alert('Błąd podczas usuwania rezerwacji.');</script>";
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
    <section class="sekcja3 my-5">
    <div class="container mt-5">
        <h2>Twoje rezerwacje</h2>
        <table class="table table-striped">
            <thead>
                <tr>
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
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['tytul']) ?></td>
                        <td><?= htmlspecialchars($row['data']) ?></td>
                        <td><?= htmlspecialchars($row['godzina']) ?></td>
                        <td><?= htmlspecialchars($row['ID_Sala']) ?></td>
                        <td><?= htmlspecialchars($row['miejsce']) ?></td>
                        <td><?= htmlspecialchars($row['cena']) ?> PLN</td>
                        <td>
                            <?= $row['status'] == 0 ? 'Nieopłacona' : 'Opłacona' ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 0): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= $row['ID_Rezerwacja'] ?>">
                                    <button type="submit" class="btn btn-danger">Usuń</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">Kontakt z obsługą</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
    </main>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>

