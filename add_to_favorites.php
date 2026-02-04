<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    var_dump($data); // Aggiungi questo log per vedere i dati ricevuti

    if (!isset($data['cocktail_id'])) {
        echo json_encode(['success' => false, 'message' => 'Dati mancanti.']);
        exit();
    }

    $cocktail_id = $data['cocktail_id'];
    $cocktail_name = $data['cocktail_name'];
    $cocktail_image = $data['cocktail_image'];

    // Aggiungi il cocktail ai preferiti
    $sql = "INSERT INTO preferiti (user_id, cocktail_id, cocktail_name, cocktail_image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $cocktail_id, $cocktail_name, $cocktail_image);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    // Se non è una richiesta POST, mostra un messaggio di errore
    echo "Errore: richiesta non valida.";
}
?>