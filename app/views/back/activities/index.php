<div class="container-fluid px-4 py-3">
  <!-- Header avec statistiques -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <?php $isAdmin = !empty($isAdmin) && $isAdmin; ?>
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-calendar-event-fill text-primary me-2"></i>
            <?= $isAdmin ? 'Gestion des Activités' : 'Mes Activités' ?>
          </h2>
          <p class="text-muted mb-0">
            <?= $isAdmin ? 'Administration complète du planning des activités' : 'Gérez vos activités programmées' ?>
          </p>
        </div>
        <a href="index.php?controller=activities&action=create" class="btn btn-primary btn-lg shadow-sm">
          <i class="bi bi-plus-circle-fill me-2"></i>
          Nouvelle Activité
        </a>
      </div>
    </div>
  </div>

  <!-- Statistiques rapides -->
  <?php if ($isAdmin): ?>
    <div class="row mb-4">
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-primary bg-gradient text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1"><?= count($activities) ?></h4>
                <p class="mb-0 opacity-75">Total Activités</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-calendar-event-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-success bg-gradient text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1">
                  <?php
                    $activeCount = 0;
                    foreach ($activities as $activity) {
                      if (isset($activity['statut']) && trim($activity['statut']) === 'active') {
                        $activeCount++;
                      }
                    }
                    echo $activeCount;
                  ?>
                </h4>
                <p class="mb-0 opacity-75">Activités Actives</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-check-circle-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-info bg-gradient text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1">
                  <?php
                    $upcomingCount = 0;
                    $now = new DateTime();
                    foreach ($activities as $activity) {
                      if (!empty($activity['date_activite']) && !empty($activity['heure_debut'])) {
                        // Créer un DateTime pour le début de l'activité
                        $activityStartTime = new DateTime($activity['date_activite'] . ' ' . $activity['heure_debut']);
                        
                        // L'activité est à venir si elle n'a pas encore commencé
                        if ($activityStartTime > $now) {
                          $upcomingCount++;
                        }
                      }
                    }
                    echo $upcomingCount;
                  ?>
                </h4>
                <p class="mb-0 opacity-75">À Venir</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-clock-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-warning bg-gradient text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1">
                  <?php
                    $availableActivities = 0;
                    foreach ($activities as $activity) {
                      if (!empty($activity['capacite']) && (int)$activity['capacite'] > 0) {
                        $inscriptionsCount = (int)($activity['inscriptions_count'] ?? 0);
                        $capacity = (int)$activity['capacite'];
                        if ($inscriptionsCount < $capacity) {
                          $availableActivities++;
                        }
                      }
                    }
                    echo $availableActivities;
                  ?>
                </h4>
                <p class="mb-0 opacity-75">Activités Disponibles</p>
                <small class="opacity-75">
                  Avec places libres
                </small>
              </div>
              <div class="align-self-center">
                <i class="bi bi-people-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Tableau des activités -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-semibold">
          <i class="bi bi-table me-2 text-primary"></i>
          Liste des Activités
        </h5>
        <div class="d-flex gap-2">
          <div class="input-group" style="width: 300px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" id="searchInput"
                   placeholder="Rechercher une activité...">
            <button class="btn btn-outline-secondary" type="button" id="clearSearch" title="Effacer la recherche">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="activitiesTable" style="width: 100%;">
          <thead class="table-light">
            <tr>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 20%;">
                <i class="bi bi-calendar-event me-1 text-primary"></i>Activité
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 12%;">
                <i class="bi bi-calendar-date me-1 text-primary"></i>Date
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 10%;">
                <i class="bi bi-clock me-1 text-primary"></i>Horaire
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 8%;">
                <i class="bi bi-people me-1 text-primary"></i>Capacité
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 8%;">
                <i class="bi bi-person-check me-1 text-primary"></i>Inscrits
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 10%;">
                <i class="bi bi-toggle-on me-1 text-primary"></i>Statut
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 25%;">
                <i class="bi bi-text-paragraph me-1 text-primary"></i>Description
              </th>
              <?php if ($isAdmin): ?>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 15%;">
                <i class="bi bi-person-workspace me-1 text-primary"></i>Coach
              </th>
              <?php endif; ?>
              <th scope="col" class="border-0 px-2 py-3 text-center text-nowrap" style="width: 10%;">
                <i class="bi bi-gear me-1 text-primary"></i>Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($activities)): ?>
              <tr>
                <td colspan="<?= $isAdmin ? '9' : '8' ?>" class="text-center p-5">
                  <div class="text-muted">
                    <i class="bi bi-calendar-x fs-1 mb-3 d-block opacity-50"></i>
                    <h6 class="mb-2">Aucune activité trouvée</h6>
                    <p class="mb-3">Commencez par créer votre première activité au système.</p>
                    <a class="btn btn-primary" href="index.php?controller=activities&action=create">
                      <i class="bi bi-plus-lg me-2"></i>Créer la Première Activité
                    </a>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
            <?php foreach ($activities as $activity): ?>
              <tr class="activity-row">
                <td class="px-2 py-3">
                  <div class="d-flex align-items-center">
                    <div class="activity-icon bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                      <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div>
                      <span class="fw-semibold text-dark d-block" title="<?= htmlspecialchars($activity['nom']) ?>">
                        <?= htmlspecialchars($activity['nom']) ?>
                      </span>
                    </div>
                  </div>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($activity['date_activite'])): ?>
                    <span class="badge bg-light text-dark border" title="<?= htmlspecialchars($activity['date_activite']) ?>">
                      <i class="bi bi-calendar-date-fill text-primary me-1"></i>
                      <?= date('d/m/Y', strtotime($activity['date_activite'])) ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($activity['heure_debut']) && !empty($activity['heure_fin'])): ?>
                    <div class="d-flex flex-column">
                      <small class="text-success">
                        <i class="bi bi-play-circle-fill me-1"></i><?= htmlspecialchars($activity['heure_debut']) ?>
                      </small>
                      <small class="text-danger">
                        <i class="bi bi-stop-circle-fill me-1"></i><?= htmlspecialchars($activity['heure_fin']) ?>
                      </small>
                    </div>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($activity['capacite']) && $activity['capacite'] > 0): ?>
                    <span class="badge bg-info bg-opacity-10 text-info border border-info">
                      <i class="bi bi-people-fill me-1"></i><?= htmlspecialchars($activity['capacite']) ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <?php 
                    $inscriptionsCount = (int)($activity['inscriptions_count'] ?? 0);
                    $capacity = (int)($activity['capacite'] ?? 0);
                    if ($capacity > 0) {
                      $percentage = round(($inscriptionsCount / $capacity) * 100);
                      $badgeClass = $percentage >= 90 ? 'bg-danger' : ($percentage >= 70 ? 'bg-warning' : 'bg-success');
                      echo '<span class="badge ' . $badgeClass . ' bg-opacity-10 text-' . str_replace('bg-', '', $badgeClass) . ' border border-' . str_replace('bg-', '', $badgeClass) . '">';
                      echo '<i class="bi bi-person-check me-1"></i>' . $inscriptionsCount . '/' . $capacity;
                      echo '</span>';
                    } else {
                      echo '<span class="text-muted">—</span>';
                    }
                  ?>
                </td>
                <td class="px-2 py-3">
                  <?php
                    $rawStatut = trim((string)($activity['statut'] ?? 'active'));
                    $status = ($rawStatut === 'active') ? 'Actif' : 'Inactif';
                    $statusClass = $status === 'Actif' ? 'success' : 'secondary';
                  ?>
                  <span class="badge badge-status badge-<?= $statusClass ?>" title="<?= htmlspecialchars($status) ?>">
                    <i class="bi bi-<?= $status === 'Actif' ? 'check-circle-fill' : 'pause-circle-fill' ?> me-1"></i>
                    <?= htmlspecialchars($status) ?>
                  </span>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($activity['description'])): ?>
                    <span class="text-muted text-truncate d-block" title="<?= htmlspecialchars($activity['description']) ?>">
                      <?= htmlspecialchars(substr($activity['description'], 0, 80)) ?><?= strlen($activity['description']) > 80 ? '...' : '' ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <?php if ($isAdmin): ?>
                <td class="px-2 py-3">
                  <?php if (!empty($activity['coach_prenom']) || !empty($activity['coach_nom'])): ?>
                    <div class="d-flex align-items-center">
                      <div class="coach-avatar bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-2">
                        <i class="bi bi-person-workspace"></i>
                      </div>
                      <span class="text-truncate" title="<?= htmlspecialchars(trim($activity['coach_prenom'] . ' ' . $activity['coach_nom'])) ?>">
                        <?= htmlspecialchars(trim($activity['coach_prenom'] . ' ' . $activity['coach_nom'])) ?>
                      </span>
                    </div>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <?php endif; ?>
                <td class="px-2 py-3 text-center">
                  <div class="btn-group" role="group">
                    <a href="index.php?controller=activities&action=edit&id=<?= urlencode($activity['id']) ?>"
                       class="btn btn-sm btn-outline-primary"
                       title="Modifier">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="index.php?controller=activities&action=delete&id=<?= urlencode($activity['id']) ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ? Cette action est irréversible.')"
                       title="Supprimer">
                      <i class="bi bi-trash3"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
