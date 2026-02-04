<?php
session_start();
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Cocktail.Base</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Stile generale del corpo */
        body {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            color: #fff;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(107, 131, 155, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0; 
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: background-color 0.3s ease; /* Aggiunta della transizione */
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

        .nav-links a {
            position: relative; /* Necessario per il posizionamento del pseudo-elemento */
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.3s ease; /* Transizione per il colore */
            padding: 8px 15px;
            letter-spacing: 0.5px;
        }

        .nav-links a::after {
            content: ''; /* Crea un pseudo-elemento */
            position: absolute;
            left: 50%; /* Posiziona al centro */
            bottom: -5px; /* Posiziona sotto il link */
            width: 0; /* Inizialmente invisibile */
            height: 2px; /* Altezza della riga */
            background-color: rgba(214, 80, 80, 0.8); /* Colore della riga */
            transition: width 0.3s ease, left 0.3s ease; /* Transizione per larghezza e posizione */
        }

        .nav-links a:hover::after {
            width: 100%; /* Espandi la riga al passaggio del mouse */
            left: 0; /* Allinea a sinistra */
        }

        /* Menu utente */
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

        /* Contenuto del dropdown */
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

        .dropdown-content a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .dropdown-content a:hover::before {
            transform: scaleY(1);
        }

        /* Contenitore della privacy */
        .privacy-container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .privacy-container h1 {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .privacy-container h2 {
            color: #fff;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .privacy-container p {
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .privacy-container ul {
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .privacy-container li {
            margin-bottom: 10px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
        }

        .privacy-container a {
            color: #e74c3c;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .privacy-container a:hover {
            text-decoration: underline;
        }

        /* Sezione footer */
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
            color: rgb(255, 255, 255);
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

        @media (max-width: 850px) {
            .privacy-container {
                width: 90%;
                padding: 30px;
                margin-top: 80px;
            }
        }

        /* Pulsante preferito */
        .favorite-btn {
            background-color: rgb(8, 8, 6); /* Colore di sfondo verde */
            color: rgb(255, 255, 255); /* Colore del testo */
            border: none; /* Nessun bordo */
            padding: 10px 15px; /* Padding */
            border-radius: 5px; /* Angoli arrotondati */
            cursor: pointer; /* Cambia il cursore al passaggio del mouse */
            transition: background-color 0.3s, transform 0.2s; /* Transizione al passaggio del mouse */
            font-size: 14px; /* Dimensione del testo */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombra per un effetto di profondità */
        }

        .favorite-btn:hover {
            background-color: #45a049; /* Colore al passaggio del mouse */
            transform: scale(1.05); /* Leggero ingrandimento al passaggio del mouse */
        }   
    </style>
</head>
<body>
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <img src="img/primo_logo_terranova-removebg-preview.png" alt="Cocktail.Base Logo">
        </div>
        <ul class="nav-links">
            <li><a href="area_riservata.php">Home</a></li>
            <li><a href="area_riservata.php">Cerca</a></li>
            <li><a href="area_riservata.php">Cocktail</a></li>
            <li><a href="area_riservata.php">Chi Siamo</a></li>
        </ul>
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-menu">
            <button class="user-box" onclick="toggleDropdown()">
                <?php echo $_SESSION['user_email']; ?> <i class="fas fa-user"></i>
            </button>
            <div class="dropdown-content" id="dropdownMenu">
                <a href="crea_cocktail.php">Crea Cocktail</a>
                <a href="cambia_password.php">Cambia Password</a>
                <a href="elimina_account.php">Elimina Account</a>
                <a href="preferiti.php">Cocktail Preferiti</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <?php else: ?>
        <div class="auth-buttons">
            <a href="form.php" class="login-btn">Accedi</a>
        </div>
        <?php endif; ?>
    </div>
</nav>

<div class="privacy-container">
    <h1>Privacy Policy</h1>
    
    <p>La tua privacy è importante per noi. Questa Privacy Policy spiega come Cocktail.Base raccoglie, utilizza e protegge le informazioni che ci fornisci quando utilizzi il nostro sito web.</p>
    
    <h2>1. Informazioni che raccogliamo</h2>
    <p>Possiamo raccogliere i seguenti tipi di informazioni:</p>
    <ul>
        <li><strong>Informazioni personali</strong>: nome, indirizzo email, e altre informazioni che fornisci durante la registrazione.</li>
        <li><strong>Informazioni di utilizzo</strong>: dati su come interagisci con il nostro sito, inclusi i cocktail che visualizzi, le ricette che salvi e le preferenze che imposti.</li>
        <li><strong>Informazioni tecniche</strong>: indirizzo IP, tipo di browser, provider di servizi internet, pagine di riferimento/uscita, sistema operativo, data/ora e dati di clickstream.</li>
    </ul>
    
    <h2>2. Come utilizziamo le tue informazioni</h2>
    <p>Utilizziamo le informazioni raccolte per:</p>
    <ul>
        <li>Fornire, gestire e migliorare il nostro servizio</li>
        <li>Personalizzare la tua esperienza sul nostro sito</li>
        <li>Comunicare con te, incluso l'invio di notifiche relative al tuo account</li>
        <li>Analizzare l'utilizzo del sito per migliorare le nostre offerte</li>
        <li>Prevenire attività fraudolente e migliorare la sicurezza del nostro sito</li>
    </ul>
    
    <h2>3. Protezione dei dati</h2>
    <p>Adottiamo misure di sicurezza appropriate per proteggere le tue informazioni personali contro l'accesso, l'alterazione, la divulgazione o la distruzione non autorizzati. Queste misure includono la crittografia delle password e la protezione dei dati sensibili.</p>
    
    <h2>4. Condivisione delle informazioni</h2>
    <p>Non vendiamo, scambiamo o trasferiamo in altro modo a terzi le tue informazioni personali identificabili, tranne nei seguenti casi:</p>
    <ul>
        <li>Con partner fidati che ci aiutano a gestire il sito web, a condizione che accettino di mantenere queste informazioni riservate</li>
        <li>Quando riteniamo che il rilascio sia appropriato per rispettare la legge, applicare le nostre politiche del sito o proteggere i nostri o altrui diritti, proprietà o sicurezza</li>
    </ul>
    
    <h2>5. Cookie</h2>
    <p>Utilizziamo i cookie per migliorare la tua esperienza sul nostro sito. I cookie sono piccoli file che un sito o il suo fornitore di servizi trasferisce sul disco rigido del tuo computer attraverso il tuo browser web (se lo consenti) che permette ai siti o ai sistemi dei fornitori di servizi di riconoscere il tuo browser e catturare e ricordare certe informazioni.</p>
    
    <h2>6. I tuoi diritti</h2>
    <p>Hai il diritto di:</p>
    <ul>
        <li>Accedere alle tue informazioni personali</li>
        <li>Correggere i dati inesatti</li>
        <li>Richiedere la cancellazione dei tuoi dati</li>
        <li>Opporti al trattamento dei tuoi dati</li>
        <li>Richiedere la limitazione del trattamento dei tuoi dati</li>
        <li>Richiedere la portabilità dei tuoi dati</li>
    </ul>
    
    <h2>7. Modifiche alla Privacy Policy</h2>
    <p>Ci riserviamo il diritto di modificare questa privacy policy in qualsiasi momento. Ti invitiamo a controllare periodicamente questa pagina per eventuali modifiche. L'uso continuato del sito dopo la pubblicazione di modifiche a questa policy costituirà la tua accettazione di tali modifiche.</p>
    
    <h2>8. Contattaci</h2>
    <p>Se hai domande su questa Privacy Policy, puoi contattarci all'indirizzo email: <a href="mailto:info@cocktailbase.it">info@cocktailbase.it</a></p>
    
    <p class="last-updated">Ultimo aggiornamento: <?php echo date("d/m/Y"); ?></p>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> Cocktail.Base - Tutti i diritti riservati | <a href="privacy_policy.php">Privacy Policy</a></p>
</div>

<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById("dropdownMenu");
        if (dropdownMenu.style.display === "block") {
            dropdownMenu.style.display = "none";
        } else {
            dropdownMenu.style.display = "block";
        }
    }

    // Chiudi il dropdown se l'utente clicca fuori da esso
    window.onclick = function(event) {
        if (!event.target.matches('.user-box') && !event.target.matches('.user-box *')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
        }
    }
</script>
</body>
</html> 