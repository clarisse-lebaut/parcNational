<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Visites</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>

    <main>
        <section>

            <style>
                .graphic_data {
                    margin: auto;
                    width: 30%;
                    text-align: center;
                    display:flex;
                    flex-direction:column;
                    justify-content:center;
                    gap:25px;
                }

            </style>

            <section class="graphic_data">
                <canvas id="visitsChart"></canvas>
                <p>Graphiques de visites par pages</p>
            </section>
            
            <script>
                const ctx = document.getElementById('visitsChart').getContext('2d');
                const visitsData = {
                    labels: <?php echo json_encode(array_column($visites, 'page')); ?>,
                    datasets: [{
                        label: 'Nombre de Visites',
                        data: <?php echo json_encode(array_column($visites, 'compteur')); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                };

                const config = {
                    type: 'doughnut', // Type de graphique
                    data: visitsData,
                    //! pense à mettre des virugles entre chaques paramètres des options
                    options: {
                        plugins: {
                            legend: {
                                position: 'top' // Position de la légende à gauche
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                const visitsChart = new Chart(ctx, config);
            </script>

        </section>
    </main>

</body>
</html>
