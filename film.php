<?php
// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

// Pobranie unikalnych gatunków filmów
$gatunki_query = "SELECT DISTINCT gatunek FROM repertuar ORDER BY gatunek ASC";
$gatunki_result = mysqli_query($polaczenie, $gatunki_query);

$gatunki = [];
while ($row = mysqli_fetch_assoc($gatunki_result)) {
    $gatunki[] = $row['gatunek'];
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
        <section class="sekcja3 ">
            
            <div class="container mt-5">
                
                <h1 style='text-align:center'>Dodaj film</h1><br>
                
        <!-- Miejsce na komunikat o sukcesie lub błędzie -->
        <div class="mt-3">
    <?php
    if (isset($_GET['error'])) {
        echo "<div class='alert alert-danger'>{$_GET['error']}</div>";
    } elseif (isset($_GET['success'])) {
        echo "<div class='alert alert-success'>Film został dodany pomyślnie!</div>";
    }
    ?>
</div>

                
                <?php
                if (isset($_GET['error']) && $_GET['error'] === 'zdjecie') {
                    echo "<div class='alert alert-danger'>Błąd przy przesyłaniu zdjęcia!</div>";
                } else if (isset($_GET['error']) && $_GET['error'] === 'blad') {
                    echo "<div class='alert alert-danger'>Błąd podczas dodawania filmu!</div>";
                } else if (isset($_GET['error']) && $_GET['error'] === 'plik_istnieje') {
                    echo "<div class='alert alert-warning'>Zmień nazwę pliku!</div>";
                } else if (isset($_GET['error']) && $_GET['error'] === 'done') {
                    echo "<div class='alert alert-success'>Film został dodany pomyślnie!</div>";
                }
                ?>

                <form action="film_add.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tytul" class="form-label">Tytuł filmu</label>
                        <input type="text" class="form-control" id="tytul" name="tytul" required>
                    </div>

                    <div class="mb-3">
                        <label for="gatunek" class="form-label">Gatunek</label>
                        <select class="form-select" id="gatunek" name="gatunek" onchange="pokazInnePole()">
                            <?php foreach ($gatunki as $gatunek): ?>
                                <option value="<?= htmlspecialchars($gatunek) ?>"><?= htmlspecialchars($gatunek) ?></option>
                            <?php endforeach; ?>
                            <option value="inny">Inny...</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="inny_gatunek" name="inny_gatunek" placeholder="Wpisz własny gatunek">
                    </div>

                    <div class="mb-3">
                        <label for="dlugosc" class="form-label">Długość filmu (w minutach)</label>
                        <input type="number" class="form-control" id="dlugosc" name="dlugosc" required>
                    </div>

                    <div class="mb-3">
                        <label for="obraz" class="form-label">Wybierz obrazek</label>
                        <input type="file" class="form-control" id="obraz" name="obraz" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Dodaj Film</button>
                    
                </form>
            </div>


            </div>
        </section>
    </main>
    <script>
        function pokazInnePole() {
            var select = document.getElementById("gatunek");
            var input = document.getElementById("inny_gatunek");

            if (select.value === "inny") {
                input.classList.remove("d-none");
                input.setAttribute("required", "required");
            } else {
                input.classList.add("d-none");
                input.removeAttribute("required");
            }
        }
    </script>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>