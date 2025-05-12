<?php 
session_start(); 
  // **OPCJA BLOKUJĄC LOGOWANIE NA MINUTĘ
  // Inicjalizacja zmiennych sesyjnych, jeśli nie są jeszcze ustawione
  if (!isset($_SESSION['login_attempts'])) {
     $_SESSION['login_attempts'] = 0;  // Licznik nieudanych prób logowania
   }
  if (!isset($_SESSION['last_attempt_time'])) {
     $_SESSION['last_attempt_time'] = time();  // Czas ostatniej próby logowania
     }
 // Sprawdzenie, czy użytkownik nie jest zablokowany po nieudanych próbach
 if ($_SESSION['login_attempts'] >= 2) {
   $time_since_last_attempt = time() - $_SESSION['last_attempt_time'];
   if ($time_since_last_attempt < 60) {  // Jeśli od ostatniej próby minęło mniej niż 60 sekund
     header('Location: login.php?error=to_much');
     exit();
   } else {
     // Reset liczby prób po upływie 1 minuty
     $_SESSION['login_attempts'] = 0;
   }
 }


  //$user=$_POST['user']; // login z formularza 
  //$pass=$_POST['pass']; // hasło z formularza 
  $user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user 
  $pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass 

  $link = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2");               // połączenie z BD – wpisać swoje dane 
  if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD 
  
  mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków 
  
  $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza 
  $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD  
  
  if(!$rekord) // Jeśli brak, to nie ma użytkownika o podanym loginie 
  { 
     mysqli_close($link); // zamknięcie połączenia z BD 
     header('Location: login.php?error=not_exist_user');
  } 
  
  else 
  {                                                // jeśli  $rekord istnieje 
    if (password_verify($pass, $rekord['password'])) 
     {                            
        //echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}"; 
        $_SESSION ['loggedin'] = true; 
        $_SESSION ['user'] = $rekord['username']; 
        $_SESSION['avatar'] = $rekord['avatar'];
        $_SESSION['id'] = $rekord['id'];
        // **OPCJA BLOKUJĄC LOGOWANIE NA MINUTĘ
        $_SESSION['login_attempts'] = 0;  // Reset liczby prób logowania po sukcesie
        $_SESSION['user_directory'] = "../zmiana/" . $rekord['username']; // Ustawienie zmiennej sesyjnej z katalogiem
        

// Połączenie z bazą danych
$link = mysqli_connect("sql313.infinityfree.com", "if0_38548544", "4uPNwL0WT0L", "if0_38548544_multikinov2"); 
if (!$link) {
    echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
    exit();
}
mysqli_query($link, "SET NAMES 'utf8'");

// Pobranie IP gościa
$ipaddress = $_SERVER['REMOTE_ADDR'];

// Pobranie bieżącej daty i godziny
date_default_timezone_set('Europe/Warsaw');
$datetime = date('Y-m-d H:i:s');

// Zbieranie danych o przeglądarki z JavaScript
$screenRes = isset($_POST['screenRes']) ? $_POST['screenRes'] : '';
$windowRes = isset($_POST['windowRes']) ? $_POST['windowRes'] : '';
$colors = isset($_POST['colors']) ? $_POST['colors'] : '';
$cookies = isset($_POST['cookies']) ? $_POST['cookies'] : '';
$javaEnabled = isset($_POST['javaEnabled']) ? $_POST['javaEnabled'] : '';
$language = isset($_POST['language']) ? $_POST['language'] : '';

// Przygotowanie zapytania do dodania rekordu
$query = "INSERT INTO goscieportalu (ipaddress, datetime, browser, screenRes, windowRes, colors, cookies, javaEnabled, language) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "sssssssss", $ipaddress, $datetime, $_SERVER['HTTP_USER_AGENT'], $screenRes, $windowRes, $colors, $cookies, $javaEnabled, $language);

// Wykonanie zapytania tylko przy danych z POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Wykonanie zapytania
    if (mysqli_stmt_execute($stmt)) {
        echo "Rekord dodany pomyślnie.";
    } else {
        echo "Błąd przy dodawaniu rekordu: " . mysqli_error($link);
    }
}
$userDirectory = realpath('../zmiana/' . $_SESSION['user']);
    // Przekieruj do głównego katalogu z odpowiednim komunikatem o błędzie
    header('Location: strona.php?dir=' . urlencode($userDirectory));

mysqli_stmt_close($stmt);
mysqli_close($link);

     } 
     else                         
     { 
        mysqli_close($link); 
        header('Location: login.php?error=wrong_password');
        // **OPCJA BLOKUJĄC LOGOWANIE NA MINUTĘ
        $_SESSION['login_attempts']++;  // Zwiększenie licznika nieudanych prób
        $_SESSION['last_attempt_time'] = time();  // Zapisanie czasu nieudanej próby
        //header("Location: index3.php");
     } 
   } 

?> 
