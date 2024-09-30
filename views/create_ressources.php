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
        <h1>Enregistrer une nouvelle ressources naturelle</h1>
        <section>
            <form action="">
                <label for="">Nom de la ressources</label>
                <input type="text">
                <label for="">Localisation</label>
                <input type="text">
                <label for="">Description</label>
                <input type="text">
                <label for="">Type</label>
                <select name="" id="">
                    <option value="">Choisir un type</option>
                    <option value="">Flore Marine</option>
                    <option value="">Flore Terrestre</option>
                    <option value="">Faune Marine</option>
                    <option value="">Faune Terrestre</option>
                </select>
                <label for="">Danger d'extinction</label>
                <select name="" id="">
                    <option value="">Level</option>
                    <option value="">Bas</option>
                    <option value="">Moyen</option>
                    <option value="">Haut</option>
                    <option value="">Très haut</option>
                </select>
                <label for="">Précautions</label>
                <input type="text">
                <label for="">Image</label>
                <input type="file" accept="image/png, image/jpeg">
            </form>
        </section>        
    </main>
</body>
</html>
