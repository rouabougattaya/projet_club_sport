<?php
// Vérification des permissions
$isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin');
$isSelf = !empty($_SESSION['user']) && (($_SESSION['user']['id'] ?? null) == $user['id']);
?>

<div class="container-fluid px-4 py-3">
  <!-- Header avec navigation -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
              <li class="breadcrumb-item">
                <a href="index.php?controller=user&action=index" class="text-decoration-none text-blue-violet">
                  <i class="bi bi-people-fill me-1"></i>Utilisateurs
                </a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                <i class="bi bi-person-circle text-blue-violet me-1"></i>Détails de l'utilisateur
              </li>
            </ol>
          </nav>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-person-circle text-blue-violet me-2"></i>
            Profil de <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
          </h2>
          <p class="text-muted mb-0">
            <?= $isAdmin ? 'Informations détaillées de l\'utilisateur' : 'Vos informations personnelles' ?>
          </p>
        </div>
    
      </div>
    </div>
  </div>



 

  <!-- Informations principales -->
  <div class="row mb-4">
    <div class="col-lg-8">
      <div class="card border-0 shadow-lg h-100">
        <div class="card-header bg-white border-0 py-3">
          <h5 class="mb-0 text-dark fw-semibold">
            <i class="bi bi-info-circle text-blue-violet me-2"></i>
            Informations Personnelles
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Nom</label>
              <p class="form-control-plaintext fw-semibold text-dark"><?= htmlspecialchars($user['nom']) ?></p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Prénom</label>
              <p class="form-control-plaintext fw-semibold text-dark"><?= htmlspecialchars($user['prenom']) ?></p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">CIN</label>
              <p class="form-control-plaintext">
                <?= !empty($user['cin']) ? htmlspecialchars($user['cin']) : '<span class="text-muted">Non renseigné</span>' ?>
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Genre</label>
              <p class="form-control-plaintext">
                <?php if (!empty($user['genre'])): ?>
                  <span class="badge badge-genre badge-<?= $user['genre'] === 'Homme' ? 'male' : 'female' ?>">
                    <i class="bi bi-<?= $user['genre'] === 'Homme' ? 'gender-male' : 'gender-female' ?> me-1"></i>
                    <?= htmlspecialchars($user['genre']) ?>
                  </span>
                <?php else: ?>
                  <span class="text-muted">Non renseigné</span>
                <?php endif; ?>
              </p>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Adresse</label>
              <p class="form-control-plaintext">
                <?php if (!empty($user['adresse'])): ?>
                  <i class="bi bi-geo-alt-fill text-blue-violet me-2"></i>
                  <?= htmlspecialchars($user['adresse']) ?>
                <?php else: ?>
                  <span class="text-muted">Non renseignée</span>
                <?php endif; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card border-0 shadow-lg h-100">
        <div class="card-header bg-white border-0 py-3">
          <h5 class="mb-0 text-dark fw-semibold">
            <i class="bi bi-shield-check text-blue-violet me-2"></i>
            Informations de Contact
          </h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label text-muted small fw-semibold text-uppercase">Email</label>
            <p class="form-control-plaintext">
              <i class="bi bi-envelope-fill text-purple me-2"></i>
              <?= htmlspecialchars($user['email']) ?>
            </p>
          </div>
          <div class="mb-3">
            <label class="form-label text-muted small fw-semibold text-uppercase">Téléphone</label>
            <p class="form-control-plaintext">
              <?php if (!empty($user['telephone'])): ?>
                <i class="bi bi-telephone-fill text-indigo me-2"></i>
                <?= htmlspecialchars($user['telephone']) ?>
              <?php else: ?>
                <span class="text-muted">Non renseigné</span>
              <?php endif; ?>
            </p>
          </div>
          <div class="mb-3">
            <label class="form-label text-muted small fw-semibold text-uppercase">Rôle</label>
            <p class="form-control-plaintext">
              <span class="badge badge-role badge-<?= $user['role'] ?> fs-6">
                <i class="bi bi-<?= $user['role'] === 'admin' ? 'shield-fill-check' : ($user['role'] === 'entraineur' ? 'person-workspace' : 'person-check-fill') ?> me-1"></i>
                <?= htmlspecialchars(ucfirst($user['role'])) ?>
              </span>
            </p>
          </div>
          <div class="mb-3">
            <label class="form-label text-muted small fw-semibold text-uppercase">Date de création</label>
            <p class="form-control-plaintext">
              <i class="bi bi-calendar-event text-blue-violet me-2"></i>
              <?= !empty($user['created_at']) ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'Non disponible' ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Actions disponibles -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-lg">
        <div class="card-header bg-white border-0 py-3">
          <h5 class="mb-0 text-dark fw-semibold">
            <i class="bi bi-gear text-blue-violet me-2"></i>
            Actions Disponibles
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="d-grid">
                <a href="index.php?controller=user&action=edit&id=<?= urlencode($user['id']) ?>" 
                   class="btn btn-outline-blue-violet">
                  <i class="bi bi-pencil-square me-2"></i>Modifier le profil
                </a>
              </div>
            </div>
            <?php if ($isAdmin && !$isSelf): ?>
              <div class="col-md-4 mb-3">
                <div class="d-grid">
                  <a href="index.php?controller=user&action=delete&id=<?= urlencode($user['id']) ?>" 
                     class="btn btn-outline-danger"
                     onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                    <i class="bi bi-trash3 me-2"></i>Supprimer l'utilisateur
                  </a>
                </div>
              </div>
            <?php endif; ?>
            <div class="col-md-4 mb-3">
              <div class="d-grid">
                <a href="index.php?controller=user&action=index" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Variables CSS cohérentes avec le thème existant */
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

