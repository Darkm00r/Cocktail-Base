<?php
session_start();
include 'connect.php'; // Assicurati che questo file contenga la connessione al database

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    header("Location: form.php");
    exit();
}

// Recupera i cocktail creati dall'utente
$stmt = $conn->prepare("SELECT nome, ingredienti, istruzioni, created_at FROM cocktail WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I tuoi Cocktail</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            color: #fff;
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        .card h3 {
            margin: 10px 0;
        }
        .card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h2>I tuoi Cocktail</h2>
    <div class="cocktail-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
            <img src="<?php echo htmlspecialchars($row['cocktail_image']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                <p><strong>Ingredienti:</strong> <?php echo htmlspecialchars($row['ingredienti']); ?></p>
                <p><strong>Istruzioni:</strong> <?php echo htmlspecialchars($row['istruzioni']); ?></p>
                <p><small>Creato il: <?php echo htmlspecialchars($row['created_at']); ?></small></p>
            </div>
        <?php endwhile; ?>
    </div>
    <a href="crea_cocktail.php">Crea un altro cocktail</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>