<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        .text{
            display: block;
            width: 60%;
            text-align: center;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid black;
            background: linear-gradient(to right, #ADD8E6, #E6E6FA);
            font-family: 'Poppins', sans-serif; /* Użycie czcionki Poppins */
            line-height: 1.6; /* Ustawienie odstępu między liniami */
            color: #2F4F4F;
            }
        h1{
            text-align: center;
            margin-top: 40px;
        }    
        .main-container{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
        }
        .hexagon-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 80%;
        }

        /* Outer hexagon that creates the border effect */
        .hexagon-border {
            width: 220px;
            height: 127px;
            position: relative;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }

        /* Inner hexagon (the actual hexagon with content) */
        .hexagon {
            width: 207px;
            height: 115px;
            margin-top: 6px;
            margin-left: 7px;
            background-color: #333;
            clip-path: inherit;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* Different colored borders for each hexagon */
        .hexagon-border.border-blue {
            background-color: #2196F3; /* Blue border */
        }

        .hexagon-border.border-green {
            background-color: #4CAF50; /* Green border */
        }

        .hexagon-border.border-orange {
            background-color: #FF9800; /* Orange border */
        }

        /* Text inside the hexagons */
        .hexagon a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            line-height: 1.5;
        }

        .hexagon a:hover {
            text-decoration: underline;
        }

        .hexagon p {
            margin: 0;
            color: white;
            font-size: 12px;
        }

    </style>
</head>
<body>
    <?php if (isset($message)): ?>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <h1>Carte d'adhésion</h1>
    <p class="text"><strong>
        Carte d'adhésion du Parc National des Calanques : Profitez de la nature tout en économisant !</strong><br><br>
        Le Parc National des Calanques, célèbre pour ses paysages époustouflants et ses richesses naturelles,
        vous propose une carte d'adhésion unique avec abonnement. En tant que membre, vous bénéficiez d'avantages
        exclusifs, dont une réduction de 20 % sur une variété d'activités passionnantes.<br>
        Que vous soyez amateur d'aventure ou à la recherche de détente,
        l'adhésion vous ouvre les portes à des offres exceptionnelles, telles que :<br>
        <strong>Via Ferrata :</strong> Pour ceux qui aiment l'escalade et les sensations fortes, explorez les magnifiques falaises des Calanques en toute sécurité.<br>
        <strong>Location de kayaks : </strong> Naviguez à travers les eaux cristallines et découvrez des criques isolées et des plages secrètes.<br>
        <strong>Croisières autour des Calanques :</strong> Embarquez pour une aventure maritime inoubliable autour des plus beaux paysages côtiers de la région.<br><br>
        <strong>Choisissez parmi nos abonnements adaptés à tous les besoins :</strong><br><br>
        Abo 3 mois : Pour une découverte courte mais intense du parc.<br>
        Abo 6 mois : Idéal pour ceux qui souhaitent explorer les Calanques tout au long de l'année.<br>
        Abo 12 mois : L'option parfaite pour les passionnés de nature qui désirent profiter des avantages pendant toute une année.<br><br>
        Rejoignez la communauté des amoureux des Calanques et vivez des expériences mémorables tout en bénéficiant de réductions attractives sur les activités qui font la renommée de ce lieu magique !
    </p>
<div class="main-container">
    <div class="hexagon-container">
        <div class="hexagon-border border-blue">
            <div class="hexagon">
                <a href="/parcNational/subscribe-3-months">
                    Abo 3 mois
                    <p>Classic</p>
                </a>
            </div>
        </div>

        <div class="hexagon-border border-orange">
            <div class="hexagon">
                <a href="/parcNational/subscribe-6-months">
                    Abo 6 mois
                    <p>Adventure</p>
                </a>
            </div>
        </div>

        <div class="hexagon-border border-green">
            <div class="hexagon">
                <a href="/parcNational/subscribe-12-months">
                    Abo 12 mois
                    <p>Trial</p>
                </a>
            </div>
        </div>
    </div>
    </div>    


</body>
</html>