<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="assets/style/config/_global.css">
  <link rel="stylesheet" href="assets/style/user/register.css">
  <script src="/assets/script/register.js" defer></script>
</head>

<body>
  <header>
        <?php include "components/_header.php"; ?>
  </header>

  <main>
    <h1>Se créer un compte</h1>

    <div>
      <?php if(isset($error)): ?>
        <div class="alert alert-danger" style="display: flex; justify-content: center; align-items: center;">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      <?php if(isset($message)): ?>
        <div class="message" style=" display: flex; justify-content: center; align-items: center; color: green; ">
          <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
          <form class="form" method="post" action="register-form" id="registerForm">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']);?>">
            <a href="login"><p>Déjà un compte ? Connectez-vous !</p></a>

            <section class="form_container">  

                <section class="civil">
                  <h2>Civilités</h2>
                  <!-- Lastname -->
                  <div>
                    <label for="inputLastname">Nom</label>
                    <input type="text" name="lastname" id="inputLastname" placeholder="Your lastname" required>
                  </div>

                  <!-- Firstname -->
                  <div>
                    <label for="inputFirstname">Prénom</label>
                    <input type="text" name="firstname" id="inputFirstname" placeholder="Your firstname" required>
                  </div>

                  <!-- Email -->
                  <div>
                    <label for="inputEmail">E-mail</label>
                    <input type="email" name="email" id="inputEmail" placeholder="Your email" required>
                    <div id="emailError" class="error-message" style="display:none;"> L'email doit contenir '@' et être au format correct.</div>
                  </div>
                  
                  <!-- Phone -->
                  <div>
                    <label for="inputPhone">Téléphone</label>
                    <input type="tel" name="phone" id="inputPhone" placeholder="Your phone number" required>
                  </div>
                </section>
                
                <section class="live">
                  <h2>Adresse</h2>
                  <!-- Address -->
                  <div>
                    <label for="inputAddress">Addresse</label>
                    <input type="text" name="adress" id="inputAddress" placeholder="1234 Main St" required>
                  </div>

                  <!-- City -->
                  <div>
                    <label for="inputCity">Ville</label>
                    <input type="text" name="city" id="inputCity" placeholder="City" required>
                  </div>

                  <!-- Zipcode -->
                  <div>
                    <label for="inputZipcode" >Code postale</label>
                    <input type="text" name="zipcode" id="inputZipcode" placeholder="Zipcode" required>
                  </div>
                </section>
                
                <section class='password'>
                  <h2>Mot de passe</h2>
                  <!-- Password -->
                  <div>
                    <label for="inputPassword">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
                    <div id="passwordError" class="error-message" style="display:none;">Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.</div>
                  </div>
                      
                  <!-- Repeat Password -->
                  <div>
                    <label for="inputRepeatPassword">Répétez le mot de passe</label>
                    <input type="password" name="repeatpassword" class="form-control" id="inputRepeatPassword" placeholder="Repeat password" required>          
                  </div>
    
                </section> 

            </section>

            <section class="submit_button">

              <div>
                <button type="submit">Valider</button>
              </div>
              
            </section>

            <div class="register-block"> 
              <button class="register-button">
                <a class="register-text" href="login">Connexion</a>
                <img class="register-button-img" src="assets/icon/sign-up-icon.svg" alt="icon register">
              </button class="register-button">
            </div>

          </form>
    </div>
  </main>
  
  <footer>
      <?php include "components/_footer.php"; ?>
  </footer>

</body>
</html>
