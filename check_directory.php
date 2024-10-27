<?php
// Ustaw ścieżkę do katalogu
$directory = 'c:/wamp64/tmp';

// Sprawdź, czy katalog istnieje
if (is_dir($directory)) {
    echo "Katalog istnieje.<br>";

    // Spróbuj utworzyć plik w tym katalogu
    $testFile = $directory . '/test_file.txt';

    // Zapisz coś do pliku
    if (file_put_contents($testFile, "Test zapisu w katalogu.")) {
        echo "Plik został pomyślnie zapisany w katalogu: $testFile<br>";
    } else {
        echo "Nie udało się zapisać pliku w katalogu.<br>";
    }

    // Sprawdź, czy plik został utworzony
    if (file_exists($testFile)) {
        echo "Plik test_file.txt został utworzony pomyślnie.";
        // Usuń plik testowy
        unlink($testFile);
    } else {
        echo "Plik test_file.txt nie został utworzony.";
    }
} else {
    echo "Katalog nie istnieje.";
}
?>
