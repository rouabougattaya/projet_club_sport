<div class="container-fluid px-4 py-3">
  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
      <!-- Header du formulaire -->
      <div class="d-flex align-items-center mb-4">
        <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
          <i class="bi bi-person-plus-fill text-white fs-4"></i>
        </div>
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">Ajouter un Nouvel Utilisateur</h2>
          <p class="text-muted mb-0">Créez un nouveau compte utilisateur dans le système</p>
        </div>
      </div>

      <!-- Formulaire -->
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <form method="post" class="needs-validation" novalidate id="createUserForm">
            <!-- Informations personnelles -->
            <div class="row mb-4">
              <div class="col-12">
                <h5 class="text-primary mb-3">
                  <i class="bi bi-person-badge me-2"></i>
                  Informations Personnelles
                </h5>
              </div>
              <div class="col-md-6 mb-3">
                <label for="nom" class="form-label fw-semibold">
                  <i class="bi bi-person me-1 text-primary"></i>Nom <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-person text-muted"></i>
                  </span>
                  <input type="text" id="nom" name="nom" class="form-control border-start-0" required 
                         placeholder="Entrez le nom de famille">
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>Le nom est requis.
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="prenom" class="form-label fw-semibold">
                  <i class="bi bi-person me-1 text-primary"></i>Prénom <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-person text-muted"></i>
                  </span>
                  <input type="text" id="prenom" name="prenom" class="form-control border-start-0" required 
                         placeholder="Entrez le prénom">
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>Le prénom est requis.
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cin" class="form-label fw-semibold">
                  <i class="bi bi-card-text me-1 text-primary"></i>CIN
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-card-text text-muted"></i>
                  </span>
                  <input type="text" id="cin" name="cin" class="form-control border-start-0" 
                         placeholder="Numéro de carte d'identité">
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="genre" class="form-label fw-semibold">
                  <i class="bi bi-gender-ambiguous me-1 text-primary"></i>Genre
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-gender-ambiguous text-muted"></i>
                  </span>
                  <select id="genre" name="genre" class="form-select border-start-0">
                    <option value="">Sélectionnez le genre</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Informations de contact -->
            <div class="row mb-4">
              <div class="col-12">
                <h5 class="text-primary mb-3">
                  <i class="bi bi-envelope me-2"></i>
                  Informations de Contact
                </h5>
              </div>
              <div class="col-12 mb-3">
                <label for="adresse" class="form-label fw-semibold">
                  <i class="bi bi-geo-alt me-1 text-primary"></i>Adresse
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-geo-alt text-muted"></i>
                  </span>
                  <input type="text" id="adresse" name="adresse" class="form-control border-start-0" 
                         placeholder="Adresse complète">
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="telephone" class="form-label fw-semibold">
                  <i class="bi bi-telephone me-1 text-primary"></i>Téléphone
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-telephone text-muted"></i>
                  </span>
                  <input type="tel" id="telephone" name="telephone" class="form-control border-start-0" 
                         placeholder="Numéro de téléphone">
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label fw-semibold">
                  <i class="bi bi-envelope me-1 text-primary"></i>Email <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-envelope text-muted"></i>
                  </span>
                  <input type="email" id="email" name="email" class="form-control border-start-0" required 
                         placeholder="adresse@email.com">
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>Veuillez entrer une adresse email valide.
                  </div>
                </div>
              </div>
            </div>

            <!-- Informations de sécurité -->
            <div class="row mb-4">
              <div class="col-12">
                <h5 class="text-primary mb-3">
                  <i class="bi bi-shield-lock me-2"></i>
                  Informations de Sécurité
                </h5>
              </div>
              <div class="col-md-6 mb-3">
                <label for="mot_de_passe" class="form-label fw-semibold">
                  <i class="bi bi-key me-1 text-primary"></i>Mot de passe <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-key text-muted"></i>
                  </span>
                  <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control border-start-0" required 
                         placeholder="Mot de passe sécurisé">
                  <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                    <i class="bi bi-eye"></i>
                  </button>
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>Le mot de passe est requis.
                  </div>
                </div>
                <div class="form-text">
                  <i class="bi bi-info-circle me-1"></i>Le mot de passe doit contenir au moins 8 caractères.
                </div>
              </div>
              <?php $isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
              <?php if ($isAdmin): ?>
                <div class="col-md-6 mb-3">
                  <label for="role" class="form-label fw-semibold">
                    <i class="bi bi-shield me-1 text-primary"></i>Rôle <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                      <i class="bi bi-shield text-muted"></i>
                    </span>
                    <select id="role" name="role" class="form-select border-start-0" required>
                      <option value="">Sélectionnez un rôle</option>
                      <option value="admin">
                        <i class="bi bi-shield-fill-check"></i> Administrateur
                      </option>
                      <option value="entraineur">
                        <i class="bi bi-person-workspace"></i> Entraîneur
                      </option>
                      <option value="adherent">
                        <i class="bi bi-person-check-fill"></i> Adhérent
                      </option>
                    </select>
                    <div class="invalid-feedback">
                      <i class="bi bi-exclamation-circle me-1"></i>Veuillez sélectionner un rôle.
                    </div>
                  </div>
                </div>
              <?php else: ?>
                <input type="hidden" name="role" value="adherent">
              <?php endif; ?>
            </div>

            <!-- Boutons d'action -->
            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
              <a href="index.php?controller=user&action=index" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-arrow-left me-2"></i>Retour à la Liste
              </a>
              <div class="d-flex gap-2">
                <button type="reset" class="btn btn-outline-warning btn-lg">
                  <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                </button>
                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                  <i class="bi bi-check-circle me-2"></i>Créer l'Utilisateur
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.card {
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.form-control:focus,
.form-select:focus {
  border-color: var(--bs-primary);
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.input-group-text {
  border-color: #dee2e6;
}

.btn {
  transition: all 0.2s ease;
}

.btn:hover {
  transform: translateY(-1px);
}

.form-label {
  color: #495057;
  margin-bottom: 0.5rem;
}

.text-primary {
  color: #0d6efd !important;
}

.bg-gradient {
  background-image: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.invalid-feedback {
  display: block;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

.form-text {
  font-size: 0.875rem;
  color: #6c757d;
  margin-top: 0.25rem;
}

.border-top {
  border-top: 1px solid #dee2e6 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('createUserForm');
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('mot_de_passe');

  // Toggle password visibility
  togglePassword.addEventListener('click', function() {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.querySelector('i').classList.toggle('bi-eye');
    this.querySelector('i').classList.toggle('bi-eye-slash');
  });

  // Form validation
  form.addEventListener('submit', function(event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  });

  // Real-time validation
  const inputs = form.querySelectorAll('input[required], select[required]');
  inputs.forEach(input => {
    input.addEventListener('blur', function() {
      if (this.checkValidity()) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
      } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
      }
    });
  });

  // Auto-format phone number
  const phoneInput = document.getElementById('telephone');
  phoneInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 0) {
      value = value.match(/(\d{0,2})(\d{0,2})(\d{0,2})(\d{0,2})/);
      e.target.value = !value[2] ? value[1] : 
                      !value[3] ? value[1] + ' ' + value[2] : 
                      !value[4] ? value[1] + ' ' + value[2] + ' ' + value[3] : 
                      value[1] + ' ' + value[2] + ' ' + value[3] + ' ' + value[4];
    }
  });
});
</script>
