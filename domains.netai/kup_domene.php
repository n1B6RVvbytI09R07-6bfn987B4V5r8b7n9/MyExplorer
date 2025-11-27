<?php
// UWAGA: Ten plik jest plikiem PHP w repozytorium, ale nie jest uruchamiany bezpośrednio.
// Jego zawartość jest symulowana przez Pythona, który faktycznie wykonuje operacje na plikach.
// Jest to miejsce, gdzie w prawdziwej architekturze serwerowej byłaby umieszczona ta logika.

// --- PRAWIDŁOWA LOGIKA PHP ---

header('Content-Type: application/json');

// Pobranie nazwy domeny z parametrów GET
$domena = isset($_GET['domena']) ? $_GET['domena'] : '';

if (empty($domena)) {
    echo json_encode(['status' => 'error', 'message' => 'Brak nazwy domeny.']);
    exit;
}

// Lokalna ścieżka do repozytorium (w normalnym PHP byłaby to ścieżka serwera)
$root_dir = '/sciezka/do/twojego/MyExplorer'; 
$target_dir = $root_dir . '/' . $domena;

try {
    // 1. Sprawdzenie i utworzenie folderu
    if (file_exists($target_dir)) {
        throw new Exception("Katalog już istnieje: {$domena}.");
    }

    if (!mkdir($target_dir, 0777, true)) {
        throw new Exception("Błąd tworzenia katalogu. Sprawdź uprawnienia.");
    }

    // 2. Utworzenie pliku index.html
    $index_content = "<!-- Tu byłby kod strony startowej domeny... -->";
    
    if (!file_put_contents($target_dir . '/index.html', $index_content)) {
        throw new Exception("Błąd zapisu pliku index.html.");
    }
    
    // 3. Sukces
    echo json_encode(['status' => 'success', 'domena' => $domena, 'message' => 'Domena utworzona pomyślnie.']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Po tym etapie, w prawdziwym PHP, następowałaby komunikacja z GitHub API,
// aby zatwierdzić i wypchnąć zmiany zdalnie, co jest niemożliwe bez tokena i serwera.
?>
