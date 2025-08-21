<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Connexion</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #0c0c0d; }
    .auth-card { width: 100%; max-width: 420px; background: #121316; border: 1px solid rgba(255,255,255,.08); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.4); }
    .auth-card .card-body { padding: 2rem; }
    .brand { display: flex; align-items: center; gap: .6rem; margin-bottom: 1rem; }
    .brand img { width: 36px; height: 36px; border-radius: 50%; }
    .brand span { font-weight: 600; color: #fff; }
    .form-label { color: #c9c9d1; }
    .form-control { background: #0f1012; border-color: #2a2b31; color: #e8e9ee; }
    .form-control:focus { background: #0f1012; color: #fff; border-color: #6ea8fe; box-shadow: 0 0 0 .2rem rgba(13,110,253,.25); }
    .btn-primary { background: linear-gradient(135deg, #695cff, #3a86ff); border: none; }
    .text-muted { color: #8e8f99 !important; }
    .alert { border-radius: 12px; }
  </style>
</head>
<body>
  <div class="container py-4">
    <?php 
      require_once __DIR__ . '/../../../../core/Flash.php';
      $flashes = class_exists('Flash') ? Flash::consumeAll() : [];
      foreach ($flashes as $flash):
        $type = in_array($flash['type'], ['primary','secondary','success','danger','warning','info','light','dark']) ? $flash['type'] : 'info';
    ?>
      <div class="alert alert-<?= htmlspecialchars($type) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endforeach; ?>

    <div class="card auth-card mx-auto">
      <div class="card-body">
        <div class="brand">
          
          <span>Se connecter</span>
        </div>
        <?= isset($content) ? $content : '' ?>
        <p class="mt-4 mb-0 text-center text-muted" style="font-size:.9rem">Besoin d'aide ? Contactez l'administrateur.</p>
      </div>
    </div>
  </div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>


