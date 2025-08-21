<form method="post" action="index.php?controller=auth&action=login">
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" class="form-control" required value="<?= isset($email) ? $email : '' ?>">
  </div>
  <div class="mb-3">
    <label for="mot_de_passe" class="form-label">Mot de passe</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary w-100">Se connecter</button>
</form>


