 <form method="post" action="index.php?controller=auth&action=login" id="loginForm" novalidate>
  <div class="form-group">
    <label for="email" class="form-label">Adresse email</label>
    <input type="email" id="email" name="email" class="form-control" 
           placeholder="Entrez votre email" 
           value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" 
           required>
    <i class="bi bi-envelope input-icon"></i>
    <div class="invalid-feedback" id="email-error"></div>
  </div>
  
  <div class="form-group">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" id="password" name="mot_de_passe" class="form-control" 
           placeholder="Entrez votre mot de passe" 
           required>
    <i class="bi bi-lock input-icon"></i>
    <button type="button" class="password-toggle" id="passwordToggle" aria-label="Afficher/Masquer le mot de passe">
      <i class="bi bi-eye"></i>
    </button>
    <div class="invalid-feedback" id="password-error"></div>
  </div>
  
  <button type="submit" class="btn-login" id="loginBtn">
    <i class="bi bi-arrow-right"></i>
    <span>Se connecter</span>
  </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('loginForm');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const passwordToggle = document.getElementById('passwordToggle');
  const loginBtn = document.getElementById('loginBtn');

  // Toggle du mot de passe
  if (passwordToggle && passwordInput) {
    passwordToggle.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      const icon = this.querySelector('i');
      if (type === 'text') {
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    });
  }

  // Validation en temps réel améliorée
  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email.trim());
  }

  function validatePassword(password) {
    return password.trim().length >= 1;
  }

  function showError(input, message) {
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    const errorElement = document.getElementById(input.id + '-error');
    if (errorElement) {
      errorElement.textContent = message;
      errorElement.style.display = 'block';
    }
  }

  function showSuccess(input) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    const errorElement = document.getElementById(input.id + '-error');
    if (errorElement) {
      errorElement.style.display = 'none';
    }
  }

  function clearValidation(input) {
    input.classList.remove('is-valid', 'is-invalid');
    const errorElement = document.getElementById(input.id + '-error');
    if (errorElement) {
      errorElement.style.display = 'none';
    }
  }

  // Validation email avec debounce
  let emailTimeout;
  emailInput.addEventListener('input', function() {
    clearTimeout(emailTimeout);
    clearValidation(this);
    
    emailTimeout = setTimeout(() => {
      if (this.value.trim()) {
        if (validateEmail(this.value)) {
          showSuccess(this);
        } else {
          showError(this, 'Format d\'email invalide');
        }
      }
    }, 300);
  });

  emailInput.addEventListener('blur', function() {
    if (!this.value.trim()) {
      showError(this, 'L\'email est obligatoire');
    } else if (!validateEmail(this.value)) {
      showError(this, 'Format d\'email invalide');
    } else {
      showSuccess(this);
    }
  });

  // Validation mot de passe
  passwordInput.addEventListener('input', function() {
    clearValidation(this);
    if (this.value.trim()) {
      showSuccess(this);
    }
  });

  passwordInput.addEventListener('blur', function() {
    if (!this.value.trim()) {
      showError(this, 'Le mot de passe est obligatoire');
    } else {
      showSuccess(this);
    }
  });

  // Validation du formulaire
  form.addEventListener('submit', function(e) {
    let isValid = true;

    // Valider email
    if (!emailInput.value.trim()) {
      showError(emailInput, 'L\'email est obligatoire');
      isValid = false;
    } else if (!validateEmail(emailInput.value)) {
      showError(emailInput, 'Format d\'email invalide');
      isValid = false;
    }

    // Valider mot de passe
    if (!passwordInput.value.trim()) {
      showError(passwordInput, 'Le mot de passe est obligatoire');
      isValid = false;
    }

    if (!isValid) {
      e.preventDefault();
      return;
    }

    // Animation de chargement améliorée
    loginBtn.disabled = true;
    const originalContent = loginBtn.innerHTML;
    loginBtn.innerHTML = '<i class="bi bi-arrow-clockwise loading active"></i><span>Connexion...</span>';
    
    // Réactiver le bouton après 5 secondes au cas où
    setTimeout(() => {
      if (loginBtn.disabled) {
        loginBtn.disabled = false;
        loginBtn.innerHTML = originalContent;
      }
    }, 5000);
  });

  // Effet de focus amélioré
  [emailInput, passwordInput].forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.classList.add('focused');
    });

    input.addEventListener('blur', function() {
      if (!this.value.trim()) {
        this.parentElement.classList.remove('focused');
      }
    });
  });

  // Auto-focus sur le premier champ
  if (!emailInput.value) {
    emailInput.focus();
  }

  // Gestion des erreurs de serveur
  const urlParams = new URLSearchParams(window.location.search);
  const error = urlParams.get('error');
  if (error) {
    // Afficher l'erreur dans le champ approprié
    if (error.includes('email')) {
      showError(emailInput, 'Email ou mot de passe incorrect');
    } else if (error.includes('password')) {
      showError(passwordInput, 'Email ou mot de passe incorrect');
    }
  }

  // Auto-dismiss des alertes avec animation
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      if (alert.parentElement) {
        alert.style.transition = 'all 0.3s ease';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
          if (alert.parentElement) {
            alert.remove();
          }
        }, 300);
      }
    }, 5000);
  });

  // Animation d'entrée des champs
  const formGroups = document.querySelectorAll('.form-group');
  formGroups.forEach((group, index) => {
    group.style.opacity = '0';
    group.style.transform = 'translateY(15px)';
    group.style.transition = 'all 0.4s ease';
    
    setTimeout(() => {
      group.style.opacity = '1';
      group.style.transform = 'translateY(0)';
    }, 150 + (index * 80));
  });

  // Animation du bouton
  setTimeout(() => {
    loginBtn.style.opacity = '0';
    loginBtn.style.transform = 'translateY(15px)';
    loginBtn.style.transition = 'all 0.4s ease';
    
    setTimeout(() => {
      loginBtn.style.opacity = '1';
      loginBtn.style.transform = 'translateY(0)';
    }, 100);
  }, 300);
});
</script>


