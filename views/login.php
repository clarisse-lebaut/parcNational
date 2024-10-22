<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La page de connection</title>
    <link rel="stylesheet" href="assets/style/user/login-page.css">
    <script src="assets/script/login.js" defer></script>
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <?php
    if(isset($error)):?>
      <div class="alert alert-danger">
      <?php echo htmlspecialchars($error); ?>
     </div>
    <?php endif; ?> 
    <div class= "main-container">
      <h1>Se Connecter</h1>
      <div class="login-container">
        <form method='post' action="loginForm" onsubmit="validateForm(event)">
          <div class="form-group">
              <label for="inputEmail2">E-mail</label> 
              <input type="email" name='email' class="form-control" id="inputEmail2" >
          </div>
          <div class="form-group">
              <label for="inputPassword2">Mot de passe</label>
              <input type="password" name='password' class="form-control" id="inputPassword2">
          </div>
          <h5><a class="register-text"href="forgot-password">Mot de passe oublié ?</a></h5>
          <div class="btn-confirmation"> 
              <button type="submit" class="connect-button">Se connecter</button>
          </div>
        </form>
      </div>
      <p>Ou connectez-vous avec : </p>
      <div class="or-connect-with">
        <a class="sm-connect" href="login-using-google" class="google-login-btn m-3">
          <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" width="20" height="20">
          Google
        </a>

        <?php
          require 'vendor/autoload.php';
          $clientId = $_ENV['FACEBOOK_CLIENT_ID'] ?? 'default_client_id';
          $redirectUri = $_ENV['FACEBOOK_REDIRECT_URI'] ?? 'default_redirect_uri';
        ?>

        <a class="sm-connect" href="https://www.facebook.com/v2.10/dialog/oauth?client_id=<?php echo htmlspecialchars($clientId); ?>&redirect_uri=<?php echo urlencode($redirectUri); ?>&scope=email,public_profile">
          <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook logo" width="20" height="20">
          Facebook
        </a>
      </div>
    </div> 
    <div class="register-block"> 
      <button class="register-button">
        <p><a class="register-text" href="register">Inscription</a></p>
        <img class="register-button-img" src="assets/icon/sign-up-icon.svg" alt="icon register">
      </button class="register-button">
    </div>
      <footer>
          <?php include "components/_footer.php"; ?>
      </footer>
</body>
</html>