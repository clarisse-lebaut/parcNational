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
            <p>Adresse mail de l'admin :</p>
            <button>Modifier</button>
        </section>
        <section class="data-admin">
            <p>Mot de passe : *****</p>
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
                    <div>Nombre</div>
                </a>
            </div>
            <div>
                <a href="manage_users">
                    <p>Gérer les utilisateurs</p>
                    <img src="assets/icon/users.svg" alt="icon user">
                    <div>Nombre</div>
                </a>
            </div>
            <div>
                <a href="manage_visitor">
                    <p>Gérer les visiteurs</p>
                    <img src="assets/icon/visitor.svg" alt="icon visitors">
                    <div>Nombre</div>
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
                            <div>information</div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="manage_campsite">
                        <p>Gérer les campings</p>
                        <div>
                            <img src="assets/icon/campsite.svg" alt="icon campsite">
                            <div>information</div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="manage_ressources">
                        <p>Gérer les ressources</p>
                        <div>
                            <img src="assets/icon/ressources.svg" alt="icon ressources">
                            <div>information</div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="manage_rapports">
                        <p>Gérer les rapport</p>
                        <div>
                            <img src="assets/icon/rapport.svg" alt="icon rapport">
                            <div>information</div>
                        </div>
                    </a>
                </div>
            </section>
            <section class="ship">
                <a href="manage_ship">
                    <div>
                        <p>Gérer les abonnements</p>
                        <div class="all_ship">information</div>
                    </div>
                </a>
            </section>
        </section>
    </main>
    
</body>
</html>