.activity-icon {
  width: 32px;
  height: 32px;
  font-size: 14px;
  flex-shrink: 0;
}

.coach-avatar {
  width: 28px;
  height: 28px;
  font-size: 12px;
  flex-shrink: 0;
}

.activity-row:hover {
  background-color: rgba(13, 110, 253, 0.05) !important;
  transform: translateY(-1px);
  transition: all 0.2s ease;
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
}

.btn:hover {
  transform: translateY(-1px);
}

.badge {
  font-size: 0.75rem;
  padding: 0.4em 0.6em;
  max-width: 100%;
}

/* Badges optimisés pour Statut */
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

.badge-status.badge-success {
  background-color: rgba(25, 135, 84, 0.1);
  color: #198754;
  border: 1px solid rgba(25, 135, 84, 0.3);
}

.badge-status.badge-secondary {
  background-color: rgba(108, 117, 125, 0.1);
  color: #6c757d;
  border: 1px solid rgba(108, 117, 125, 0.3);
}

.table th {
  font-weight: 600;
  color: #495057;
  background-color: #f8f9fa;
  border-bottom: 2px solid #dee2e6;
  white-space: nowrap;
}

.table td {
  vertical-align: middle;
  border-bottom: 1px solid #f1f3f4;
  max-width: 0;
  overflow: hidden;
}

