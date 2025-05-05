<?php declare(strict_types=1);
session_start();

// Połączenie z bazą danych
$polaczenie = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");
if (!$polaczenie) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
mysqli_set_charset($polaczenie, 'utf8mb4');

if (!isset($_SESSION['user'])) {
    die("Musisz być zalogowany, aby edytować swoje dane.");
}

$username = $_SESSION['user'];

// Pobranie danych użytkownika
$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($polaczenie, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$alertMessage = ''; // Zmienna do przechowywania komunikatu alertu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_imie = trim($_POST['imie']);
    $new_nazwisko = trim($_POST['nazwisko']);
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Sprawdzenie, czy nowy login już istnieje
    $query_check_username = "SELECT * FROM users WHERE username = ? AND username != ?";
    $stmt_check_username = mysqli_prepare($polaczenie, $query_check_username);
    mysqli_stmt_bind_param($stmt_check_username, "ss", $new_username, $username);
    mysqli_stmt_execute($stmt_check_username);
    $result_check_username = mysqli_stmt_get_result($stmt_check_username);

    // Sprawdzenie, czy nowy email już istnieje
    $query_check_email = "SELECT * FROM users WHERE email = ? AND username != ?";
    $stmt_check_email = mysqli_prepare($polaczenie, $query_check_email);
    mysqli_stmt_bind_param($stmt_check_email, "ss", $new_email, $username);
    mysqli_stmt_execute($stmt_check_email);
    $result_check_email = mysqli_stmt_get_result($stmt_check_email);

    // Sprawdzenie wyników
    if (mysqli_num_rows($result_check_username) > 0) {
        header('Location: zmien.php?error=login_exist');
    } elseif (mysqli_num_rows($result_check_email) > 0) {
        header('Location: zmien.php?error=email_exist');
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        header('Location: zmien.php?error=password_error');
    } else {
        // Aktualizacja danych
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $query_update = "UPDATE users SET username = ?, email = ?, imie = ?, nazwisko = ?, password = ? WHERE username = ?";
            $stmt_update = mysqli_prepare($polaczenie, $query_update);
            mysqli_stmt_bind_param($stmt_update, "ssssss", $new_username, $new_email, $new_imie, $new_nazwisko, $hashed_password, $username);
        } else {
            $query_update = "UPDATE users SET username = ?, email = ?, imie = ?, nazwisko = ? WHERE username = ?";
            $stmt_update = mysqli_prepare($polaczenie, $query_update);
            mysqli_stmt_bind_param($stmt_update, "sssss", $new_username, $new_email, $new_imie, $new_nazwisko, $username);
        }

        if (mysqli_stmt_execute($stmt_update)) {
            $_SESSION['user'] = $new_username;
            header('Location: zmien.php?error=done');
            exit();
        } else {
            $alertMessage = "<div class='alert alert-danger'>Błąd podczas aktualizacji danych!</div>";
        }
    }
}

mysqli_close($polaczenie);
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
    <link rel="stylesheet" href="strona.css">
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
    <div class="container">
    <h1 style='text-align:center'>Zmień swoje dane</h1>
    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'email_exist') {
      echo "<div class='alert alert-danger'>Podany email już istnieje!</div>";
    } else if (isset($_GET['error']) && $_GET['error'] === 'login_exist') {
        echo "<div class='alert alert-danger'>Podany login już istnieje!</div>";
    }  else if (isset($_GET['error']) && $_GET['error'] === 'password_error') {
        echo "<div class='alert alert-danger'>Hasła muszą być takie same!</div>";
    }else if (isset($_GET['error']) && $_GET['error'] === 'done') {
      echo "<div class='alert alert-success'>Zaktualizowano dane użytkownika!</div>";
    }
    ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nazwa użytkownika</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Imię</label>
            <input type="text" name="imie" class="form-control" value="<?= htmlspecialchars($user['imie']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nazwisko</label>
            <input type="text" name="nazwisko" class="form-control" value="<?= htmlspecialchars($user['nazwisko']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nowe Hasło (jeśli chcesz zmienić)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Powtórz Hasło</label>
            <input type="password" name="confirm_password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </form>
</div>
</section>
    </main>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>