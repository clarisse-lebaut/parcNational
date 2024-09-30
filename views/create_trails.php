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
        <h1>Crée un nouveau sentier</h1>
        <section>
            <form action="">
                <label for="">Nom du sentier</label>
                <input type="text">
                <label for="">Information</label>
                <input type="text">
                <label for="">Accès</label>
                <input type="text">
                <label for="">Km</label>
                <input type="number">
                <label for="">Temps</label>
                <input type="datetime">
                <label for="">Difficulté</label>
                <select name="" id="">
                    <option value="">Chosir une ifficulté</option>
                    <option value="">Facile</option>
                    <option value="">Moyen</option>
                    <option value="">Difficile</option>
                </select>
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