.table tbody tr:last-child td {
  border-bottom: none;
}

.bg-gradient {
  background-image: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-rgb) 100%);
}

/* Optimisation de la lisibilité */
.table-responsive {
  overflow: visible;
}

.text-nowrap {
  white-space: nowrap;
}

.text-truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Optimisation des colonnes */
.table th,
.table td {
  padding: 0.5rem 0.75rem;
  font-size: 0.85rem;
  line-height: 1.3;
}

/* Badges plus lisibles */
.badge {
  font-size: 0.75rem;
  padding: 0.3em 0.6em;
  font-weight: 500;
  display: inline-block;
  max-width: 100%;
}

/* Boutons d'action plus accessibles */
.btn-group .btn {
  padding: 0.25rem 0.375rem;
  font-size: 0.8rem;
}

/* Focus amélioré pour la recherche */
#searchInput:focus {
  border-color: var(--bs-primary);
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.input-group-text {
  border-color: #dee2e6;
}

/* Lignes alternées pour une meilleure lisibilité */
.activity-row:nth-child(even) {
  background-color: rgba(0, 0, 0, 0.02);
}

.activity-row:hover {
  background-color: rgba(13, 110, 253, 0.08) !important;
}

/* Optimisation pour les petits écrans */
@media (max-width: 1200px) {
  .table th,
  .table td {
    padding: 0.375rem 0.5rem;
    font-size: 0.8rem;
  }
  
  .activity-icon {
    width: 28px;
    height: 28px;
    font-size: 12px;
  }
  
  .coach-avatar {
    width: 24px;
    height: 24px;
    font-size: 10px;
  }
}

