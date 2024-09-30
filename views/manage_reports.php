<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Sentiers</title>
    <link rel="stylesheet" href="assets/style/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <main>
        <section class="data">
            <div>
                <p>Total de rapports enregistrer</p>
                <img src="assets/icon/file-blank.svg" alt="icon files">
                <div><?php echo htmlspecialchars($total_reports); ?></div>
            </div>

            <div>
                <p>Dernier rapports ajouter</p>
                <img src="assets/icon/file-fill.svg" alt="icon fill file">
                <div><?php echo htmlspecialchars($name_report); ?></div>
            </div>

            <div>
                <a href="add">Ajouter un rapports</a>
                <img src="assets/icon/add.svg" alt="icon visitors">
            </div>    
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Description</td>
                        <td>Éditer</td>
                        <td>Supprimer</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report['name']); ?></td>
                            <td><?php echo htmlspecialchars($report['description']); ?></td>
                            <td><button><img src="assets/icon/edit.svg" alt="icon edit"></button></td>
                            <td><button><img src="assets/icon/delete.svg" alt="icon delete"></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        
    </main>
</body>
</html>