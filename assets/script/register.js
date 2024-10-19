
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