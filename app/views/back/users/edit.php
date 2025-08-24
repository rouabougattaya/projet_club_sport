<div class="container-fluid px-4 py-3">
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
      <!-- Header du formulaire -->
      <div class="d-flex align-items-center mb-4">
        <div class="bg-warning bg-gradient rounded-circle p-3 me-3">
          <i class="bi bi-pencil-square text-white fs-4"></i>
        </div>
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">Modifier l'Utilisateur</h2>
          <p class="text-muted mb-0">Mettez à jour les informations de <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></p>
        </div>
      </div>

      <!-- Informations actuelles -->
      <div class="card border-0 bg-light mb-4">
        <div class="card-body p-3">
          <div class="d-flex align-items-center">
            <div class="avatar-sm bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3">
              <span class="fw-semibold"><?= strtoupper(substr($user['nom'], 0, 1)) ?></span>
            </div>
            <div class="flex-grow-1">
              <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h6>
              <p class="mb-0 text-muted small">
                <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($user['email']) ?> • 
                <i class="bi bi-shield me-1"></i><?= ucfirst($user['role']) ?>
              </p>
            </div>
            <div class="text-end">
              <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'entraineur' ? 'primary' : 'success') ?> bg-opacity-10 text-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'entraineur' ? 'primary' : 'success') ?> border border-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'entraineur' ? 'primary' : 'success') ?>">
                <i class="bi bi-<?= $user['role'] === 'admin' ? 'shield-fill-check' : ($user['role'] === 'entraineur' ? 'person-workspace' : 'person-check-fill') ?> me-1"></i>
                <?= htmlspecialchars(ucfirst($user['role'])) ?>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Formulaire -->
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <form method="post" class="needs-validation" novalidate id="editUserForm">
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
                  <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" 
                         class="form-control border-start-0" required placeholder="Entrez le nom de famille">
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
                  <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" 
                         class="form-control border-start-0" required placeholder="Entrez le prénom">
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
                  <input type="text" id="cin" name="cin" value="<?= htmlspecialchars($user['cin'] ?? '') ?>" 
                         class="form-control border-start-0" placeholder="Numéro de carte d'identité">
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
                    <option value="" <?= empty($user['genre']) ? 'selected' : '' ?>>Sélectionnez le genre</option>
                <option value="Homme" <?= ($user['genre'] ?? '') === 'Homme' ? 'selected' : '' ?>>Homme</option>
                <option value="Femme" <?= ($user['genre'] ?? '') === 'Femme' ? 'selected' : '' ?>>Femme</option>
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
                  <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($user['adresse'] ?? '') ?>" 
                         class="form-control border-start-0" placeholder="Adresse complète">
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
                  <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" 
                         class="form-control border-start-0" placeholder="Numéro de téléphone">
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
                  <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                         class="form-control border-start-0" required placeholder="adresse@email.com">
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
                  <i class="bi bi-key me-1 text-primary"></i>Nouveau mot de passe
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-key text-muted"></i>
                  </span>
                  <input type="password" id="mot_de_passe" name="mot_de_passe" 
                         class="form-control border-start-0" placeholder="Laissez vide pour ne pas changer">
                  <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                    <i class="bi bi-eye"></i>
                  </button>
            </div>
                <div class="form-text">
                  <i class="bi bi-info-circle me-1"></i>Laissez ce champ vide si vous ne souhaitez pas modifier le mot de passe.
            </div>
            </div>
            <?php $canEditRole = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
            <?php if ($canEditRole): ?>
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
                      <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                        <i class="bi bi-shield-fill-check"></i> Administrateur
                      </option>
                      <option value="entraineur" <?= $user['role'] === 'entraineur' ? 'selected' : '' ?>>
                        <i class="bi bi-person-workspace"></i> Entraîneur
                      </option>
                      <option value="adherent" <?= $user['role'] === 'adherent' ? 'selected' : '' ?>>
                        <i class="bi bi-person-check-fill"></i> Adhérent
                      </option>
                </select>
                    <div class="invalid-feedback">
                      <i class="bi bi-exclamation-circle me-1"></i>Veuillez sélectionner un rôle.
                    </div>
                  </div>
              </div>
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
                <button type="submit" class="btn btn-warning btn-lg shadow-sm">
                  <i class="bi bi-check-circle me-2"></i>Mettre à Jour
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
.avatar-sm {
  width: 40px;
  height: 40px;
  font-size: 14px;
}

.card {
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.form-control:focus,
.form-select:focus {
  border-color: var(--bs-warning);
  box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
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
  background-image: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
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

.bg-light {
  background-color: #f8f9fa !important;
}

.badge {
  font-size: 0.75rem;
  padding: 0.5em 0.75em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('editUserForm');
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('mot_de_passe');

  // Toggle password visibility
  if (togglePassword && passwordInput) {
    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.querySelector('i').classList.toggle('bi-eye');
      this.querySelector('i').classList.toggle('bi-eye-slash');
    });
  }

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
  if (phoneInput) {
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
  }
});
</script>
