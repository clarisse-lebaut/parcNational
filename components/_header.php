<link rel="stylesheet" href="/parcNational/assets/style/_header.css">
<link rel="stylesheet" href="/parcNational/assets/style/_global.css">
<style>
    a{
        color :blue;
    }
</style>
<nav class="nav-header">
    <img class="logo-header" src="assets/img/logo-pncal.svg" alt="Logo du Parc Nationnal des Calanques">
    <ul class="ul-header">
        <li><a href="home">Accueil</a></li>
        <li><a href="coves">Les Calanques</a></li>
        <li><a href="ressources">Les Ressources naturelles</a></li>
        <li><a href="trails">Les Sentiers</a></li>
        <li><a href="campsite">Les Campings</a></li>
        <li><a href="map">La Carte</a></li>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a href="/parcNational/login">Connexion</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="profile">Profil</a></li>
            <li><a href="/parcNational/logout">Se déconnecter</a></li>
        <?php endif; ?>
        <li><a href="admin_home">Admin</a></li>
    </ul>
</nav>