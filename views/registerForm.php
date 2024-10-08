<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="assets/style/_global.css">
  <link rel="stylesheet" href="assets/style/_header.css">
  <link rel="stylesheet" href="assets/style/_footer.css">
  <link rel="stylesheet" href="assets/style/register.css">
</head>

<body>
  <header>
        <?php include "components/_header.php"; ?>
  </header>

  <main>
    <h1>Se créer un compte</h1>

  <div>
    <?php
    if(isset ($error)){
      echo '<div class="alert alert-danger">';
      echo $error;
      echo '</div>';
    }
    ?>
        <form class="form" method="post" action="/parcNational/register-form" id="registerForm">
        
          <a href="login"><p>Déjà un compte ? Connectez-vous !</p></a>
          
          <section class="form_container">  

              <section class="civil">
                <h2>Civilités</h2>
                <!-- Lastname -->
                <div>
                  <label for="inputLastname">Lastname</label>
                  <input type="text" name="lastname" id="inputLastname" placeholder="Your lastname" required>
                </div>

                <!-- Firstname -->
                <div>
                  <label for="inputFirstname">Firstname</label>
                  <input type="text" name="firstname" id="inputFirstname" placeholder="Your firstname" required>
                </div>

                <!-- Email -->
                <div>
                  <label for="inputEmail">Email</label>
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
                <h2>Adresses</h2>
                <!-- Address -->
                <div>
                  <label for="inputAddress">Address</label>
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
                
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'];?>">
              </section> 

          </section>

          <section class="submit_button">

            <div>
              <button type="submit">Valider</button>
            </div>
            
          </section>

          <a href="login"><p>Déjà un compte ? Connectez-vous !</p></a>
        
        </form>
  </div>
  </main>


  <script>
    document.getElementById('inputEmail').addEventListener('input', function() {
      const email = this.value.trim();//Removes spaces at the beginning and the end
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
