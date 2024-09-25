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
    <label for="inputPassword2" class="visually-hidden">Password</label>
    <input type="password" name='password' class="form-control" id="inputPassword2" placeholder="Password">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Confirm identity</button>
  </div>
  <h5 class= 'm-3'><a href=" registerForm.php">Don't have an account yet? Go to the register page.</h5>
  
</form>
<a href="/parcNational/login-using-google" class="google-login-btn m-3">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" width="20" height="20">
        Connect with Google
    </a>
</body>
</html>