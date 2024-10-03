<link rel="stylesheet" href="assets/style/_global.css">
<link rel="stylesheet" href="assets/style/_footer.css">

<nav class="nav-footer">
    <section class="first-section-footer">
        <div>
            <li>Parc National des Calanques</li>
        </div>
        <div class="icon-container-footer">
            <img src="assets/icon/facebook.svg" alt="Icon Facebook">
            <img src="assets/icon/instagram.svg" alt="Icon Instagram">
            <img src="assets/icon/whatsapp.svg" alt="Icon Whatsapp">
            <img src="assets/icon/tiktok.svg" alt="Icon TikTok">
            <img src="assets/icon/linkedin.svg" alt="Icon Linkedin">
        </div>
    </section>

    <section class="second-section-footer">
        <div>
            <ul class="ul-footer">
                <li>Navigation</li>
                <br>
                <li><a href="home">Accueil</a></li>
                <li><a href="ressource.php">Les ressources naturelles</a></li>
                <li><a href="trails">Les Sentiers</a></li>
                <li><a href="campsite.php">Les campings</a></li>
                <?php if (!isset($_SESSION['user'])): ?>
                    <li><a href="log">Connexion</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="profile">Profil</a></li>
                    <li><a href="deconnection">Se déconnecter</a></li>
                <?php endif; ?>
            </ul>
            <ul class="ul-footer">
                <li>Coordonnées</li>
                <br>
                <li><a href="#">Adresse</a></li>
                <li><a href="#">Tel</a></li>
                <li><a href="#">Siège</a></li>
            </ul>
            <ul class="ul-footer">
                <li>A propos</li>
                <br>
                <li><a href="about">Qui sommes-nous ?</a></li>
                <li><a href="about">Protections des données</a></li>
                <li><a href="about">Règles et conditions</a></li>
            </ul>
        </div>
        <div class="logo-container-footer">
            <img src="assets/icon/logo-site.svg" alt="Logo du Parc Nationnal des Calanques">
        </div>
    </section>

    <section class="thrid-section-footer">
        <p>Copyright</p>  
    </section>
</nav>