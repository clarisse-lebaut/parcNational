<link rel="stylesheet" href="../assets/styles/_header.css">

<nav class="nav-header">
    <ul class="ul-header">
        <li><a href="home">Accueil</a></li>
        <li><a href="coves">Les calanques</a></li>
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
        <li><a href="about">A propos</a></li>
        <li><a href="admin_home">Admin</a></li>
    </ul>
</nav>