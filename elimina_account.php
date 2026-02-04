<?php
session_start();
include 'connect.php';

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    header("Location: form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Controlla se il modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verifica le credenziali
    $sql = "SELECT password FROM utenti WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifica la password
        if (password_verify($password, $user['password'])) {
            // Elimina l'account dell'utente
            $sql = "DELETE FROM utenti WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                // Rimuovi i dati di sessione
                session_destroy();
                // Mostra un messaggio di successo
                echo "<script>
                        alert('Account eliminato con successo.');
                        window.location.href = 'index.html';
                      </script>";
                exit();
            } else {
                echo "Errore durante l'eliminazione dell'account: " . $conn->error;
            }
        } else {
            echo "Password errata.";
        }
    } else {
        echo "Email non trovata.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Account</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            color: #fff;
        }

        .navbar {
            background-color: rgba(107, 131, 155, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0; 
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0 30px;
        }

        .logo {
            margin-right: auto;
        }

        .nav-links {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            margin-right: 20px;
        }

        .nav-links li {
            margin: 0 10px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 15px;
            letter-spacing: 0.5px;
        }

        .nav-links a:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .user-menu {
            position: relative;
            margin-left: auto;
            margin-right: 20px;
        }

        .user-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background-color: #c0392b;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: none !important;
            transform: none !important;
        }

        .user-box:hover, .user-box:active, .user-box:focus {
            background-color: #c0392b !important;
            color: white !important;
            transform: none !important;
            box-shadow: none !important;
            border-color: transparent !important;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            min-width: 220px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 1;
            overflow: hidden;
            animation: fadeIn 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dropdown-content.show {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-content a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            padding-left: 25px;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 175px auto; /* Margine superiore per centrare */
        }

        h2 {
            text-align: center;
            color: #fff;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c0392b;
        }

        .footer-section {
    text-align: center; /* Centra il testo */
    }

    .footer {
        text-align: center;
        padding: 20px;
        margin-top: 50px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
    }

    .footer a {
        color:rgb(255, 255, 255);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer a:hover {
        text-decoration: underline;
    }

    .social-links {
    display: flex;
    justify-content: center; /* Centra i loghi */
    gap: 1rem; /* Spazio tra i loghi */
    margin-top: 10px; /* Spazio sopra i loghi */
    }
    </style>
    <script>
        function confirmDeletion() {
            return confirm("Sei sicuro di voler eliminare il tuo account? Questa azione è irreversibile.");
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show');
        }

        // Chiudi il dropdown se l'utente clicca fuori da esso
        window.onclick = function(event) {
            if (!event.target.matches('.user-box')) {
                const dropdowns = document.getElementsByClassName("dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="area_riservata.php">
                    <img src="img/primo_logo_terranova-removebg-preview.png" alt="Cocktail.Base Logo">
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="area_riservata.php">Home</a></li>
                <li><a href="area_riservata.php">Cerca</a></li>
                <li><a href="area_riservata.php">Cocktail</a></li>
                <li><a href="area_riservata.php">Chi Siamo</a></li>
            </ul>
            <div class="user-menu">
                <button class="user-box" onclick="toggleDropdown()">
                    <i class="fas fa-user-circle" style="font-size: 18px; margin-right: 8px;"></i>
                    <?php echo $_SESSION['user_email']; ?>
                </button>
                <div class="dropdown-content" id="dropdownMenu">
                    <a href="crea_cocktail.php">Crea Cocktail</a>
                    <a href="cambia_password.php">Cambia Password</a>
                    <a href="elimina_account.php">Elimina Account</a>
                    <a href="preferiti.php">Cocktail Preferiti</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Elimina il tuo account</h2>
        <form method="POST" action="" onsubmit="return confirmDeletion();">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Elimina Account</button>
        </form>
    </div>

    <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Cocktail.Base</h3>
                    <p>La tua destinazione ideale per scoprire e imparare tutto sui cocktail. Esplora la nostra ampia selezione di ricette, impara nuove tecniche e trova il drink perfetto per ogni occasione.</p>
                    <p>Per saperne di più, leggi la nostra <a href="privacy_policy.php" style="color: white;">Privacy Policy</a>.</p>

                </div>
                <div class="footer-section">
                    <h3>Link Utili</h3>
                    <ul>
                        <li><a href="#search">Cerca Cocktail</a></li>
                        <li><a href="#popular">Cocktail Popolari</a></li>
                        <li><a href="#about">Chi Siamo</a></li>
                        <li><a href="#home">Home</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Seguici</h3>
                    <div class="social-links">
                        <a href="#" target="_blank"><i class="fab fa-tiktok"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Cocktail.Base Tutti i diritti riservati.</p>
            </div>
        </footer>
</body>
</html>