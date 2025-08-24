<div class="container-fluid px-4 py-3">
  <!-- Header avec navigation -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-plus-circle-fill text-primary me-2"></i>
            Créer une Nouvelle Activité
          </h2>
          <p class="text-muted mb-0">
            Ajoutez une nouvelle activité au planning du club
          </p>
        </div>
        <a href="index.php?controller=activities&action=index" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>Retour aux Activités
        </a>
      </div>
    </div>
  </div>

  <!-- Formulaire de création -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
          <h5 class="mb-0 text-dark fw-semibold">
            <i class="bi bi-form-text me-2 text-primary"></i>
            Informations de l'Activité
          </h5>
        </div>
        <div class="card-body p-4">
          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger border-0 shadow-sm">
              <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill text-danger me-2 fs-4"></i>
                <div>
                  <h6 class="alert-heading mb-1">Erreurs de validation</h6>
                  <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                      <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <form method="post" class="needs-validation" novalidate>
            <!-- Informations de base -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-primary fw-semibold mb-3">
                  <i class="bi bi-info-circle me-2"></i>Informations Générales
                </h6>
              </div>
              
              <div class="col-md-8">
                <label class="form-label fw-semibold">
                  <i class="bi bi-calendar-event me-1 text-primary"></i>
                  Nom de l'Activité <span class="text-danger">*</span>
                </label>
                <input type="text" name="nom" class="form-control form-control-lg" 
                       required value="<?= htmlspecialchars($old['nom'] ?? '') ?>"
                       placeholder="Ex: Cours de natation, Entraînement football...">
                <div class="form-text">Donnez un nom clair et descriptif à votre activité</div>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-people me-1 text-primary"></i>
                  Capacité Maximale
                </label>
                <input type="number" name="capacite" class="form-control form-control-lg" 
                       min="1" value="<?= htmlspecialchars($old['capacite'] ?? '20') ?>"
                       placeholder="20">
                <div class="form-text">Nombre maximum de participants</div>
              </div>
            </div>

            <!-- Planning et horaires -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-primary fw-semibold mb-3">
                  <i class="bi bi-clock me-2"></i>Planning et Horaires
                </h6>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-calendar-date me-1 text-primary"></i>
                  Date de l'Activité
                </label>
                <input type="date" name="date_activite" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($old['date_activite'] ?? '') ?>"
                       min="<?= date('Y-m-d') ?>">
                <div class="form-text">Date à laquelle l'activité se déroule</div>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-play-circle me-1 text-success"></i>
                  Heure de Début
                </label>
                <input type="time" name="heure_debut" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($old['heure_debut'] ?? '') ?>">
                <div class="form-text">Heure de début de l'activité</div>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-stop-circle me-1 text-danger"></i>
                  Heure de Fin
                </label>
                <input type="time" name="heure_fin" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($old['heure_fin'] ?? '') ?>">
                <div class="form-text">Heure de fin de l'activité</div>
              </div>
            </div>

            <!-- Statut et coach -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-primary fw-semibold mb-3">
                  <i class="bi bi-gear me-2"></i>Configuration
                </h6>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-toggle-on me-1 text-primary"></i>
                  Statut de l'Activité
                </label>
                <select name="statut" class="form-select form-select-lg">
                  <?php $s = trim((string)($old['statut'] ?? 'active')); $isActive = ($s === 'active'); ?>
                  <option value="active" <?= $isActive ? 'selected' : '' ?>>
                    <i class="bi bi-check-circle me-2"></i>Actif
                  </option>
                  <option value="Inactif" <?= !$isActive ? 'selected' : '' ?>>
                    <i class="bi bi-pause-circle me-2"></i>Inactif
                  </option>
                </select>
                <div class="form-text">Définir si l'activité est disponible</div>
              </div>
              
              <?php if (!empty($isAdmin) && $isAdmin): ?>
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-person-workspace me-1 text-primary"></i>
                  Entraîneur Responsable <span class="text-danger">*</span>
                </label>
                <select name="id_entraineur" class="form-select form-select-lg" required>
                  <option value="">-- Sélectionner un entraîneur --</option>
                  <?php foreach ($coaches as $coach): ?>
                    <option value="<?= (int)$coach['id'] ?>" 
                            <?= (isset($old['id_entraineur']) && (int)$old['id_entraineur'] === (int)$coach['id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom']) ?>
                      <small class="text-muted">(ID: <?= $coach['id'] ?>)</small>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="form-text">Choisir l'entraîneur qui encadrera l'activité</div>
              </div>
              <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-primary fw-semibold mb-3">
                  <i class="bi bi-text-paragraph me-2"></i>Description Détaillée
                </h6>
              </div>
              
              <div class="col-12">
                <label class="form-label fw-semibold">
                  <i class="bi bi-card-text me-1 text-primary"></i>
                  Description de l'Activité
                </label>
                <textarea name="description" class="form-control" rows="5" 
                          placeholder="Décrivez en détail le contenu de l'activité, les objectifs, le matériel nécessaire, etc..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                <div class="form-text">
                  <i class="bi bi-lightbulb me-1"></i>
                  Une description claire aide les participants à comprendre l'activité
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="row">
              <div class="col-12">
                <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                  <a href="index.php?controller=activities&action=index" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-x-circle me-2"></i>Annuler
                  </a>
                  <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-check-circle me-2"></i>Créer l'Activité
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
  color: var(--bs-primary) !important;
  transition: color 0.3s ease;
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
  
  // Validation de la date (pas de date passée)
  const dateInput = document.querySelector('input[name="date_activite"]');
  if (dateInput) {
    dateInput.addEventListener('change', function() {
      const selectedDate = new Date(this.value);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      
      if (selectedDate < today) {
        this.setCustomValidity('La date ne peut pas être dans le passé');
        this.classList.add('is-invalid');
      } else {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
      }
    });
  }
  
  // Validation des heures (fin > début)
  const startTimeInput = document.querySelector('input[name="heure_debut"]');
  const endTimeInput = document.querySelector('input[name="heure_fin"]');
  
  function validateTimeRange() {
    if (startTimeInput.value && endTimeInput.value) {
      if (startTimeInput.value >= endTimeInput.value) {
        endTimeInput.setCustomValidity('L\'heure de fin doit être après l\'heure de début');
        endTimeInput.classList.add('is-invalid');
      } else {
        endTimeInput.setCustomValidity('');
        endTimeInput.classList.remove('is-invalid');
      }
    }
  }
  
  if (startTimeInput && endTimeInput) {
    startTimeInput.addEventListener('change', validateTimeRange);
    endTimeInput.addEventListener('change', validateTimeRange);
  }
});
</script>


