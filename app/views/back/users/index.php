<div class="d-flex justify-content-between align-items-center mb-4">
  <?php $isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
  <h2 class="mb-0"><?= $isAdmin ? 'Liste des utilisateurs' : 'Mon profil' ?></h2>
  <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
    <a href="index.php?controller=user&action=create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Ajouter un utilisateur</a>
  <?php endif; ?>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">CIN</th>
            <th scope="col">Genre</th>
            <th scope="col">Adresse</th>
            <th scope="col">Téléphone</th>
            <th scope="col">Email</th>
            <th scope="col">Rôle</th>
            <th scope="col" class="text-end" style="width: 180px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($users)): ?>
            <tr>
              <td colspan="9" class="text-center p-5 text-muted">
                <div class="mb-2">Aucun utilisateur trouvé.</div>
                <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
                  <a class="btn btn-sm btn-primary" href="index.php?controller=user&action=create"><i class="bi bi-plus-lg me-1"></i>Ajouter le premier utilisateur</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endif; ?>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
              <td><?= htmlspecialchars($user['cin'] ?? '') ?: '—' ?></td>
              <td><?= htmlspecialchars($user['genre'] ?? '') ?: '—' ?></td>
              <td><?= htmlspecialchars($user['adresse'] ?? '') ?: '—' ?></td>
              <td><?= htmlspecialchars($user['telephone'] ?? '') ?: '—' ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td>
                <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'entraineur' ? 'primary' : 'secondary') ?>">
                  <?= htmlspecialchars(ucfirst($user['role'])) ?>
                </span>
              </td>
              <td class="text-end">
                <a href="index.php?controller=user&action=edit&id=<?= urlencode($user['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
                  <a href="index.php?controller=user&action=delete&id=<?= urlencode($user['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"><i class="bi bi-trash"></i></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