@media (max-width: 992px) {
  .table th,
  .table td {
    padding: 0.25rem 0.375rem;
    font-size: 0.75rem;
  }
  
  .activity-icon {
    width: 24px;
    height: 24px;
    font-size: 10px;
  }
  
  .coach-avatar {
    width: 20px;
    height: 20px;
    font-size: 9px;
  }
  
  .btn-group .btn {
    padding: 0.2rem 0.3rem;
    font-size: 0.75rem;
  }
}

@media (max-width: 768px) {
  .table th,
  .table td {
    padding: 0.25rem 0.25rem;
    font-size: 0.7rem;
  }
  
  .activity-icon {
    width: 20px;
    height: 20px;
    font-size: 9px;
  }
  
  .coach-avatar {
    width: 18px;
    height: 18px;
    font-size: 8px;
  }
  
  .badge {
    font-size: 0.65rem;
    padding: 0.2em 0.4em;
  }
  
  .btn-group .btn {
    padding: 0.15rem 0.25rem;
    font-size: 0.7rem;
  }
}

/* Gestion des icônes dans les colonnes */
.table th i,
.table td i {
  flex-shrink: 0;
}

/* Optimisation des cellules avec texte long */
.table td {
  word-wrap: break-word;
  word-break: break-word;
}

/* Hover effects pour les badges */
.badge-status:hover {
  transform: scale(1.05);
  transition: transform 0.2s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const clearSearchBtn = document.getElementById('clearSearch');
  const activityRows = document.querySelectorAll('.activity-row');
  const tableBody = document.querySelector('tbody');
  
  // Fonction de recherche
  function filterActivities(searchTerm) {
    let hasResults = false;
    
    activityRows.forEach(row => {
      const text = row.textContent.toLowerCase();
      if (text.includes(searchTerm.toLowerCase())) {
        row.style.display = '';
        hasResults = true;
      } else {
        row.style.display = 'none';
      }
    });
    
    // Afficher/masquer le message "aucun résultat"
    const noResultsRow = tableBody.querySelector('tr:not(.activity-row)');
    if (noResultsRow) {
      if (!hasResults && searchTerm.length > 0) {
        // Créer un message "aucun résultat trouvé"
        const newNoResultsRow = document.createElement('tr');
        const colSpan = <?= $isAdmin ? '9' : '8' ?>;
        newNoResultsRow.innerHTML = `
          <td colspan="${colSpan}" class="text-center p-5">
            <div class="text-muted">
              <i class="bi bi-search fs-1 mb-3 d-block opacity-50"></i>
              <h6 class="mb-2">Aucun résultat trouvé</h6>
              <p class="mb-0">Aucune activité ne correspond à votre recherche : "<strong>${searchTerm}</strong>"</p>
            </div>
          </td>
        `;
        tableBody.appendChild(newNoResultsRow);
      } else if (hasResults) {
        // Supprimer le message "aucun résultat"
        const existingNoResults = tableBody.querySelector('tr:not(.activity-row)');
        if (existingNoResults) {
          existingNoResults.remove();
        }
      }
    }
  }
  
  // Écouter les changements dans la barre de recherche
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.trim();
    filterActivities(searchTerm);
    
    // Afficher/masquer le bouton de suppression
    if (searchTerm.length > 0) {
      clearSearchBtn.style.display = 'block';
    } else {
      clearSearchBtn.style.display = 'none';
    }
  });
  
  // Bouton pour effacer la recherche
  clearSearchBtn.addEventListener('click', function() {
    searchInput.value = '';
    searchInput.focus();
    filterActivities('');
    this.style.display = 'none';
  });
  
  // Masquer le bouton de suppression au chargement
  clearSearchBtn.style.display = 'none';
  
  // Recherche avec la touche Entrée
  searchInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      this.blur();
    }
  });
});
</script>


