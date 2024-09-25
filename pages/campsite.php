<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style/filter_campsites.css">
    <script src="../assets/script/filter_campsites.js" defer></script>
</head>
<body>
    <header></header>
    <main>
        <section>
            <h2>Filtre des ressources</h2>
            <hr>
            <div class="filter">
                <p>Filtres : </p>
                <div class="dropdown">
                    <button class="dropdown-btn"><div>Prix</div><img src="../assets/icon/arrow-drop-down.svg" alt="icon arrow for dropdown"></button>
                    <div class="dropdown-content">
                        <label for="tag"><input type="checkbox" class="tag" name="tag" value="asc">du - cher au + cher</label>
                        <label for="tag"><input type="checkbox" class="tag" name="tag" value="desc">du + cher au - cher</label>
                    </div>
                </div>
                <div class="switch-container">
                    <label>
                        <input class="checkbox" type="checkbox" id="switch" name="switch">
                        <span class="btn-switch"></span>
                    </label>
                </div>
            </div>
        </section>
    </main>
    <footer></footer>
</body>
</html>