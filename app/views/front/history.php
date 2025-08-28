<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Historique - Espace Adhérent</title>
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
  <link rel="stylesheet" href="css/style.css">
  
  <!-- Styles pour la vidéo d'arrière-plan -->
  <style>
    .intro-section {
      position: relative;
      min-height: 100vh;
      width: 100vw;
      display: flex;
      align-items: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      overflow: hidden;
      margin: 0;
      padding: 0;
    }
    
    .video-background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: 1;
      overflow: hidden;
    }
    
    .video-background iframe {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 100vw;
      height: 100vh;
      min-width: 100%;
      min-height: 100%;
      transform: translate(-50%, -50%);
      pointer-events: none;
      object-fit: cover;
      /* Solution pour couvrir tout l'écran sans barres noires */
      width: 100vw;
      height: 100vh;
      /* Agrandir la vidéo pour éviter les barres noires */
      width: calc(100vw + 30%);
      height: calc(100vh + 30%);
      /* Ajuster la position et l'échelle */
      transform: translate(-50%, -50%) scale(1.3);
      /* Assurer que la vidéo couvre tout */
      object-fit: cover;
      background-size: cover;
      background-position: center;
    }
    
    /* Solution alternative pour différents ratios d'écran */
    @media (min-aspect-ratio: 16/9) {
      .video-background iframe {
        width: calc(100vw + 40%);
        height: calc(100vh + 40%);
        transform: translate(-50%, -50%) scale(1.4);
      }
    }
    
    @media (max-aspect-ratio: 16/9) {
      .video-background iframe {
        width: calc(100vw + 50%);
        height: calc(100vh + 50%);
        transform: translate(-50%, -50%) scale(1.5);
      }
    }
    
    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.3);
      z-index: 2;
    }
    
    .intro-content {
      position: relative;
      z-index: 3;
      width: 100%;
      padding: 0;
    }
    
    /* Assurer que la section prend tout l'écran */
    body {
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    
    .site-wrap {
      margin: 0;
      padding: 0;
    }
    
    @media (max-width: 768px) {
      .video-background iframe {
        display: none;
      }
      
      .intro-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }
    }
  </style>
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
                <li><a href="index.php?controller=front&action=history" class="nav-link active">Historique</a></li>
                <li><a href="index.php?controller=front&action=profile" class="nav-link">Mon Profil</a></li>
                <li><a href="index.php?controller=auth&action=logout" class="nav-link">Déconnexion</a></li>
              </ul>
            </nav>
            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a>
          </div>
        </div>
      </div>
    </header>

    <div class="intro-section" id="home-section">
      <!-- Vidéo YouTube en arrière-plan -->
      <div class="video-background">
        <div id="youtube-video"></div>
      </div>
      
      <!-- Overlay sombre pour améliorer la lisibilité du texte -->
      <div class="video-overlay"></div>
      
      <div class="container intro-content">
        <div class="row align-items-center">
          <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
            <h1 class="mb-3 text-white">Historique</h1>
            <p class="lead mx-auto desc mb-5 text-white">Consultez l'historique de vos activités et inscriptions</p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="history-section">
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
            <h2 class="heading mb-3">Historique Personnel</h2>
            <p>Consultez toutes vos inscriptions avec leur statut : <strong>validé</strong>, <strong>annulé</strong>, <strong>refusé</strong>, <strong>terminé</strong>.</p>
          </div>
        </div>

        <!-- Section des statistiques de l'historique -->
        <div class="row mt-5">
          <div class="col-12">
                         <div class="card shadow-sm" style="background: white; border: 2px solid #dc3545;">
                             <div class="card-header bg-white" style="border: none;">
                <h5 class="mb-0 text-dark fw-bold">
                   Statistiques de votre historique
                </h5>
              </div>
              <div class="card-body p-4">
                <div class="row g-4">
                  <div class="col-md-3">
                  <div class="stat-card text-center p-4 rounded-3" style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                      <div class="stat-number mb-2">
                        <h2 class="fw-bold mb-0" style="color: #dc3545;"><?= count(array_filter($userHistory, function($ins) { return in_array(strtolower(trim($ins['statut'])), ['validee', 'validée', 'confirmee']); })) ?></h2>
                      </div>
                      <div class="stat-label">
                        <h6 class="fw-bold mb-1" style="color: #343a40;">Validées</h6>
                        <small class="text-muted">Inscriptions confirmées</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="stat-card text-center p-4 rounded-3" style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                      <div class="stat-number mb-2">
                        <h2 class="fw-bold mb-0" style="color: #dc3545;"><?= count(array_filter($userHistory, function($ins) { return in_array(strtolower(trim($ins['statut'])), ['terminee', 'terminée', 'termine']); })) ?></h2>
                      </div>
                      <div class="stat-label">
                        <h6 class="fw-bold mb-1" style="color: #343a40;">Terminées</h6>
                        <small class="text-muted">Activités complétées</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                  <div class="stat-card text-center p-4 rounded-3" style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                      <div class="stat-number mb-2">
                        <h2 class="fw-bold mb-0" style="color: #dc3545;"><?= count(array_filter($userHistory, function($ins) { return in_array(strtolower(trim($ins['statut'])), ['annulee', 'annulée', 'annule']); })) ?></h2>
                      </div>
                      <div class="stat-label">
                        <h6 class="fw-bold mb-1" style="color: #343a40;">Annulées</h6>
                        <small class="text-muted">Inscriptions annulées</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                  <div class="stat-card text-center p-4 rounded-3" style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                      <div class="stat-number mb-2">
                        <h2 class="fw-bold mb-0" style="color: #dc3545;"><?= count(array_filter($userHistory, function($ins) { return in_array(strtolower(trim($ins['statut'])), ['refusee', 'refusée']); })) ?></h2>
                      </div>
                      <div class="stat-label">
                        <h6 class="fw-bold mb-1" style="color: #343a40;">Refusées</h6>
                        <small class="text-muted">Inscriptions refusées</small>
                      </div>
                    </div>
                  </div>
                </div>
              
                <hr class="my-4">
                <div class="row">
                  <div class="col-12">
                    <div class="d-flex align-items-center mb-4">
                      <h5 class="mb-0 fw-bold" style="color: #343a40;"> Détail des inscriptions de l'historique</h5>
                    </div>
                    <?php if (!empty($userHistory)): ?>
                      <div class="table-responsive">
                        <table class="table table-hover border-0 shadow-sm table-sm w-100" style="background: white; border-radius: 8px; overflow: hidden; font-size: 0.9rem;">
                          <thead style="background: #dc3545; color: white;">
                            <tr>
                              <th class="border-0 py-2 px-2 fw-bold text-white" style="width: 30%;">
                                Activité
                              </th>
                              <th class="border-0 py-2 px-2 fw-bold text-white" style="width: 18%;">
                                Coach
                              </th>
                              <th class="border-0 py-2 px-2 fw-bold text-white" style="width: 15%;">
                                Date
                              </th>
                              <th class="border-0 py-2 px-2 fw-bold text-white" style="width: 15%;">
                                Horaire
                              </th>
                              <th class="border-0 py-2 px-2 fw-bold text-white" style="width: 12%;">
                                Statut
                              </th>
                              <th class="border-0 py-2 px-2 fw-bold text-white" style="width: 10%;">
                                Date inscription
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($userHistory as $ins): ?>
                              <tr class="border-bottom hover-row" style="transition: all 0.3s ease;">
                                <td class="py-2 px-2">
                                  <div class="d-flex align-items-center">
                                    <div>
                                      <strong class="d-block" style="color: #343a40; font-size: 0.9rem;"><?= htmlspecialchars($ins['activity_nom']) ?></strong>
                                      <small class="text-muted" style="font-size: 0.8rem;"><?= htmlspecialchars($ins['description'] ?? '') ?></small>
                                    </div>
                                  </div>
                                </td>
                                <td class="py-2 px-2">
                                  <div class="text-center">
                                    <span class="badge px-2 py-1 rounded-pill" style="background: #343a40; color: white; font-size: 0.8rem;">
                                      <?= htmlspecialchars(($ins['coach_prenom'] ?? '') . ' ' . ($ins['coach_nom'] ?? '')) ?>
                                    </span>
                                  </div>
                                </td>
                                <td class="py-2 px-2">
                                  <span class="badge px-2 py-1 rounded-pill" style="background: #343a40; color: white; font-size: 0.8rem;">
                                    <?= date('d/m/Y', strtotime($ins['date_activite'])) ?>
                                  </span>
                                </td>
                                <td class="py-2 px-2">
                                  <span class="badge px-2 py-1 rounded-pill" style="background: #dc3545; color: white; font-size: 0.8rem;">
                                    <?= substr($ins['heure_debut'], 0, 5) ?> - <?= substr($ins['heure_fin'], 0, 5) ?>
                                  </span>
                                </td>
                                <td class="py-2 px-2">
                                  <span class="badge px-2 py-1 rounded-pill shadow-sm" style="background: #dc3545; color: white; font-size: 0.8rem;">
                                    <?php 
                                    $exactStatus = $ins['statut'];
                                    if (in_array(strtolower(trim($exactStatus)), ['validee', 'validée', 'confirmee'])) {
                                        echo '✅ Validée';
                                    } elseif (in_array(strtolower(trim($exactStatus)), ['terminee', 'terminée', 'termine'])) {
                                        echo '🏁 Terminée';
                                    } elseif (in_array(strtolower(trim($exactStatus)), ['annulee', 'annulée', 'annule'])) {
                                        echo '❌ Annulée';
                                    } elseif (in_array(strtolower(trim($exactStatus)), ['refusée', 'refusee'])) {
                                        echo '🚫 Refusée';
                                    } else {
                                        echo ' ' . ucfirst($exactStatus);
                                    }
                                    ?>
                                  </span>
                                </td>
                                <td class="py-2 px-2">
                                  <div class="text-muted">
                                    <small style="font-size: 0.8rem;"><?= date('d/m/Y H:i', strtotime($ins['date_inscription'])) ?></small>
                                  </div>
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
                          <h5 class="text-muted mb-2">Aucun historique disponible</h5>
                          <p class="text-muted mb-4">Vous n'avez pas encore d'inscriptions dans votre historique</p>
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
    <script src="js/main.js"></script>
    
    <!-- Script pour contrôler la vidéo YouTube avec timing précis -->
    <script>
      var player;
      var startTime = 255; // 4 minutes 15 secondes
      var endTime = 271;   // 4 minutes 31 secondes
      var checkInterval;
      
      // Charger l'API YouTube
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      
      // Fonction appelée quand l'API YouTube est prête
      function onYouTubeIframeAPIReady() {
        console.log('API YouTube prête');
        player = new YT.Player('youtube-video', {
          height: '100%',
          width: '100%',
          videoId: 'w-cRWOjlk8c',
          playerVars: {
            'autoplay': 1,
            'mute': 1,
            'controls': 0,
            'showinfo': 0,
            'rel': 0,
            'modestbranding': 1,
            'iv_load_policy': 3,
            'cc_load_policy': 0,
            'playsinline': 1,
            'start': startTime
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange,
            'onError': onPlayerError
          }
        });
      }
      
      // Fonction appelée quand le player est prêt
      function onPlayerReady(event) {
        console.log('Vidéo YouTube prête');
        event.target.seekTo(startTime);
        event.target.playVideo();
        startTimeCheck();
      }
      
      // Fonction appelée quand l'état du player change
      function onPlayerStateChange(event) {
        console.log('État du player:', event.data);
        if (event.data == YT.PlayerState.PLAYING) {
          startTimeCheck();
        } else if (event.data == YT.PlayerState.PAUSED || event.data == YT.PlayerState.ENDED) {
          stopTimeCheck();
        }
      }
      
      // Démarrer la vérification du temps
      function startTimeCheck() {
        if (checkInterval) {
          clearInterval(checkInterval);
        }
        checkInterval = setInterval(checkTime, 1000);
      }
      
      // Arrêter la vérification du temps
      function stopTimeCheck() {
        if (checkInterval) {
          clearInterval(checkInterval);
          checkInterval = null;
        }
      }
      
      // Fonction pour vérifier le temps et contrôler la boucle
      function checkTime() {
        if (player && player.getCurrentTime) {
          try {
            var currentTime = player.getCurrentTime();
            console.log('Temps actuel:', currentTime);
            
            // Si on dépasse la fin, revenir au début de la séquence
            if (currentTime >= endTime) {
              console.log('Fin de séquence atteinte, retour au début');
              player.seekTo(startTime);
              player.playVideo();
            }
          } catch (e) {
            console.log('Erreur lors de la vérification du temps:', e);
          }
        }
      }
      
      // Fonction appelée en cas d'erreur
      function onPlayerError(event) {
        console.log('Erreur vidéo YouTube:', event.data);
        // Fallback vers un arrière-plan statique
        $('#home-section').css('background', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)');
      }
      
      // Gestion responsive pour mobile
      $(document).ready(function() {
        if (window.innerWidth <= 768) {
          $('#youtube-video').hide();
        }
        
        // Gestion du redimensionnement de la fenêtre
        $(window).resize(function() {
          if (window.innerWidth <= 768) {
            $('#youtube-video').hide();
          } else {
            $('#youtube-video').show();
          }
        });
      });
    </script>
  </div>
</body>
</html>

