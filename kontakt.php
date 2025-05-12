<?php declare(strict_types=1);  /* Ta linia musi byc pierwsza */ ?>
<?php
session_start(); // Zawsze zaczynamy sesję na początku pliku
?>

<!DOCTYPE html>
<html lang="pl">
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Twój Opis">
    <meta name="author" content="Twoje dane">
    <meta name="keywords" content="Twoje słowa kluczowe">
    <title>Multikino</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <style type="text/css" class="init"></style>
    <link rel="stylesheet" href="twoj_css.css">
    <link rel="stylesheet" href="strona.css">
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
</head>
<style>

.lokalizacja{
    font-size: 60px;

}

.lokalizacja1 {
    margin-top: 20px;
    font-size: 40px;

}

/* ======== GLOBALNE STYLE ======== */
body {
    font-family: 'Poppins', sans-serif;
   color: #333;
}


/* ======== KONTAKT ======== */
.set-section {
    padding: 30px;
    border-radius: 10px;
    margin-top: 20px;

}

.set-section h3 {
    color: red;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* ======== DANE KONTAKTOWE ======== */
.contact-details h4 {
    font-size: 18px;
    margin: 10px 0;
}

.contact-details img {
    border-radius: 10px;
}



/* ======== FAQ (AKORDEON) ======== */
.accordion-button {
    background:rgb(246, 12, 12);
    color: white;
    font-weight: bold;
    border: none;
}


.accordion-body {
    font-size: 16px;
    line-height: 1.6;
}

/* ======== MODAL ======== */
#reservationModal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.modal-content h2 {
    color:rgb(0, 0, 0);
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.modal-content button {
    background: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.modal-content button:hover {
    background: #c82333;
}

@media (max-width: 768px) {
    .lokalizacja{
        margin-top: 60px;
        font-size: 40px;

}

.lokalizacja1 {
    margin-top: 20px;
    font-size: 20px;

}
#audioPlayer {
    display: none;
}
.set-section {
    padding: 10px;
    border-radius: 10px;

}

.accordion-button {
    color: white;
    font-weight: bold;
    border: none;
}


.accordion-body {
    
    font-size: 16px;
    line-height: 1.6;
}


#mapPlayer {
    border: 2px solid black;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.5);
}

}

@media (max-width: 480) {
    .lokalizacja{
        margin-top: 60px;
        font-size: 40px;

}

.lokalizacja1 {
    margin-top: 20px;
    font-size: 20px;

}
#audioPlayer {
    display: none;
}
.set-section {
    padding: 10px;
    border-radius: 10px;

}

.accordion-button {
    color: white;
    font-weight: bold;
    border: none;
}


.accordion-body {
    
    font-size: 16px;
    line-height: 1.6;
}


#mapPlayer {
    border: 2px solid black;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.5);
}

}

</style>

<body onload="myLoadHeader()">
    <div id="animatedBackground"></div>
    <div id="myHeader"></div>
    <main>
        <section class="sekcja3">
            <div class="container text-center my-5">
                <h1 class="lokalizacja"> ☎️ Kontakt ☎️</h1>
                <div class="container">
                    <div class="set-section cien">
                    <h3>Masz pytania lub sugestie? Skontaktuj się z nami!</h3>
                        <div class="content" style="font-size:1vw;">
                            <div class="contact-details">
                                <h4><b>Email:</b> kontakt@multikino.pl</h4>
                                <h4><b>Telefon:</b> +48 123 456 789</h4>
                                <h4><b>Adres:</b> Profesora Sylwestra Kaliskiego 7, 85-796 Bydgoszcz</h4>
                                <img src="../image/kontakt.png" id="audioPlayer" alt="Kontakt"
                                    style="max-width: 24vw;  max-height: 18vw; min-width: 15vw; min-height: 12vw;">
                            </div>
                            <br>
                            <div class="container mt-4">
                                <h2 class="text-center">Najczęściej zadawane pytania (FAQ)</h2>
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#faq1" aria-expanded="true">
                                                Jakie są godziny otwarcia?
                                            </button>
                                        </h2>
                                        <div id="faq1" class="accordion-collapse collapse show"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Nasze godziny otwarcia to od poniedziałku do piątku: 8:00 - 23:00, w
                                                weekendy: 8:00 - 01:00.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq2">
                                                Czy można dokonać rezerwacji online?
                                            </button>
                                        </h2>
                                        <div id="faq2" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Tak, rezerwacji można dokonać za pośrednictwem naszej strony
                                                internetowej lub telefonicznie.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq3">
                                                Jakie formy płatności akceptujecie?
                                            </button>
                                        </h2>
                                        <div id="faq3" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Akceptujemy płatności gotówką, kartami płatniczymi oraz systemy
                                                płatności online, takie jak BLIK.
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <br>
                            <div class="map">
                                <h1 class="lokalizacja1">Nasza lokalizacja</h1>
                                <center>
                                    <div class="map-container">
                                        <iframe id="mapPlayer"
                                            src="https://www.google.com/maps/embed?pb=!1m21!1m12!1m3!1d1196.5616067170142!2d18.129568202565007!3d53.14388321857518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m6!3e6!4m3!3m2!1d53.1441519!2d18.1300564!4m0!5e0!3m2!1spl!2spl!4v1743104766112!5m2!1spl!2spl"
                                            width="600" height="450" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <?php require_once 'motyw.php'; ?>
    <?php require_once 'footer.php'; ?>
</body>


</html>