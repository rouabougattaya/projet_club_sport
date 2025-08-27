<div class="container-fluid px-4 py-3">
  <!-- Header avec navigation -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-person-plus-fill text-blue-violet me-2"></i>
            Ajouter un Nouvel Utilisateur
          </h2>
          <p class="text-muted mb-0">
            Créez un nouveau compte utilisateur dans le système
          </p>
        </div>
        <a href="index.php?controller=user&action=index" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-2"></i>Retour aux Utilisateurs
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
            <i class="bi bi-form-text me-2 text-blue-violet"></i>
            Informations de l'Utilisateur
          </h5>
        </div>
        <div class="card-body p-4">
          <form method="post" id="createUserForm">
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
                <input type="text" name="nom" id="nom" class="form-control form-control-lg" 
                       placeholder="Entrez le nom de famille">
                <div class="invalid-feedback" id="nom-error"></div>
                <div class="form-text">Nom de famille de l'utilisateur</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-person me-1 text-blue-violet"></i>
                  Prénom <span class="text-danger">*</span>
                </label>
                <input type="text" name="prenom" id="prenom" class="form-control form-control-lg" 
                       placeholder="Entrez le prénom">
                <div class="invalid-feedback" id="prenom-error"></div>
                <div class="form-text">Prénom de l'utilisateur</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-card-text me-1 text-blue-violet"></i>
                  CIN <span class="text-danger">*</span>
                </label>
                <input type="text" name="cin" id="cin" class="form-control form-control-lg" 
                       placeholder="Ex: 12345678" maxlength="8" pattern="\d{8}">
                <div class="invalid-feedback" id="cin-error"></div>
                <div class="form-text">Numéro de carte d'identité nationale (exactement 8 chiffres)</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-gender-ambiguous me-1 text-blue-violet"></i>
                  Genre <span class="text-danger">*</span>
                </label>
                <select name="genre" id="genre" class="form-select form-select-lg">
                  <option value="">Sélectionnez le genre</option>
                  <option value="Homme">Homme</option>
                  <option value="Femme">Femme</option>
                </select>
                <div class="invalid-feedback" id="genre-error"></div>
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
                  Adresse <span class="text-danger">*</span>
                </label>
                <input type="text" name="adresse" id="adresse" class="form-control form-control-lg" 
                       placeholder="Ex: Rue de la Paix, Ville">
                <div class="invalid-feedback" id="adresse-error"></div>
                <div class="form-text">Adresse complète (lettres, espaces, tirets et apostrophes uniquement)</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-telephone me-1 text-blue-violet"></i>
                  Téléphone <span class="text-danger">*</span>
                </label>
                <input type="tel" name="telephone" id="telephone" class="form-control form-control-lg" 
                       placeholder="Numéro de téléphone">
                <div class="invalid-feedback" id="telephone-error"></div>
                <div class="form-text">Numéro de téléphone de contact</div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-envelope me-1 text-blue-violet"></i>
                  Email <span class="text-danger">*</span>
                </label>
                <input type="email" name="email" id="email" class="form-control form-control-lg" 
                       placeholder="adresse@email.com">
                <div class="invalid-feedback" id="email-error"></div>
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
                  Mot de passe <span class="text-danger">*</span>
                </label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control form-control-lg" 
                       placeholder="Mot de passe sécurisé">
                <div class="invalid-feedback" id="mot_de_passe-error"></div>
                <div class="form-text">Mot de passe pour l'accès au système</div>
              </div>
              
              <?php $isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
              <?php if ($isAdmin): ?>
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-shield me-1 text-primary"></i>
                  Rôle <span class="text-danger">*</span>
                </label>
                <select name="role" id="role" class="form-select form-select-lg">
                  <option value="">-- Sélectionner un rôle --</option>
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
                <div class="invalid-feedback" id="role-error"></div>
                <div class="form-text">Choisir le rôle de l'utilisateur</div>
              </div>
              <?php else: ?>
                <input type="hidden" name="role" value="adherent">
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
                    <i class="bi bi-check-circle me-2"></i>Créer l'Utilisateur
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
  const form = document.getElementById('createUserForm');
  const nomInput = document.getElementById('nom');
  const prenomInput = document.getElementById('prenom');
  const emailInput = document.getElementById('email');
  const motDePasseInput = document.getElementById('mot_de_passe');
  const roleInput = document.getElementById('role');
  const telephoneInput = document.querySelector('input[name="telephone"]');

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
      if (!value.trim()) return { valid: false, message: 'Le nom est obligatoire' };
      if (value.trim().length < 2) return { valid: false, message: 'Le nom doit contenir au moins 2 caractères' };
      if (!/^[a-zA-ZÀ-ÿ\s'-]+$/.test(value.trim())) return { valid: false, message: 'Le nom ne peut contenir que des lettres, espaces, tirets et apostrophes' };
      return { valid: true, message: '' };
    },
    prenom: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le prénom est obligatoire' };
      if (value.trim().length < 2) return { valid: false, message: 'Le prénom doit contenir au moins 2 caractères' };
      if (!/^[a-zA-ZÀ-ÿ\s'-]+$/.test(value.trim())) return { valid: false, message: 'Le prénom ne peut contenir que des lettres, espaces, tirets et apostrophes' };
      return { valid: true, message: '' };
    },
    email: (value) => {
      if (!value.trim()) return { valid: false, message: 'L\'email est obligatoire' };
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value.trim())) return { valid: false, message: 'Format d\'email invalide' };
      return { valid: true, message: '' };
    },
    mot_de_passe: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le mot de passe est obligatoire' };
      if (value.length < 6) return { valid: false, message: 'Le mot de passe doit contenir au moins 6 caractères' };
      if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) return { valid: false, message: 'Le mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre' };
      return { valid: true, message: '' };
    },
    role: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le rôle est obligatoire' };
      if (!['admin', 'entraineur', 'adherent'].includes(value)) return { valid: false, message: 'Rôle invalide' };
      return { valid: true, message: '' };
    },
    cin: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le CIN est obligatoire' };
      if (!/^\d{8}$/.test(value.trim())) return { valid: false, message: 'Le CIN doit contenir exactement 8 chiffres' };
      return { valid: true, message: '' };
    },
    genre: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le genre est obligatoire' };
      if (!['Homme', 'Femme'].includes(value)) return { valid: false, message: 'Genre invalide' };
      return { valid: true, message: '' };
    },
    adresse: (value) => {
      if (!value.trim()) return { valid: false, message: 'L\'adresse est obligatoire' };
      if (value.trim().length < 10) return { valid: false, message: 'L\'adresse doit contenir au moins 10 caractères' };
      if (value.trim().length > 200) return { valid: false, message: 'L\'adresse ne peut pas dépasser 200 caractères' };
      if (!/^[a-zA-ZÀ-ÿ\s\-\'\.]+$/.test(value.trim())) return { valid: false, message: 'L\'adresse ne peut contenir que des lettres, espaces, tirets et apostrophes' };
      return { valid: true, message: '' };
    },
    telephone: (value) => {
      if (!value.trim()) return { valid: false, message: 'Le téléphone est obligatoire' };
      const phoneRegex = /^[\d\s\-\+\(\)]+$/;
      if (!phoneRegex.test(value.trim())) return { valid: false, message: 'Format de téléphone invalide' };
      if (value.trim().replace(/\D/g, '').length < 8) return { valid: false, message: 'Le numéro doit contenir au moins 8 chiffres' };
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

  // Auto-format pour le numéro de téléphone
  if (telephoneInput) {
    telephoneInput.addEventListener('input', function(e) {
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
