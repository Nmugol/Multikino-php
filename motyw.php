<?php declare(strict_types=1);  /* Ta linia musi być pierwsza */ ?> 
<!-- Przycisk do zmiany motywu -->
<div class="dropdown position-fixed bottom-0 end-0 m-4" style="z-index:10;">
        <button class="btn btn-primary dropdown-toggle" type="button" id="themeDropdown" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i id="themeIcon" class="bi bi-sun-fill"></i> <!-- Ikona motywu -->
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
        <li><button class="dropdown-item" id="autoMode"><i class="bi bi-circle-half"></i> Auto</button></li>
            <li><button class="dropdown-item" id="lightMode"><i class="bi bi-flower3"></i> Jasny - Zielony</button></li>
            <li><button class="dropdown-item" id="yellowMode"><i class="bi bi-sun-fill"></i> Jasny - Żółty</button></li>
            <li><button class="dropdown-item" id="blueMode"><i class="bi bi-cloudy-fill"></i> Ciemny - Niebieski</button></li>
            <li><button class="dropdown-item" id="darkMode"><i class="bi bi-moon-fill"></i> Ciemny - Czerwony</button></li>
        </ul>
    </div>