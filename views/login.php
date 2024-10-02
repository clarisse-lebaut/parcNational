<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    if(isset($error)){
      echo '<div class="alert alert-danger">';
      echo $error;
      echo '</div>';
    }
    ?>
    <h1> Connection</h1>
    <form method='post' action="/parcNational/loginForm" class="row g-3">
      <div class="col-auto">
        <label for="inputEmail2" class="visually-hidden">Email</label>
        <input type="email" name='email' class="form-control" id="inputEmail2" placeholder=Email>
      </div>
      <div class="col-auto">
        <label for="inputPassword2" class="visually-hidden">Le mot de passe</label>
        <input type="password" name='password' class="form-control" id="inputPassword2" placeholder="Le mot de passe">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Confirmez votre identité</button>
      </div>
      <h5 class= 'm-3'><a href="register">Vous n'avez pas encore de compte ? Allez à la page d'inscription..</h5>
    </form>
    <a href="/parcNational/login-using-google" class="google-login-btn m-3">
      <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" width="20" height="20">
      Connectez-vous avec Google
    </a>
    <?php
      require 'vendor/autoload.php';
      $clientId = $_ENV['FACEBOOK_CLIENT_ID'] ?? 'default_client_id';
      $redirectUri = $_ENV['FACEBOOK_REDIRECT_URI'] ?? 'default_redirect_uri';
    ?>
    <a href="https://www.facebook.com/v2.10/dialog/oauth?client_id=<?php echo htmlspecialchars($clientId); ?>&redirect_uri=<?php echo urlencode($redirectUri); ?>&scope=email,public_profile">
      <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook logo" width="20" height="20">
      Connectez-vous avec Facebook
    </a>
</body>
</html>