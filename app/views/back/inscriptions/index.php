<div class="container-fluid px-4 py-3">
  <!-- Header avec statistiques -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <?php $isAdmin = !empty($isAdmin) && $isAdmin; ?>
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-person-check-fill text-primary me-2"></i>
            <?= $isAdmin ? 'Gestion des Inscriptions' : 'Mes Inscriptions' ?>
          </h2>
          <p class="text-muted mb-0">
            <?= $isAdmin ? 'Administration complète des inscriptions aux activités' : 'Suivez vos inscriptions aux activités' ?>
          </p>
        </div>
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
                <h4 class="fw-bold mb-1"><?= count($inscriptions) ?></h4>
                <p class="mb-0 opacity-75">Total Inscriptions</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-person-check-fill fs-1 opacity-75"></i>
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
                    $pendingCount = 0;
                    foreach ($inscriptions as $insc) {
                      if (isset($insc['statut']) && strtolower(trim($insc['statut'])) === 'en_attente') {
                        $pendingCount++;
                      }
                    }
                    echo $pendingCount;
                  ?>
                </h4>
                <p class="mb-0 opacity-75">En Attente</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-clock-fill fs-1 opacity-75"></i>
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
                    $validatedCount = 0;
                    foreach ($inscriptions as $insc) {
                      if (isset($insc['statut']) && strtolower(trim($insc['statut'])) === 'validée') {
                        $validatedCount++;
                      }
                    }
                    echo $validatedCount;
                  ?>
                </h4>
                <p class="mb-0 opacity-75">Validées</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-check-circle-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-danger bg-gradient text-white shadow-sm h-100">
	<div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1">
                  <?php
                    $refusedCount = 0;
                    foreach ($inscriptions as $insc) {
                      if (isset($insc['statut']) && strtolower(trim($insc['statut'])) === 'refusée') {
                        $refusedCount++;
                      }
                    }
                    echo $refusedCount;
                  ?>
                </h4>
                <p class="mb-0 opacity-75">Refusées</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-x-circle-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Tableau des inscriptions -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-semibold">
          <i class="bi bi-table me-2 text-primary"></i>
          Liste des Inscriptions
        </h5>
        <div class="d-flex gap-2">
          <div class="input-group" style="width: 300px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" id="searchInput"
                   placeholder="Rechercher une inscription...">
            <button class="btn btn-outline-secondary" type="button" id="clearSearch" title="Effacer la recherche">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
		<div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="inscriptionsTable" style="width: 100%;">
				<thead class="table-light">
					<tr>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 25%;">
                <i class="bi bi-calendar-event me-1 text-primary"></i>Activité
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 25%;">
                <i class="bi bi-person me-1 text-primary"></i>Adhérent
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 15%;">
                <i class="bi bi-calendar-date me-1 text-primary"></i>Date
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 15%;">
                <i class="bi bi-toggle-on me-1 text-primary"></i>Statut
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-center text-nowrap" style="width: 20%;">
                <i class="bi bi-gear me-1 text-primary"></i>Actions
              </th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($inscriptions)): ?>
              <tr>
                <td colspan="5" class="text-center p-5">
                  <div class="text-muted">
                    <i class="bi bi-person-x fs-1 mb-3 d-block opacity-50"></i>
                    <h6 class="mb-2">Aucune inscription trouvée</h6>
                    <p class="mb-3">Aucune inscription n'a encore été créée dans le système.</p>
                  </div>
                </td>
              </tr>
					<?php endif; ?>
					<?php foreach ($inscriptions as $insc): ?>
              <tr class="inscription-row">
                <td class="px-2 py-3">
                  <div class="d-flex align-items-center">
                    <div class="activity-icon bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                      <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div>
                      <span class="fw-semibold text-dark d-block" title="<?= htmlspecialchars($insc['activity_nom']) ?>">
                        <?= htmlspecialchars($insc['activity_nom']) ?>
                      </span>
                    </div>
                  </div>
                </td>
                <td class="px-2 py-3">
                  <div class="d-flex align-items-center">
                    <div class="user-avatar bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2">
                      <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="fw-medium text-dark" title="<?= htmlspecialchars(trim(($insc['user_prenom'] ?? '') . ' ' . ($insc['user_nom'] ?? ''))) ?>">
                      <?= htmlspecialchars(trim(($insc['user_prenom'] ?? '') . ' ' . ($insc['user_nom'] ?? ''))) ?>
                    </span>
                  </div>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($insc['date_inscription'])): ?>
                    <span class="badge bg-light text-dark border" title="<?= htmlspecialchars((string)$insc['date_inscription']) ?>">
                      <i class="bi bi-calendar-date-fill text-primary me-1"></i>
                      <?= date('d/m/Y', strtotime($insc['date_inscription'])) ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <?php 
                    $s = strtolower((string)$insc['statut']);
									$label = ($s === 'validée') ? 'Validée' : (($s === 'refusée') ? 'Refusée' : (($s === 'annulée') ? 'Annulée' : (($s === 'terminée') ? 'Terminée' : 'En attente')));
                    $cls = ($label === 'Validée') ? 'success' : (($label === 'Refusée') ? 'danger' : (($label === 'Annulée') ? 'secondary' : (($label === 'Terminée') ? 'dark' : 'warning')));
								?>
                  <span class="badge badge-status badge-<?= $cls ?>" title="<?= htmlspecialchars($label) ?>">
                    <i class="bi bi-<?= $label === 'Validée' ? 'check-circle-fill' : ($label === 'Refusée' ? 'x-circle-fill' : ($label === 'Annulée' ? 'pause-circle-fill' : ($label === 'Terminée' ? 'flag-checkered' : 'clock-fill'))) ?> me-1"></i>
                    <?= htmlspecialchars($label) ?>
                  </span>
							</td>
                <td class="px-2 py-3 text-center">
								<?php if ($s === 'en_attente'): ?>
                    <div class="btn-group" role="group">
                      <a class="btn btn-sm btn-success" href="index.php?controller=inscriptions&action=validate&id=<?= urlencode((string)$insc['id']) ?>" title="Valider">
                        <i class="bi bi-check-lg"></i>
                      </a>
                      <a class="btn btn-sm btn-outline-danger" href="index.php?controller=inscriptions&action=refuse&id=<?= urlencode((string)$insc['id']) ?>" onclick="return confirm('Refuser cette inscription ?');" title="Refuser">
                        <i class="bi bi-x-lg"></i>
                      </a>
                    </div>
								<?php elseif ($s === 'validée'): ?>
                    <div class="btn-group" role="group">
                      <a class="btn btn-sm btn-outline-danger" href="index.php?controller=inscriptions&action=refuse&id=<?= urlencode((string)$insc['id']) ?>" onclick="return confirm('Refuser cette inscription ?');" title="Refuser">
                        <i class="bi bi-x-lg"></i>
                      </a>
                    </div>
								<?php elseif ($s === 'refusée' || $s === 'annulée' || $s === 'terminée'): ?>
                    <button class="btn btn-sm btn-secondary" disabled title="Aucune action disponible">
                      <i class="bi bi-dash-lg"></i>
                    </button>
								<?php else: ?>
                    <button class="btn btn-sm btn-secondary" disabled title="Aucune action disponible">
                      <i class="bi bi-dash-lg"></i>
                    </button>
								<?php endif; ?>
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

