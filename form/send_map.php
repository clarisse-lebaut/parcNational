<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ConnectBDD
{
    public function connectBDD()
    {
        try {
            $connectBDD = new PDO("mysql:host=localhost;dbname=my_map;charset=utf8", "root", "");
            $connectBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion réussie à la base de données !<br>";
            return $connectBDD;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}

// Fonction pour importer le CSV
function importCsvToDatabase($fileTmpName, $pdo) {
    if (($handle = fopen($fileTmpName, "r")) !== FALSE) {
        echo "Fichier ouvert avec succès<br>";
        $firstRow = true; // Pour ignorer l'en-tête du CSV
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($firstRow) {
                $firstRow = false;
                continue; // Ignorer la première ligne (en-têtes)
            }

            // Debugging
            echo "Ligne CSV : ";
            var_dump($data);

            // Extraire les données
            $type = $data[1];
            $part_number = intval($data[2]);
            $coordinate_number = intval($data[3]);
            $mystery_number = intval($data[4]);
            $longitude = floatval($data[5]);
            $latitude = floatval($data[6]);

            // Préparer la requête SQL
            $sql = "INSERT INTO map (type, part_number, coordinate_number, mystery_number, longitude, latitude)
                    VALUES (:type, :part_number, :coordinate_number, :mystery_number, :longitude, :latitude)";
            
            $stmt = $pdo->prepare($sql);

            // Exécuter la requête
            if ($stmt->execute([
                ':type' => $type,
                ':part_number' => $part_number,
                ':coordinate_number' => $coordinate_number,
                ':mystery_number' => $mystery_number,
                ':longitude' => $longitude,
                ':latitude' => $latitude
            ])) {
                echo "Insertion réussie<br>";
            } else {
                echo "Erreur lors de l'insertion<br>";
                print_r($stmt->errorInfo()); // Affiche les erreurs SQL
            }
        }
        fclose($handle);
        echo "Fichier CSV traité avec succès<br>";
    } else {
        echo "Erreur lors de l'ouverture du fichier.<br>";
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv-file'])) {
    echo "Fichier reçu<br>";

    $file = $_FILES['csv-file'];
    var_dump($file); // Affiche les détails du fichier

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Erreur lors du téléchargement du fichier.");
    }

    // Vérifier l'extension du fichier
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($fileExtension !== 'csv') {
        die("Le fichier téléchargé n'est pas un CSV.");
    }

    // Vérifier le type MIME du fichier avec finfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    echo "Type MIME détecté : " . $fileType . "<br>";

    // Types MIME communs pour les fichiers CSV
    $validMimeTypes = [
        'text/csv',
        'application/csv',
        'application/vnd.ms-excel',
        'text/plain'
    ];

    if (!in_array($fileType, $validMimeTypes)) {
        die("Le fichier téléchargé n'est pas un CSV.");
    }
    // Connexion à la base de données
    $database = new ConnectBDD();
    $pdo = $database->connectBDD();

    // Importer le fichier CSV dans la base de données
    importCsvToDatabase($file['tmp_name'], $pdo);

    echo "Importation terminée avec succès !";
} else {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer CSV</title>
</head>
<body>
    <h1>Importer CSV map dans BDD</h1>

    <form action="send_map.php" method="post" enctype="multipart/form-data">
        <label for="csv-file">Choisissez un fichier CSV :</label>
        <input type="file" id="csv-file" name="csv-file" accept=".csv" required>
        <button type="submit">Importer</button>
    </form>
</body>
</html>
<?php
}
?>
