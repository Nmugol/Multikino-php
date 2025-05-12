<?php

declare(strict_types=1);  /* Ta linia musi byc pierwsza */ ?>
<?php
session_start();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']); // Po wyświetleniu wyczyść
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
      margin-top: 200px; /* Zmniejszenie marginesu górnego */
      width: 600px;
      padding: 15px;

    }

    .form-floating {
      margin-bottom: 5px; /* Większe odstępy między polami formularza */
    }

    .form-floating input {
      height: 35px; /* Zmniejszenie wysokości pól formularza */
      font-size: 14px; /* Zmniejszenie rozmiaru czcionki */
    }

    .form-floating label {
      font-size: 14px; /* Zmniejszenie rozmiaru czcionki etykiety */
    }

    h1.h3 {
      font-size: 1.5rem; /* Zmniejszenie rozmiaru nagłówka */
    }

    button.w-100 {
      font-size: 0.9rem; /* Zmniejszenie rozmiaru tekstu przycisku */
    }

    p {
      font-size: 0.8rem; /* Zmniejszenie rozmiaru tekstu w paragrafie */
    }

    .alert {
        
      font-size: 0.85rem; /* Zmniejszenie rozmiaru tekstu alertu */
    }

    img.mb-4 {
      width: 120px; /* Zmniejszenie rozmiaru obrazka */
      height: 120px;
    }

    .im-for {
      border: 2px solid red;
      font-size: 15px; /* Zmniejszony rozmiar nagłówka */
    }

    @media (max-width: 480px) {
      body {
      display: flex;
      justify-content: center; /* Wyśrodkowanie poziome */
      align-items: center; /* Wyśrodkowanie pionowe */
      min-height: 100vh; /* Wysokość na cały ekran */
      margin: 0;
      font-family: Arial, sans-serif;

    }

    main.form-signin {
      margin-top: 100px; /* Zmniejszenie marginesu górnego */
      width: 350px;
      padding: 15px;

    }

    .form-floating {
      margin-bottom: 5px; /* Większe odstępy między polami formularza */
    }

    .form-floating input {
      height: 35px; /* Zmniejszenie wysokości pól formularza */
      font-size: 14px; /* Zmniejszenie rozmiaru czcionki */
    }

    .form-floating label {
      font-size: 14px; /* Zmniejszenie rozmiaru czcionki etykiety */
    }

    h1.h3 {
      font-size: 1.5rem; /* Zmniejszenie rozmiaru nagłówka */
    }

    button.w-100 {
      font-size: 0.9rem; /* Zmniejszenie rozmiaru tekstu przycisku */
    }

    p {
      font-size: 0.8rem; /* Zmniejszenie rozmiaru tekstu w paragrafie */
    }

    .alert {
      font-size: 0.85rem; /* Zmniejszenie rozmiaru tekstu alertu */
    }

    img.mb-4 {
      width: 120px; /* Zmniejszenie rozmiaru obrazka */
      height: 120px;
    }

    .im-for {
      border: 2px solid red;
      font-size: 15px; /* Zmniejszony rozmiar nagłówka */
    }
    }
    @media (max-width: 768) {
      body {
      display: flex;
      justify-content: center; /* Wyśrodkowanie poziome */
      align-items: center; /* Wyśrodkowanie pionowe */
      min-height: 100vh; /* Wysokość na cały ekran */
      margin: 0;
      font-family: Arial, sans-serif;

    }

    main.form-signin {
      margin-top: 100px; /* Zmniejszenie marginesu górnego */
margin-left: 20px;
      width: 350px;
      padding: 15px;

    }

    .form-floating {
      margin-bottom: 5px; /* Większe odstępy między polami formularza */
    }

    .form-floating input {
      height: 35px; /* Zmniejszenie wysokości pól formularza */
      font-size: 14px; /* Zmniejszenie rozmiaru czcionki */
    }

    .form-floating label {
      font-size: 14px; /* Zmniejszenie rozmiaru czcionki etykiety */
    }

    h1.h3 {
      font-size: 1.5rem; /* Zmniejszenie rozmiaru nagłówka */
    }

    button.w-100 {
      font-size: 0.9rem; /* Zmniejszenie rozmiaru tekstu przycisku */
    }

    p {
      font-size: 0.8rem; /* Zmniejszenie rozmiaru tekstu w paragrafie */
    }

    .alert {
      font-size: 0.85rem; /* Zmniejszenie rozmiaru tekstu alertu */
    }

    img.mb-4 {
      width: 120px; /* Zmniejszenie rozmiaru obrazka */
      height: 120px;
    }

    .im-for {
      border: 2px solid red;
      font-size: 15px; /* Zmniejszony rozmiar nagłówka */
    }
    }
  </style>

  <!-- Custom styles for this template -->
