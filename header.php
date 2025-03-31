<?php declare(strict_types=1);  /* Ta linia musi być pierwsza */ ?> 
<?php 
session_start(); // Zawsze zaczynamy sesję na początku pliku
?>
<header> 
<div class="container"> 
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top mt-0 mb-0 ms-0 me-0 pt-0 pb-0 ps-0 pe-0"> 
<div class="container-fluid"> 
<div class="collapse navbar-collapse" id="main_nav"> 
<ul class="navbar-nav "> 
<li class="nav-item"><a class="nav-link" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" href="strona.php">Strona główna <i class="fa fa-home"></i></a></li>
<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" data-bs-toggle="dropdown"> O Nas </a><ul class="dropdown-menu"> 
<li><a class="dropdown-item" href="oferta.php"><i class="fa fa-utensils"></i> Kinowe przekąski </a></li> 
<li><a class="dropdown-item" href="kontakt.php"><i class="fa fa-envelope"></i> Kontakt </a></li> 
</ul></li>
<!-- Goście portalu widoczne tylko dla admina -->
<?php if (isset($_SESSION['user'])) : ?>
    <?php if ($_SESSION['user'] == 'admin') : ?>
        <li class="nav-item"><a class="nav-link" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" href="goscie_portalu.php">Goście portalu <i class="fa fa-users"></i></a></li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" data-bs-toggle="dropdown"> Zarządzaj Multikinem </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="rezerwacje_admin.php"><i class="fa fa-calendar-check"></i> Wyświetl rezerwacje </a></li>
                <li><a class="dropdown-item" href="film.php"><i class="fa fa-film"></i> Dodaj film </a></li>
                <li><a class="dropdown-item" href="dodaj_seans.php"><i class="fa fa-clock"></i> Dodaj seans </a></li>
            </ul>
        </li>
    <?php else : ?>
        <!-- Wyświetlanie kontaktu dla zwykłych użytkowników -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" data-bs-toggle="dropdown"> Zarządzaj rezerwacjami </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="rezerwacje.php"><i class="fa fa-calendar"></i> Dokonaj rezerwacji </a></li>
                <li><a class="dropdown-item" href="modyfikuj.php"><i class="fa fa-table"></i> Tabela rezerwacji </a></li>
            </ul>
        </li>
        <li class="nav-item"><a class="nav-link" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" href="zmien.php">Zmień dane osobowe <i class="fa fa-user"></i></a></li>
        <?php endif; ?>
<?php endif; ?>
</div>  
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation"> 
<span class="navbar-toggler-icon"></span> 
</button>   
<?php
session_start(); // Start sesji
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $avatar = $_SESSION['avatar'];  // Zakładam, że w sesji trzymasz też ścieżkę do avatara
    // Jeżeli użytkownik jest zalogowany, pokazujemy opcję wylogowania
    echo 
    '<div class="nav-link ms-auto" style="color:white; text-shadow: black 0.1em 0.1em 0.2em; text-align:right; ">'.$_SESSION["user"].' <img src="' .$_SESSION["avatar"]. '" alt="Avatar" style="width:40px; height:40px; border-radius:50%; margin-right:10px;"></div><a class="nav-link" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" href="logout.php">Wyloguj się <i class="fa fa-sign-out-alt"></i></a>';
} 
else {
    echo 
    '<a class="nav-link" style="color:white; text-shadow: black 0.1em 0.1em 0.2em;" href="login.php">Zaloguj się <i class="fa fa-sign-out-alt"></i></a>';
}
?>  
</div>  
</nav>   
</div> 
<script type="text/javascript" src="twoj_js.js"></script>  
</header>