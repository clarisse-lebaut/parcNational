document.addEventListener('DOMContentLoaded', function () {
    var emailInput = document.getElementById('inputEmail2');
    var passwordInput = document.getElementById('inputPassword2');
    var emailError = document.createElement('div'); 
    emailError.id = 'emailError';
    emailError.className = 'error-message'; 
    emailInput.parentNode.appendChild(emailError);
    
    var passwordError = document.createElement('div');
    passwordError.id = 'passwordError';
    passwordError.className = 'error-message';
    passwordInput.parentNode.appendChild(passwordError);
    var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    emailInput.addEventListener('blur', function () {
        if (!emailInput.value.match(emailPattern)) {
            emailInput.style.borderColor = 'red';
            emailError.textContent = "L'adresse e-mail n'est pas correcte.";
            emailError.style.color = 'red';
        } else {
            emailInput.style.borderColor = '';
            emailError.textContent = ''; 
        }
    });
    passwordInput.addEventListener('blur', function () {
        if (passwordInput.value.length < 8) {
            passwordInput.style.borderColor = 'red'; 
            passwordError.textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
            passwordError.style.color = 'red';
        } else {
            passwordInput.style.borderColor = '';
            passwordError.textContent = '';
        }
    });

    document.querySelector('form').addEventListener('submit', function (event) {
        var isValid = true;
        var errorMessage = '';
        if (!emailInput.value.match(emailPattern)) {
            emailInput.style.borderColor = 'red';
            errorMessage = "L'adresse e-mail n'est pas correcte. ";
            emailError.style.color = 'red';
            isValid = false;
        }else {
              emailError.textContent = ''; 
        }

        if (passwordInput.value.length < 8) {
            passwordInput.style.borderColor = 'red';
            errorMessage += 'Le mot de passe doit contenir au moins 8 caractères.';
            passwordError.style.color = 'red';
            isValid = false;
        }else {
            passwordError.textContent = '';
        }

        if (!isValid) {
            alert(errorMessage);
            event.preventDefault();
        }
    });
    });