// Popola il select delle lettere
document.addEventListener('DOMContentLoaded', function() {
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
    const letterSelect = document.getElementById('searchByLetter');
    letters.forEach(letter => {
        const option = document.createElement('option');
        option.value = letter;
        option.textContent = letter;
        letterSelect.appendChild(option);
    });
});

// Funzione per gestire la ricerca
function performSearch() {
    const searchType = document.getElementById('searchType').value;
    const searchValue = document.getElementById('cocktailName').value;
    
    console.log('Tipo di ricerca:', searchType);
    console.log('Valore ricerca:', searchValue);

    switch(searchType) {
        case 'name':
            fetch(`https://www.thecocktaildb.com/api/json/v1/1/search.php?s=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.drinks) {
                        displayResults(data.drinks);
                    } else {
                        displayResults([]);
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    displayResults([]);
                });
            break;

        case 'ingredient':
            fetch(`https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.drinks) {
                        displayResults(data.drinks);
                    } else {
                        displayResults([]);
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    displayResults([]);
                });
            break;

        case 'category':
            fetch(`https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.drinks) {
                        displayResults(data.drinks);
                    } else {
                        displayResults([]);
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    displayResults([]);
                });
            break;

        case 'random':
            fetch('https://www.thecocktaildb.com/api/json/v1/1/random.php')
                .then(response => response.json())
                .then(data => {
                    if (data && data.drinks) {
                        displayResults(data.drinks);
                    } else {
                        displayResults([]);
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    displayResults([]);
                });
            break;
    }
}

// Funzione per ottenere e mostrare i dettagli di un cocktail
function getCocktailDetails(id) {
    fetch(`https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.drinks && data.drinks[0]) {
                displayDetailedModal(data.drinks[0]);
            }
        })
        .catch(error => console.error('Errore nel caricamento dei dettagli:', error));
}

