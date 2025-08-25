<div class="container-fluid px-4 py-3">
  <!-- Header avec navigation -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-pencil-square text-blue-violet me-2"></i>
            Modifier l'Utilisateur
          </h2>
          <p class="text-muted mb-0">
            Mettez à jour les informations de <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
          </p>
        </div>
        <a href="index.php?controller=user&action=index" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>Retour aux Utilisateurs
        </a>
      </div>
    </div>
  </div>

  <!-- Informations actuelles -->
  <div class="card border-0 bg-light mb-4">
    <div class="card-body p-3">
      <div class="d-flex align-items-center">
        <div class="avatar-sm bg-blue-violet bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3">
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

  <!-- Formulaire de modification -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
          <h5 class="mb-0 text-dark fw-semibold">
            <i class="bi bi-form-text me-2 text-blue-violet"></i>
            Informations de l'Utilisateur
          </h5>
        </div>
        <div class="card-body p-4">
          <form method="post" class="needs-validation" novalidate>
            <!-- Informations personnelles -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-blue-violet fw-semibold mb-3">
                  <i class="bi bi-person-badge me-2"></i>Informations Personnelles
                </h6>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-person me-1 text-blue-violet"></i>
                  Nom <span class="text-danger">*</span>
                </label>
                <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" 
                       class="form-control form-control-lg" required placeholder="Entrez le nom de famille">
                <div class="form-text">Nom de famille de l'utilisateur</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-person me-1 text-blue-violet"></i>
                  Prénom <span class="text-danger">*</span>
                </label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" 
                       class="form-control form-control-lg" required placeholder="Entrez le prénom">
                <div class="form-text">Prénom de l'utilisateur</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-card-text me-1 text-blue-violet"></i>
                  CIN
                </label>
                <input type="text" name="cin" value="<?= htmlspecialchars($user['cin'] ?? '') ?>" 
                       class="form-control form-control-lg" placeholder="Numéro de carte d'identité">
                <div class="form-text">Numéro de carte d'identité nationale</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-gender-ambiguous me-1 text-blue-violet"></i>
                  Genre
                </label>
                <select name="genre" class="form-select form-select-lg">
                  <option value="" <?= empty($user['genre']) ? 'selected' : '' ?>>Sélectionnez le genre</option>
                  <option value="Homme" <?= ($user['genre'] ?? '') === 'Homme' ? 'selected' : '' ?>>Homme</option>
                  <option value="Femme" <?= ($user['genre'] ?? '') === 'Femme' ? 'selected' : '' ?>>Femme</option>
                </select>
                <div class="form-text">Genre de l'utilisateur</div>
              </div>
            </div>

            <!-- Informations de contact -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-blue-violet fw-semibold mb-3">
                  <i class="bi bi-envelope me-2"></i>Informations de Contact
                </h6>
              </div>
              
              <div class="col-12">
                <label class="form-label fw-semibold">
                  <i class="bi bi-geo-alt me-1 text-blue-violet"></i>
                  Adresse
                </label>
                <input type="text" name="adresse" value="<?= htmlspecialchars($user['adresse'] ?? '') ?>" 
                       class="form-control form-control-lg" placeholder="Adresse complète">
                <div class="form-text">Adresse complète de l'utilisateur</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-telephone me-1 text-blue-violet"></i>
                  Téléphone
                </label>
                <input type="tel" name="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" 
                       class="form-control form-control-lg" placeholder="Numéro de téléphone">
                <div class="form-text">Numéro de téléphone de contact</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-envelope me-1 text-blue-violet"></i>
                  Email <span class="text-danger">*</span>
                </label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                       class="form-control form-control-lg" required placeholder="adresse@email.com">
                <div class="form-text">Adresse email de l'utilisateur</div>
              </div>
            </div>

            <!-- Informations de sécurité -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-primary fw-semibold mb-3">
                  <i class="bi bi-gear me-2"></i>Configuration
                </h6>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-key me-1 text-primary"></i>
                  Nouveau mot de passe
                </label>
                <input type="password" name="mot_de_passe" 
                       class="form-control form-control-lg" placeholder="Laissez vide pour ne pas changer">
                <div class="form-text">Laissez ce champ vide si vous ne souhaitez pas modifier le mot de passe</div>
              </div>
              
              <?php $canEditRole = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
              <?php if ($canEditRole): ?>
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-shield me-1 text-primary"></i>
                  Rôle <span class="text-danger">*</span>
                </label>
                <select name="role" class="form-select form-select-lg" required>
                  <option value="">-- Sélectionner un rôle --</option>
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
                <div class="form-text">Choisir le rôle de l'utilisateur</div>
              </div>
              <?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="row">
              <div class="col-12">
                <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                  <a href="index.php?controller=user&action=index" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-x-circle me-2"></i>Annuler
                  </a>
                  <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-check-circle me-2"></i>Mettre à Jour
                  </button>
                </div>
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

