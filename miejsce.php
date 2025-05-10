<?php

declare(strict_types=1);
session_start();

// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

// Pobranie ID seansu z URL
if (!isset($_GET['seans_id']) || !is_numeric($_GET['seans_id'])) {
}
$thisIDSeans = (int) $_GET['seans_id'];

// Pobranie ID klienta z ciasteczka
$id_klienta = $_SESSION['id'] ?? null;
if (!$id_klienta) {
    die("Błąd: Nie znaleziono ID klienta.");
}

// Pobranie informacji o sali i seansie
$sala_query = "SELECT s.ID_Sala, s.data, s.godzina, s.cena, sa.ilosc_miejsc, f.tytul 
               FROM seans s 
               JOIN sala sa ON s.ID_Sala = sa.ID_Sala 
               JOIN repertuar f ON s.ID_Film = f.id
               WHERE s.ID = '$thisIDSeans'";
$result_s = mysqli_query($polaczenie, $sala_query);
if (!$result_s || mysqli_num_rows($result_s) === 0) {
}
$sala_row = mysqli_fetch_assoc($result_s);

$sala_id = $sala_row['ID_Sala'];
$data = $sala_row['data'];
$godzina = $sala_row['godzina'];
$cena = $sala_row['cena'];
$ilosc_miejsc = $sala_row['ilosc_miejsc'];
$tytul_filmu = $sala_row['tytul'];

// Pobranie zajętych miejsc
$zajete_miejsca_query = "SELECT miejsce FROM rezerwacja WHERE ID_Seans = '$thisIDSeans'";
$result_zajete = mysqli_query($polaczenie, $zajete_miejsca_query);
$zajete_miejsca = [];
while ($row = mysqli_fetch_assoc($result_zajete)) {
    $zajete_miejsca = array_merge($zajete_miejsca, explode(',', $row['miejsce']));
}

// Pobranie miejsc zajętych przez konkretnego użytkownika
$zajete_miejsca_klienta_query = "SELECT miejsce FROM rezerwacja WHERE ID_Seans = '$thisIDSeans' AND ID_Klient = '$id_klienta'";
$result_zajete_klienta = mysqli_query($polaczenie, $zajete_miejsca_klienta_query);
$zajete_miejsca_klienta = [];
while ($row = mysqli_fetch_assoc($result_zajete_klienta)) {
    $zajete_miejsca_klienta = array_merge($zajete_miejsca_klienta, explode(',', $row['miejsce']));
}

// Lista wszystkich miejsc w sali
$wszystkie_miejsca = range(1, $ilosc_miejsc);

