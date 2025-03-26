<?php
require_once 'function.php';
$connect = get_sql();

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    // Sprawdzenie, czy login należy do klienta
    $queryKlient = "SELECT * FROM klient WHERE Login='$login'";
    $resultKlient = $connect->query($queryKlient);

    // Sprawdzenie, czy login należy do kasjera
    $queryKasjer = "SELECT * FROM kasjer WHERE Login='$login'";
    $resultKasjer = $connect->query($queryKasjer);

    if ($resultKlient && $resultKlient->num_rows > 0) {
        $klient = $resultKlient->fetch_assoc();

        if (password_verify($password, $klient['haslo'])) {
            $klientID = $klient['ID_Klient'];
            session_regenerate_id();
            setcookie("zalogowany", "1", time() + 3600, "/");
            setcookie("id", $klientID, time() + 3600, "/");
            $connect->close();
            header("Location: index.php");
            exit();
        } else {
            $connect->close();
            header("Location: login.php?warning=1");
            exit();
        }
    } elseif ($resultKasjer && $resultKasjer->num_rows > 0) {
        $kasjer = $resultKasjer->fetch_assoc();

        if (password_verify($password, $kasjer['haslo'])) {
            $kasjerLogin = $kasjer['Login'];
            session_regenerate_id();
            setcookie("zalogowany", "2", time() + 3600, "/");
            setcookie("id", $kasjerLogin, time() + 3600, "/");
            $connect->close();
            header("Location: index.php");
            exit();
        } else {
            $connect->close();
            header("Location: login.php?warning=1");
            exit();
        }
    } else {
        $connect->close();
        header("Location: login.php?warning=2");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="naglowek">
        <ul>
            <li><a href="index.php">Strona główna</a></li>
            <li style="float:right"><a href="register.php">Zarejestruj się</a></li>
        </ul>
    </div>
    
    <div class="body">
        <div class="wrapper">
            <form method="post" action="login.php">
                <h1>Zaloguj się</h1>
                <div class="input-box">
                    <input type="text" id="login" name="login" placeholder="login" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="hasło" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <?php include 'warnings.php'; ?>
                <input type="submit" class="btn" value="Zaloguj">
                <div class="register-link">
                    <p>Nie masz jeszcze konta?<a href="register.php"> Zarejestruj się!</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>