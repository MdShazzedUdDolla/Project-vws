function checkPasswordStrength(password) {
    var strengthBar = document.getElementById("password-strength");
    var strength = 0;
    if (password.length >= 6) {
      if (password.match(/[a-z]+/)) {
        strength += 1;
      }
      if (password.match(/[A-Z]+/)) {
        strength += 1;
      }
      if (password.match(/[0-9]+/)) {
        strength += 1;
      }
      if (password.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
        strength += 1;
      }
    }
    var strengthClass = "";
    var strengthText = "";
    switch (strength) {
      case 0:
        strengthClass = "very-weak";
        strengthText = "Very Weak";
        break;
      case 1:
        strengthClass = "weak";
        strengthText = "Weak";
        break;
      case 2:
        strengthClass = "fair";
        strengthText = "Fair";
        break;
      case 3:
        strengthClass = "strong";
        strengthText = "Strong";
        break;
      case 4:
        strengthClass = "very-strong";
        strengthText = "Very Strong";
        break;
    }
    strengthBar.className = "password-strength " + strengthClass;
    strengthBar.textContent = strengthText;
  }

  function checkPasswordsMatch() {
    var passwordInput = document.getElementById("password");
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    var confirmInput = document.getElementById("confirm_password");

    if (password !== confirmPassword) {
      confirmInput.setCustomValidity("Passwords do not match!");
    } else {
      confirmInput.setCustomValidity("");
    }
    var strengthBar = document.getElementById("password-strength");
    if(strengthBar.textContent!=="Very Strong"){
        passwordInput.setCustomValidity("Passwords does not meet requirement.");
    }else {
        passwordInput.setCustomValidity("");
    }
  }
  var passwordInput = document.getElementById("password");
  var confirmInput = document.getElementById("confirm_password");
  confirmInput.addEventListener("blur", function() {
    checkPasswordsMatch();
  });


  passwordInput.addEventListener("blur", function() {
    checkPasswordsMatch();
  });

  var form = document.getElementById("reg-form");
  form.addEventListener("submit", function(event) {
    checkPasswordsMatch();
    if (!form.checkValidity()) {
      event.preventDefault();
    }
  });