<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <main>
        <h1>Crée un nouveau rapport</h1>
        <section>
            <form action="">
                <label for="">Nom du rapport</label>
                <input type="text">
                <label for="">Description</label>
                <input type="text">
                <label for="">Ressources en alerte</label>
                <select name="" id="">
                    <option value="">Chosir une ressources</option>
                    <?php 
                    // faire une boucle pour récupérer toutes les ressources
                    ?>
                </select>
            </form>
        </section>        
    </main>
</body>
</html>