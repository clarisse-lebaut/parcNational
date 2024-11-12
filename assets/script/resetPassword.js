
document.addEventListener('DOMContentLoaded', function(){
    var passwordInput = document.getElementById('inputPassword2');
    var repeatPassworInput = document.getElementById('inputRepeatPassword2');
    var passwordError = document.getElementById('passwordError');
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>/?]).{8,}$/;
    
    passwordInput.addEventListener('blur', function(){
        if(!passwordInput.value.match(passwordPattern)){
            passwordInput.style.borderColor = 'red';
            passwordError.textContent = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
            passwordError.style.color = 'red';
        }else{
            passwordInput.style.borderColor = '';
            passwordError.textContent = '';
            
        }
    });

    repeatPassworInput.addEventListener('input', function(){
        if(repeatPassworInput.value !== passwordInput.value){
            repeatPassworInput.style.borderColor = 'red';
            passwordError.textContent = 'Le mots de passe ne coresspondent pas.';
            passwordError.style.color = 'red';
        }else{
            repeatPassworInput.style.borderColor = '';
            passwordError.textContent = '';
        }
    });

    document.querySelector('form').addEventListener('submit', function(event){
        var isValid = true;
        var errorMessage = '';

        if(!passwordInput.value.match(passwordPattern)){
            passwordInput.style.borderColor = 'red';
            errorMessage += 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial ';
            isValid = false;
        }
        if(repeatPassworInput.value !== passwordInput.value){
            repeatPassworInput.style.borderColor = 'red';
            errorMessage += 'Les mots de passe ne correspondent pas';
            isValid = false;
        }

        if(!isValid){
            alert(errorMessage);
            event.preventDefault();
        }
    });
});