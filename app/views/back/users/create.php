<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="card-title mb-4">Ajouter un utilisateur</h2>
        <form method="post" class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" id="nom" name="nom" class="form-control" required>
              <div class="invalid-feedback">Nom requis.</div>
            </div>
            <div class="col-md-6">
              <label for="prenom" class="form-label">Prénom</label>
              <input type="text" id="prenom" name="prenom" class="form-control" required>
              <div class="invalid-feedback">Prénom requis.</div>
            </div>
            <div class="col-md-6">
              <label for="cin" class="form-label">CIN</label>
              <input type="text" id="cin" name="cin" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="genre" class="form-label">Genre</label>
              <select id="genre" name="genre" class="form-select">
                <option value="">—</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
              </select>
            </div>
            <div class="col-md-12">
              <label for="adresse" class="form-label">Adresse</label>
              <input type="text" id="adresse" name="adresse" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="telephone" class="form-label">Téléphone</label>
              <input type="text" id="telephone" name="telephone" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" class="form-control" required>
              <div class="invalid-feedback">Email valide requis.</div>
            </div>
            <div class="col-md-6">
              <label for="mot_de_passe" class="form-label">Mot de passe</label>
              <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required>
              <div class="invalid-feedback">Mot de passe requis.</div>
            </div>
            <?php $isAdmin = !empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? null) === 'admin'); ?>
            <?php if ($isAdmin): ?>
              <div class="col-md-6">
                <label for="role" class="form-label">Rôle</label>
                <select id="role" name="role" class="form-select" required>
                  <option value="admin">Admin</option>
                  <option value="entraineur">Entraîneur</option>
                  <option value="adherent">Adhérent</option>
                </select>
              </div>
            <?php else: ?>
              <input type="hidden" name="role" value="adherent">
            <?php endif; ?>
          </div>
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="index.php?controller=user&action=index" class="btn btn-outline-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
