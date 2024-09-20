<?php
// Affichage des erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Classe pour se connecter à la base de données
class ConnectBDD
{
    public function connectBDD()
    {
        try {
            $connectBDD = new PDO("mysql:host=localhost;dbname=my_map;charset=utf8", "root", "");
            $connectBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connectBDD;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}

// Fonction pour importer le CSV
function importCsvToDatabase($fileTmpName, $pdo, $trail_id) {
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

            // Extraire les données du CSV
            $type = $data[1];
            $part_number = intval($data[2]);
            $coordinate_number = intval($data[3]);
            $longitude = floatval($data[4]);
            $latitude = floatval($data[5]);

            // Préparer la requête SQL pour insérer les données dans la table position_geographique
            $sql = "INSERT INTO position_geographique (trail_id, type, part_number, coordinate_number, longitude, latitude)
                    VALUES (:trail_id, :type, :part_number, :coordinate_number, :longitude, :latitude)";
            
            $stmt = $pdo->prepare($sql);

            // Exécuter la requête
            if ($stmt->execute([
                ':trail_id' => $trail_id,
                ':type' => $type,
                ':part_number' => $part_number,
                ':coordinate_number' => $coordinate_number,
                ':longitude' => $longitude,
                ':latitude' => $latitude
            ])) {
                echo "Insertion réussie pour ce point<br>";
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

// Traitement du formulaire (quand l'utilisateur soumet un fichier)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv-file'])) {
    echo "Fichier reçu<br>";

    // Récupérer l'ID du sentier sélectionné
    if (!isset($_POST['trail_id']) || empty($_POST['trail_id'])) {
        die("Veuillez sélectionner un sentier.");
    }

    $trail_id = intval($_POST['trail_id']); // ID du sentier sélectionné
    echo "Sentier sélectionné : $trail_id<br>";

    $file = $_FILES['csv-file'];
    var_dump($file); // Affiche les détails du fichier pour le debug

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
    $validMimeTypes = ['text/csv', 'application/csv', 'application/vnd.ms-excel', 'text/plain'];

    if (!in_array($fileType, $validMimeTypes)) {
        die("Le fichier téléchargé n'est pas un CSV.");
    }

    // Connexion à la base de données
    $database = new ConnectBDD();
    $pdo = $database->connectBDD();

    // Importer le fichier CSV dans la base de données
    importCsvToDatabase($file['tmp_name'], $pdo, $trail_id);

    echo "Importation terminée avec succès !";
} else {
    // Connexion à la base de données pour récupérer les sentiers
    $database = new ConnectBDD();
    $pdo = $database->connectBDD();

    // Récupérer la liste des sentiers
    $sql = "SELECT trail_id, name FROM trail";
    $stmt = $pdo->query($sql);
    $trails = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer CSV</title>
</head>
<body>
    <h1>Importer un fichier CSV dans la base de données</h1>

    <form action="send_trail_all.php" method="post" enctype="multipart/form-data">
        <label for="trail">Choisissez un sentier :</label>
        <select id="trail" name="trail_id" required>
            <option value="">-- Sélectionner un sentier --</option>
            <?php foreach ($trails as $trail): ?>
                <option value="<?= $trail['trail_id'] ?>"><?= htmlspecialchars($trail['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="csv-file">Choisissez un fichier CSV :</label>
        <input type="file" id="csv-file" name="csv-file" accept=".csv" required>
        <br><br>

        <button type="submit">Importer</button>
    </form>
</body>
</html>
<?php
}
?>
