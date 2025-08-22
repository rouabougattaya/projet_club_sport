<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Activités Disponibles - Espace Adhérent</title>
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
                <li><a href="index.php?controller=front&action=activities" class="nav-link active">Activités</a></li>
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
            <h1 class="mb-3 text-white">Activités Disponibles</h1>
            <p class="lead mx-auto desc mb-5 text-white">Découvrez toutes les activités sportives disponibles et inscrivez-vous !</p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="activities-section">
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

        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-8 section-heading">
            <span class="subheading">Catalogue des Activités</span>
            <h2 class="heading mb-3">Toutes les Activités</h2>
            <p>Parcourez notre sélection d'activités sportives et trouvez celle qui vous convient.</p>
          </div>
        </div>

        <div class="row">
          <?php if (empty($availableActivities)): ?>
            <div class="col-12 text-center">
              <div class="alert alert-info">
                <h4>Aucune activité disponible pour le moment</h4>
                <p>Revenez plus tard pour découvrir de nouvelles activités !</p>
              </div>
            </div>
          <?php else: ?>
            <?php foreach ($availableActivities as $activity): ?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="class-item border rounded shadow-sm p-3 h-100">
                  <div class="d-flex align-items-start mb-3">
                    <a href="index.php?controller=front&action=activity&id=<?= $activity['id'] ?>" class="class-item-thumbnail me-3">
                      <img src="images/img_1.jpg" alt="Activité sportive" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                    </a>
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="mb-1 text-primary">
                          <a href="index.php?controller=front&action=activity&id=<?= $activity['id'] ?>" class="text-decoration-none">
                            <?= htmlspecialchars($activity['nom']) ?>
                          </a>
                        </h5>
                        <span class="badge bg-<?= $activity['statut'] === 'active' ? 'success' : 'warning' ?> fs-6">
                          <?= $activity['statut'] === 'active' ? '✅ Active' : '⏸️ Inactive' ?>
                        </span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="activity-details mb-3">
                    <div class="d-flex align-items-center mb-2">
                      <i class="icon-user me-2 text-muted"></i>
                      <span class="text-muted">
                        <?= htmlspecialchars(($activity['coach_prenom'] ?? '') . ' ' . ($activity['coach_nom'] ?? '')) ?>
                      </span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                      <i class="icon-calendar me-3 text-muted"></i>
                      <span class="text-muted">
                        <?= date('d/m/Y', strtotime($activity['date_activite'])) ?>
                      </span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <i class="icon-clock me-2 text-muted"></i>
                      <span class="text-muted">
                        <?= substr($activity['heure_debut'], 0, 5) ?> - <?= substr($activity['heure_fin'], 0, 5) ?>
                      </span>
                    </div>
                  </div>
                  
                  <div class="activity-description mb-3">
                    <p class="text-muted small mb-0">
                      <?= htmlspecialchars(substr($activity['description'], 0, 100)) ?>...
                    </p>
                  </div>
                  
                  <div class="d-flex justify-content-center mt-auto">
                    <a href="index.php?controller=front&action=activity&id=<?= $activity['id'] ?>" class="btn btn-primary btn-sm">
                      <i class="icon-eye me-1"></i>
                      Voir les détails
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
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
 