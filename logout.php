<?php
session_start(); //rozpoczęcie

session_unset(); //usunięcie zmiennych sesyjnych

session_destroy(); //zniszczenie sesji

header('Location: strona.php'); 

exit();
?>