<?php
session_start();

// Verifica che la sessione sia attiva
if (isset($_SESSION['user_id'])) {
    // Rimuove tutte le variabili di sessione
    session_unset();

    // Distrugge la sessione
    session_destroy();

    // Rimuove il cookie della sessione, se presente
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/'); // Scade il cookie di sessione
    }
}

// Reindirizza alla home page
header("Location: index.html");
exit();
?>