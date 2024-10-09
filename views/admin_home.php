<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Home</title>
    <link rel="stylesheet" href="assets/stylec/config/_global-admin.css">
    <link rel="stylesheet" href="assets/style/config/_header-admin.css">
    <link rel="stylesheet" href="assets/style/admin/admin_home.css">
</head>

<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <main>
        <section class="data-person">
            <div>
                <a href="manage_admin">Gérer les adminstrateurs</a>
                <img src="assets/icon/admin.svg" alt="icon admin">
                <div><?php echo htmlspecialchars($total_admin); ?></div>
            </div>
            <div>
                <a href="manage_users">Gérer les utilisateurs</a>
                <img src="assets/icon/users.svg" alt="icon user">
                <div><?php echo htmlspecialchars($total_users); ?></div>
            </div>

            <div>
                <a href="manage_visitor">Gérer les visiteurs</a>
                <img src="assets/icon/visitor.svg" alt="icon visitors">
                <div>??</div>
            </div>    
        </section>

        <section class="data-subject">
            <section class="data-page">
                <div class="one">
                    <a href="manage_trails">Gérer les sentiers</a>
                    <img src="assets/icon/hiking.svg" alt="icon trails">
                    <div><?php echo htmlspecialchars($total_trails); ?></div>
                </div>
   
                <div class="two">
                    <a href="manage_campsite">Gérer les campings</a>
                    <img src="assets/icon/campsite.svg" alt="icon campsite">
                    <div><?php echo htmlspecialchars($total_campsites); ?></div>
                </div>

                <div class="three">
                    <a href="manage_ressources">Gérer les ressources</a>
                    <img src="assets/icon/ressources.svg" alt="icon ressources">
                    <div><?php echo htmlspecialchars($total_ressources); ?></div>
                </div>

                <div class="four">
                    <a href="manage_reports">Gérer les rapport</a>
                    <img src="assets/icon/rapport.svg" alt="icon rapport">
                    <div><?php echo htmlspecialchars($total_rapports); ?></div>
                </div>

                <div class="five">
                    <a href="manage_ship">Gérer les abonnements</a>
                    <div class="all_ship">informations</div>
                </div>
            </section>    
        </section>
    </main>
    
</body>
</html>
