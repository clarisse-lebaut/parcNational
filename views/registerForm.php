<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Example</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .error-message{
      color: red;
      display: none;
    }
  </style>
</head>
<body>
<header>
        <?php include "components/_header.php"; ?>
    </header>
  <div class="container mt-5">
    <?php
    if(isset ($error)){
      echo '<div class="alert alert-danger">';
      echo $error;
      echo '</div>';
    }
    ?>
    <form method="post" action="/parcNational/register-form" id="registerForm">
      <div class="row g-3">
        <!-- Lastname -->
        <div class="col-md-6">
          <label for="inputLastname" class="form-label">Lastname</label>
          <input type="text" name="lastname" class="form-control" id="inputLastname" placeholder="Your lastname" required>
        </div>

        <!-- Firstname -->
        <div class="col-md-6">
          <label for="inputFirstname" class="form-label">Firstname</label>
          <input type="text" name="firstname" class="form-control" id="inputFirstname" placeholder="Your firstname" required>
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <label for="inputEmail" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Your email" required>
          <div id="emailError" class="error-message" style="display:none;"> L'email doit contenir '@' et être au format correct.</div>
        </div>

        <!-- Password -->
        <div class="col-md-6">
          <label for="inputPassword" class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
          <div id="passwordError" class="error-message" style="display:none;">Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.
        </div>

        <!-- Repeat Password -->
        <div class="col-md-6">
          <label for="inputRepeatPassword" class="form-label">Répétez le mot de passe</label>
          <input type="password" name="repeatpassword" class="form-control" id="inputRepeatPassword" placeholder="Repeat password" required>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'];?>">

        <!-- Phone -->
        <div class="col-md-6">
          <label for="inputPhone" class="form-label">Téléphone</label>
          <input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="Your phone number" required>
        </div>

        <!-- Address -->
        <div class="col-12">
          <label for="inputAddress"  class="form-label">Address</label>
          <input type="text" name="adress" class="form-control" id="inputAddress" placeholder="1234 Main St" required>
        </div>

        <!-- City -->
        <div class="col-md-6">
          <label for="inputCity" class="form-label">Ville</label>
          <input type="text" name="city" class="form-control" id="inputCity" placeholder="City" required>
        </div>

        <!-- Zipcode -->
        <div class="col-md-6">
          <label for="inputZipcode"  class="form-label">Code postale</label>
          <input type="text" name="zipcode" class="form-control" id="inputZipcode" placeholder="Zipcode" required>
        </div>

        <!-- Submit Button -->
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    document.getElementById('inputEmail').addEventListener('input', function() {
      const email = this.value.trim();
      const emailError = document.getElementById('emailError');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailRegex.test(email)) {
        emailError.style.display = 'block';
      }else{
        emailError.style.display = 'none';
      }
    });

    document.getElementById('inputPassword').addEventListener('input', function() {
      const password = this.value.trim();
      const passwordError = document.getElementById('passwordError');
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

      if (!passwordRegex.test(password)) {
        passwordError.style.display = 'block';
      } else{
        passwordError.style.display = 'none';
      }
    });
  </script>
  <footer>
        <?php include "components/_footer.php"; ?>
  </footer>  
</body>
</html>
