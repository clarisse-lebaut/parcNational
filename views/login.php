<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
    <link rel="stylesheet" href="assets/style/_global.css">
    <link rel="stylesheet" href="assets/style/login.css">
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <?php
    if(isset($error)){
      echo '<div class="alert alert-danger">';
      echo $error;
      echo '</div>';
    }
    ?>
    <main>

    <h1>Connection</h1>
    
    <section class="form-container">

      <form class="form" method='post' action="/parcNational/loginForm">
          <label for="inputEmail2">Email</label>
          <input type="email" name='email' id="inputEmail2" placeholder=Email>
          
          <label for="inputPassword2">Mot de passe</label>
          <input type="password" name='password' id="inputPassword2" placeholder="Mot de passe">
          
          <button type="submit">Se connecter</button>
          
          <a href="register">Vous n'avez pas encore de compte ? Inscrivez-vous !</a> 
      </form>
    </section>

    <section class="connection_container">
      <a href="/parcNational/login-using-google"><img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" width="20" height="20">Connectez-vous avec Google</a>

      <?php
        require 'vendor/autoload.php';
        $clientId = $_ENV['FACEBOOK_CLIENT_ID'] ?? 'default_client_id';
        $redirectUri = $_ENV['FACEBOOK_REDIRECT_URI'] ?? 'default_redirect_uri';
      ?>
            
      <a href="https://www.facebook.com/v2.10/dialog/oauth?client_id=<?php echo htmlspecialchars($clientId); ?>&redirect_uri=<?php echo urlencode($redirectUri); ?>&scope=email,public_profile"><img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook logo" width="20" height="20">Connectez-vous avec Facebook</a>
    </section>    

    </main>

    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>