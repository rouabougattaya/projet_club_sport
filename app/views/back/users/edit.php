<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title mb-4">Modifier un utilisateur</h2>
        <form method="post" class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" class="form-control" required>
              <div class="invalid-feedback">Nom requis.</div>
            </div>
            <div class="col-md-6">
              <label for="prenom" class="form-label">Prénom</label>
              <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" class="form-control" required>
              <div class="invalid-feedback">Prénom requis.</div>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
              <div class="invalid-feedback">Email valide requis.</div>
            </div>
            <div class="col-md-6">
              <label for="mot_de_passe" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
              <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control">
            </div>
            <?php $canEditRole = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
            <?php if ($canEditRole): ?>
              <div class="col-md-6">
                <label for="role" class="form-label">Rôle</label>
                <select id="role" name="role" class="form-select" required>
                  <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                  <option value="entraineur" <?= $user['role'] === 'entraineur' ? 'selected' : '' ?>>Entraîneur</option>
                  <option value="adherent" <?= $user['role'] === 'adherent' ? 'selected' : '' ?>>Adhérent</option>
                </select>
              </div>
            <?php endif; ?>
          </div>
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="index.php?controller=user&action=index" class="btn btn-outline-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
