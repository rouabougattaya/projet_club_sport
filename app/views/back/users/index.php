<div class="container-fluid px-4 py-3">
  <!-- Header avec statistiques -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <?php $isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
        <div>
          <h2 class="h3 mb-1 text-dark fw-bold">
            <i class="bi bi-people-fill text-blue-violet me-2"></i>
            <?= $isAdmin ? 'Gestion des Utilisateurs' : 'Mon Profil' ?>
          </h2>
          <p class="text-muted mb-0">
            <?= $isAdmin ? 'Administration complète du système utilisateurs' : 'Gérez vos informations personnelles' ?>
          </p>
        </div>
        <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
          <a href="index.php?controller=user&action=create" class="btn btn-blue-violet btn-lg shadow-sm">
            <i class="bi bi-person-plus-fill me-2"></i>
            Ajouter un Utilisateur
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Statistiques rapides -->
  <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
    <div class="row mb-4">
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-gradient-blue-violet text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1"><?= count($users) ?></h4>
                <p class="mb-0 opacity-75">Total Utilisateurs</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-people-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-gradient-indigo text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1"><?= count(array_filter($users, fn($u) => $u['role'] === 'adherent')) ?></h4>
                <p class="mb-0 opacity-75">Adhérents</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-person-check-fill fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-gradient-purple text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1"><?= count(array_filter($users, fn($u) => $u['role'] === 'entraineur')) ?></h4>
                <p class="mb-0 opacity-75">Entraîneurs</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-person-workspace fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 bg-gradient-violet text-white shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4 class="fw-bold mb-1"><?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?></h4>
                <p class="mb-0 opacity-75">Administrateurs</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-shield-fill-check fs-1 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Tableau des utilisateurs -->
  <div class="card border-0 shadow-lg">
    <div class="card-header bg-white border-0 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-semibold">
          <i class="bi bi-table me-2 text-blue-violet"></i>
          Liste des Utilisateurs
        </h5>
        <div class="d-flex gap-2">
          <div class="input-group" style="width: 300px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" id="searchInput"
                   placeholder="Rechercher un utilisateur...">
            <button class="btn btn-outline-secondary" type="button" id="clearSearch" title="Effacer la recherche">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="usersTable" style="width: 100%;">
          <thead class="table-light">
            <tr>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 10%;">
                <i class="bi bi-person-badge me-1 text-blue-violet"></i>Nom
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 10%;">
                <i class="bi bi-person me-1 text-blue-violet"></i>Prénom
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 8%;">
                <i class="bi bi-card-text me-1 text-blue-violet"></i>CIN
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 12%;">
                <i class="bi bi-gender-ambiguous me-1 text-blue-violet"></i>Genre
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 16%;">
                <i class="bi bi-geo-alt me-1 text-blue-violet"></i>Adresse
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 12%;">
                <i class="bi bi-telephone me-1 text-blue-violet"></i>Téléphone
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 18%;">
                <i class="bi bi-envelope me-1 text-blue-violet"></i>Email
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-nowrap" style="width: 12%;">
                <i class="bi bi-shield me-1 text-blue-violet"></i>Rôle
              </th>
              <th scope="col" class="border-0 px-2 py-3 text-center text-nowrap" style="width: 2%;">
                <i class="bi bi-gear me-1 text-blue-violet"></i>Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($users)): ?>
              <tr>
                <td colspan="9" class="text-center p-5">
                  <div class="text-muted">
                    <i class="bi bi-inbox-fill fs-1 mb-3 d-block opacity-50"></i>
                    <h6 class="mb-2">Aucun utilisateur trouvé</h6>
                    <p class="mb-3">Commencez par ajouter votre premier utilisateur au système.</p>
                    <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
                      <a class="btn btn-blue-violet" href="index.php?controller=user&action=create">
                        <i class="bi bi-plus-lg me-2"></i>Ajouter le Premier Utilisateur
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
            <?php foreach ($users as $user): ?>
              <tr class="user-row">
                <td class="px-2 py-3">
                  <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-blue-violet bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                      <span class="fw-semibold"><?= strtoupper(substr($user['nom'], 0, 1)) ?></span>
                    </div>
                    <span class="fw-semibold text-dark text-truncate" title="<?= htmlspecialchars($user['nom']) ?>"><?= htmlspecialchars($user['nom']) ?></span>
                  </div>
                </td>
                <td class="px-2 py-3">
                  <span class="text-dark text-truncate d-block" title="<?= htmlspecialchars($user['prenom']) ?>"><?= htmlspecialchars($user['prenom']) ?></span>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($user['cin'])): ?>
                    <span class="badge bg-light text-dark border text-truncate d-block" title="<?= htmlspecialchars($user['cin']) ?>"><?= htmlspecialchars($user['cin']) ?></span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($user['genre'])): ?>
                    <span class="badge badge-genre badge-<?= $user['genre'] === 'Homme' ? 'male' : 'female' ?>" title="<?= htmlspecialchars($user['genre']) ?>">
                      <i class="bi bi-<?= $user['genre'] === 'Homme' ? 'gender-male' : 'gender-female' ?> me-1"></i>
                      <?= htmlspecialchars($user['genre']) ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($user['adresse'])): ?>
                    <span class="text-muted text-truncate d-block" title="<?= htmlspecialchars($user['adresse']) ?>">
                      <i class="bi bi-geo-alt-fill text-blue-violet me-1"></i>
                      <?= htmlspecialchars($user['adresse']) ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <?php if (!empty($user['telephone'])): ?>
                    <span class="d-flex align-items-center">
                      <i class="bi bi-telephone-fill text-indigo me-1"></i>
                      <span class="text-truncate" title="<?= htmlspecialchars($user['telephone']) ?>"><?= htmlspecialchars($user['telephone']) ?></span>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-2 py-3">
                  <span class="d-flex align-items-center">
                    <i class="bi bi-envelope-fill text-purple me-1"></i>
                    <span class="text-truncate" title="<?= htmlspecialchars($user['email']) ?>"><?= htmlspecialchars($user['email']) ?></span>
                  </span>
                </td>
                <td class="px-2 py-3">
                  <span class="badge badge-role badge-<?= $user['role'] ?>" title="<?= htmlspecialchars(ucfirst($user['role'])) ?>">
                    <i class="bi bi-<?= $user['role'] === 'admin' ? 'shield-fill-check' : ($user['role'] === 'entraineur' ? 'person-workspace' : 'person-check-fill') ?> me-1"></i>
                    <?= htmlspecialchars(ucfirst($user['role'])) ?>
                  </span>
                </td>
                <td class="px-2 py-3 text-center">
                  <div class="btn-group" role="group">
                    <a href="index.php?controller=user&action=show&id=<?= urlencode($user['id']) ?>"
                       class="btn btn-sm btn-outline-info"
                       title="Voir les détails">
                      <i class="bi bi-eye"></i>
                    </a>
                    <a href="index.php?controller=user&action=edit&id=<?= urlencode($user['id']) ?>"
                       class="btn btn-sm btn-outline-blue-violet"
                       title="Modifier">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
                      <a href="index.php?controller=user&action=delete&id=<?= urlencode($user['id']) ?>"
                         class="btn btn-sm btn-outline-danger"
                         onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')"
                         title="Supprimer">
                        <i class="bi bi-trash3"></i>
                      </a>
                    <?php endif; ?>
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

