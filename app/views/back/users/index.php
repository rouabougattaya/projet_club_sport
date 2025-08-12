<div class="d-flex justify-content-between align-items-center mb-4">
  <?php $isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
  <h2 class="mb-0"><?= $isAdmin ? 'Liste des utilisateurs' : 'Mon profil' ?></h2>
  <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin'): ?>
    <a href="index.php?controller=user&action=create" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Ajouter un utilisateur</a>
  <?php endif; ?>
</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Rôle</th>
            <th scope="col" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['id']) ?></td>
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
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
