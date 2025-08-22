<!DOCTYPE html>
<html lang="fr">
<head>
  <title><?= htmlspecialchars($activity['nom']) ?> - Espace Adhérent</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="Espace Adhérent" />

  <link rel="shortcut icon" href="images/ftco-32x32.png">
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/aos.css">
  <link href="css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  <div class="site-wrap">
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">
      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <div class="site-logo"><a href="index.php?controller=front&action=home">Espace Adhérent<span>.</span></a></div>
          <div class="ml-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="index.php?controller=front&action=home" class="nav-link">Accueil</a></li>
                <li><a href="index.php?controller=front&action=activities" class="nav-link">Activités</a></li>
                <li><a href="index.php?controller=front&action=planning" class="nav-link">Mon Planning</a></li>
                <li><a href="index.php?controller=front&action=history" class="nav-link">Historique</a></li>
                <li><a href="index.php?controller=auth&action=logout" class="nav-link">Déconnexion</a></li>
              </ul>
            </nav>
            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a>
          </div>
        </div>
      </div>
    </header>

    <div class="intro-section" id="home-section">
      <!-- Vidéo YouTube en arrière-plan avec jquery.mb.YTPlayer -->
      <a id="bgndVideo" class="player"
        data-property="{videoURL:'https://www.youtube.com/watch?v=w-cRWOjlk8c',showYTLogo:false, showAnnotations: false, showControls: false, cc_load_policy: false, containment:'#home-section',autoPlay:true, mute:true, startAt:255, stopAt: 271, opacity:1}">
      </a>
      
      <!-- Overlay sombre pour améliorer la lisibilité du texte -->
      <div class="video-overlay"></div>
      
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
            <h1 class="mb-3 text-white"><?= htmlspecialchars($activity['nom']) ?></h1>
            <p class="lead mx-auto desc mb-5 text-white">Détails de l'activité</p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="activity-details-section">
      <div class="container">
        <?php 
        $flashMessages = Flash::consumeAll();
        foreach ($flashMessages as $flash): 
            $alertClass = $flash['type'] === 'success' ? 'alert-success' : 'alert-danger';
        ?>
            <div class="alert <?= $alertClass ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endforeach; ?>

        <div class="row">
          <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
              <div class="card-body p-4">
                <div class="d-flex align-items-start mb-4">
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                      <h2 class="text-primary mb-2"><?= htmlspecialchars($activity['nom']) ?></h2>
                    </div>
                    
                    <div class="activity-meta mb-4">
                      <div class="d-flex align-items-center mb-2">
                        <span class="text-muted">
                          <strong>Coach :</strong> <?= htmlspecialchars(($activity['coach_prenom'] ?? '') . ' ' . ($activity['coach_nom'] ?? '')) ?>
                        </span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <span class="text-muted">
                          <strong>Date :</strong> <?= date('d/m/Y', strtotime($activity['date_activite'])) ?>
                        </span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <span class="text-muted">
                          <strong>Horaire :</strong> <?= substr($activity['heure_debut'], 0, 5) ?> à <?= substr($activity['heure_fin'], 0, 5) ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="activity-info mb-4">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="info-card bg-light p-3 rounded border">
                        <div class="d-flex align-items-center">
                          <div>
                            <strong class="d-block">Capacité</strong>
                            <span class="text-muted"><?= $activity['capacite'] ?> places</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="info-card bg-light p-3 rounded border">
                        <div class="d-flex align-items-center">
                          <div>
                            <strong class="d-block">Places disponibles</strong>
                            <span class="text-<?= $availableSpots > 0 ? 'success' : 'danger' ?>"><?= $availableSpots ?> places</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="activity-description">
                  <h5 class="text-primary mb-3">Description</h5>
                  <div class="bg-light p-3 rounded border">
                    <p class="mb-0"><?= nl2br(htmlspecialchars($activity['description'])) ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card border-0 shadow-lg">
              <div class="card-header bg-gradient-primary text-white">
                <h5 class="mb-0">Inscription</h5>
              </div>
              <div class="card-body p-4">
                
                <?php if ($activity['statut'] !== 'active'): ?>
                  <div class="alert alert-warning">
                    Cette activité n'est plus disponible.
                  </div>
                <?php elseif (isset($isExpired) && $isExpired): ?>
                  <div class="alert alert-danger">
                    <strong>Cette activité est déjà terminée !</strong><br>
                    Vous ne pouvez plus vous inscrire à cette activité car elle s'est déjà déroulée.
                  </div>
                <?php elseif ($availableSpots <= 0): ?>
                  <div class="alert alert-danger">
                    Cette activité est complète.
                  </div>
                <?php elseif ($isSubscribed): ?>
                  <?php
                  // Récupérer le statut de l'inscription
                  $pdo = Database::connect();
                  $inscriptionModel = new Inscription($pdo);
                  $inscription = $inscriptionModel->getByUserActivity($_SESSION['user']['id'], $activity['id']);
                  $statusClass = '';
                  $statusText = '';
                  
                  switch ($inscription['statut']) {
                      case 'en_attente':
                          $statusClass = 'warning';
                          $statusText = 'En attente de validation';
                          break;
                      case 'confirmee':
                          $statusClass = 'success';
                          $statusText = 'Inscription validée !';
                          break;
                      case 'refusee':
                          $statusClass = 'danger';
                          $statusText = 'Inscription refusée';
                          break;
                      case 'annulee':
                          $statusClass = 'secondary';
                          $statusText = 'Inscription annulée';
                          break;
                      default:
                          $statusClass = 'info';
                          $statusText = 'Inscription en cours';
                  }
                  ?>
                  <div class="alert alert-<?= $statusClass ?>">
                    <span class="text-<?= $statusClass ?> fw-bold">Statut de votre inscription :</span><br>
                    <span class="text-<?= $statusClass ?> fs-6 mt-2 fw-bold">
                      <?= $statusText ?>
                    </span>
                  </div>
                  
                  <?php if ($inscription['statut'] === 'en_attente' || $inscription['statut'] === 'confirmee'): ?>
                    <form method="POST" action="index.php?controller=front&action=cancel" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette inscription ?')">
                      <input type="hidden" name="inscription_id" value="<?= $inscription['id'] ?>">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-danger">
                          Annuler l'inscription
                        </button>
                      </div>
                    </form>
                  <?php endif; ?>
                <?php elseif (!isset($isExpired) || !$isExpired): ?>
                  <form method="POST" action="index.php?controller=front&action=subscribe">
                    <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary btn-lg">
                        S'inscrire à cette activité
                      </button>
                    </div>
                  </form>
                <?php endif; ?>
                
                <div class="mt-4">
                  <a href="index.php?controller=front&action=activities" class="btn btn-outline-secondary w-100">
                    Retour aux activités
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <p>&copy; Copyright <strong><span>Espace Adhérent</span></strong>. Tous droits réservés</p>
          </div>
        </div>
      </div>
    </footer>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/jquery.mb.YTPlayer.min.js"></script>
    <script src="js/main.js"></script>
    
    <!-- Script pour initialiser la vidéo YouTube en arrière-plan -->
    <script>
      $(document).ready(function() {
        // Initialiser le player YouTube en arrière-plan
        $("#bgndVideo").YTPlayer({
          videoURL: 'https://www.youtube.com/watch?v=w-cRWOjlk8c',
          showYTLogo: false,
          showAnnotations: false,
          showControls: false,
          cc_load_policy: false,
          containment: '#home-section',
          autoPlay: true,
          mute: true,
          startAt: 255,
          stopAt: 271,
          opacity: 1,
          onReady: function() {
            console.log('Vidéo YouTube prête');
          },
          onError: function(error) {
            console.log('Erreur vidéo YouTube:', error);
            // Fallback vers un arrière-plan statique
            $('#home-section').css('background', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)');
          }
        });
      });
    </script>
  </div>
</body>
</html>
