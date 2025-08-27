<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Administration - Dashboard</title>
  <meta content="Interface d'administration professionnelle" name="description">
  <meta content="admin, dashboard, gestion" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  
  <!-- Dashboard Fix CSS -->
  <link href="assets/css/dashboard-fix.css" rel="stylesheet">
  
  <!-- Custom Professional Styles -->
  <style>
    /* Variables CSS spécifiques à l'admin - sans conflit avec main.css */
    :root {
      --admin-primary: #8B5CF6;
      --admin-primary-dark: #7C3AED;
      --admin-primary-light: #A78BFA;
      --admin-secondary: #94A3B8;
      --admin-success: #10B981;
      --admin-warning: #F59E0B;
      --admin-danger: #EF4444;
      --admin-dark-bg: #1E1B4B;
      --admin-dark-surface: #312E81;
      --admin-text-light: #F8FAFC;
      --admin-text-muted: #CBD5E1;
      --admin-border: #4C1D95;
      --admin-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --admin-shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
      --admin-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }

    /* Reset des styles pour éviter les conflits */
    body.admin-body {
      font-family: 'Inter', sans-serif !important;
      background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%) !important;
      margin: 0 !important;
      padding: 0 !important;
      overflow-x: hidden !important;
    }

    /* Header/Sidebar */
    .admin-header {
      background: linear-gradient(180deg, var(--admin-dark-bg) 0%, var(--admin-dark-surface) 100%);
      border-right: 1px solid var(--admin-border);
      box-shadow: var(--admin-shadow-lg);
      backdrop-filter: blur(10px);
      position: fixed !important;
      left: 0 !important;
      top: 0 !important;
      height: 100vh !important;
      width: 280px !important;
      z-index: 1000 !important;
      transition: all 0.3s ease;
      display: flex !important;
      flex-direction: column !important;
      overflow: hidden !important;
    }

    .admin-header .logo {
      padding: 2rem 1rem;
      border-bottom: 1px solid var(--admin-border);
      margin-bottom: 1.5rem;
      text-align: center;
      flex-shrink: 0;
    }

    .admin-header .logo h1 {
      font-family: 'Poppins', sans-serif !important;
      font-size: 1.75rem !important;
      font-weight: 800 !important;
      background: linear-gradient(135deg, #A78BFA, #C4B5FD);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 0 !important;
      text-align: center;
    }

    /* Navigation */
    .admin-nav {
      padding: 0 1rem;
      flex: 1;
      overflow-y: auto;
      margin-bottom: 1rem;
    }

    .admin-nav ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .admin-nav li {
      margin-bottom: 0.5rem;
    }

    .admin-nav a {
      display: flex;
      align-items: center;
      padding: 0.875rem 1rem;
      color: var(--admin-text-muted);
      text-decoration: none;
      border-radius: 12px;
      transition: all 0.3s ease;
      font-weight: 500;
      font-size: 0.95rem;
      position: relative;
      overflow: hidden;
    }

    .admin-nav a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 0;
      background: linear-gradient(90deg, #A78BFA, #C4B5FD);
      transition: width 0.3s ease;
      z-index: 0;
    }

    .admin-nav a:hover::before,
    .admin-nav a.active::before {
      width: 100%;
    }

    .admin-nav a .navicon {
      font-size: 1.2rem;
      margin-right: 0.75rem;
      position: relative;
      z-index: 1;
      transition: all 0.3s ease;
    }

    .admin-nav a span {
      position: relative;
      z-index: 1;
      transition: all 0.3s ease;
    }

    .admin-nav a:hover,
    .admin-nav a.active {
      color: var(--admin-text-light);
      transform: translateX(5px);
    }

    .admin-nav a:hover .navicon,
    .admin-nav a.active .navicon {
      color: var(--admin-text-light);
      transform: scale(1.1);
    }

    /* Bouton Contact Spécial */
    .contact-special-btn {
      background: linear-gradient(135deg, #A78BFA, #C4B5FD) !important;
      color: var(--admin-text-light) !important;
      margin-top: 2rem !important;
      border-radius: 12px !important;
      padding: 1.2rem 1rem !important;
      text-align: center !important;
      justify-content: center !important;
      box-shadow: var(--admin-shadow-md) !important;
      border: 2px solid rgba(167, 139, 250, 0.3) !important;
      position: relative !important;
      z-index: 1000 !important;
      display: flex !important;
      width: calc(100% - 2rem) !important;
      margin-left: 1rem !important;
      margin-right: 1rem !important;
      font-weight: 600 !important;
    }

    .contact-special-btn:hover {
      background: linear-gradient(135deg, #C4B5FD, #DDD6FE) !important;
      transform: translateX(5px) !important;
      box-shadow: var(--admin-shadow-lg) !important;
      color: var(--admin-text-light) !important;
      text-decoration: none !important;
    }

    .contact-special-btn .navicon {
      color: var(--admin-text-light) !important;
      font-size: 1.2rem !important;
    }

    .contact-special-btn span {
      color: var(--admin-text-light) !important;
      font-weight: 600 !important;
    }

    /* User Info - TOUJOURS VISIBLE EN BAS */
    .admin-user-info {
      padding: 1.5rem 1rem;
      background: var(--admin-dark-surface);
      border-top: 1px solid var(--admin-border);
      flex-shrink: 0;
      margin-top: auto;
      position: sticky;
      bottom: 0;
    }

    .admin-user-info .user-details {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
    }

    .admin-user-info .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, #A78BFA, #C4B5FD);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--admin-text-light);
      font-weight: 600;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .admin-user-info .user-text {
      flex: 1;
      min-width: 0;
    }

    .admin-user-info .user-name {
      color: var(--admin-text-light);
      font-weight: 600;
      font-size: 0.9rem;
      margin: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .admin-user-info .user-role {
      color: var(--admin-text-muted);
      font-size: 0.8rem;
      margin: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .admin-user-info .logout-btn {
      width: 100%;
      padding: 0.75rem;
      background: linear-gradient(135deg, #A78BFA, #C4B5FD);
      color: var(--admin-text-light);
      border: none;
      border-radius: 8px;
      font-weight: 500;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .admin-user-info .logout-btn:hover {
      transform: translateY(-1px);
      box-shadow: var(--admin-shadow-md);
      color: var(--admin-text-light);
      text-decoration: none;
    }

    /* Main Content - TOUJOURS À DROITE */
    .admin-main {
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      min-height: 100vh;
      margin-left: 280px !important;
      transition: all 0.3s ease;
      position: relative !important;
      z-index: 1 !important;
    }

    .admin-section {
      padding: 2rem;
    }

    /* Toggle Button pour Mobile */
    .admin-toggle {
      display: none;
      position: fixed;
      top: 1rem;
      left: 1rem;
      z-index: 1001;
      background: var(--admin-primary);
      border: none;
      color: white;
      padding: 0.5rem;
      border-radius: 8px;
      font-size: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 1199px) {
      .admin-header {
        left: -100%;
      }
      
      .admin-header.header-show {
        left: 0;
      }

      .admin-main {
        margin-left: 0;
      }

      .admin-toggle {
        display: block;
      }
    }

    @media (max-width: 768px) {
      .admin-section {
        padding: 1rem;
      }
      
      .admin-header .logo h1 {
        font-size: 1.5rem;
      }

      .admin-header {
        width: 100%;
        max-width: 280px;
      }
    }

    /* Override des styles Bootstrap pour éviter les conflits */
    .admin-body .alert {
      border: none !important;
      border-radius: 12px !important;
      font-weight: 500 !important;
      box-shadow: var(--admin-shadow-sm) !important;
      margin-bottom: 1.5rem !important;
    }

    .admin-body .alert-success {
      background: linear-gradient(135deg, var(--admin-success), #059669) !important;
      color: var(--admin-text-light) !important;
    }

    .admin-body .alert-danger {
      background: linear-gradient(135deg, var(--admin-danger), #dc2626) !important;
      color: var(--admin-text-light) !important;
    }

    .admin-body .alert-warning {
      background: linear-gradient(135deg, var(--admin-warning), #d97706) !important;
      color: var(--admin-text-light) !important;
    }

    .admin-body .alert-info {
      background: linear-gradient(135deg, #A78BFA, #C4B5FD) !important;
      color: var(--admin-text-light) !important;
    }
  </style>
</head>

<body class="admin-body">
  <!-- Toggle Button pour Mobile -->
  <button class="admin-toggle" id="adminToggle">
    <i class="bi bi-list"></i>
  </button>

  <!-- Header/Sidebar -->
  <header id="adminHeader" class="admin-header d-flex flex-column">
    <a href="index.php?controller=dashboard&action=index" class="logo d-flex align-items-center justify-content-center">
      <h1>Administration</h1>
    </a>

    <nav class="admin-nav">
      <ul>
        <li>
          <a href="index.php?controller=dashboard&action=index" <?= ($_GET['controller'] ?? '') === 'dashboard' ? 'class="active"' : '' ?>>
            <i class="bi bi-speedometer2 navicon"></i>
            <span>Tableau de Bord</span>
          </a>
        </li>
        
        <?php $role = $_SESSION['user']['role'] ?? null; $roleNorm = is_string($role) ? strtolower($role) : $role; $userId = $_SESSION['user']['id'] ?? null; ?>
        
        <?php if ($roleNorm === 'admin'): ?>
          <li>
            <a href="index.php?controller=user&action=index" <?= ($_GET['controller'] ?? '') === 'user' ? 'class="active"' : '' ?>>
              <i class="bi bi-people navicon"></i>
              <span>Utilisateurs</span>
            </a>
          </li>
          <li>
            <a href="index.php?controller=activities&action=index" <?= ($_GET['controller'] ?? '') === 'activities' ? 'class="active"' : '' ?>>
              <i class="bi bi-clipboard2-check navicon"></i>
              <span>Activités</span>
            </a>
          </li>
          <li>
            <a href="index.php?controller=inscriptions&action=index" <?= ($_GET['controller'] ?? '') === 'inscriptions' ? 'class="active"' : '' ?>>
              <i class="bi bi-list-check navicon"></i>
              <span>Inscriptions</span>
            </a>
          </li>
        <?php elseif ($roleNorm === 'entraineur'): ?>
          <li>
            <a href="index.php?controller=user&action=edit&id=<?= urlencode((string)$userId) ?>" <?= ($_GET['controller'] ?? '') === 'user' && ($_GET['action'] ?? '') === 'edit' ? 'class="active"' : '' ?>>
              <i class="bi bi-person navicon"></i>
              <span>Mon Profil</span>
            </a>
          </li>
          <li>
            <a href="index.php?controller=activities&action=index" <?= ($_GET['controller'] ?? '') === 'activities' ? 'class="active"' : '' ?>>
              <i class="bi bi-clipboard2-check navicon"></i>
              <span>Mes Activités</span>
            </a>
          </li>
          <li>
            <a href="index.php?controller=inscriptions&action=index" <?= ($_GET['controller'] ?? '') === 'inscriptions' ? 'class="active"' : '' ?>>
              <i class="bi bi-list-check navicon"></i>
              <span>Inscriptions</span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="index.php?controller=user&action=edit&id=<?= urlencode((string)$userId) ?>" <?= ($_GET['controller'] ?? '') === 'user' && ($_GET['action'] ?? '') === 'edit' ? 'class="active"' : '' ?>>
              <i class="bi bi-person navicon"></i>
              <span>Mon Profil</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>

    <?php if (!empty($_SESSION['user'])): ?>
      <div class="admin-user-info">
        <div class="user-details">
          <div class="user-avatar">
            <?= strtoupper(substr($_SESSION['user']['prenom'], 0, 1)) ?>
          </div>
          <div class="user-text">
            <p class="user-name"><?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></p>
            <p class="user-role"><?= htmlspecialchars(ucfirst($_SESSION['user']['role'])) ?></p>
          </div>
        </div>
        <a href="index.php?controller=auth&action=logout" class="logout-btn">
          <i class="bi bi-box-arrow-right"></i>
          <span>Déconnexion</span>
        </a>
      </div>
    <?php else: ?>
      <div class="admin-user-info">
        <a href="index.php?controller=auth&action=login" class="logout-btn">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Connexion</span>
        </a>
      </div>
    <?php endif; ?>
  </header>

  <!-- Main Content -->
  <main class="admin-main">
    <section class="admin-section">
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

      <?php echo isset($content) ? $content : ''; ?>
    </section>
  </main>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Admin Toggle Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const adminToggle = document.getElementById('adminToggle');
      const adminHeader = document.getElementById('adminHeader');
      
      if (adminToggle && adminHeader) {
        adminToggle.addEventListener('click', function() {
          adminHeader.classList.toggle('header-show');
        });
        
        // Fermer le menu sur mobile quand on clique ailleurs
        document.addEventListener('click', function(e) {
          if (!adminHeader.contains(e.target) && !adminToggle.contains(e.target)) {
            adminHeader.classList.remove('header-show');
          }
        });
      }
    });
  </script>
</body>
</html>


