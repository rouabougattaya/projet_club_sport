<?php
// Vérification des permissions
$isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin');
$isCoach = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'entraineur');
$isSelfCoach = $isCoach && (($_SESSION['user']['id'] ?? null) == $activity['id_entraineur']);
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
                <a href="index.php?controller=activities&action=index" class="text-decoration-none text-blue-violet">
                  <i class="bi bi-calendar-event-fill me-1"></i>Activités
                </a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                <i class="bi bi-info-circle text-blue-violet me-1"></i>Détails de l'activité
              </li>
            </ol>
          </nav>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-calendar-event text-blue-violet me-2"></i>
            <?= htmlspecialchars($activity['nom']) ?>
          </h2>
          <p class="text-muted mb-0">
            <?= $isAdmin ? 'Informations détaillées de l\'activité' : 'Détails de votre activité' ?>
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
            Informations de l'Activité
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Nom de l'activité</label>
              <p class="form-control-plaintext fw-semibold text-dark"><?= htmlspecialchars($activity['nom']) ?></p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Statut</label>
              <p class="form-control-plaintext">
                <span class="badge badge-status badge-<?= $activity['statut'] === 'active' ? 'active' : 'inactive' ?>">
                  <i class="bi bi-<?= $activity['statut'] === 'active' ? 'check-circle' : 'x-circle' ?> me-1"></i>
                  <?= $activity['statut'] === 'active' ? 'Active' : 'Inactive' ?>
                </span>
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Date</label>
              <p class="form-control-plaintext">
                <i class="bi bi-calendar-event text-blue-violet me-2"></i>
                <?= !empty($activity['date_activite']) ? date('d/m/Y', strtotime($activity['date_activite'])) : 'Non définie' ?>
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Heure de début</label>
              <p class="form-control-plaintext">
                <i class="bi bi-clock text-indigo me-2"></i>
                <?= !empty($activity['heure_debut']) ? date('H:i', strtotime($activity['heure_debut'])) : 'Non définie' ?>
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Heure de fin</label>
              <p class="form-control-plaintext">
                <i class="bi bi-clock-fill text-purple me-2"></i>
                <?= !empty($activity['heure_fin']) ? date('H:i', strtotime($activity['heure_fin'])) : 'Non définie' ?>
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Capacité</label>
              <p class="form-control-plaintext">
                <i class="bi bi-people text-violet me-2"></i>
                <?= !empty($activity['capacite']) ? htmlspecialchars($activity['capacite']) : 'Illimitée' ?>
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Places disponibles</label>
              <p class="form-control-plaintext">
                <i class="bi bi-check-circle text-success me-2"></i>
                <?php if (!empty($activity['capacite'])): ?>
                  <span class="fw-semibold text-success"><?= (int)$activity['capacite'] - $inscriptionsCount ?></span> sur <?= htmlspecialchars($activity['capacite']) ?>
                <?php else: ?>
                  <span class="text-muted">Illimitées</span>
                <?php endif; ?>
              </p>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Description</label>
              <p class="form-control-plaintext">
                <?php if (!empty($activity['description'])): ?>
                  <?= nl2br(htmlspecialchars($activity['description'])) ?>
                <?php else: ?>
                  <span class="text-muted">Aucune description disponible</span>
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
            Informations de l'Entraîneur
          </h5>
        </div>
        <div class="card-body">
          <?php if ($coach): ?>
            <div class="mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Nom complet</label>
              <p class="form-control-plaintext">
                <i class="bi bi-person-workspace text-purple me-2"></i>
                <?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom']) ?>
              </p>
            </div>
            <div class="mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Email</label>
              <p class="form-control-plaintext">
                <i class="bi bi-envelope-fill text-indigo me-2"></i>
                <?= htmlspecialchars($coach['email']) ?>
              </p>
            </div>
            <div class="mb-3">
              <label class="form-label text-muted small fw-semibold text-uppercase">Téléphone</label>
              <p class="form-control-plaintext">
                <?php if (!empty($coach['telephone'])): ?>
                  <i class="bi bi-telephone-fill text-blue-violet me-2"></i>
                  <?= htmlspecialchars($coach['telephone']) ?>
                <?php else: ?>
                  <span class="text-muted">Non renseigné</span>
                <?php endif; ?>
              </p>
            </div>
          <?php else: ?>
            <p class="text-muted">Aucun entraîneur assigné</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistiques des inscriptions -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-lg">
        <div class="card-header bg-white border-0 py-3">
          <h5 class="mb-0 text-dark fw-semibold">
            <i class="bi bi-graph-up text-blue-violet me-2"></i>
            Statistiques des Inscriptions
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="text-center">
                <div class="display-4 fw-bold text-blue-violet"><?= $inscriptionsCount ?></div>
                <p class="text-muted mb-0">Inscriptions</p>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="text-center">
                <div class="display-4 fw-bold text-indigo">
                  <?= !empty($activity['capacite']) ? (int)$activity['capacite'] - $inscriptionsCount : '∞' ?>
                </div>
                <p class="text-muted mb-0">Places disponibles</p>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="text-center">
                <div class="display-4 fw-bold text-purple">
                  <?= !empty($activity['capacite']) ? round(($inscriptionsCount / (int)$activity['capacite']) * 100) : 0 ?>%
                </div>
                <p class="text-muted mb-0">Taux de remplissage</p>
              </div>
            </div>
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
            <?php if ($isAdmin || $isSelfCoach): ?>
              <div class="col-md-3 mb-3">
                <div class="d-grid">
                  <a href="index.php?controller=activities&action=edit&id=<?= urlencode($activity['id']) ?>" 
                     class="btn btn-outline-blue-violet">
                    <i class="bi bi-pencil-square me-2"></i>Modifier l'activité
                  </a>
                </div>
              </div>
            <?php endif; ?>
            <?php if ($isAdmin): ?>
              <div class="col-md-3 mb-3">
                <div class="d-grid">
                  <a href="index.php?controller=activities&action=delete&id=<?= urlencode($activity['id']) ?>" 
                     class="btn btn-outline-danger"
                     onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ? Cette action est irréversible.')">
                    <i class="bi bi-trash3 me-2"></i>Supprimer l'activité
                  </a>
                </div>
              </div>
            <?php endif; ?>
            <div class="col-md-3 mb-3">
              <div class="d-grid">
                <a href="index.php?controller=activities&action=index" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="d-grid">
                <a href="index.php?controller=inscriptions&action=index&activity_id=<?= urlencode($activity['id']) ?>" 
                   class="btn btn-outline-indigo">
                  <i class="bi bi-people me-2"></i>Gérer les inscriptions
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

.btn-outline-indigo {
  color: var(--indigo);
  border-color: var(--indigo);
}

.btn-outline-indigo:hover {
  background-color: var(--indigo);
  border-color: var(--indigo);
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

.text-success {
  color: #16a34a !important;
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

/* Badges optimisés pour Statut et Inscriptions */
.badge-status {
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

.badge-status.badge-active {
  background-color: rgba(34, 197, 94, 0.1);
  color: #16a34a;
  border: 1px solid rgba(34, 197, 94, 0.3);
}

.badge-status.badge-inactive {
  background-color: rgba(239, 68, 68, 0.1);
  color: #dc2626;
  border: 1px solid rgba(239, 68, 68, 0.3);
}

.badge-inscription {
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

.badge-inscription.badge-active {
  background-color: rgba(34, 197, 94, 0.1);
  color: #16a34a;
  border: 1px solid rgba(34, 197, 94, 0.3);
}

.badge-inscription.badge-inactive {
  background-color: rgba(239, 68, 68, 0.1);
  color: #dc2626;
  border: 1px solid rgba(239, 68, 68, 0.3);
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
  
  .display-4 {
    font-size: 2rem;
  }
}
</style>