// Obsługa rezerwacji miejsc
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['thisIDMiejsca'])) {
    $selectedPlaces = $_POST['thisIDMiejsca'];
    $selectedPlacesString = implode(",", $selectedPlaces);
    $ilosc_biletow = count($selectedPlaces);

    $add = "INSERT INTO rezerwacja (ID_Klient, ID_Seans, data, ilosc_biletow, miejsce, cena, status, bilety) 
            VALUES ('$id_klienta', '$thisIDSeans', NOW(), '$ilosc_biletow', '$selectedPlacesString', '$cena', 0, 0)";
    mysqli_query($polaczenie, $add);

    // Zamiast wyświetlania modala, odświeżamy stronę i ustawiamy flagę w URL
    echo "<script>window.location.href = 'miejsce.php?seans_id=$thisIDSeans&reserved=true&miejsca=$selectedPlacesString';</script>";
    exit();
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
    <style>
        /* Kontener na treść */

        .modal-backdrop {
    display: none !important;
}
        .container2 {
            margin: 100px auto;
            text-align: center;
            padding: 20px;
            width: 500px;
        }

        /* Sekcja z informacjami o seansie */

        .seans-info {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
            width: 400px;
            margin-bottom: 40px;
        }

        .seans-info p {
            font-size: 30px;
            text-align: center;


        }

        .wybierz {
            margin-top: 30px;
            margin-bottom: 20px;
            font-size: 30px;
            text-align: center;
        }

        .wybierz2 {
            font-size: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        .info-item {
            margin-bottom: 23px;
            font-size: 16px;
            text-align: left;
            margin: 5px;
            margin-left: 50px;
            text-align: center;
        }

        /* Siatka miejsc */

        .seats-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 10px;
            justify-content: center;
            width: 450px;
            margin-top: 20px;
        }


        /* Styl dla miejsc */

        .seat {
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            background-color: rgb(128, 131, 130);
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }



        .seat.taken {
            background-color: red;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: green;
        }

        .seat.user-taken {
            background-color: yellow;
            cursor: not-allowed;
            color: black;
        }

        .screen {
            width: 100%;
            max-width: 350px;
            height: 14px;
            background-color: black;
            margin: 20px auto;
            text-align: center;
            color: white;
            font-weight: bold;
            font-size: 10px;
        }

        @media (max-width: 768px) {
            .container2 {
                margin: 100px auto;
                text-align: center;
                padding: 20px;
                width: 100%;
            }

            .info-item {
            margin-bottom: 23px;
            font-size: 16px;
            text-align: left;
            margin: 5px;
        }
            /* Sekcja z informacjami o seansie */

            .seans-info {
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
                text-align: left;
                width: 100%;
                margin-bottom: 40px;
            }

            .seats-grid {
                display: grid;
                grid-template-columns: repeat(10, 1fr);
                gap: 10px;
                justify-content: center;
                width: 100%;
                margin-top: 20px;
            }


            /* Styl dla miejsc */

            .seat {
                width: 25px;
                height: 25px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: rgb(128, 131, 130);
                color: white;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

        }

        @media (max-width: 480) {
            .container2 {
                margin: 100px auto;
                text-align: center;
                padding: 20px;
                width: 100%;
            }

            /* Sekcja z informacjami o seansie */

            .seans-info {
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
                text-align: left;
                width: 100%;
                margin-bottom: 40px;
            }
            .info-item {
            margin-bottom: 23px;
            font-size: 16px;
            text-align: left;
            margin: 5px;
        }
            .seats-grid {
                display: grid;
                grid-template-columns: repeat(10, 1fr);
                gap: 10px;
                justify-content: center;
                width: 100%;
                margin-top: 20px;
            }


            /* Styl dla miejsc */

            .seat {
                width: 25px;
                height: 25px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: rgb(128, 131, 130);
                color: white;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

        }

        body[data-bs-theme="dark"] .info-item span {
    color: #f8f9fa;
}
body[data-bs-theme="auto"] .info-item strong {
            color:rgb(68, 68, 68);
        }
        body[data-bs-theme="light"] .info-item strong {
            color:rgb(0, 109, 73);
        }
        body[data-bs-theme="yellow"] .info-item strong {
            color:rgb(114, 104, 0);
        }
        body[data-bs-theme="blue"] .info-item strong {
            color:rgb(13, 0, 255);
        }
        body[data-bs-theme="dark"] .info-item strong {
            color:rgb(255, 0, 0);
        }

        body[data-bs-theme="dark"] .screen, body[data-bs-theme="blue"] .screen {
            background-color: rgb(74, 74, 74);
            text-shadow: black 0.1em 0.1em 0.2em;
        }



[data-bs-theme="blue"] .modal-dialog{
    color: white;
    text-shadow: black 0.1em 0.1em 0.2em;
}
[data-bs-theme="dark"] .modal-dialog {
    color: white;
    text-shadow: black 0.1em 0.1em 0.2em;
}

[data-bs-theme="dark"] .btn-close, [data-bs-theme="blue"] .btn-close  {
    --bs-btn-close-color: white;
        --bs-btn-close-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e");
    }

[data-bs-theme="light"] .btn-close, [data-bs-theme="yellow"] .btn-close, [data-bs-theme="auto"] .btn-close {
    --bs-btn-close-color: #000;
    --bs-btn-close-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e");
    }

[data-bs-theme="blue"] .modal-content, [data-bs-theme="dark"] .modal-content {
    background-color: #212529;
    color:white;
}

.seat.available {
    cursor: pointer;
}

/* Efekt hover tylko dla dostępnych miejsc */
.seat.available:hover {
    opacity: 60%;
    transition: opacity 0.3s ease-in-out;
}

.legend-item {
    display: flex;
    align-items: center;  /* Wyrównanie w pionie */
    justify-content: flex-start;  /* Wyrównanie w poziomie - tekst z lewej strony */
    gap: 10px; /* Odstęp między ikoną a tekstem */
}
.button-center {
    display: flex;
    justify-content: center;  /* Wyśrodkowanie poziome */
    align-items: center;      /* Wyśrodkowanie pionowe */
    width: 100%;              /* Pełna szerokość kontenera */
    text-align: center;       /* Dodatkowo wyrównanie tekstu w poziomie */
}


    </style>
</head>

<body onload="myLoadHeader()">
    <div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
        <section class="sekcja3 my-6">
            <?php
            if (isset($_GET['error']) && $_GET['error'] === 'done') {
                echo "<div class='alert alert-success'>Zarezerwowano wybrane miejsca!</div>";
            }
            ?>
            <div class="container2" style="margin-top: 10px;">
                <div class="wybierz">Podsumowanie wybranego filmu: </div>
                <div class="seans-info">
    <div class="info-item"><strong>Tytuł:</strong> <span><?= htmlspecialchars($tytul_filmu) ?></span></div>
    <div class="info-item"><strong>Data:</strong> <span><?= htmlspecialchars($data) ?></span></div>
    <div class="info-item"><strong>Godzina:</strong> <span><?= htmlspecialchars($godzina) ?></span></div>
    <?php
    // Przypisanie nazwy sali do ID
    switch ($sala_id) {
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
    ?>
    <div class="info-item"><strong>Sala:</strong> <span><?= htmlspecialchars($salaNazwa) ?></span></div>
    <div class="info-item"><strong>Całkowita cena:</strong> <span id="total-price">0 zł</span></div>
</div>
<center style="margin-top: -30px;">
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#legendModal">
            Zobacz legendę oznaczeń miejsc
        </button>
</center>

    <!-- Modal z legendą -->
    <div class="modal fade" id="legendModal" tabindex="-1" aria-labelledby="legendModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="legendModalLabel">Oznaczenia miejsc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="legend-item">
                        <label class="seat user-taken" style="cursor: default;"></label> Zajęte przez Ciebie
                    </div><br>
                    <div class="legend-item">
                        <label class="seat taken" style="cursor: default;"></label> Zajęte przez innych
                    </div><br>
                    <div class="legend-item">
                        <label class="seat" style="cursor: default;"></label> Dostępne do wyboru
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>


                <h2 class="wybierz2">Należy wybrać numer miejsca</h2>
                <div class="screen">ekran</div>
                <form method="post" action="miejsce.php?seans_id=<?= $thisIDSeans ?>" id="seatsForm">
                    <div class="seats-grid">
                        <?php foreach ($wszystkie_miejsca as $miejsce): ?>
                            <?php
                            $is_taken = in_array($miejsce, $zajete_miejsca); // Miejsce zajęte przez innych
                            $is_taken_by_user = in_array($miejsce, $zajete_miejsca_klienta); // Miejsce zajęte przez aktualnego użytkownika
                            ?>
                            <label class="seat <?= $is_taken_by_user ? 'user-taken' : ($is_taken ? 'taken' : 'available') ?>"
            data-seat="<?= $miejsce ?>">
            <?= $miejsce ?>
            <?php if (!$is_taken && !$is_taken_by_user): ?>
                <input type="checkbox" name="thisIDMiejsca[]" value="<?= $miejsce ?>" hidden>
            <?php endif; ?>
        </label>
                        <?php endforeach; ?>
                    </div>
                    <br><br>
                    <input type="submit" value="Zatwierdź" class="btn btn-danger">
                </form>
    
                <div id="reservationModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-header d-flex justify-content-center w-100">
                <h5 class="modal-title" id="confirmModalLabel">Rezerwacja zakończona!</h5>
            </div>
            <div class="modal-body">
                <p>Pomyślnie dokonano rezerwacji na seans.</p>
                <p><strong>Zarezerwowane miejsca:</strong></p> 
                <p><span id="reservedSeats"></span></p>
            </div>
            <div class="modal-footer d-flex justify-content-center gap-2">
                <a href="strona.php" class="btn btn-primary flex-grow-1 text-center">Przejdź do strony głównej</a>
                <a href="modyfikuj.php" class="btn btn-primary flex-grow-1 text-center">Przejdź do swoich rezerwacji</a>
            </div>
        </div>
    </div>
</div>


            </div>
            <script>
            document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get("reserved") === "true") {
        var myModal = new bootstrap.Modal(document.getElementById("reservationModal"), {
            keyboard: false
        });

        // Pobranie miejsc z URL i formatowanie ich do układu 5 w wierszu
        const reservedSeats = urlParams.get("miejsca");

        if (reservedSeats) {
            const seatsArray = reservedSeats.split(","); // Podział miejsc po przecinku
            let formattedSeats = "";

            for (let i = 0; i < seatsArray.length; i++) {
                if (i > 0 && i % 5 === 0) {
                    formattedSeats += "<br>"; // Nowa linia co 5 miejsc
                }

                formattedSeats += seatsArray[i]; // Dodaj miejsce

                if (i < seatsArray.length - 1) {
                    formattedSeats += ", "; // Dodaj przecinek, ale nie na końcu
                }
            }

            document.getElementById("reservedSeats").innerHTML = formattedSeats;
        } else {
            document.getElementById("reservedSeats").textContent = "Brak danych";
        }

        myModal.show();

        // Usunięcie "reserved=true" i "miejsca" z URL, aby nie powtarzać modala przy kolejnym odświeżeniu
        const newUrl = window.location.pathname + window.location.search.replace(/(\?|&)reserved=true.*$/, '');
        window.history.replaceState(null, '', newUrl);
    }
});



</script>


            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll(".seat:not(.taken)").forEach(seat => {
                        seat.addEventListener("click", function() {
                            const checkbox = this.querySelector("input[type='checkbox']");
                            if (checkbox) {
                                checkbox.checked = !checkbox.checked;
                                this.classList.toggle("selected", checkbox.checked);
                            }
                        });
                    });
                });

                document.addEventListener("DOMContentLoaded", function() {
    // Funkcja do aktualizacji ceny
    function updateTotalPrice() {
        const selectedSeats = document.querySelectorAll("input[name='thisIDMiejsca[]']:checked");
        const numberOfSeats = selectedSeats.length;
        const pricePerSeat = <?= $cena ?>; // Cena za jedno miejsce
        const totalPrice = numberOfSeats * pricePerSeat;

        // Zaktualizuj wyświetlaną cenę
        document.getElementById('total-price').textContent = totalPrice + " zł";
    }

    // Dodaj event listener do wszystkich miejsc, które nie są zajęte
    document.querySelectorAll(".seat:not(.taken)").forEach(seat => {
        seat.addEventListener("click", function() {
            const checkbox = this.querySelector("input[type='checkbox']");
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                this.classList.toggle("selected", checkbox.checked);
                updateTotalPrice(); // Zaktualizuj cenę po zmianie zaznaczenia
            }
        });
    });

    // Zainicjuj cenę po załadowaniu strony
    updateTotalPrice();
});

            </script>
        </section>
    </main>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>