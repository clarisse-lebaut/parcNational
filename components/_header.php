<link rel="stylesheet" href="assets/style/config/_header.css">
<link rel="stylesheet" href="assets/style/config/_global.css">

<nav class="nav-header">
    <img class="logo-header" src="assets/img/logo-pncal.svg" alt="Logo du Parc Nationnal des Calanques">
    <ul class="ul-header">
        <li><a href="home">Accueil</a></li>
        <li><a href="coves">Les Calanques</a></li>
        <li><a href="ressources">Les Ressources Naturelles</a></li>
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
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2): // Vérifie si l'utilisateur a le rôle d'administrateur ?>
                <li><a href="admin_home">Admin</a></li>
            <?php endif; ?>
        <?php else: ?>
        <li><a href="login"></a></li>
        <?php endif; ?>
    </ul>
</nav>

<nav class="nav-header-mobil">
    <!-- Bouton hamburger (pour les petits écrans) -->
    <div class="hamburger" onclick="toggleMenu()">&#9776;</div>
    
    <ul class="ul-header-mobil">
        <li><a href="home">Accueil</a></li>
        <li><a href="coves">Les Calanques</a></li>
        <li><a href="ressources">Les Ressources Naturelles</a></li>
        <li><a href="trails">Les Sentiers</a></li>
        <li><a href="campsite">Les Campings</a></li>
        <li><a href="map">La Carte</a></li>
        <li><a href="view-available-memberships">Les Abonnements</a></li>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a href="login">Connexion</a></li>
        <?php else: ?>
            <li><a href="profile">Profil</a></li>
            <li><a href="logout">Se déconnecter</a></li>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2): ?>
                <li><a href="admin_home">Admin</a></li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>


<script>
    function toggleMenu() {
        const menu = document.querySelector('.ul-header-mobil');
        menu.classList.toggle('show'); // Ajoute/retire la classe "show" pour afficher ou masquer le menu
    }
</script>
