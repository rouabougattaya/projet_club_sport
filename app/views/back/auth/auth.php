<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Connexion - Espace Administrateur</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      position: relative;
      overflow: hidden;
    }

    /* Motif sportif en arrière-plan */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="sport" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.05)"/><rect x="10" y="10" width="30" height="30" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23sport)"/></svg>');
      animation: float 15s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-10px) rotate(90deg); }
    }

    .auth-container {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 380px;
      margin: 1rem;
    }

    .auth-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .auth-header {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      padding: 1.5rem 1.5rem 1rem;
      text-align: center;
      position: relative;
    }

    .brand-logo {
      width: 50px;
      height: 50px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 0.75rem;
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease;
    }

    .brand-logo:hover {
      transform: scale(1.05);
    }

    .brand-logo i {
      font-size: 1.5rem;
      color: white;
    }

    .brand-title {
      color: white;
      font-size: 1.4rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
      position: relative;
      z-index: 1;
    }

    .brand-subtitle {
      color: rgba(255, 255, 255, 0.9);
      font-size: 0.9rem;
      font-weight: 400;
      position: relative;
      z-index: 1;
    }

    .auth-body {
      padding: 1.5rem 1.5rem;
    }

    .form-group {
      margin-bottom: 1rem;
      position: relative;
    }

    .form-label {
      color: #374151;
      font-weight: 600;
      font-size: 0.85rem;
      margin-bottom: 0.4rem;
      display: block;
      transition: color 0.3s ease;
    }

    .form-group:focus-within .form-label {
      color: #1e3c72;
    }

    .form-control {
      width: 100%;
      padding: 0.75rem 0.75rem 0.75rem 2.5rem;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      background: #f9fafb;
      font-weight: 500;
    }

    .form-control:focus {
      outline: none;
      border-color: #1e3c72;
      background: white;
      box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
      transform: translateY(-1px);
    }

    .form-control.is-invalid {
      border-color: #ef4444;
      box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-control.is-valid {
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .input-icon {
      position: absolute;
      left: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus + .input-icon {
      color: #1e3c72;
      transform: translateY(-50%) scale(1.1);
    }

    .form-control.is-invalid + .input-icon {
      color: #ef4444;
    }

    .form-control.is-valid + .input-icon {
      color: #10b981;
    }

    .invalid-feedback {
      display: block;
      color: #ef4444;
      font-size: 0.8rem;
      margin-top: 0.3rem;
      animation: shake 0.5s ease-in-out;
      font-weight: 500;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-3px); }
      75% { transform: translateX(3px); }
    }

    .btn-login {
      width: 100%;
      padding: 0.75rem;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      border: none;
      border-radius: 8px;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(30, 60, 114, 0.3);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .alert {
      border-radius: 8px;
      border: none;
      margin-bottom: 1rem;
      animation: slideIn 0.4s ease-out;
      font-weight: 500;
      font-size: 0.85rem;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-8px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-success {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
    }

    .alert-danger {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
    }

    .alert-warning {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
    }

    .alert-info {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
    }

    .auth-footer {
      text-align: center;
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 1px solid #e5e7eb;
    }

    .auth-footer p {
      color: #6b7280;
      font-size: 0.8rem;
      margin: 0;
    }

    .auth-footer a {
      color: #1e3c72;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .auth-footer a:hover {
      color: #2a5298;
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .auth-container {
        margin: 0.5rem;
      }
      
      .auth-card {
        border-radius: 12px;
      }
      
      .auth-header {
        padding: 1.25rem 1rem 0.75rem;
      }
      
      .auth-body {
        padding: 1.25rem 1rem;
      }
      
      .brand-logo {
        width: 45px;
        height: 45px;
      }
      
      .brand-logo i {
        font-size: 1.3rem;
      }
      
      .brand-title {
        font-size: 1.2rem;
      }
    }

    /* Loading animation */
    .loading {
      display: none;
    }

    .loading.active {
      display: inline-block;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Password toggle */
    .password-toggle {
      position: absolute;
      right: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #9ca3af;
      cursor: pointer;
      font-size: 1rem;
      transition: color 0.3s ease;
      z-index: 10;
    }

    .password-toggle:hover {
      color: #1e3c72;
    }

    .password-toggle:focus {
      outline: none;
    }

    /* Security indicator */
    .security-indicator {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      margin-top: 0.75rem;
      padding: 0.5rem;
      background: rgba(30, 60, 114, 0.1);
      border-radius: 6px;
      border-left: 3px solid #1e3c72;
    }

    .security-indicator i {
      color: #1e3c72;
      font-size: 0.9rem;
    }

    .security-indicator span {
      color: #374151;
      font-size: 0.75rem;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <div class="auth-container">
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

    <div class="auth-card">
      <div class="auth-header">
        <div class="brand-logo">
          <i class="bi bi-trophy"></i>
        </div>
        <h1 class="brand-title">Espace Administrateur</h1>
        <p class="brand-subtitle">Accès sécurisé</p>
      </div>
      
      <div class="auth-body">
        <?= isset($content) ? $content : '' ?>
        
        <!-- Indicateur de sécurité -->
        <div class="security-indicator">
          <i class="bi bi-shield-check"></i>
          <span>Connexion sécurisée</span>
        </div>
        
        <div class="auth-footer">
          <p>Besoin d'aide ? <a href="mailto:admin@example.com">Contactez l'admin</a></p>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>


