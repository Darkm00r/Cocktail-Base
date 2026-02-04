<?php
include 'connect.php'; // Include la connessione al database

// Validazione e sanitizzazione dei dati
function sanitizeInput($conn, $data) {
    return mysqli_real_escape_string($conn, trim(strip_tags($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Aggiungi questa riga per il debug
    // Verifica che tutti i campi siano stati inviati e non siano vuoti
    if (empty($_POST['names']) || empty($_POST['surnames']) || empty($_POST['emailCreate']) || empty($_POST['passwordCreate'])) {
        die("Tutti i campi sono obbligatori.");
    }

    // Recupero e sanitizzazione dati dal form
    $nome = sanitizeInput($conn, $_POST['names']);
    $cognome = sanitizeInput($conn, $_POST['surnames']);
    $email = filter_var($_POST['emailCreate'], FILTER_SANITIZE_EMAIL);
    $password = sanitizeInput($conn, $_POST['passwordCreate']);

    // Validazione email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Indirizzo email non valido");
    }

    // Controlla se l'email è già registrata
    $check_query = "SELECT * FROM utenti WHERE email = '$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email già registrata.']);
        $conn->close();
        exit;
    }

    // Cripta la password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Procedi con la query INSERT
    $sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES ('$nome', '$cognome', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Reindirizza alla home page con il parametro di successo
        header("Location: index.html?success=true&name=" . urlencode($nome));
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante la registrazione: ' . $conn->error]);
    }

    $conn->close();
}
?>
