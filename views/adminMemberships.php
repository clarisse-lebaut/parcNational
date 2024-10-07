<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/modify-admin.css">
</head>
<body>
<h1>Gérer les Abonnements</h1>

<a class="lien-ajout" href="admin-memberships-add">
    Ajouter un Nouvel Abonnement
    <img src="assets/icon/add.svg" alt="icon add">
</a>
    <section class="board">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>ID</th>
                <th>Durée (Mois)</th>
                <th>Prix (€)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($memberships as $membership): ?>
                <tr>
                    <td><?= $membership['memberships_name'] ?></td>
                    <td><?= $membership['card_id'] ?></td>
                    <td><?= $membership['duration'] ?></td>
                    <td><?= $membership['price'] ?></td>
                    <td>
                        <a href="admin-memberships-edit?id=<?= $membership['card_id'] ?>">
                            <button>
                                <img src="assets/icon/edit.svg" alt="icon edit"> 
                            </button>
                        </a>
                        <a href="admin-memberships-delete?id=<?= $membership['card_id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet adhésion?')">
                            <button>
                                <img src="assets/icon/delete.svg" alt="icon delete">
                            </button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>    

</body>
</html>


