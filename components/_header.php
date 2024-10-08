<!-- <?php
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?> -->

<link rel="stylesheet" href="assets/style/_header.css">
<link rel="stylesheet" href="assets/style/_global.css">

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
        <li><a href="view-available-memberships">Les Abonnements</a></li>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a href="login">Connexion</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="profile">Profil</a></li>
            <li><a href="logout">Se déconnecter</a></li>
            <?php if ($_SESSION['user_role'] == 2): // Vérifie si l'utilisateur a le rôle d'administrateur ?>
                <li><a href="admin_home">Admin</a></li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>