.avatar-sm {
  width: 32px;
  height: 32px;
  font-size: 12px;
  flex-shrink: 0;
}

.user-row:hover {
  background-color: rgba(79, 70, 229, 0.05) !important;
  transform: translateY(-1px);
  transition: all 0.2s ease;
}

.card {
  transition: all 0.3s ease;
  border-radius: 12px;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.btn {
  transition: all 0.2s ease;
  border-radius: 8px;
}

.btn:hover {
  transform: translateY(-1px);
}

.badge {
  font-size: 0.75rem;
  padding: 0.4em 0.6em;
  max-width: 100%;
  border-radius: 8px;
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

/* Optimisation de la lisibilité sans scroll */
.table-responsive {
  overflow: visible;
}

/* Amélioration de la lisibilité */
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

/* Amélioration de la lisibilité du texte */
.table td span {
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
  border-color: var(--blue-violet);
  box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

.input-group-text {
  border-color: #dee2e6;
}

/* Amélioration de l'espacement */
.table-responsive {
  padding: 0;
  margin: 0;
}

/* Lignes alternées pour une meilleure lisibilité */
.user-row:nth-child(even) {
  background-color: rgba(0, 0, 0, 0.02);
}

.user-row:hover {
  background-color: rgba(79, 70, 229, 0.08) !important;
}

/* Optimisation pour les petits écrans */
@media (max-width: 1200px) {
  .table th,
  .table td {
    padding: 0.375rem 0.5rem;
    font-size: 0.8rem;
  }
  
  .avatar-sm {
    width: 28px;
    height: 28px;
    font-size: 11px;
  }
  
  .badge {
    font-size: 0.7rem;
    padding: 0.25em 0.5em;
  }
  
  .badge-genre,
  .badge-role {
    font-size: 0.65rem;
    padding: 0.3em 0.5em;
    min-width: auto;
  }
}

@media (max-width: 992px) {
  .table th,
  .table td {
    padding: 0.25rem 0.375rem;
    font-size: 0.75rem;
  }
  
  .avatar-sm {
    width: 24px;
    height: 24px;
    font-size: 10px;
  }
  
  .btn-group .btn {
    padding: 0.2rem 0.3rem;
    font-size: 0.75rem;
  }
  
  .badge-genre,
  .badge-role {
    font-size: 0.6rem;
    padding: 0.25em 0.4em;
    min-width: auto;
  }
}

@media (max-width: 768px) {
  .table th,
  .table td {
    padding: 0.25rem 0.25rem;
    font-size: 0.7rem;
  }
  
  .avatar-sm {
    width: 20px;
    height: 20px;
    font-size: 9px;
  }
  
  .badge {
    font-size: 0.65rem;
    padding: 0.2em 0.4em;
  }
  
  .btn-group .btn {
    padding: 0.15rem 0.25rem;
    font-size: 0.7rem;
  }
  
  .badge-genre,
  .badge-role {
    font-size: 0.55rem;
    padding: 0.2em 0.35em;
    min-width: auto;
  }
}

/* Optimisation pour les très petits écrans */
@media (max-width: 576px) {
  .table-responsive {
    font-size: 0.7rem;
  }
  
  .table th,
  .table td {
    padding: 0.2rem 0.15rem;
    font-size: 0.65rem;
  }
  
  .badge {
    font-size: 0.6rem;
    padding: 0.15em 0.3em;
  }
  
  .btn-group .btn {
    padding: 0.1rem 0.2rem;
    font-size: 0.65rem;
  }
  
  .avatar-sm {
    width: 18px;
    height: 18px;
    font-size: 8px;
  }
  
  .badge-genre,
  .badge-role {
    font-size: 0.5rem;
    padding: 0.15em 0.3em;
    min-width: auto;
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
.badge-genre:hover,
.badge-role:hover {
  transform: scale(1.05);
  transition: transform 0.2s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const clearSearchBtn = document.getElementById('clearSearch');
  const userRows = document.querySelectorAll('.user-row');
  const tableBody = document.querySelector('tbody');
  
  // Fonction de recherche
  function filterUsers(searchTerm) {
    let hasResults = false;
    
    userRows.forEach(row => {
      const text = row.textContent.toLowerCase();
      if (text.includes(searchTerm.toLowerCase())) {
        row.style.display = '';
        hasResults = true;
      } else {
        row.style.display = 'none';
      }
    });
    
    // Afficher/masquer le message "aucun résultat"
    const noResultsRow = tableBody.querySelector('tr:not(.user-row)');
    if (noResultsRow) {
      if (!hasResults && searchTerm.length > 0) {
        // Créer un message "aucun résultat trouvé"
        const newNoResultsRow = document.createElement('tr');
        newNoResultsRow.innerHTML = `
          <td colspan="9" class="text-center p-5">
            <div class="text-muted">
              <i class="bi bi-search fs-1 mb-3 d-block opacity-50"></i>
              <h6 class="mb-2">Aucun résultat trouvé</h6>
              <p class="mb-0">Aucun utilisateur ne correspond à votre recherche : "<strong>${searchTerm}</strong>"</p>
            </div>
          </td>
        `;
        tableBody.appendChild(newNoResultsRow);
      } else if (hasResults) {
        // Supprimer le message "aucun résultat"
        const existingNoResults = tableBody.querySelector('tr:not(.user-row)');
        if (existingNoResults) {
          existingNoResults.remove();
        }
      }
    }
  }
  
  // Écouter les changements dans la barre de recherche
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.trim();
    filterUsers(searchTerm);
    
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
    filterUsers('');
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

</style>



<script>

document.addEventListener('DOMContentLoaded', function() {

  const searchInput = document.getElementById('searchInput');

  const clearSearchBtn = document.getElementById('clearSearch');

  const userRows = document.querySelectorAll('.user-row');

  const tableBody = document.querySelector('tbody');

  
  
  // Fonction de recherche

  function filterUsers(searchTerm) {

    let hasResults = false;

    
    
    userRows.forEach(row => {

      const text = row.textContent.toLowerCase();

      if (text.includes(searchTerm.toLowerCase())) {

        row.style.display = '';

        hasResults = true;

      } else {

        row.style.display = 'none';

      }

    });

    
    
    // Afficher/masquer le message "aucun résultat"

    const noResultsRow = tableBody.querySelector('tr:not(.user-row)');

    if (noResultsRow) {

      if (!hasResults && searchTerm.length > 0) {

        // Créer un message "aucun résultat trouvé"

        const newNoResultsRow = document.createElement('tr');

        newNoResultsRow.innerHTML = `

          <td colspan="9" class="text-center p-5">

            <div class="text-muted">

              <i class="bi bi-search fs-1 mb-3 d-block opacity-50"></i>

              <h6 class="mb-2">Aucun résultat trouvé</h6>

              <p class="mb-0">Aucun utilisateur ne correspond à votre recherche : "<strong>${searchTerm}</strong>"</p>

            </div>

          </td>

        `;

        tableBody.appendChild(newNoResultsRow);

      } else if (hasResults) {

        // Supprimer le message "aucun résultat"

        const existingNoResults = tableBody.querySelector('tr:not(.user-row)');

        if (existingNoResults) {

          existingNoResults.remove();

        }

      }

    }

  }

  
  
  // Écouter les changements dans la barre de recherche

  searchInput.addEventListener('input', function() {

    const searchTerm = this.value.trim();

    filterUsers(searchTerm);

    
    
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

    filterUsers('');

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
