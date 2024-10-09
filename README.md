# Parc National des Calanques

Dans cette branche un premier merge entre deux branches.
C'est avant tout un test pour voir les confilts qu'il va falloir régler lorsque toutes les fonctionnalité seront à réunir.

Il s'agit également de pouvoir relier le module de connexion et d'inscription afin d'implanter les dernières fonctionnalaité qui permettent à l'utilisateur de se connecter et d'acceder à son profil, de faire appraitre certaine condition comme les nouveau onglets, et les boutons pour les favoris de l'utilisateurs.

D'autre part, ce premier merge donne l'ocassion de corriger :
- les routes
- la connexion à la base de donnée
- le rangements des fichiers
- le nommage des fichiers
- la correction de l'environnement de dévéloppement

Changement dans filter.js ---> ligne 149 (<a href="/parcNational/manage-favorite-trail?trail_id=${item.trail_id}" class="fav-btn"><img src="assets/icon/favorite-fill.svg" alt="heart icon"></a>)