<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Rapports</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    <main>
        <section class="data">
            <div>
                <p>Total de rapports enregistrés</p>
                <img src="assets/icon/file-blank.svg" alt="icon files">
                <div><?php echo htmlspecialchars($total_reports); ?></div>
            </div>

            <div>
                <p>Dernier rapport ajouté</p>
                <img src="assets/icon/file-fill.svg" alt="icon fill file">
                <div><?php echo htmlspecialchars($name_report); ?></div>
            </div>

            <div>
                <a href="create_reports">Ajouter un rapport</a>
                <img src="assets/icon/add.svg" alt="icon add report">
            </div>    
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Description</td>
                        <td>Ressource Associée</td> <!-- Nouvelle colonne pour la ressource associée -->
                        <td>Éditer</td>
                        <td>Supprimer</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report['name']); ?></td>
                            <td><?php echo htmlspecialchars($report['description']); ?></td>
                            <td>
                                <?php 
                                    // Vérifier et afficher la ressource associée
                                    if (isset($report['ressource_name']) && !empty($report['ressource_name'])) {
                                        echo htmlspecialchars($report['ressource_name']);
                                    } else {
                                        echo 'Aucune ressource associée';
                                    }
                                ?>
                            </td>
                            <td>
                                <form method="GET" action="create_reports">
                                    <input type="text" name="report_id" value="<?php echo htmlspecialchars($report['report_id']); ?>">    
                                    <button type="submit"><img src="assets/icon/edit.svg" alt="icon edit"></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="manage_reports" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?');">
                                    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($report['report_id']); ?>">    
                                    <button type="submit"><img src="assets/icon/delete.svg" alt="icon delete"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
