<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Home</title>
    <link rel="stylesheet" href="assets/style/config/_global-admin.css">
    <link rel="stylesheet" href="assets/style/config/_header-admin.css">
    <link rel="stylesheet" href="assets/style/admin/admin_home.css">
</head>

<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <main>
        <section class="data-person">
            <a href="manage_admin">
                <div>
                    <p>Gérer les adminstrateurs</p>
                    <img src="assets/icon/admin.svg" alt="icon admin">
                    <div><?php echo htmlspecialchars($total_admin); ?></div>
                </div>
            </a>
            

            <a href="manage_users">
                <div>
                    <p>Gérer les utilisateurs</p>
                    <img src="assets/icon/users.svg" alt="icon user">
                    <div><?php echo htmlspecialchars($total_users); ?></div>
                </div>
            </a>
            

            <a href="manage_admin">
                <div>
                    <p>Gérer les visiteurs</p>
                    <img src="assets/icon/visitor.svg" alt="icon visitors">
                    <div>??</div>
                </div>
            </a> 
        </section>

        <section class="data-subject">
            <section class="data-page">
                <a href="manage_trails">
                    <div>
                        <p>Gérer les sentiers</p>
                        <img src="assets/icon/hiking.svg" alt="icon trails">
                        <div><?php echo htmlspecialchars($total_trails); ?></div>
                    </div>
                </a>
   
                <a href="manage_campsite">
                    <div>
                        <p>Gérer les campings</p>
                        <img src="assets/icon/campsite.svg" alt="icon campsite">
                        <div><?php echo htmlspecialchars($total_campsites); ?></div>
                    </div>
                </a>

                <a href="manage_ressources">
                    <div>
                        <p>Gérer les ressources</p>
                        <img src="assets/icon/ressources.svg" alt="icon ressources">
                        <div><?php echo htmlspecialchars($total_ressources); ?></div>
                    </div>
                </a>

                <a href="manage_reports">
                    <div>
                        <p>Gérer les rapports</p>
                        <img src="assets/icon/rapport.svg" alt="icon rapport">
                        <div><?php echo htmlspecialchars($total_rapports); ?></div>
                    </div>
                </a>

                <a href="manage_ship">
                    <div>
                        <p>Gérer les abonnements</p>
                        <img src="assets/icon/card_membership.svg" alt="icon rapport">
                        <div>informations</div>
                        <!-- <div><?php echo htmlspecialchars($total_shiphs); ?></div> -->
                    </div>
                </a>

                <a href="manage_article">
                    <div>
                        <p>Gérer les articles</p>
                        <img src="assets/icon/news.svg" alt="icon news">
                        <div>informations</div>
                        <!-- <div><?php echo htmlspecialchars($total_news); ?></div> -->
                    </div>
                </a>
            </section>    
        </section>
    </main>
    
</body>
</html>
