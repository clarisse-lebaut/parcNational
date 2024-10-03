
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Membership</title>
    <style>
        .subscription{
            width: 40%;
            height: 33%;
            border: 2px solid black;
            background: linear-gradient(to right, #ADD8E6, #E6E6FA);
        }
        h3,p{
            margin: 10px;
            font-family: 'Poppins', sans-serif; 
            line-height: 1.6; 
            color: #2F4F4F;

        }
    </style>    
</head>
<body>
    <h2>Votre abonnement:</h2>
    <?php if (isset($membership)): ?>
        <div class="subscription">
            <h3>Votre adhésion active:</h3>
            <p> Mdme/M : &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            <?php
                 echo !empty($membership['lastname']) ? htmlspecialchars($membership['lastname']) : 'N/A';
            ?></p>       
            <p>Identificateur: &nbsp &nbsp &nbsp &nbsp
            <?php
                echo htmlspecialchars($membership['random_id']); 
            ?></p>
            <p>Date de début: &nbsp &nbsp &nbsp
            <?php 
                $deliveryDate = new DateTime($membership['delivery_date']);
                echo htmlspecialchars($deliveryDate->format('Y-m-d H:i')); 
            ?>
            </p>
            <p>Date d'expiration: &nbsp
            <?php 
                $expiryDate = new DateTime($membership['expiry_date']);
                echo htmlspecialchars($expiryDate->format('Y-m-d H:i'));
            ?>
            </p>
        </div>
    <?php else: ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

</body>
</html>