<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Mon Planning - Espace Adhérent</title>
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
                <li><a href="index.php?controller=front&action=planning" class="nav-link active">Mon Planning</a></li>
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
            <h1 class="mb-3 text-white">Mon Planning</h1>
            <p class="lead mx-auto desc mb-5 text-white">Vos activités à venir</p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="planning-section">
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
            <span class="subheading">Mes Activités</span>
            <h2 class="heading mb-3">Planning Personnel</h2>
            <p>Consultez vos inscriptions <strong>validées</strong> et <strong>en attente</strong> pour toutes vos activités.</p>
          </div>
        </div>

        <!-- Guide des statuts -->
       
        <!-- Section des statistiques du planning -->
        <div class="row mt-5">
          <div class="col-12">
            <div class="card border-primary shadow-lg">
              <div class="card-header bg-gradient-primary text-white">
                <h5 class="mb-0">
                  <i class="icon-chart-bar me-2"></i> 
                   Statistiques de votre planning
                </h5>
              </div>
              <div class="card-body p-4">
                <div class="row g-4">
                  <div class="col-md-4">
                    <div class="stat-card text-center p-4 rounded-3 bg-orange bg-opacity-10 border border-orange border-2">
                      <div class="stat-icon mb-3">
                        <span class="badge bg-orange fs-1 p-3 rounded-circle"></span>
                      </div>
                      <div class="stat-number mb-2">
                        <h2 class="text-orange fw-bold mb-0"><?= count($inscriptionsEnAttente) ?></h2>
                      </div>
                      <div class="stat-label">
                        <h6 class="text-orange fw-bold mb-1">En attente</h6>
                        <small class="text-muted">Demandes en cours</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="stat-card text-center p-4 rounded-3 bg-emerald bg-opacity-10 border border-emerald border-2">
                      <div class="stat-icon mb-3">
                        <span class="badge bg-emerald fs-1 p-3 rounded-circle"></span>
                      </div>
                      <div class="stat-number mb-2">
                        <h2 class="text-emerald fw-bold mb-0"><?= count($inscriptionsConfirmees) ?></h2>
                      </div>
                      <div class="stat-label">
                        <h6 class="text-emerald fw-bold mb-1">Confirmées</h6>
                        <small class="text-muted">Inscriptions validées</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="stat-card text-center p-4 rounded-3 bg-purple bg-opacity-10 border border-purple border-2">
                      <div class="stat-icon mb-3">
                        <span class="badge bg-purple fs-1 p-3 rounded-circle"></span>
                      </div>
                      <div class="stat-number mb-2">
                        <h2 class="text-purple fw-bold mb-0"><?= count($userPlanning) ?></h2>
                      </div>
                      <div class="stat-label">
                        <h6 class="text-purple fw-bold mb-1">Total planning</h6>
                        <small class="text-muted">Activités actives</small>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4">
                <div class="row">
                  <div class="col-12">
                    <div class="d-flex align-items-center mb-4">
                      <h5 class="text-primary mb-0"> Détail des inscriptions du planning</h5>
                    </div>
                    <?php if (!empty($userPlanning)): ?>
                      <div class="table-responsive">
                        <table class="table table-hover border-0 shadow-sm table-sm">
                          <thead class="bg-gradient-light text-dark">
                                                          <tr>
                                <th class="border-0 py-3 px-4 fw-bold">
                                  <i class=""></i>Activité
                                </th>
                                <th class="border-0 py-3 px-4 fw-bold">
                                  <i class=""></i>Coach
                                </th>
                                <th class="border-0 py-3 px-4 fw-bold">
                                  <i class="i"></i>Date
                                </th>
                                <th class="border-0 py-3 px-4 fw-bold">
                                  <i class="icon-clock me-2"></i>Horaire
                                </th>
                                <th class="border-0 py-3 px-4 fw-bold">
                                  <i class=""></i>Statut
                                </th>
                                <th class="border-0 py-2 px-3 fw-bold">
                                  <i class="icon-calendar-plus me-1"></i>Date inscription
                                </th>
                                <th class="border-0 py-2 px-3 fw-bold">
                                  <i class=""></i>Actions
                                </th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($userPlanning as $ins): ?>
                              <tr class="border-bottom hover-row">
                                <td class="py-2 px-3">
                                  <div class="d-flex align-items-center">
                                
                                    <div>
                                      <strong class="d-block"><?= htmlspecialchars($ins['activity_nom']) ?></strong>
                                      <small class="text-muted"><?= htmlspecialchars($ins['description'] ?? '') ?></small>
                                    </div>
                                  </div>
                                </td>
                                <td class="py-2 px-3">
                                  <div class="text-center">
                                    <span class="badge bg-secondary bg-opacity-75 fs-6 px-2 py-1 rounded-pill">
                                      <i class="icon-user me-1"></i><?= htmlspecialchars(($ins['coach_prenom'] ?? '') . ' ' . ($ins['coach_nom'] ?? '')) ?>
                                    </span>
                                  </div>
                                </td>
                                <td class="py-2 px-3">
                                  <span class="badge bg-secondary bg-opacity-75 fs-6 px-2 py-1 rounded-pill">
                                    <i class="icon-calendar me-1"></i><?= date('d/m/Y', strtotime($ins['date_activite'])) ?>
                                  </span>
                                </td>
                                <td class="py-2 px-3">
                                  <span class="badge bg-info bg-opacity-75 fs-6 px-2 py-1 rounded-pill">
                                    <i class="icon-clock me-1"></i><?= substr($ins['heure_debut'], 0, 5) ?> - <?= substr($ins['heure_fin'], 0, 5) ?>
                                  </span>
                                </td>
                                <td class="py-2 px-3">
                                  <span class="badge bg-<?= $ins['statut'] === 'en_attente' ? 'orange' : 'emerald' ?> fs-6 px-2 py-1 rounded-pill shadow-sm">
                                    <?php 
                                    if ($ins['statut'] === 'en_attente') {
                                        echo '⏳ En attente';
                                    } elseif (in_array($ins['statut'], ['confirmee', 'validée', 'validee'])) {
                                        echo '✅ Validée';
                                    } else {
                                        echo ucfirst($ins['statut']);
                                    }
                                    ?>
                                  </span>
                                </td>
                                <td class="py-2 px-3">
                                  <div class="text-muted">
                                    <i class="icon-calendar-plus me-1"></i>
                                    <small><?= date('d/m/Y H:i', strtotime($ins['date_inscription'])) ?></small>
                                  </div>
                                </td>
                                <td class="py-2 px-3">
                                  <?php if ($ins['statut'] === 'en_attente'): ?>
                                    <!-- En attente : peut annuler -->
                                    <div class="d-flex flex-column gap-2">
                                      <span class="text-muted small">
                                        <i class="icon-info me-1"></i> En attente de validation par l'admin
                                      </span>
                                      <form method="POST" action="index.php?controller=front&action=cancel" 
                                            style="display: inline;" 
                                            onsubmit="return confirm('⚠️ ATTENTION : Cette action supprimera définitivement votre inscription. Êtes-vous sûr de vouloir continuer ?')">
                                        <input type="hidden" name="inscription_id" value="<?= $ins['id'] ?>">
                                        <button type="submit" class="btn btn-orange btn-sm rounded-pill shadow-sm">
                                          <i class="icon-x-circle me-1"></i>
                                          Supprimer
                                        </button>
                                      </form>
                                    </div>
                                  <?php elseif (in_array($ins['statut'], ['confirmee', 'validée', 'validee'])): ?>
                                    <!-- Validée : peut annuler -->
                                    <div class="d-flex flex-column gap-2">
                                      <span class="text-emerald small">
                                        <i class="icon-check-circle me-1"></i> Votre inscription est validée !
                                      </span>
                                      <form method="POST" action="index.php?controller=front&action=cancel" 
                                            style="display: inline;" 
                                            onsubmit="return confirm('⚠️ ATTENTION : Cette action supprimera définitivement votre inscription. Êtes-vous sûr de vouloir continuer ?')">
                                        <input type="hidden" name="inscription_id" value="<?= $ins['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm">
                                          <i class="icon-x-circle me-1"></i>
                                          Supprimer
                                        </button>
                                      </form>
                                    </div>
                                  <?php endif; ?>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    <?php else: ?>
                      <div class="text-center py-5">
                        <div class="empty-state">
                          <i class="icon-inbox text-muted mb-3" style="font-size: 4rem;"></i>
                          <h5 class="text-muted mb-2">Aucune inscription active</h5>
                          <p class="text-muted mb-4">Vous n'avez pas encore d'inscriptions en cours</p>
                          <a href="index.php?controller=front&action=activities" class="btn btn-primary">
                            <i class="icon-plus-circle me-2"></i>Découvrir les activités
                          </a>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
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
