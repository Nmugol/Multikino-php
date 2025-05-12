<?php

declare(strict_types=1);  /* Ta linia musi byc pierwsza */ ?>
<!DOCTYPE html>
<html lang="pl">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Multikino</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
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
    body {
      display: flex;
      justify-content: center; /* Wyśrodkowanie poziome */
      align-items: center; /* Wyśrodkowanie pionowe */
      min-height: 400vh; /* Cała wysokość ekranu */
      margin: 0;
      font-family: Arial, sans-serif;
    }
    main.form-signin {
      margin-top: 70px;
      width: 400px;
      padding: 15px;
    }
    
    .form-floating {
      margin-bottom: 5px; /* Większe odstępy między polami formularza */
    }

  </style>

  <!-- Custom styles for this template -->
</head>
<?php require_once 'header.php'; ?>

<body class="text-center">
  <div id="animatedBackground"></div>
  
<section>
  <main class="form-signin">
    <form method="post" action="weryfikuj.php">
      <img class="mb-4" src="../image/ikonka.png" alt="" width="150" height="150" >
      <h1 class="h3 mb-3 fw-normal">Zaloguj się</h1>
      <?php
      if (isset($_GET['error']) && $_GET['error'] === 'not_exist_user') {
        echo "<div class='alert alert-danger'>Brak użytkownika o takim loginie!</div>";
      } else if (isset($_GET['error']) && $_GET['error'] === 'to_much') {
        echo "<div class='alert alert-danger'>Za dużo nieudanych prób logowania. Poczekaj 1 minutę przed kolejną próbą.</div>";
      } else if (isset($_GET['error']) && $_GET['error'] === 'wrong_password') {
        echo "<div class='alert alert-danger'>Login lub hasło jest błędne</div>";
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
    <?php require_once 'motyw.php'; ?>
  </main>
  </section>
  <?php require_once 'footer.php'; ?>

</body>

</html>