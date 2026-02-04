<?php
session_start(); // Avvia la sessione
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $utente = $result->fetch_assoc();

    if ($utente && password_verify($password, $utente['password'])) {
        $_SESSION['user_id'] = $utente['id']; // Salva l'ID dell'utente nella sessione
        $_SESSION['user_email'] = $utente['email']; // Salva l'email dell'utente
        header("Location: area_riservata.php"); // Reindirizza all'area riservata
        exit();
    } else {
        echo "Email o password errati.";
    }
}
?>