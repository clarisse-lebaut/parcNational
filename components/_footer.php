<link rel="stylesheet" href="assets/style/_global.css">
<link rel="stylesheet" href="assets/style/_footer.css">

<nav class="nav-footer">
    <section class="first-section-footer">
        <div class="title-logo-container">
            <img class="logo-footer" src="assets/img/logo-pncal.jpg" alt="Logo du Parc Nationnal des Calanques">
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
                <li class="ul-title"><b>Navigation</b></li>
                <br>
                <li><a href="home">Accueil</a></li>
                <li><a href="ressources">Les Ressources naturelles</a></li>
                <li><a href="trails">Les Sentiers</a></li>
                <li><a href="campsite">Les Campings</a></li>
                <li><a href="map">La Carte</a></li>
                <?php if (!isset($_SESSION['user'])): ?>
                    <li><a href="log">Connexion</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="profile">Profil</a></li>
                    <li><a href="deconnection">Se déconnecter</a></li>
                <?php endif; ?>
            </ul>
            <ul class="ul-footer">
                <li class="ul-title"><b>Coordonnées</b></li>
                <br>
                <li><a href="#">13008 Marseille</a></li>
                <li><a href="#">141 avenue du Prado</a></li>
                <br>
                <li><a href="#">Tel : 04 20 10 50 00</a></li>
            </ul>
            <ul class="ul-footer">
                <li class="ul-title"><b>A propos</b></li>
                <br>
                <li><a href="about">Qui sommes-nous ?</a></li>
                <li><a href="about">Protections des données</a></li>
                <li><a href="about">Règles et conditions</a></li>
            </ul>
        </div>
        <div class="weather-container-footer">
            <p>Widget Météo</p>
        </div>
    </section>

    <section class="thrid-section-footer">
        <p>© Parc National des Calanques. 2024. Tous droits réservés.</p>  
    </section>
</nav>