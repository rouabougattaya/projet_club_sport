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
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
      position: relative;
      overflow: hidden;
    }

    /* Arrière-plan sportif avec vidéo/image */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        linear-gradient(135deg, rgba(248, 250, 252, 0.9) 0%, rgba(226, 232, 240, 0.8) 50%, rgba(203, 213, 225, 0.7) 100%),
        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="sport" width="80" height="80" patternUnits="userSpaceOnUse"><circle cx="40" cy="40" r="4" fill="rgba(100,116,139,0.08)"/><rect x="20" y="20" width="40" height="40" fill="none" stroke="rgba(100,116,139,0.06)" stroke-width="1"/><path d="M25 25 L55 55 M55 25 L25 55" stroke="rgba(100,116,139,0.04)" stroke-width="1"/><circle cx="40" cy="40" r="15" fill="none" stroke="rgba(100,116,139,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23sport)"/></svg>');
      animation: float 25s ease-in-out infinite;
    }

    /* Éléments sportifs flottants */
    body::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 20%, rgba(100, 116, 139, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(100, 116, 139, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 40% 60%, rgba(100, 116, 139, 0.03) 0%, transparent 50%);
      animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 0.5; }
      50% { opacity: 1; }
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
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(226, 232, 240, 0.3);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(100, 116, 139, 0.15);
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
      background: linear-gradient(135deg, #64748b 0%, #475569 50%, #334155 100%);
      padding: 1.5rem 1.5rem 1rem;
      text-align: center;
      position: relative;
    }

    .brand-logo {
      width: 60px;
      height: 60px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 0.75rem;
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease;
      border: 2px solid rgba(255, 255, 255, 0.2);
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
      color: #64748b;
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
      border-color: #64748b;
      background: white;
      box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.1);
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
      color: #64748b;
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
      background: linear-gradient(135deg, #64748b 0%, #475569 50%, #334155 100%);
      border: none;
      border-radius: 12px;
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
      box-shadow: 0 8px 20px rgba(100, 116, 139, 0.3);
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
      color: #64748b;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .auth-footer a:hover {
      color: #475569;
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
      color: #64748b;
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
      background: rgba(100, 116, 139, 0.1);
      border-radius: 8px;
      border-left: 3px solid #64748b;
    }

    .security-indicator i {
      color: #64748b;
      font-size: 0.9rem;
    }

    .security-indicator span {
      color: #374151;
      font-size: 0.75rem;
      font-weight: 500;
    }

    /* Icônes sportives flottantes */
    .floating-icons {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
    }

    .floating-icon {
      position: absolute;
      top: var(--position);
      left: var(--position);
      font-size: 2rem;
      color: rgba(100, 116, 139, 0.1);
      animation: floatIcon 15s ease-in-out infinite;
      animation-delay: var(--delay);
      transform: rotate(0deg);
    }

    .floating-icon:nth-child(2) {
      top: 15%;
      left: 80%;
      font-size: 1.8rem;
    }

    .floating-icon:nth-child(3) {
      top: 70%;
      left: 15%;
      font-size: 2.2rem;
    }

    .floating-icon:nth-child(4) {
      top: 25%;
      left: 70%;
      font-size: 1.6rem;
    }

    .floating-icon:nth-child(5) {
      top: 80%;
      left: 60%;
      font-size: 1.9rem;
    }

    @keyframes floatIcon {
      0%, 100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.1;
      }
      25% {
        transform: translateY(-20px) rotate(90deg);
        opacity: 0.2;
      }
      50% {
        transform: translateY(-10px) rotate(180deg);
        opacity: 0.15;
      }
      75% {
        transform: translateY(-15px) rotate(270deg);
        opacity: 0.25;
      }
    }
  </style>
</head>
<body>
  <!-- Icônes sportives flottantes -->
  <div class="floating-icons">
    <i class="bi bi-dumbbell floating-icon" style="--delay: 0s; --position: 10%"></i>
    <i class="bi bi-trophy floating-icon" style="--delay: 2s; --position: 85%"></i>
    <i class="bi bi-heart-pulse floating-icon" style="--delay: 4s; --position: 20%"></i>
    <i class="bi bi-lightning-charge floating-icon" style="--delay: 6s; --position: 75%"></i>
    <i class="bi bi-speedometer2 floating-icon" style="--delay: 8s; --position: 40%"></i>
  </div>

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
          <i class="bi bi-dumbbell"></i>
        </div>
        <h1 class="brand-title">Espace Sport</h1>
        <p class="brand-subtitle">Connexion sécurisée</p>
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


