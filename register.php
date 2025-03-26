<?php
require_once('function.php');
$connect = get_sql();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $_POST["name"];
    $nazwisko = $_POST["lastname"];
    $email = $_POST["email"];
    $login = $_POST["login"];
    $password = $_POST["haslo"];
    $confirm_password = $_POST["confirmPassword"];

    if ($password === $confirm_password) {
        $query = "SELECT * FROM klient WHERE email='$email' OR login='$login'";
        $query2 = "SELECT COUNT(ID_Klient) AS liczba FROM klient";
$result2 = $connect->query($query2);
$row = $result2->fetch_assoc();
$zmienna = $row['liczba'] + 1;
$klient_id = "Kl_" . $zmienna;

        
        $result = $connect->query($query);

        if ($result->num_rows > 0) {
            // Login zajęty
            header("Location: register.php?warning=4");
        } else {
            // Jeśli email i login nie istnieją w bazie, dodaj klienta
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $klient = "INSERT INTO klient (ID_Klient, imie, nazwisko, email, login, haslo) VALUES ('$klient_id', '$imie', '$nazwisko', '$email', '$login', '$hash')";
            if ($connect->query($klient) === TRUE) {
                header("Location: login.php?warning=6");
            } else {
                echo "Błąd rejestracji: " . $connect->error;
            }
        }
    } else {
        // Hasła nie są identyczne
        header("Location: register.php?warning=3");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>
<div class="naglowek">
        <ul>
            <li><a href="index.php">Strona główna </a></li>
        </ul>
    </div>


    <div class="body">
        <div class="wrapper">
            <h1>Zarejestruj się:</h1>
            <form method="post" action="register.php">
                <div class="input-box">
                    <input type="text" id="name" name="name" placeholder="podaj imię" required>
                </div>

                <div class="input-box">
                    <input type="text" id="lastname" name="lastname" placeholder="podaj naziwsko" required>
                </div>

                <div class="input-box">
                    <input type="email" id="email" name="email" placeholder="podaj adres e-mail" required>
                </div>
                
                <div class="input-box">
                    <input type="text" id="login" name="login" placeholder="podaj login" required>
                </div>
                <div class="input-box">
                    <input type="password" id="haslo" name="haslo" placeholder="podaj hasło" required>
                </div>
                <div class="input-box">
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="powtórz hasło" required>
                </div>
        
        <?php
        include 'warnings.php';
        ?>
        <input type="submit" class="btn" value="Zarejestruj się">
        </form>
    </div>
    </div>

</body>

</html>