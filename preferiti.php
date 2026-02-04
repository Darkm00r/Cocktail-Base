<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cocktail Preferiti</title>
</head>
<body>
    <h1>I tuoi Cocktail Preferiti</h1>
    <div class="cocktail-container" id="cocktailContainer"></div>

    <script>
        // Recupera i preferiti dal localStorage
        const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        const cocktailContainer = document.getElementById('cocktailContainer');

        // Funzione per ottenere i dettagli del cocktail dalle API
        function fetchCocktailDetails(cocktailId) {
            return fetch(`https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=${cocktailId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Errore nella richiesta: ' + response.statusText);
                    }
                    return response.json();
                });
        }

        // Mostra i cocktail preferiti
        favorites.forEach(cocktailId => {
            fetchCocktailDetails(cocktailId).then(data => {
                const cocktail = data.drinks[0]; // Assumendo che ci sia sempre un drink
                const cocktailCard = document.createElement('div');
                cocktailCard.className = 'cocktail-card';
                cocktailCard.innerHTML = `
                    <h2>${cocktail.strDrink}</h2>
                    <img src="${cocktail.strDrinkThumb}" alt="${cocktail.strDrink}">
                    <p>${cocktail.strInstructions}</p>
                    <button onclick="removeFromFavorites(${cocktailId})">Rimuovi dai Preferiti</button>
                `;
                cocktailContainer.appendChild(cocktailCard);
            }).catch(error => {
                console.error('Errore nel recupero dei dettagli del cocktail:', error);
            });
        });

        // Funzione per rimuovere dai preferiti
        function removeFromFavorites(cocktailId) {
            let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
            favorites = favorites.filter(id => id !== cocktailId);
            localStorage.setItem('favorites', JSON.stringify(favorites));
            location.reload(); // Ricarica la pagina per aggiornare la lista
        }
    </script>
</body>
</html>