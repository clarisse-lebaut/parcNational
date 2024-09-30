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
        <h1>Enregistrer un nouveau camping</h1>
        <section>
            <form action="">
                <label for="">Nom du camping</label>
                <input type="text">
                <label for="">Description</label>
                <input type="text">
                <label for="">Adresse</label>
                <input type="text">
                <label for="">Ville</label>
                <input type="text">
                <label for="">Code Postal</label>
                <input type="number">
                <label for="">Image</label>
                <input type="file" accept="image/png, image/jpeg">
                <label for="">Etat</label>
                <select name="" id="">
                    <option value="">Etat</option>
                    <option value="">Ouvert</option>
                    <option value="">Fermé</option>
                </select>
            </form>
        </section>        
    </main>
</body>
</html>