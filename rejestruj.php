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

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="../bootstrap-5.0.2-examples/sign-in/signin.css" rel="stylesheet">
</head> 

<body class="text-center">
<div id="animatedBackground"></div>
<a class="powrot" href="strona.php" class="btn btn-outline-light px-4 py-2" style="font-size: 18px;">
    Wróć na stronę główną Multikina<i class="fa fa-sign-out"></i>
</a>

<main class="form-signin">
  <form method="post" action="add.php" enctype="multipart/form-data">
  <img class="mb-4" src="../image/ikonka.png" alt="" width="150" height="150">
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
    }
    ?>
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="Imię" name="imie" maxlength="100" size="20"> 
      <label for="floatingInput">Imię</label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="Nazwisko" name="nazwisko" maxlength="100" size="20"> 
      <label for="floatingInput">Nazwisko</label>
    </div>
    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="email" maxlength="100" size="20"> 
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="Login" name="user" maxlength="20" size="20"> 
      <label for="floatingInput">Login</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pass" maxlength="20" size="20">
      <label for="floatingPassword">Hasło</label>
    </div> 
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPasswordConfirm" placeholder="Password" name="confpass" maxlength="20" size="20">
      <label for="floatingPasswordConfirm">Powtórz hasło</label>
    </div> 
    <div class="form-floating">
    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
    <label for="avatar">Wybierz avatar</label>
</div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Zarejestruj</button>
    <br><br>
    <p>Masz już konto? <a href="login.php">Przejdź do logowania</a></p>
  </form>
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