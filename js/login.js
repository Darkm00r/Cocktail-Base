const passwordAccess = (loginPass, loginEye) => {
    const input = document.getElementById(loginPass),
          iconEye = document.getElementById(loginEye);
 
    iconEye.addEventListener('click', () => {
       input.type === 'password' ? input.type = 'text' : input.type = 'password';
       iconEye.classList.toggle('ri-eye-fill');
       iconEye.classList.toggle('ri-eye-off-fill');
    });
 }
 passwordAccess('password','loginPassword');
 
 const passwordRegister = (loginPass, loginEye) => {
    const input = document.getElementById(loginPass),
          iconEye = document.getElementById(loginEye);
 
    iconEye.addEventListener('click', () => {
       input.type === 'password' ? input.type = 'text' : input.type = 'password';
       iconEye.classList.toggle('ri-eye-fill');
       iconEye.classList.toggle('ri-eye-off-fill');
    });
 }
 passwordRegister('passwordCreate','loginPasswordCreate');
 
 const loginAcessRegister = document.getElementById('loginAccessRegister'),
       buttonRegister = document.getElementById('loginButtonRegister'),
       buttonAccess = document.getElementById('loginButtonAccess');
 
 buttonRegister.addEventListener('click', () => {
    loginAcessRegister.classList.add('active');
 });
 
 buttonAccess.addEventListener('click', () => {
    loginAcessRegister.classList.remove('active');
 });
 
 const translations = {
    en: {
       loginTitle: "Log in to your account.",
       emailLabel: "Email",
       passwordLabel: "Password",
       forgotPassword: "Forgot your password?",
       loginButton: "Login",
       registerTitle: "Create new account.",
    },
    it: {
       loginTitle: "Accedi al tuo account.",
       emailLabel: "Email",
       passwordLabel: "Password",
       forgotPassword: "Hai dimenticato la password?",
       loginButton: "Accedi",
       registerTitle: "Crea un nuovo account.",
    }
 };
 
 const languageToggle = document.getElementById('languageToggle');
 languageToggle.addEventListener('click', () => {
    const currentLang = languageToggle.innerText === "Italiano" ? "it" : "en";
    const newLang = currentLang === "it" ? "en" : "it";
    languageToggle.innerText = newLang === "it" ? "English" : "Italiano";
 
    document.querySelectorAll('[data-translate]').forEach(element => {
       const key = element.getAttribute('data-translate');
       element.innerText = translations[newLang][key];
    });
 });