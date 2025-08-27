<div class="container-fluid px-4 py-3">
  <!-- Header avec navigation -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-pencil-square text-blue-violet me-2"></i>
            Modifier l'Activité
          </h2>
          <p class="text-muted mb-0">
            Modifiez les informations de l'activité : <?= htmlspecialchars($activity['nom']) ?>
          </p>
        </div>
        <a href="index.php?controller=activities&action=index" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>Retour aux Activités
        </a>
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
            Modifier les Informations
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

          <form method="post" id="editActivityForm">
            <!-- Informations de base -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-blue-violet fw-semibold mb-3">
                  <i class="bi bi-info-circle me-2"></i>Informations Générales
                </h6>
              </div>
              
              <div class="col-md-8">
                <label class="form-label fw-semibold">
                  <i class="bi bi-calendar-event me-1 text-blue-violet"></i>
                  Nom de l'Activité <span class="text-danger">*</span>
                </label>
                <input type="text" name="nom" id="nom" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($activity['nom']) ?>"
                       placeholder="Ex: Cours de natation, Entraînement football...">
                <div class="invalid-feedback" id="nom-error"></div>
                <div class="form-text">Donnez un nom clair et descriptif à votre activité</div>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-people me-1 text-blue-violet"></i>
                  Capacité Maximale
                </label>
                <input type="number" name="capacite" id="capacite" class="form-control form-control-lg" 
                       min="1" value="<?= htmlspecialchars($activity['capacite'] ?? '20') ?>"
                       placeholder="20">
                <div class="invalid-feedback" id="capacite-error"></div>
                <div class="form-text">Nombre maximum de participants</div>
              </div>
            </div>

            <!-- Planning et horaires -->
            <div class="row g-4 mb-4">
              <div class="col-12">
                <h6 class="text-blue-violet fw-semibold mb-3">
                  <i class="bi bi-clock me-2"></i>Planning et Horaires
                </h6>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-calendar-date me-1 text-blue-violet"></i>
                  Date de l'Activité
                </label>
                <input type="date" name="date_activite" id="date_activite" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($activity['date_activite'] ?? '') ?>"
                       min="<?= date('Y-m-d') ?>">
                <div class="invalid-feedback" id="date_activite-error"></div>
                <div class="form-text">Date à laquelle l'activité se déroule</div>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-play-circle me-1 text-success"></i>
                  Heure de Début
                </label>
                <input type="time" name="heure_debut" id="heure_debut" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($activity['heure_debut'] ?? '') ?>">
                <div class="invalid-feedback" id="heure_debut-error"></div>
                <div class="form-text">Heure de début de l'activité</div>
              </div>
              
              <div class="col-md-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-stop-circle me-1 text-danger"></i>
                  Heure de Fin
                </label>
                <input type="time" name="heure_fin" id="heure_fin" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($activity['heure_fin'] ?? '') ?>">
                <div class="invalid-feedback" id="heure_fin-error"></div>
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
                <select name="statut" id="statut" class="form-select form-select-lg">
                  <?php $s = trim((string)($activity['statut'] ?? 'active')); $isActive = ($s === 'active'); ?>
                  <option value="active" <?= $isActive ? 'selected' : '' ?>>
                    <i class="bi bi-check-circle me-2"></i>Actif
                  </option>
                  <option value="Inactif" <?= !$isActive ? 'selected' : '' ?>>
                    <i class="bi bi-pause-circle me-2"></i>Inactif
                  </option>
                </select>
                <div class="invalid-feedback" id="statut-error"></div>
                <div class="form-text">Définir si l'activité est disponible</div>
              </div>
              
              <?php if (!empty($isAdmin) && $isAdmin): ?>
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-person-workspace me-1 text-primary"></i>
                  Entraîneur Responsable <span class="text-danger">*</span>
                </label>
                <select name="id_entraineur" id="id_entraineur" class="form-select form-select-lg">
                  <option value="">-- Sélectionner un entraîneur --</option>
                  <?php foreach ($coaches as $coach): ?>
                    <option value="<?= (int)$coach['id'] ?>" 
                            <?= ((int)$activity['id_entraineur'] === (int)$coach['id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom']) ?>
                      <small class="text-muted">(ID: <?= $coach['id'] ?>)</small>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback" id="id_entraineur-error"></div>
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
                <textarea name="description" id="description" class="form-control" rows="5" 
                          placeholder="Décrivez en détail le contenu de l'activité, les objectifs, le matériel nécessaire, etc..."><?= htmlspecialchars($activity['description']) ?></textarea>
                <div class="invalid-feedback" id="description-error"></div>
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
                    <i class="bi bi-check-circle me-2"></i>Enregistrer les Modifications
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
  // Récupération des éléments du formulaire
  const form = document.getElementById('editActivityForm');
  const nomInput = document.getElementById('nom');
  const capaciteInput = document.getElementById('capacite');
  const dateActiviteInput = document.getElementById('date_activite');
  const heureDebutInput = document.getElementById('heure_debut');
  const heureFinInput = document.getElementById('heure_fin');

  // Fonction de validation des champs
  function validateField(field, validationFunction) {
    const errorElement = document.getElementById(field.id + '-error');
    const result = validationFunction(field.value);
    
    if (result.valid) {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
      errorElement.textContent = '';
    } else {
      field.classList.remove('is-valid');
      field.classList.add('is-invalid');
      errorElement.textContent = result.message;
    }
    return result.valid;
  }

  // Règles de validation personnalisées
  const validations = {
    nom: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le nom de l\'activité est obligatoire' };
      if (value.trim().length < 3) return { valid: false, message: 'Le nom doit contenir au moins 3 caractères' };
      if (value.trim().length > 100) return { valid: false, message: 'Le nom ne peut pas dépasser 100 caractères' };
      // Vérification des caractères autorisés : lettres uniquement, espaces, tirets, apostrophes, points
      if (!/^[a-zA-ZÀ-ÿ\s\-\'\.]+$/.test(value.trim())) {
        return { valid: false, message: 'Le nom ne peut contenir que des lettres, espaces, tirets, apostrophes et points' };
      }
      return { valid: true, message: '' };
    },
    capacite: (value) => {
      if (!value.trim()) return { valid: false, message: 'La capacité est obligatoire' };
      const capacite = parseInt(value);
      if (isNaN(capacite) || capacite < 1) return { valid: false, message: 'La capacité doit être un nombre positif' };
      if (capacite > 1000) return { valid: false, message: 'La capacité ne peut pas dépasser 1000' };
      return { valid: true, message: '' };
    },
    date_activite: (value) => {
      if (!value.trim()) return { valid: false, message: 'La date est obligatoire' };
      const selectedDate = new Date(value);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      
      if (selectedDate < today) return { valid: false, message: 'La date ne peut pas être dans le passé' };
      return { valid: true, message: '' };
    },
    heure_debut: (value) => {
      if (!value.trim()) return { valid: false, message: 'L\'heure de début est obligatoire' };
      return { valid: true, message: '' };
    },
    heure_fin: (value) => {
      if (!value.trim()) return { valid: false, message: 'L\'heure de fin est obligatoire' };
      if (heureDebutInput.value && value <= heureDebutInput.value) {
        return { valid: false, message: 'L\'heure de fin doit être après l\'heure de début' };
      }
      return { valid: true, message: '' };
    },
    statut: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le statut est obligatoire' };
      if (!['active', 'Inactif'].includes(value)) return { valid: false, message: 'Statut invalide' };
      return { valid: true, message: '' };
    },
    description: (value) => {
      if (!value.trim()) return { valid: false, message: 'La description est obligatoire' };
      if (value.trim().length < 10) return { valid: false, message: 'La description doit contenir au moins 10 caractères' };
      if (value.trim().length > 1000) return { valid: false, message: 'La description ne peut pas dépasser 1000 caractères' };
      // Vérification des caractères autorisés : lettres uniquement, espaces, ponctuation, tirets, apostrophes
      if (!/^[a-zA-ZÀ-ÿ\s\-\'\.\,\!\?\:\;\(\)]+$/.test(value.trim())) {
        return { valid: false, message: 'La description ne peut contenir que des lettres, espaces et ponctuation autorisée' };
      }
      return { valid: true, message: '' };
    }
  };

  // Validation en temps réel pour chaque champ
  Object.keys(validations).forEach(fieldName => {
    const field = document.getElementById(fieldName);
    if (field) {
      // Validation au chargement si le champ a une valeur
      if (field.value.trim()) {
        validateField(field, validations[fieldName]);
      }
      
      // Validation quand on quitte le champ
      field.addEventListener('blur', function() {
        validateField(this, validations[fieldName]);
      });
      
      // Validation aussi au changement pour feedback immédiat
      field.addEventListener('input', function() {
        if (this.value.trim()) {
          validateField(this, validations[fieldName]);
        } else {
          // Si le champ devient vide, afficher l'erreur
          this.classList.remove('is-valid');
          this.classList.add('is-invalid');
          const errorElement = document.getElementById(this.id + '-error');
          if (errorElement) {
            errorElement.textContent = validations[fieldName]('').message;
          }
        }
      });
      
      // Validation spéciale pour les heures (vérifier la cohérence)
      if (fieldName === 'heure_debut' || fieldName === 'heure_fin') {
        field.addEventListener('change', function() {
          if (heureDebutInput.value && heureFinInput.value) {
            validateField(heureFinInput, validations.heure_fin);
          }
        });
      }
    }
  });

  // Validation du formulaire avant soumission
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    let isFormValid = true;
    
    // Valider tous les champs obligatoires
    Object.keys(validations).forEach(fieldName => {
      const field = document.getElementById(fieldName);
      if (field) {
        const isValid = validateField(field, validations[fieldName]);
        if (!isValid) {
          isFormValid = false;
        }
      }
    });

    // Si le formulaire est valide, le soumettre
    if (isFormValid) {
      form.submit();
    }
  });

  // Contrôle de saisie en temps réel pour le nom de l'activité
  if (nomInput) {
    nomInput.addEventListener('input', function(e) {
      // Filtrer les caractères non autorisés (pas de chiffres)
      const allowedChars = /[a-zA-ZÀ-ÿ\s\-\'\.]/;
      let value = this.value;
      let filteredValue = '';
      
      for (let i = 0; i < value.length; i++) {
        if (allowedChars.test(value[i])) {
          filteredValue += value[i];
        }
      }
      
      if (filteredValue !== value) {
        this.value = filteredValue;
      }
    });

    // Empêcher le collage de caractères non autorisés
    nomInput.addEventListener('paste', function(e) {
      e.preventDefault();
      const pastedText = (e.clipboardData || window.clipboardData).getData('text');
      const cleanText = pastedText.replace(/[^a-zA-ZÀ-ÿ\s\-\'\.]/g, '');
      this.value = cleanText;
    });
  }
});
</script>


