// Funkcja do dynamicznego ładowania nagłówka (jeśli potrzebne)
function myLoadHeader() {
    $(document).ready(function() {
        $('#myHeader').load("header.php", function() {
            setupThemeToggle(); // Upewnij się, że setupThemeToggle jest wywoływane po załadowaniu nagłówka
        });
    });

}

// Funkcja do ustawiania i zapamiętywania trybu kolorystycznego
function setupThemeToggle() {
    const storedTheme = localStorage.getItem('theme') || 'light'; // Domyślnie motyw jasny
    setTheme(storedTheme); // Ustawienia z localStorage lub domyślny jasny

    // Dodajemy event listener tylko raz
    document.querySelectorAll('#lightMode, #darkMode, #autoMode').forEach(button => {
        button.addEventListener('click', function() {
            const theme = this.id.replace('Mode', ''); // 'light', 'dark', 'auto'
            setTheme(theme);
            localStorage.setItem('theme', theme);
        });
    });
}

// Funkcja do ustawienia motywu i odpowiedniej ikony
function setTheme(theme) {
    document.body.setAttribute('data-bs-theme', theme);
    const themeIcon = document.getElementById('themeIcon');

    // Ustaw ikonę odpowiednią dla motywu
    if (theme === 'light') {
        themeIcon.classList.remove('bi-moon-fill', 'bi-circle-half');
        themeIcon.classList.add('bi-sun-fill');
    } else if (theme === 'dark') {
        themeIcon.classList.remove('bi-sun-fill', 'bi-circle-half');
        themeIcon.classList.add('bi-moon-fill');
    } else {
        themeIcon.classList.remove('bi-sun-fill', 'bi-moon-fill');
        themeIcon.classList.add('bi-circle-half');
    }

    // Zaktualizuj ikony zgodnie z motywem
    updateIcons(theme);
}

// Funkcja do aktualizacji ikon
function updateIcons(theme) {
    const infoIcon = document.querySelector('.icon-info');
    const helpIcon = document.querySelector('.icon-help');

    // Upewnij się, że ikony istnieją, zanim spróbujesz je zaktualizować
    if (infoIcon) {
        infoIcon.src = theme === 'dark' ? '../icons/info_dark.svg' : '../icons/info.svg';
    }
    if (helpIcon) {
        helpIcon.src = theme === 'dark' ? '../icons/help_dark.svg' : '../icons/help.svg';
    }
}


// Funkcja do wczytania zapisanej skórki przy starcie
$(document).ready(function() {
    const storedTheme = localStorage.getItem('theme') || 'light'; // Domyślny jasny motyw
    setTheme(storedTheme); // Ustawienie motywu przy starcie
});