<?php declare(strict_types=1);  /* Ta linia musi byc pierwsza */ ?> 
<!DOCTYPE html>
<html lang="pl">
<head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <meta name="description" content="Twój Opis"> 
    <meta name="author" content="Twoje dane"> 
    <meta name="keywords" content="Twoje słowa kluczowe"> 
    <title>Multikino</title> 
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css"> 
    <style type="text/css" class="init"></style> 
    <link rel="stylesheet" href="twoj_css.css"> 
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" integrity="sha384w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> 
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> 
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script> 
    <script type="text/javascript" src="twoj_js.js"></script>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

<<<<<<< Upstream, based on 80c697d79bfb84934d21453382212e00a2bb84a6
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
=======
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
>>>>>>> ff4dbdd zapis z 3.04.2025

<<<<<<< Upstream, based on 80c697d79bfb84934d21453382212e00a2bb84a6
    <!-- Custom styles for this template -->
    <link href="../bootstrap-5.0.2-examples/sign-in/signin.css" rel="stylesheet">
</head> 

<body class="text-center">
<div id="animatedBackground"></div>
<a class="powrot" href="strona.php" class="btn btn-outline-light px-4 py-2" style="font-size: 18px;">
    Wróć na stronę główną Multikina<i class="fa fa-sign-out"></i>
</a>

<main class="form-signin">
  <form method="post" action="weryfikuj.php">
  <img class="mb-4" src="../image/ikonka.png" alt="" width="150" height="150">
    <h1 class="h3 mb-3 fw-normal">Zaloguj się</h1>
    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'not_exist_user') {
      echo "<div class='alert alert-danger'>Brak użytkownika o takim loginie!</div>";
    } else if (isset($_GET['error']) && $_GET['error'] === 'to_much') {
      echo "<div class='alert alert-danger'>Za dużo nieudanych prób logowania. Poczekaj 1 minutę przed kolejną próbą.</div>";
    } else if (isset($_GET['error']) && $_GET['error'] === 'wrong_password') {
      echo "<div class='alert alert-danger'>Błąd w loginie lub haśle.</div>";
    }
    ?>
    <div class="form-floating">
      <input type="login" class="form-control" id="floatingInput" placeholder="Login" name="user" maxlength="20" size="20"> 
      <label for="floatingInput">Login</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pass" maxlength="20" size="20">
      <label for="floatingPassword">Hasło</label>
    </div> 
    <!-- Ukryte pola dla danych o przeglądarce -->
    <input type="hidden" id="screenRes" name="screenRes">
    <input type="hidden" id="windowRes" name="windowRes">
    <input type="hidden" id="colors" name="colors">
    <input type="hidden" id="cookies" name="cookies">
    <input type="hidden" id="javaEnabled" name="javaEnabled">
    <input type="hidden" id="language" name="language">
=======
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
>>>>>>> ff4dbdd zapis z 3.04.2025

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Zapamiętaj mnie
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Zaloguj się</button>
    <br><br>
    <p>Nie masz konta? <a href="rejestruj.php">Zarejestruj się</a></p>
  </form>
  <script>
    // Funkcja do zbierania szczegółowych informacji o przeglądarce
    function collectBrowserDetails() {
        document.getElementById('screenRes').value = window.screen.width + "x" + window.screen.height;
        document.getElementById('windowRes').value = window.innerWidth + "x" + window.innerHeight;
        document.getElementById('colors').value = window.screen.colorDepth;
        document.getElementById('cookies').value = navigator.cookieEnabled ? 'true' : 'false';
        document.getElementById('javaEnabled').value = navigator.javaEnabled() ? 'true' : 'false';
        document.getElementById('language').value = navigator.language;
    }

    window.onload = function() {
        collectBrowserDetails();
        setupThemeToggle();
    };
</script>
   <!-- Przycisk do zmiany motywu (z ikoną) -->
<div class="dropdown position-fixed bottom-0 end-0 m-4">
  <button class="btn btn-primary dropdown-toggle" type="button" id="themeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i id="themeIcon" class="bi bi-sun-fill"></i> <!-- Ikona motywu -->
  </button>
  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
    <li><button class="dropdown-item" id="lightMode"><i class="bi bi-sun-fill"></i> Jasny</button></li>
    <li><button class="dropdown-item" id="darkMode"><i class="bi bi-moon-fill"></i> Ciemny</button></li>
    <li><button class="dropdown-item" id="autoMode"><i class="bi bi-circle-half"></i> Auto</button></li>
  </ul>
</div>
  <?php require_once 'footer.php'; ?>  
</main>
  </body>
</html>