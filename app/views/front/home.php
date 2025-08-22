<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Espace Adhérent - Accueil</title>
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
            <h1 class="mb-3 text-white">Bienvenue <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?> !</h1>
            <p class="lead mx-auto desc mb-5 text-white">Découvrez vos activités sportives et gérez vos inscriptions en toute simplicité</p>
            <p class="text-center">
              <a href="index.php?controller=front&action=activities" class="btn btn-outline-white py-3 px-5">Découvrir les activités</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="bgimg" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-7">
            <h2 class="">Gérez vos activités sportives</h2>
            <p class="lead mx-auto desc mb-5">Inscrivez-vous aux activités, consultez votre planning et suivez votre progression.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="classes-section">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-8 section-heading">
            <span class="subheading">Activités Sportives</span>
            <h2 class="heading mb-3">Activités Disponibles</h2>
            <p>Découvrez toutes les activités sportives disponibles et inscrivez-vous selon vos préférences.</p>
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
            <?php foreach (array_slice($availableActivities, 0, 6) as $activity): ?>
              <div class="col-lg-6">
                <div class="class-item d-flex align-items-center">
                  <a href="index.php?controller=front&action=activity&id=<?= $activity['id'] ?>" class="class-item-thumbnail">
                    <img src="images/img_1.jpg" alt="Activité sportive">
                  </a>
                  <div class="class-item-text">
                    <h2><a href="index.php?controller=front&action=activity&id=<?= $activity['id'] ?>"><?= htmlspecialchars($activity['nom']) ?></a></h2>
                    <span>Par <?= htmlspecialchars($activity['coach_prenom'] . ' ' . $activity['coach_nom']) ?></span>,
                    <span><?= date('d/m/Y', strtotime($activity['date_activite'])) ?> - <?= substr($activity['heure_debut'], 0, 5) ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="row mt-4">
          <div class="col-12 text-center">
            <a href="index.php?controller=front&action=activities" class="btn btn-primary">Voir toutes les activités</a>
          </div>
        </div>
      </div>
    </div>

    <div class="bgimg" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-7">
            <h2 class="">Chaque pas compte</h2>
            <p class="lead mx-auto desc mb-5">Restez motivé et suivez vos progrès dans vos activités sportives.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="schedule-section">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-8 section-heading">
            <span class="subheading">Mon Planning</span>
            <h2 class="heading mb-3">Mes Activités à Venir</h2>
            <p>Consultez vos activités programmées et gérez vos inscriptions en cours.</p>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <?php if (empty($userPlanning)): ?>
              <div class="text-center">
                <div class="alert alert-info">
                  <h4>Aucune activité planifiée</h4>
                  <p>Vous n'avez pas encore d'activités à venir.</p>
                  <a href="index.php?controller=front&action=activities" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Découvrir les activités
                  </a>
                </div>
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="table-dark">
                    <tr>
                      <th>Activité</th>
                      <th>Coach</th>
                      <th>Date</th>
                      <th>Horaire</th>
                      <th>Statut</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach (array_slice($userPlanning, 0, 5) as $inscription): ?>
                      <tr>
                        <td>
                          <strong><?= htmlspecialchars($inscription['activity_nom']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($inscription['coach_prenom'] . ' ' . $inscription['coach_nom']) ?></td>
                        <td><?= date('d/m/Y', strtotime($inscription['date_activite'])) ?></td>
                        <td><?= substr($inscription['heure_debut'], 0, 5) ?> - <?= substr($inscription['heure_fin'], 0, 5) ?></td>
                        <td>
                          <?php
                          $statusClass = '';
                          $statusText = '';
                          switch ($inscription['statut']) {
                              case 'en_attente':
                                  $statusClass = 'warning';
                                  $statusText = 'En attente';
                                  break;
                              case 'confirmee':
                                  $statusClass = 'success';
                                  $statusText = 'Confirmée';
                                  break;
                              default:
                                  $statusClass = 'secondary';
                                  $statusText = ucfirst($inscription['statut']);
                          }
                          ?>
                          <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <div class="text-center mt-4">
                <a href="index.php?controller=front&action=planning" class="btn btn-primary">Voir tout mon planning</a>
              </div>
            <?php endif; ?>
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
