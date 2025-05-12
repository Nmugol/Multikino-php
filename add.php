<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<HEAD>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Twój Opis">
  <meta name="author" content="Twoje dane">
  <meta name="keywords" content="Twoje słowa kluczowe">
  <title>Piszczek Przemysław</title>
  <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
  <style type="text/css" class="init"></style>
  <link rel="stylesheet" href="twoj_css.css">
  <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"
    integrity="sha384w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
  <script type="text/javascript" src="twoj_js.js"></script>
</HEAD>

<BODY>
  <?php
  session_start();
  $_SESSION['old'] = $_POST;  // zapisz dane do sesji
  
  $user = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");    // rozbrojenie potencjalnej bomby w zmiennej $user 
  $pass = htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");    // rozbrojenie potencjalnej bomby w zmiennej $pass 
  $confpass = htmlentities($_POST['confpass'], ENT_QUOTES, "UTF-8");
  $imie = htmlentities($_POST['imie'], ENT_QUOTES, "UTF-8");
  $nazwisko = htmlentities($_POST['nazwisko'], ENT_QUOTES, "UTF-8");
  $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");

  // Sprawdzanie, czy pola nazwa użytkownika i hasło są uzupełnione
  if (empty($user) || empty($pass)) {
    header('Location: rejestruj.php?error=empty');
    exit();
  }

  if ($pass !== $confpass) {
    header('Location: rejestruj.php?error=passwords');
    exit();
  }

  // Walidacja złożoności hasła
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pass)) {
  header('Location: rejestruj.php?error=weak_password');
  exit();
}


  if (!ctype_alnum($user)) {
    header('Location: rejestruj.php?error=login');
    exit();
  }

  $link = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");              // połączenie z BD – wpisać swoje dane 
  if (!$link) {
    echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
  } // obsługa błędu połączenia z BD 
  
  mysqli_query($link, "SET NAMES 'utf8mb4'");
  
  $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza 
  $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD  
  
  if ($rekord) {
    mysqli_close($link); // zamknięcie połączenia z BD 
    header('Location: rejestruj.php?error=login_exist');
  }

  $result1 = mysqli_query($link, "SELECT * FROM users WHERE email='$email'"); // wiersza, w którym login=login z formularza 
  $rekord1 = mysqli_fetch_array($result1); // wiersza z BD, struktura zmiennej jak w BD  
  
  if ($rekord1) {
    mysqli_close($link); // zamknięcie połączenia z BD 
    header('Location: rejestruj.php?error=email_exist');
  }

  $hash = password_hash($pass, PASSWORD_DEFAULT);
 // Wstawianie użytkownika do bazy danych (bez awatara na razie)
$query = "INSERT INTO users (username, password, imie, nazwisko, email) VALUES ('$user', '$hash', '$imie', '$nazwisko', '$email')";

if (mysqli_query($link, $query)) {
    // Tworzenie katalogu macierzystego dla użytkownika
    $user_directory = "../zmiana/" . $user;
    if (!file_exists($user_directory) && !mkdir($user_directory, 0755, true)) {
        echo "Nie udało się utworzyć katalogu.";
        exit();
    }

    // Sprawdzamy, czy plik został przesłany
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $name = basename($_FILES['avatar']['name']);
        $avatar_path = "$user_directory/$name";

        if (move_uploaded_file($tmp_name, $avatar_path)) {
            // Zapisujemy ścieżkę do awatara w bazie
            $avatar_path_db = mysqli_real_escape_string($link, $avatar_path);
        } else {
            echo "Błąd podczas przesyłania pliku.";
            exit();
        }
    } else {
        // Jeśli brak przesłanego pliku, ustaw domyślny awatar
        $avatar_path_db = 'avatars/default.png';
    }

    // Aktualizacja użytkownika o ścieżkę do awatara
    $update_query = "UPDATE users SET avatar='$avatar_path_db' WHERE username='$user'";
    mysqli_query($link, $update_query);

    echo "Rejestracja pomyślna";
    header("Location: login.php");
    exit();
} else {
    echo "Wystąpił błąd przy dodaniu użytkownika";
}

mysqli_close($link);

  ?>
  <?php require_once 'footer.php'; ?>
</BODY>

</HTML>