</head>
<?php require_once 'header.php'; ?>

<body class="text-center">
  <div id="animatedBackground"></div>
  
<section>
  <main class="form-signin">
    <form style="margin-top: 50px" method="post" action="add.php" enctype="multipart/form-data">
    <img class="mb-4" src="../image/ikonka.png" alt="" width="120" height="120">
    <h1 class="h3 mb-3 fw-normal">Zarejestruj się</h1>
    <?php
        if (isset($_GET['error']) && $_GET['error'] === 'login_exist') {
          echo "<div class='alert alert-danger'>Podany login już istnieje!</div>";
        } else if (isset($_GET['error']) && $_GET['error'] === 'email_exist') {
          echo "<div class='alert alert-danger'>Podany email już istnieje!</div>";
        } else if (isset($_GET['error']) && $_GET['error'] === 'passwords') {
          echo "<div class='alert alert-danger'>Hasła muszą być takie same!</div>";
        } else if (isset($_GET['error']) && $_GET['error'] === 'empty') {
          echo "<div class='alert alert-danger'>Nazwa użytkownika i hasło muszą być uzupełnione!</div>";
        } else if (isset($_GET['error']) && $_GET['error'] === 'login') {
          echo "<div class='alert alert-danger'>Login musi zawierać tylko litery i cyfry!</div>";
        } else if (isset($_GET['error']) && $_GET['error'] === 'weak_password') {
          echo "<div class='alert alert-danger'>Hasło musi mieć min. 8 znaków, w tym wielką i małą literę, cyfrę i znak specjalny!</div>";
        }
        ?>
      <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="Imię" name="imie" maxlength="200" value="<?= htmlspecialchars($old['imie'] ?? '') ?>">
            <label for="floatingInput" class="im-for">Imię</label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="Nazwisko" name="nazwisko" maxlength="100" value="<?= htmlspecialchars($old['nazwisko'] ?? '') ?>">
            <label for="floatingInput">Nazwisko</label>
          </div>
          <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email" maxlength="100" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            <label for="floatingInput">Email</label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="Login" name="user" maxlength="20" value="<?= htmlspecialchars($old['user'] ?? '') ?>">
            <label for="floatingInput">Login</label>
          </div>
          <div class="form-floating position-relative">
  <input type="password" class="form-control" id="pass" name="pass" placeholder="Hasło">
  <label for="pass">Hasło</label>
  <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePass" style="cursor: pointer;"></i>
</div>

<div class="form-floating position-relative">
  <input type="password" class="form-control" id="confpass" name="confpass" placeholder="Powtórz hasło">
  <label for="confpass">Powtórz hasło</label>
  <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="toggleConfPass" style="cursor: pointer;"></i>
</div>

          <div class="form-floating">
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            <label for="avatar">Wybierz avatar</label>
          </div>
      <!-- Ukryte pola dla danych o przeglądarce -->
      <input type="hidden" id="screenRes" name="screenRes">
      <input type="hidden" id="windowRes" name="windowRes">
      <input type="hidden" id="colors" name="colors">
      <input type="hidden" id="cookies" name="cookies">
      <input type="hidden" id="javaEnabled" name="javaEnabled">
      <input type="hidden" id="language" name="language">
      <button class="w-100 btn btn-lg btn-primary" type="submit">Zarejestruj</button>

          <br><br>
          <p>Masz już konto? <a href="login.php">Przejdź do logowania</a></p>
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
    <script>
  document.getElementById("togglePass").addEventListener("click", function () {
    const passField = document.getElementById("pass");
    const type = passField.getAttribute("type") === "password" ? "text" : "password";
    passField.setAttribute("type", type);
    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
  });

  document.getElementById("toggleConfPass").addEventListener("click", function () {
    const passField = document.getElementById("confpass");
    const type = passField.getAttribute("type") === "password" ? "text" : "password";
    passField.setAttribute("type", type);
    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
  });
</script>

    <?php require_once 'motyw.php'; ?>
  </main>
  </section>
  <?php require_once 'footer.php'; ?>

</body>

</html>