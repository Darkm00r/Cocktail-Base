<?php
// Parametri di connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cocktail_base"; // Cambia il nome del database se necessario

// Creazione connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>