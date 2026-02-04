<?php
session_start();
include 'connect.php'; // Assicurati che questo file contenga la connessione al database

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    header("Location: form.php");
    exit();
}

// Controlla se il modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $istruzioni = $_POST['istruzioni'];
    $ingredienti = isset($_POST['ingredienti']) ? $_POST['ingredienti'] : '';
    $immagine_url = $_POST['immagine_url'];  // URL dell'immagine esterna
    
    // Gestione del caricamento dell'immagine
    $immagine_file = '';  // Percorso immagine caricato

    if (isset($_FILES['immagine_file']) && $_FILES['immagine_file']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Percorso della cartella uploads
        $target_file = $target_dir . basename($_FILES["immagine_file"]["name"]);
        
        // Verifica il tipo di file (per evitare l'upload di file dannosi)
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_type, $allowed_types)) {
            // Sposta il file caricato nella cartella di destinazione
            if (move_uploaded_file($_FILES["immagine_file"]["tmp_name"], $target_file)) {
                $immagine_file = $target_file; // Salva il percorso del file caricato
            } else {
                echo "Errore nel caricamento del file.";
            }
        } else {
            echo "Tipo di file non valido. Sono consentiti solo JPG, JPEG, PNG, e GIF.";
        }
    }

    // Se non c'è immagine caricata, usa l'URL immagine se disponibile
    $immagine_finale = $immagine_file ?: ($immagine_url ?: null);

    // Verifica che ci sia un'immagine o un URL
    if ($immagine_finale === null) {
        echo "Errore: Devi fornire un'immagine o un URL per il cocktail.";
        exit();
    }

    // Prepara la query per inserire i dati nel database
    $stmt = $conn->prepare("INSERT INTO cocktail (nome, ingredienti, istruzioni, user_id, cocktail_image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $nome, $ingredienti, $istruzioni, $_SESSION['user_id'], $immagine_finale);

    if ($stmt->execute()) {
        header("Location: visualizza_cocktail.php");
        exit();
    } else {
        echo "Errore: " . $stmt->error; // Mostra eventuali errori
    }

    $stmt->close();
}
?>