.user-avatar {
  width: 28px;
  height: 28px;
  font-size: 12px;
  flex-shrink: 0;
}

.inscription-row:hover {
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

.badge-status.badge-danger {
  background-color: rgba(220, 53, 69, 0.1);
  color: #dc3545;
  border: 1px solid rgba(220, 53, 69, 0.3);
}

.badge-status.badge-warning {
  background-color: rgba(255, 193, 7, 0.1);
  color: #ffc107;
  border: 1px solid rgba(255, 193, 7, 0.3);
}

.badge-status.badge-secondary {
  background-color: rgba(108, 117, 125, 0.1);
  color: #6c757d;
  border: 1px solid rgba(108, 117, 125, 0.3);
}

.badge-status.badge-dark {
  background-color: rgba(33, 37, 41, 0.1);
  color: #212529;
  border: 1px solid rgba(33, 37, 41, 0.3);
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
.inscription-row:nth-child(even) {
  background-color: rgba(0, 0, 0, 0.02);
}

.inscription-row:hover {
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
  
  .user-avatar {
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
  
  .user-avatar {
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
  
  .user-avatar {
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
  const inscriptionRows = document.querySelectorAll('.inscription-row');
  const tableBody = document.querySelector('tbody');
  
  // Fonction de recherche
  function filterInscriptions(searchTerm) {
    let hasResults = false;
    
    inscriptionRows.forEach(row => {
      const text = row.textContent.toLowerCase();
      if (text.includes(searchTerm.toLowerCase())) {
        row.style.display = '';
        hasResults = true;
      } else {
        row.style.display = 'none';
      }
    });
    
    // Afficher/masquer le message "aucun résultat"
    const noResultsRow = tableBody.querySelector('tr:not(.inscription-row)');
    if (noResultsRow) {
      if (!hasResults && searchTerm.length > 0) {
        // Créer un message "aucun résultat trouvé"
        const newNoResultsRow = document.createElement('tr');
        newNoResultsRow.innerHTML = `
          <td colspan="5" class="text-center p-5">
            <div class="text-muted">
              <i class="bi bi-search fs-1 mb-3 d-block opacity-50"></i>
              <h6 class="mb-2">Aucun résultat trouvé</h6>
              <p class="mb-0">Aucune inscription ne correspond à votre recherche : "<strong>${searchTerm}</strong>"</p>
            </div>
          </td>
        `;
        tableBody.appendChild(newNoResultsRow);
      } else if (hasResults) {
        // Supprimer le message "aucun résultat"
        const existingNoResults = tableBody.querySelector('tr:not(.inscription-row)');
        if (existingNoResults) {
          existingNoResults.remove();
        }
      }
    }
  }
  
  // Écouter les changements dans la barre de recherche
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.trim();
    filterInscriptions(searchTerm);
    
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
    filterInscriptions('');
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


