<?php
function renderNavigation() {
    echo '
    <nav>
        <ul>
            <li><a href="../index.php">menu</a></li>
            <li><a href="../form/geojson_toCSV.html">convertir le geojson</a></li>
            <li><a href="../form/send_map.php">envoyer la map dans la base de données</a></li>
            <li><a href="../form/send_trail.php">envoyer le sentiers dans la base de données</a></li>
            <li><a href="../form/send_viewpoint.php">envoyer le point de vue dans la base de données</a></li>
            <li><a href="../map/map.php">test</a></li>
        </ul>
    </nav>
    ';
}
?>
