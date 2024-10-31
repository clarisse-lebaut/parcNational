<?php
function logout()
{
    // Démarre la session (nécessaire pour accéder aux variables de session)
    session_start();

    // Vide toutes les variables de session
    $_SESSION = [];

    // Si un cookie de session existe, le supprimer en le rendant expiré
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Détruire la session
    session_destroy();

    // Redirection vers la page de connexion ou d'accueil
    header("Location: parcNational/login"); // Modifier "login" par la route souhaitée
    exit;
}