// Funzione per mostrare il modal con i dettagli
function displayDetailedModal(drink) {
    // Creiamo gli array degli ingredienti e delle misure
    const ingredients = [];
    for (let i = 1; i <= 15; i++) {
        if (drink[`strIngredient${i}`]) {
            const ingredient = drink[`strIngredient${i}`];
            const measure = drink[`strMeasure${i}`] || '';
            ingredients.push(`${measure} ${ingredient}`);
        }
    }

    // Creiamo il modal
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div class="modal-header">
                <img src="${drink.strDrinkThumb}" alt="${drink.strDrink}">
                <h2>${drink.strDrink}</h2>
            </div>
            <div class="modal-body">
                <div class="ingredients">
                    <h3>Ingredienti:</h3>
                    <ul>
                        ${ingredients.map(ing => `<li>${ing}</li>`).join('')}
                    </ul>
                </div>
                <div class="instructions">
                    <h3>Istruzioni:</h3>
                    <p>${drink.strInstructions || 'Istruzioni non disponibili.'}</p>
                </div>
            </div>
        </div>
    `;

    // Aggiungiamo il modal al body
    document.body.appendChild(modal);

    // Gestiamo la chiusura del modal
    const closeButton = modal.querySelector('.close-button');
    closeButton.onclick = () => {
        document.body.removeChild(modal);
    };

    // Chiudi il modal se si clicca fuori
    window.onclick = (event) => {
        if (event.target === modal) {
            document.body.removeChild(modal);
        }
    };
}

let allDrinks = []; // Array per memorizzare tutti i drink
let currentIndex = 0;
const drinksPerPage = 10;

function displayResults(drinks) {
    allDrinks = drinks || [];
    currentIndex = 0;
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = ''; // Pulisce i risultati precedenti
    
    if (!drinks || drinks.length === 0) {
        resultsContainer.innerHTML = '<p class="no-results">Nessun cocktail trovato</p>';
        return;
    }

    displayNextDrinks();
}

function createDrinkCard(drink) {
    // Crea la card del drink
    const card = document.createElement('div');
    card.className = 'cocktail-card';

    // La struttura della card mantiene solo il bottone per i dettagli e i preferiti
    card.innerHTML = `
        <img src="${drink.strDrinkThumb}" alt="${drink.strDrink}" class="cocktail-image">
        <div class="cocktail-info">
            <h3>${drink.strDrink}</h3>
            <!-- Dettagli e Preferiti direttamente qui -->
            <button onclick="getCocktailDetails('${drink.idDrink}')">Dettagli</button>
            <button onclick="addToFavorites('${drink.idDrink}')">Aggiungi ai preferiti</button>
        </div>
    `;
    
    return card;
}

function displayNextDrinks() {
    const resultsContainer = document.getElementById('results');
    const loadMoreContainer = document.getElementById('load-more-container') || createLoadMoreContainer();
    
    // Mostra i prossimi 10 drink
    const drinksToShow = allDrinks.slice(currentIndex, currentIndex + drinksPerPage);
    
    drinksToShow.forEach(drink => {
        const drinkCard = createDrinkCard(drink);
        resultsContainer.appendChild(drinkCard);
    });
    
    currentIndex += drinksPerPage;
    
    // Aggiorna il bottone "Carica altri"
    if (currentIndex >= allDrinks.length) {
        loadMoreContainer.innerHTML = '<p class="no-more-drinks">Non ci sono più drink da mostrare</p>';
    } else {
        loadMoreContainer.innerHTML = `
            <button class="load-more-btn" onclick="displayNextDrinks()">
                Mostra altri drink
            </button>
        `;
    }
}

function createLoadMoreContainer() {
    const container = document.createElement('div');
    container.id = 'load-more-container';
    container.style.textAlign = 'center';
    container.style.marginTop = '20px';
    document.getElementById('results').after(container);
    return container;
}

function getPopularCocktails() {
    const formData = new FormData();
    formData.append('searchType', 'popular');
    formData.append('searchValue', '');

    fetch('http://localhost/Sito-Con-Database/search.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.drinks) {
            displayPopularCocktails(data.drinks);
        }
    });
}

function displayPopularCocktails(drinks) {
    const popularCocktailsDiv = document.getElementById('popularCocktails');
    popularCocktailsDiv.innerHTML = '';

    drinks.forEach(drink => {
        const card = document.createElement('div');
        card.className = 'cocktail-card';
        card.innerHTML = `
            <img src="${drink.strDrinkThumb}" alt="${drink.strDrink}">
            <div class="cocktail-info">
                <h3>${drink.strDrink}</h3>
                <p>${drink.strInstructions ? drink.strInstructions : 'N/A'}</p>
            </div>
        `;
        popularCocktailsDiv.appendChild(card);
    });
}

// Chiama la funzione per ottenere i cocktail popolari al caricamento della pagina
document.addEventListener('DOMContentLoaded', getPopularCocktails);

// Aggiungi questo all'inizio del file o dopo il DOMContentLoaded
document.getElementById('searchType').addEventListener('change', function() {
    const cocktailNameContainer = document.querySelector('.cocktail-name-container');
    const searchLabel = document.querySelector('.cocktail-name-container label');
    const searchInput = document.getElementById('cocktailName');
    const searchType = this.value;
    
    switch(searchType) {
        case 'random':
            cocktailNameContainer.style.display = 'none';
            break;
        case 'name':
            cocktailNameContainer.style.display = 'block';
            searchLabel.textContent = 'Nome del cocktail:';
            searchInput.placeholder = 'Inserisci il nome del cocktail';
            break;
        case 'ingredient':
            cocktailNameContainer.style.display = 'block';
            searchLabel.textContent = 'Ingrediente del cocktail:';
            searchInput.placeholder = 'Inserisci l\'ingrediente';
            break;
        case 'category':
            cocktailNameContainer.style.display = 'block';
            searchLabel.textContent = 'Categoria del cocktail:';
            searchInput.placeholder = 'Inserisci la categoria';
            break;
    }
});

// Assicurati che il campo sia correttamente impostato quando si carica la pagina
document.addEventListener('DOMContentLoaded', function() {
    const searchType = document.getElementById('searchType').value;
    const cocktailNameContainer = document.querySelector('.cocktail-name-container');
    const searchLabel = document.querySelector('.cocktail-name-container label');
    const searchInput = document.getElementById('cocktailName');
    
    switch(searchType) {
        case 'random':
            cocktailNameContainer.style.display = 'none';
            break;
        case 'name':
            cocktailNameContainer.style.display = 'block';
            searchLabel.textContent = 'Nome del cocktail:';
            searchInput.placeholder = 'Inserisci il nome del cocktail';
            break;
        case 'ingredient':
            cocktailNameContainer.style.display = 'block';
            searchLabel.textContent = 'Ingrediente del cocktail:';
            searchInput.placeholder = 'Inserisci l\'ingrediente';
            break;
        case 'category':
            cocktailNameContainer.style.display = 'block';
            searchLabel.textContent = 'Categoria del cocktail:';
            searchInput.placeholder = 'Inserisci la categoria';
            break;
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const agePopup = document.getElementById('agePopup');
    const cookiePopup = document.getElementById('cookiePopup');
    const overlay = document.getElementById('overlay');
    const yesButton = document.getElementById('yesButton');
    const noButton = document.getElementById('noButton');
    const acceptCookiesButton = document.getElementById('acceptCookies');
    const declineCookiesButton = document.getElementById('declineCookies');

    // Funzione per leggere un cookie
    function getCookie(name) {
        let cookieArr = document.cookie.split(';');
        for (let i = 0; i < cookieArr.length; i++) {
            let cookie = cookieArr[i].trim();
            if (cookie.startsWith(name + '=')) {
                return cookie.substring(name.length + 1);
            }
        }
        return null;
    }

    // Funzione per settare un cookie
    function setCookie(name, value, days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Impostiamo la durata del cookie
        let expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Funzione per nascondere entrambi i pop-up e l'overlay
    function hidePopups() {
        agePopup.style.display = 'none';
        cookiePopup.style.display = 'none';
        overlay.style.display = 'none';
    }

    // Mostra il pop-up dell'età
    agePopup.style.display = 'flex';
    overlay.style.display = 'block'; // Mostra l'overlay

    // Quando l'utente risponde al pop-up dell'età
    yesButton.addEventListener('click', function () {
        setCookie('ageConfirmed', 'true', 30); // Impostiamo il cookie per 30 giorni
        hidePopups();
        showCookiePopup(); // Mostra il pop-up dei cookie
    });

    noButton.addEventListener('click', function () {
        window.location.href = 'https://youtube.com/shorts/nLMqKfae7j4?si=x6jstaxJ9j8_b6ll'; // Reindirizza altrove se non ha 18 anni
    });

    // Mostra il pop-up dei cookie se non è stato accettato
    function showCookiePopup() {
        if (!getCookie('cookiesAccepted')) {
            cookiePopup.style.display = 'flex'; // Cambiato da 'block' a 'flex' per mantenerlo centrato
        }
    }

    // Quando l'utente accetta i cookie
    acceptCookiesButton.addEventListener('click', function () {
        setCookie('cookiesAccepted', 'true', 30); // Salva l'accettazione dei cookie per 30 giorni
        hidePopups();
    });

    // Quando l'utente rifiuta i cookie
    declineCookiesButton.addEventListener('click', function () {
        setCookie('cookiesAccepted', 'false', 30); // Salva il rifiuto dei cookie per 30 giorni
        hidePopups();
    });
});


function toggleDropdown() {
    const userBox = document.querySelector('.user-box');
    const dropdown = document.getElementById('dropdownMenu');
    
    // Aggiungi o rimuovi la classe 'open' al box utente
    userBox.classList.toggle('open');
    
    // Verifica se il menu è stato aperto
    console.log('Menu aperto:', userBox.classList.contains('open'));
}

// Chiudi il menu se clicchi fuori dal box
window.onclick = function(event) {
    if (!event.target.matches('.user-box') && !event.target.closest('.user-menu')) {
        const userBox = document.querySelector('.user-box');
        const dropdown = document.getElementById('dropdownMenu');
        
        // Rimuovi la classe 'open' per nascondere il menu
        if (userBox.classList.contains('open')) {
            userBox.classList.remove('open');
            console.log('Menu chiuso');
        }
    }
}



