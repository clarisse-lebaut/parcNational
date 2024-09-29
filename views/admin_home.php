<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Home</title>
    <link rel="stylesheet" href="asset.style/_global.css">
    <link rel="stylesheet" href="assets/style/admin_home.css">
</head>

<body>
    <header>
        <nav class="nav-admin">
            <div class="name-admin">
                <img src="#" alt="avatar admin">
                <p>Bonjour, nomdel'admin !</p>
            </div>
            <div class="icon-admin">
                <a href="admin_home"><img src="assets/icon/home.svg" alt="icon home"></a>
                <a href="home"><img src="assets/icon/off.svg" alt="icon off"></a>
            </div>    
        </nav>
        <section class="data-admin">
            <p>Adresse mail de l'admin : récupérer l'adresse mail</p>
            <button>Modifier</button>
        </section>
        <section class="data-admin">
            <p>Mot de passe : *********</p>
            <button>Modifier</button>
        </section>
    </header>
    <main>
        <section>
        <section class="data-person">
            <div>
                <a href="manage_admin">
                    <p>Gérer les adminstrateurs</p>
                    <img src="assets/icon/admin.svg" alt="icon admin">
                    <div><?php echo htmlspecialchars($total_users); ?></div>
                </a>
            </div>
            <div>
                <!-- <a href="manage_users"> -->
                    <p>Gérer les utilisateurs</p>
                    <img src="assets/icon/users.svg" alt="icon user">
                    <div><?php echo htmlspecialchars($total_users); ?></div>
                <!-- </a> -->
            </div>
            <div>
                <a href="manage_visitor">
                    <p>Gérer les visiteurs</p>
                    <img src="assets/icon/visitor.svg" alt="icon visitors">
                    <div>??</div>
                </a>
            </div>
        </section>

        <section class="data-subject">
            <section class="data-page">
                <div>
                    <a href="manage_trails">
                        <p>Gérer les sentiers</p>
                        <div>
                            <img src="assets/icon/hiking.svg" alt="icon trails">
                            <div><?php echo htmlspecialchars($total_trails); ?></div>
                            <div>
                                <?php if (!empty($last_trails)): ?>
                                    <ul>
                                        <?php foreach ($last_trails as $trail): ?>
                                            <li><?php echo htmlspecialchars($trail['name']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>Aucun sentier trouvé.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="manage_campsite">
                        <p>Gérer les campings</p>
                        <div>
                            <img src="assets/icon/campsite.svg" alt="icon campsite">
                            <div><?php echo htmlspecialchars($total_campsites); ?></div>
                            <div>
                                <?php if (!empty($last_campsites)): ?>
                                    <ul>
                                        <?php foreach ($last_campsites as $campsites): ?>
                                            <li><?php echo htmlspecialchars($campsites['name']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>Aucun camping trouvé.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="manage_ressources">
                        <p>Gérer les ressources</p>
                        <div>
                            <img src="assets/icon/ressources.svg" alt="icon ressources">
                            <div><?php echo htmlspecialchars($total_ressources); ?></div>
                            <div>
                                <?php if (!empty($last_ressources)): ?>
                                    <ul>
                                        <?php foreach ($last_ressources as $ressources): ?>
                                            <li><?php echo htmlspecialchars($ressources['name']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>Aucune ressources trouvé.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="manage_rapports">
                        <p>Gérer les rapport</p>
                        <div>
                            <img src="assets/icon/rapport.svg" alt="icon rapport">
                            <div><?php echo htmlspecialchars($total_rapports); ?></div>
                            <div>
                                <?php if (!empty($last_rapports)): ?>
                                    <ul>
                                        <?php foreach ($last_rapports as $rapports): ?>
                                            <li><?php echo htmlspecialchars($rapports['name']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>Aucun rapports trouvé.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            </section>
            <section class="ship">
                <a href="manage_ship">
                    <div>
                        <p>Gérer les abonnements</p>
                        <div class="all_ship">informations</div>
                    </div>
                </a>
            </section>
        </section>
    </main>
    
</body>
</html>
