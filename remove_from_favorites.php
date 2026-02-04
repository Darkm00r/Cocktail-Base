<?php
session_start();
include 'connect.php'; // Assicurati di includere il file di connessione al database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['cocktail_id'])) {
        echo json_encode(['success' => false, 'message' => 'Dati mancanti.']);
        exit();
    }

    $cocktail_id = $data['cocktail_id'];
    $user_id = $_SESSION['user_id'];

    // Prepara e esegui la query per rimuovere il cocktail dai preferiti
    $stmt = $conn->prepare("DELETE FROM preferiti WHERE user_id = ? AND cocktail_id = ?");
    $stmt->bind_param("ii", $user_id, $cocktail_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante la rimozione dai preferiti.']);
    }

    $stmt->close();
    $conn->close();
}
?>