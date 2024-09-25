<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style/filter_ressources.css">
    <script src="../assets/script/filter_ressources.js" defer></script>
</head>
<body>
    <header></header>
    <main>
        <section>
            <h2>Filtre des ressources</h2>
            <hr>
            <div class="filter">
                <p>Filtres : </p>
                <button class="tag" name="tag" value="ressource-marine">Ressources Marines</button>
                <button class="tag" name="tag" value="ressource-terrestre">Ressources Terrestres</button>
                <button class="tag" name="tag" value="faunes">Faunes</button>
                <button class="tag" name="tag" value="flore">Flore</button>
                <button class="tag" name="tag" value="flore-marine">Flore Marine</button>
                <button class="tag" name="tag" value="flore-terrestre">Flore Terrestre</button>
                <button class="tag" name="tag" value="faune-marine">Faune Marine</button>
                <button class="tag" name="tag" value="faune-terrestre">FauneTerrestre</button>
            </div>
            <p>Filtre actif :</p>
            <div id="active-filter" class="active-filter"></div>
        </section>
    </main>
    <footer></footer>
</body>
</html>