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
    <link rel="stylesheet" href="styl.css">
    <style>
        /* Dodajemy animację do całego body */
body {
    opacity: 0; /* Ustalamy początkową przezroczystość na 0 */
    transform: translateY(20px); /* Element zaczyna z lekkim przesunięciem w dół */
    animation: fadeIn 2s forwards; /* Ustalamy nazwę animacji, czas trwania i tryb */
}

/* Animacja stopniowego pojawiania się i przesuwania */
@keyframes fadeIn {
    0% {
        opacity: 0; /* Na początku jest przezroczysty */
        transform: translateY(20px); /* Na początku przesunięty w dół */
    }
    100% {
        opacity: 1; /* Na końcu pełna widoczność */
        transform: translateY(0); /* Na końcu wraca do pierwotnej pozycji */
    }
}

.body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 91.5vh;
    background: url('image/tlo.jpg') no-repeat;
    background-size: cover;
    background-position: center;
}

.wrapper {
    background-color: transparent;
    border: 0.2vw solid #ffffff;
    color: #fff;
    width: 35vw;
    border-radius: 1vw;
    padding: 2vw 2vw;
    backdrop-filter: blur(1vw);
    box-shadow: 0 0 1vw #000000;
}

.wrapper h1{
    font-size: 3vw;
    color: white;
    text-align: center;
}

.wrapper .input-box{
    position: relative;
    width: 100%;
    height: 5vw;
    margin: 3vw 0;
}

.input-box input{
    width: 100%;
    height: 100%;
    background: transparent;
    border: none;
    outline: none;
    border: 0.2vw solid #ffffff;
    border-radius: 4vw;
    color:#fff;
    font-size: 1.2vw;
    padding: 1vw 3vw 1vw 1vw;


}

.input-box input::placeholder{
    color:#fff;
}

.input-box i{
    position: absolute;
    right:2vw;
    top:50%;
    transform: translateY(-50%);
    font-size: 2vw;
}

.btn{
    width: 100%;
    height: 4vw;
    background: #fff;
    border: none;
    outline: none;
    border-radius: 4vw;
    box-shadow: #ffffff;
    cursor: pointer;
    color: #333;
    font-weight: 600;
    font-size: 1.2vw;
}

.register-link{
    font-size: 1vw;
    text-align: center;
    margin: 2vw 0 1vw;
}

.register-link p a {
color: rgb(211, 224, 92);
text-decoration: none;
font-weight: 600;

}

.register-link p a:hover {
    color: rgb(139, 148, 62);
    transform: translateY(-0.2vw);
text-decoration: underline;
    
    }


    </style>
</head>

<body>
<div class="naglowek cien">
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="oferta.php">Kinowe przekąski</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>
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
    <div class="naglowek cien" style="justify-content: center; align-items: center; position: fixed; bottom: 0; width:100%"><ul style="display: flex; justify-content: center; align-items: center;">
<li style="padding:0.5vw; text-align:center;">© 2025 Multikino</li>
            
        </ul></div>
</body>

</html>