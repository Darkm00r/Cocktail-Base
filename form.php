<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Non mostrare l'icona del cuore
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
   <link rel="stylesheet" href="css/stile-login.css">
</head>
<body>

   <div class="login container grid" id="loginAccessRegister">
      <div class="login__access">
         <h1 class="login__title">Accedi al tuo account.</h1>
         <div class="login__area">
            <form action="login.php" method="POST" class="login__form">
               <div class="login__content grid">
                  <div class="login__box">
                     <input type="email" id="email" name="email" required placeholder=" " class="login__input">
                     <label for="email" class="login__label">Email</label>
                     <i class="ri-mail-fill login__icon"></i>
                  </div>
                  <div class="login__box">
                     <input type="password" id="password" name="password" required placeholder=" " class="login__input">
                     <label for="password" class="login__label">Password</label>
                     <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                  </div>
               </div>
               <a href="#" class="login__forgot">Hai dimenticato la password?</a>
               <button type="submit" class="login__button">Accedi</button>
            </form>
            <div class="login__social">
               <p class="login__social-title">Oppure accedi con</p>
               <div class="login__social-links">
                  <a href="#" class="login__social-link">
                     <img src="img/icon-google.svg" alt="immagine" class="login__social-img">
                  </a>
                  <a href="#" class="login__social-link">
                     <img src="img/icon-apple.svg" alt="immagine" class="login__social-img">
                  </a>
               </div>
            </div>
            <p class="login__switch">
               Non hai un account? 
               <button id="loginButtonRegister">Crea un account</button>
            </p>
         </div>
      </div>
      <div class="login__register">
         <h1 class="login__title">Crea un nuovo account.</h1>
         <div class="login__area">
            <form action="register.php" method="POST" class="login__form">
               <div class="login__content grid">
                  <div class="login__group grid">
                     <div class="login__box">
                        <input type="text" id="names" name="names" required placeholder=" " class="login__input">
                        <label for="names" class="login__label">Nome</label>
                        <i class="ri-user-fill login__icon"></i>
                     </div>
                     <div class="login__box">
                        <input type="text" id="surnames" name="surnames" required placeholder=" " class="login__input">
                        <label for="surnames" class="login__label">Cognome</label>
                        <i class="ri-user-fill login__icon"></i>
                     </div>
                  </div>
                  <div class="login__box">
                     <input type="email" id="emailCreate" name="emailCreate" required placeholder=" " class="login__input">
                     <label for="emailCreate" class="login__label">Email</label>
                     <i class="ri-mail-fill login__icon"></i>
                  </div>
                  <div class="login__box">
                     <input type="password" id="passwordCreate" name="passwordCreate" required placeholder=" " class="login__input">
                     <label for="passwordCreate" class="login__label">Password</label>
                     <i class="ri-eye-off-fill login__icon login__password" id="loginPasswordCreate"></i>
                  </div>
               </div>
               <button type="submit" class="login__button">Crea account</button>
            </form>
            <p class="login__switch">
               Hai già un account? 
               <button id="loginButtonAccess">Accedi</button>
            </p>
         </div>
      </div>
   </div>
   <script src="js/login.js"></script>
</body>
</html>