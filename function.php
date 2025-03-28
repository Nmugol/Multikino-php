<?php

function get_sql(){
    $servername = "sql313.infinityfree.com";
    $username = "if0_38548544";
    $passworddb = "4uPNwL0WT0L";
    $dbname = "if0_38548544_multikino";

    // Utwórz połączenie z bazą danych
    $connect = new mysqli($servername, $username, $passworddb, $dbname);
    $connect->set_charset("utf8mb4");

    if ($connect->connect_error) {
        die("Nie nawiązano połączenia z bazą: " . $connect->connect_error);

    }
    return $connect;
}

?>