.form-control,
.form-select {
  border: 2px solid #e9ecef;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
  border-color: var(--bs-primary);
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
  transform: translateY(-1px);
}

.form-control-lg,
.form-select-lg {
  padding: 0.75rem 1rem;
  font-size: 1rem;
}

.form-label {
  color: #495057;
  margin-bottom: 0.5rem;
}

.form-text {
  font-size: 0.875rem;
  color: #6c757d;
  margin-top: 0.25rem;
}

.card {
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.btn {
  transition: all 0.2s ease;
  border-radius: 8px;
  font-weight: 500;
}

.btn:hover {
  transform: translateY(-1px);
}

.btn-lg {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
}

.alert {
  border-radius: 8px;
}

.alert-danger {
  background-color: rgba(220, 53, 69, 0.1);
  border: 1px solid rgba(220, 53, 69, 0.2);
  color: #721c24;
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

/* Responsive design */
@media (max-width: 768px) {
  .container-fluid {
    padding: 1rem;
  }
  
  .btn-lg {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
  }
  
  .form-control-lg,
  .form-select-lg {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
  }
}

/* Animation pour les champs requis */
.form-control:required:invalid,
.form-select:required:invalid {
  border-color: #dc3545;
}

.form-control:required:valid,
.form-select:required:valid {
  border-color: #198754;
}

/* Hover effects pour les sections */
.row:hover .col-12 h6 {
  color: var(--blue-violet) !important;
  transition: color 0.3s ease;
}

/* Nouvelles couleurs personnalisées - Dégradés Bleu-Violet */
:root {
  --blue-violet: #4f46e5;
  --blue-violet-rgb: 79, 70, 229;
  --indigo: #6366f1;
  --indigo-rgb: 99, 102, 241;
  --purple: #8b5cf6;
  --purple-rgb: 139, 92, 246;
  --violet: #7c3aed;
  --violet-rgb: 124, 58, 237;
  --blue: #3b82f6;
  --blue-rgb: 59, 130, 246;
}

/* Classes de couleurs personnalisées */
.btn-blue-violet {
  background-color: var(--blue-violet);
  border-color: var(--blue-violet);
  color: white;
}

.btn-blue-violet:hover {
  background-color: #4338ca;
  border-color: #4338ca;
  color: white;
}

.btn-outline-blue-violet {
  color: var(--blue-violet);
  border-color: var(--blue-violet);
}

.btn-outline-blue-violet:hover {
  background-color: var(--blue-violet);
  border-color: var(--blue-violet);
  color: white;
}

.text-blue-violet {
  color: var(--blue-violet) !important;
}

.text-indigo {
  color: var(--indigo) !important;
}

.text-purple {
  color: var(--purple) !important;
}

.text-violet {
  color: var(--violet) !important;
}

.bg-blue-violet {
  background-color: var(--blue-violet) !important;
}

/* Dégradés Bleu-Violet */
.bg-gradient-blue-violet {
  background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
}

.bg-gradient-indigo {
  background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

.bg-gradient-purple {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.bg-gradient-violet {
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
}

/* Focus amélioré pour les champs */
.form-control:focus,
.form-select:focus {
  border-color: var(--blue-violet);
  box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Validation en temps réel
  const form = document.querySelector('.needs-validation');
  const inputs = form.querySelectorAll('input, select, textarea');
  
  inputs.forEach(input => {
    input.addEventListener('blur', function() {
      validateField(this);
    });
    
    input.addEventListener('input', function() {
      if (this.classList.contains('is-invalid')) {
        validateField(this);
      }
    });
  });
  
  function validateField(field) {
    if (field.hasAttribute('required') && !field.value.trim()) {
      field.classList.add('is-invalid');
      field.classList.remove('is-valid');
    } else if (field.hasAttribute('required') && field.value.trim()) {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
    }
  }
  
  // Validation du formulaire avant soumission
  form.addEventListener('submit', function(event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      
      // Afficher les erreurs pour tous les champs
      inputs.forEach(input => {
        validateField(input);
      });
    }
    
    form.classList.add('was-validated');
  });
  
  // Auto-format phone number
  const phoneInput = document.querySelector('input[name="telephone"]');
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
