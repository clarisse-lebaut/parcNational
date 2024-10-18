<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Adminstrateurs</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <main>
        <section class="data">
            <div>
                <p>Nombre total d'administrateur</p>
                <img src="assets/icon/admin.svg" alt="icon admin">
                <div><?php echo htmlspecialchars($total_admin); ?></div>
            </div>

            <div>
                <a href="create_admin"><p>Ajouter un administrateur</p></a>
                <a href="create_admin"><img src="assets/icon/add.svg" alt="icon add"></a>
            </div> 
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Prénom</td>
                        <td>E-mail</td>
                        <td>Téléphone</td>
                        <td>Adresse</td>
                        <td>Ville</td>
                        <td>Code Postal</td>
                        <td>Editer</td>
                        <td>Supprimer</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin as $admins): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admins['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($admins['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($admins['mail']); ?></td>
                            <td><?php echo htmlspecialchars($admins['phone']); ?></td>
                            <td><?php echo htmlspecialchars($admins['address']); ?></td>
                            <td><?php echo htmlspecialchars($admins['city']); ?></td>
                            <td><?php echo htmlspecialchars($admins['zipcode']); ?></td>
                            <td>
                                <form method="GET" action="create_admin">
                                    <input type="hidden" name="user_id" value="<?php echo $admins['user_id']; ?>">    
                                    <button class="edit-button" type="submit"><img src="assets/icon/edit.svg" alt="icon edit"></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="manage_admin" onsubmit="return confirm('Êtes-vous sûr de vouloir modifier cet administrateur ?');">
                                    <input type="hidden" name="user_id" value="<?php echo $admins['user_id']; ?>">    
                                    <button class="del-button"><img src="assets/icon/delete.svg" alt="icon delete"></button>
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