<?php
header("Access-Control-Allow-Origin: *");  // Permetti tutte le origini
header("Content-Type: application/json");  // Imposta il tipo di contenuto a JSON
header("Access-Control-Allow-Methods: GET, POST");

// API base URL
$baseUrl = "https://www.thecocktaildb.com/api/json/v1/1/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchType = $_POST['searchType'] ?? '';
    $searchValue = $_POST['searchValue'] ?? '';
    
    switch($searchType) {
        case 'name':
            // Ricerca per nome
            $apiUrl = $baseUrl . "search.php?s=" . urlencode($searchValue);
            break;
            
        case 'ingredient':
            $url = "https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=" . urlencode($searchValue);
            break;
            
        case 'category':
            // Ricerca per categoria (utilizzeremo filter.php)
            $apiUrl = $baseUrl . "filter.php?c=" . urlencode($searchValue);
            break;
            
        case 'random':
            // Cocktail random
            $apiUrl = $baseUrl . "random.php";
            break;

        case 'id':
            // Ricerca per ID
            $apiUrl = $baseUrl . "lookup.php?i=" . urlencode($searchValue);
            break;
            
        case 'letter':
            // Ricerca per lettera
            $apiUrl = $baseUrl . "search.php?f=" . urlencode($searchValue);
            break;
            
        default:
            echo json_encode(['error' => 'Tipo di ricerca non valido']);
            exit;
    }
    
    if (isset($url)) {
        $response = file_get_contents($url);
        if ($response === false) {
            echo json_encode(['error' => 'Errore nella richiesta API']);
        } else {
            echo $response;
        }
    } else {
        echo json_encode(['error' => 'Tipo di ricerca non valido']);
    }
} else {
    echo json_encode(['error' => 'Metodo non valido']);
}
?>