/* Badges optimisés pour Genre et Rôle */
.badge-genre {
  font-size: 0.7rem;
  padding: 0.4em 0.6em;
  font-weight: 600;
  border-radius: 12px;
  min-width: auto;
  text-align: center;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
}

.badge-genre.badge-male {
  background-color: rgba(79, 70, 229, 0.1);
  color: var(--blue-violet);
  border: 1px solid rgba(79, 70, 229, 0.3);
}

.badge-genre.badge-female {
  background-color: rgba(139, 92, 246, 0.1);
  color: var(--purple);
  border: 1px solid rgba(139, 92, 246, 0.3);
}

.badge-role {
  font-size: 0.7rem;
  padding: 0.4em 0.6em;
  font-weight: 600;
  border-radius: 12px;
  min-width: auto;
  text-align: center;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
}

.badge-role.badge-admin {
  background-color: rgba(124, 58, 237, 0.1);
  color: var(--violet);
  border: 1px solid rgba(124, 58, 237, 0.3);
}

.badge-role.badge-entraineur {
  background-color: rgba(79, 70, 229, 0.1);
  color: var(--blue-violet);
  border: 1px solid rgba(79, 70, 229, 0.3);
}

.badge-role.badge-adherent {
  background-color: rgba(99, 102, 241, 0.1);
  color: var(--indigo);
  border: 1px solid rgba(99, 102, 241, 0.3);
}

/* Styles pour les cartes */
.card {
  transition: all 0.3s ease;
  border-radius: 12px;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Styles pour les boutons */
.btn {
  transition: all 0.2s ease;
  border-radius: 8px;
}

.btn:hover {
  transform: translateY(-1px);
}

/* Breadcrumb personnalisé */
.breadcrumb-item a {
  color: var(--blue-violet);
  text-decoration: none;
}

.breadcrumb-item a:hover {
  color: #4338ca;
  text-decoration: underline;
}

.breadcrumb-item.active {
  color: var(--blue-violet);
  font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
  .breadcrumb {
    font-size: 0.875rem;
  }
  
  .h3 {
    font-size: 1.5rem;
  }
  
  .card-body {
    padding: 1rem;
  }
}
</style>
