<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calanques de Marseille</title>
    <link rel="stylesheet" href="assets/style/user/coves.css">
    <link rel="stylesheet" href="assets/style/_global.css">
</head>
<body>
    <main>
        <section>
            <div class="hero-page">
                <header><?php include "components/_header.php"; ?></header>    
                <hgroup class="text-overlay">
                    <h1 class="title-page">Les Calanques de Marseille</h1>
                    <p>
                        De majestueuses formations rocheuses bordées d'eaux cristallines de la Méditerranée 
                        vous offrent des panoramas à couper le souffle.
                        Que vous veniez pour une simple promenade ou une journée de découverte,
                        chaque calanque révèle des paysages époustouflants entre terre et mer.
                    </p>
                </hgroup>
            </div>
        </section>
       
        <nav class="coves-nav">
            <?php 
            // Initialiser un compteur pour les IDs
            $idCounter = 1;
            foreach ($calanques as $calanque): ?>
                <li class="cove-li">
                    <a href="#calanque-<?= $idCounter; ?>"><?= htmlspecialchars($calanque['name']); ?></a>
                </li>
                <?php $idCounter++; // Incrémenter le compteur ?>
            <?php endforeach; ?>
        </nav>

        <section>
            <h2 style="text-align:center;">Qu'est-ce qu'une Calanque ?</h2>
            <p>Le terme provençal « calanques » désigne des anses bordées de pentes abruptes. Il est la fusion de deux mots :</p>
            <section>
                <li>
                    <div><strong>Calo</strong></div>
                    <p>
                        Vieux mot provençal, il signifie « petite crique rocheuse ».<br>Il est lui-même issu d'une très ancienne racine méditerranéenne (kal) 
                        <br>qui désigne des criques aussi bien en Corse qu'aux Baléares.<br>Cette racine remonte à l'époque ligure et a servi 
                        en Provence à caractériser de nombreux lieux rocheux : <br>de là proviennent les mots calade (route empierrée) et
                        <br>
                        caler (immobiliser, à l'origine à l'aide d'une pierre).
                    </p>
                </li>
                <li>
                    <div><strong>Anca</strong></div>
                    <p>
                        Ce suffixe, également d'origine ligure, indique une pente rapide :<br>on le retrouve notamment dans le mot alpin avalanche.
                    </p>
                </li>
            </section>
        </section>

        <section>
            <h2 style="text-align:center;">Comment se sont formées les Calanques ?</h2>
            <p style="margin: 0px 150px 25px 150px;">
                Les roches calcaires du Parc national sont à l’origine faites de sédiments. 
                C’était il y a 80 millions d’années, durant le Mésozoïque, 
                plus précisément au Jurassique et au Crétacé <i>(au temps des dinosaures !)</i>. Des 
                fragments de squelettes et de coquilles de micro-organismes marins subissent 
                alors des transformations chimiques. 
                Ces minéraux fins d'origine corallienne sont charriés par un fleuve qui coulait du sud au nord,
                et s’accumulent patiemment sur plusieurs centaines de mètres au fond d’une mer tropicale…
            </p>
            <section>
                <li>
                    <div><strong>Tectonique des plaques</strong></div>
                    <p>
                        <br>
                        Durant l’ère tertiaire, il y a 60 millions d’années, les plaques africaine et européenne se chevauchent, et ces roches émergent alors.
                        <br>
                        Ainsi apparaît la chaîne pyrénéo-provençale, qui comprend notamment les Pyrénées, la Corse et la Sardaigne. Puis ce massif s’érode, 
                        se fracture, se déforme peu à peu.
                    </p>
                </li>
                <li>
                    <div><strong>Glaciations, réchauffements, érosion</strong></div>
                    <p>
                        <br>
                        Durant l’ère tertiaire, il y a 60 millions d’années, les plaques africaine et européenne se chevauchent, et ces roches émergent alors.
                        <br>
                        Les périodes chaudes facilitent la création d’un réseau karstique. L’action dissolvante des eaux de ruissellement et 
                        d’infiltration sculpte ce paysage et conduit à la formation de grottes, avens et rivières souterraines.
                    </p>
                </li>
            </section>
            <p style="margin:25px 150px 25px 150px;">
                Les périodes de glaciation du Quaternaire, il y a 1,8 million d’années, provoquent l’abaissement 
                du niveau de la mer à -130 mètres en moyenne.
                L’érosion des massifs calcaires littoraux s’accélère alors : 
                des vallées profondes et étroites se dessinent,
                ainsi que des failles verticales qui hachent les massifs. Le niveau de la mer remonte, noyant la partie en aval 
                des ravins, qui deviennent nos calanques.
            </p>
        </section>

        <h2 style="text-align:center;">Nos Calanques</h2>

        <section>
            <?php if (!empty($calanques)): ?>
                <div>
                    <?php 
                    // Réinitialiser le compteur pour l'affichage
                    $idCounter = 1; 
                    foreach ($calanques as $calanque): ?>
                        <article>
                            <section>
                                <div>
                                    <hgroup class=".hgroup">
                                        <h2 id="calanque-<?= $idCounter; ?>"><?= htmlspecialchars($calanque['name']); ?>,</h2>
                                        <p><i><?= htmlspecialchars($calanque['location']); ?></i></p>
                                    </hgroup>
                                    <svg height="2" width="100%">
                                        <line x1="0" y1="0" x2="100%" y2="0" style="stroke:#3498db;stroke-width:2" />
                                    </svg>
                                </div>
                            </section>
                            <section>
                                <?php if (!empty($calanque['image'])): ?>
                                    <img src="../<?= htmlspecialchars($calanque['image']); ?>" alt="Image de <?= htmlspecialchars($calanque['name']); ?>">
                                <?php endif; ?>
                                <p><?= htmlspecialchars($calanque['description']); ?></p>
                            </section>
                        </article>
                        <?php $idCounter++; // Incrémenter le compteur à chaque itération ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucune calanque disponible.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>
