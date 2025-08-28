<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Mon Profil - Espace Adhérent</title>
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
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
                <li><a href="index.php?controller=front&action=history" class="nav-link">Historique</a></li>
                <li><a href="index.php?controller=front&action=profile" class="nav-link active">Mon Profil</a></li>
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
            <h1 class="mb-3 text-white">Mon Profil</h1>
            <p class="lead mx-auto desc mb-5 text-white">Gérez vos informations personnelles et vos préférences</p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section" id="profile-section">
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
            <span class="subheading">Mon Profil</span>
            <h2 class="heading mb-3">Gérez vos informations personnelles</h2>
            <p>Modifiez vos informations personnelles et changez votre mot de passe en toute sécurité.</p>
          </div>
        </div>

        <div class="row">
          <!-- Statistiques de l'utilisateur -->
          <div class="col-lg-4 mb-4">
            <div class="card border-danger shadow-lg h-100">
              <div class="card-header bg-gradient-danger text-white">
                <h5 class="mb-0">
                  Informations personnelles
                </h5>
              </div>
              <div class="card-body text-center">
                <div class="user-avatar-large mb-3">
               
                </div>
                <h4 class="card-title"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h4>
                <p class="text-muted">Adhérent</p>
                
                <div class="row text-center mt-4">
                  <div class="col-4">
                    <div class="stat-item">
                      <h5 class="text-danger mb-1"><?= $totalInscriptions ?></h5>
                      <small class="text-muted">Total</small>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="stat-item">
                      <h5 class="text-success mb-1"><?= $inscriptionsValidees ?></h5>
                      <small class="text-muted">Validées</small>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="stat-item">
                      <h5 class="text-warning mb-1"><?= $inscriptionsEnAttente ?></h5>
                      <small class="text-muted">En attente</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Formulaire de modification des informations -->
          <div class="col-lg-8 mb-4">
            <div class="card border-danger shadow-lg">
              <div class="card-header bg-gradient-danger text-white">
                <h5 class="mb-0">
                  Modifier mes informations
                </h5>
              </div>
              <div class="card-body p-4">
                                 <form method="POST" action="index.php?controller=front&action=updateProfile" id="updateProfileForm">
                   <!-- Informations personnelles -->
                   <div class="row mb-4">
                     <div class="col-12">
                       <h6 class="text-danger mb-3">
                         Informations personnelles
                       </h6>
                     </div>
                     <div class="col-md-6 mb-3">
                       <label for="prenom" class="form-label fw-bold">Prénom <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>">
                       <div class="invalid-feedback" id="prenom-error"></div>
                     </div>
                     <div class="col-md-6 mb-3">
                       <label for="nom" class="form-label fw-bold">Nom <span class="text-danger">*</span></label>
                       <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>">
                       <div class="invalid-feedback" id="nom-error"></div>
                     </div>
                     <div class="col-md-6 mb-3">
                       <label for="genre" class="form-label fw-bold">Genre <span class="text-danger">*</span></label>
                       <select class="form-control" id="genre" name="genre">
                         <option value="">Sélectionnez le genre</option>
                         <option value="Homme" <?= ($user['genre'] ?? '') === 'Homme' ? 'selected' : '' ?>>Homme</option>
                         <option value="Femme" <?= ($user['genre'] ?? '') === 'Femme' ? 'selected' : '' ?>>Femme</option>
                       </select>
                       <div class="invalid-feedback" id="genre-error"></div>
                     </div>
                                           <div class="col-md-6 mb-3">
                        <label for="cin" class="form-label fw-bold">CIN (Carte d'Identité Nationale) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cin" name="cin" value="<?= htmlspecialchars($user['cin'] ?? '') ?>" placeholder="Ex: 12345678">
                        <small class="form-text text-muted">
                          <i class="icon-info-circle me-1"></i>
                          Numéro de votre carte d'identité nationale (8 chiffres exactement)
                        </small>
                        <div class="invalid-feedback" id="cin-error"></div>
                      </div>
                   </div>

                   <!-- Informations de contact -->
                   <div class="row mb-4">
                     <div class="col-12">
                       <h6 class="text-danger mb-3">
                         Informations de contact
                       </h6>
                     </div>
                     <div class="col-md-6 mb-3">
                       <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                       <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                       <div class="invalid-feedback" id="email-error"></div>
                     </div>
                     <div class="col-md-6 mb-3">
                       <label for="telephone" class="form-label fw-bold">Téléphone <span class="text-danger">*</span></label>
                       <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" placeholder="Ex: 06 12 34 56 78">
                       <div class="invalid-feedback" id="telephone-error"></div>
                     </div>
                     <div class="col-12 mb-3">
                       <label for="adresse" class="form-label fw-bold">Adresse complète <span class="text-danger">*</span></label>
                       <textarea class="form-control" id="adresse" name="adresse" rows="3" placeholder="Votre adresse complète..."><?= htmlspecialchars($user['adresse'] ?? '') ?></textarea>
                       <div class="invalid-feedback" id="adresse-error"></div>
                     </div>
                   </div>

                   <div class="text-end">
                     <button type="submit" class="btn btn-danger btn-lg">
                       Mettre à jour mes informations
                     </button>
                   </div>
                 </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Formulaire de changement de mot de passe -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="card border-danger shadow-lg">
              <div class="card-header bg-gradient-danger text-white">
                <h5 class="mb-0">
                  Changer mon mot de passe
                </h5>
              </div>
              <div class="card-body p-4">
                                 <form method="POST" action="index.php?controller=front&action=changePassword" id="changePasswordForm">
                  <div class="row">
                                         <div class="col-md-4 mb-3">
                       <label for="current_password" class="form-label">Mot de passe actuel</label>
                       <input type="password" class="form-control" id="current_password" name="current_password">
                       <div class="invalid-feedback" id="current_password-error"></div>
                     </div>
                     <div class="col-md-4 mb-3">
                       <label for="new_password" class="form-label">Nouveau mot de passe</label>
                       <input type="password" class="form-control" id="new_password" name="new_password">
                       <div class="invalid-feedback" id="new_password-error"></div>
                     </div>
                     <div class="col-md-4 mb-3">
                       <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                       <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                       <div class="invalid-feedback" id="confirm_password-error"></div>
                     </div>
                  </div>
                  <button type="submit" class="btn btn-danger">
                    Changer le mot de passe
                  </button>
                </form>
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

         <!-- Script de validation personnalisée pour le formulaire de profil -->
     <script>
       document.addEventListener('DOMContentLoaded', function() {
         // Récupération des éléments du formulaire de profil
         const profileForm = document.getElementById('updateProfileForm');
         const passwordForm = document.getElementById('changePasswordForm');
         
         // Éléments du formulaire de profil
         const prenomInput = document.getElementById('prenom');
         const nomInput = document.getElementById('nom');
         const emailInput = document.getElementById('email');
         const telephoneInput = document.getElementById('telephone');
         const genreInput = document.getElementById('genre');
         const cinInput = document.getElementById('cin');
         const adresseInput = document.getElementById('adresse');
         
         // Éléments du formulaire de mot de passe
         const currentPasswordInput = document.getElementById('current_password');
         const newPasswordInput = document.getElementById('new_password');
         const confirmPasswordInput = document.getElementById('confirm_password');

         // Fonction de validation des champs
         function validateField(field, validationFunction) {
           const errorElement = document.getElementById(field.id + '-error');
           if (!errorElement) return true; // Pas d'erreur si pas d'élément d'erreur
           
           const result = validationFunction(field.value);
           
           if (result.valid) {
             field.classList.remove('is-invalid');
             field.classList.add('is-valid');
             errorElement.textContent = '';
           } else {
             field.classList.remove('is-valid');
             field.classList.add('is-invalid');
             errorElement.textContent = result.message;
           }
           return result.valid;
         }

         // Règles de validation pour le profil (tous les champs obligatoires)
         const profileValidations = {
           prenom: (value) => {
             if (!value.trim()) return { valid: false, message: 'Le prénom est obligatoire' };
             if (value.trim().length < 2) return { valid: false, message: 'Le prénom doit contenir au moins 2 caractères' };
             if (!/^[a-zA-ZÀ-ÿ\s'-]+$/.test(value.trim())) return { valid: false, message: 'Le prénom ne peut contenir que des lettres, espaces, tirets et apostrophes' };
             return { valid: true, message: '' };
           },
           nom: (value) => {
             if (!value.trim()) return { valid: false, message: 'Le nom est obligatoire' };
             if (value.trim().length < 2) return { valid: false, message: 'Le nom doit contenir au moins 2 caractères' };
             if (!/^[a-zA-ZÀ-ÿ\s'-]+$/.test(value.trim())) return { valid: false, message: 'Le nom ne peut contenir que des lettres, espaces, tirets et apostrophes' };
             return { valid: true, message: '' };
           },
           email: (value) => {
             if (!value.trim()) return { valid: false, message: 'L\'email est obligatoire' };
             const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
             if (!emailRegex.test(value.trim())) return { valid: false, message: 'Format d\'email invalide' };
             return { valid: true, message: '' };
           },
           genre: (value) => {
             if (!value.trim()) return { valid: false, message: 'Le genre est obligatoire' };
             if (!['Homme', 'Femme'].includes(value)) return { valid: false, message: 'Veuillez sélectionner un genre valide' };
             return { valid: true, message: '' };
           },
           cin: (value) => {
             if (!value.trim()) return { valid: false, message: 'Le CIN est obligatoire' };
             if (!/^\d{8}$/.test(value.trim())) return { valid: false, message: 'Le CIN doit contenir exactement 8 chiffres' };
             return { valid: true, message: '' };
           },
           telephone: (value) => {
             if (!value.trim()) return { valid: false, message: 'Le téléphone est obligatoire' };
             const phoneRegex = /^[\d\s\-\+\(\)]+$/;
             if (!phoneRegex.test(value.trim())) return { valid: false, message: 'Format de téléphone invalide' };
             if (value.trim().replace(/\D/g, '').length < 8) return { valid: false, message: 'Le numéro doit contenir au moins 8 chiffres' };
             return { valid: true, message: '' };
           },
           adresse: (value) => {
             if (!value.trim()) return { valid: false, message: 'L\'adresse est obligatoire' };
             if (value.trim().length < 10) return { valid: false, message: 'L\'adresse doit contenir au moins 10 caractères' };
             if (value.trim().length > 200) return { valid: false, message: 'L\'adresse ne peut pas dépasser 200 caractères' };
             if (!/^[a-zA-ZÀ-ÿ\s\-\'\.]+$/.test(value.trim())) return { valid: false, message: 'L\'adresse ne peut contenir que des lettres, espaces, tirets et apostrophes' };
             return { valid: true, message: '' };
           }
         };

         // Règles de validation pour le mot de passe
         const passwordValidations = {
           current_password: (value) => {
             if (!value.trim()) return { valid: false, message: 'Le mot de passe actuel est obligatoire' };
             return { valid: true, message: '' };
           },
           new_password: (value) => {
             if (!value.trim()) return { valid: false, message: 'Le nouveau mot de passe est obligatoire' };
             if (value.length < 6) return { valid: false, message: 'Le mot de passe doit contenir au moins 6 caractères' };
             if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) return { valid: false, message: 'Le mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre' };
             return { valid: true, message: '' };
           },
           confirm_password: (value) => {
             if (!value.trim()) return { valid: false, message: 'La confirmation du mot de passe est obligatoire' };
             if (value !== newPasswordInput.value) return { valid: false, message: 'Les mots de passe ne correspondent pas' };
             return { valid: true, message: '' };
           }
         };

         // Validation en temps réel pour le profil
         Object.keys(profileValidations).forEach(fieldName => {
           const field = document.getElementById(fieldName);
           if (field) {
             // Validation au chargement si le champ a une valeur
             if (field.value.trim()) {
               validateField(field, profileValidations[fieldName]);
             }
             
             // Validation quand on quitte le champ
             field.addEventListener('blur', function() {
               validateField(this, profileValidations[fieldName]);
             });
             
             // Validation aussi au changement pour feedback immédiat
             field.addEventListener('input', function() {
               if (this.value.trim()) {
                 validateField(this, profileValidations[fieldName]);
               } else {
                 // Si le champ devient vide, afficher l'erreur
                 this.classList.remove('is-valid');
                 this.classList.add('is-invalid');
                 const errorElement = document.getElementById(this.id + '-error');
                 if (errorElement) {
                   errorElement.textContent = profileValidations[fieldName]('').message;
                 }
               }
             });
           }
         });

         // Validation en temps réel pour le mot de passe
         Object.keys(passwordValidations).forEach(fieldName => {
           const field = document.getElementById(fieldName);
           if (field) {
             field.addEventListener('blur', function() {
               validateField(this, passwordValidations[fieldName]);
             });
             
             // Validation spéciale pour la confirmation
             if (fieldName === 'new_password') {
               field.addEventListener('input', function() {
                 if (confirmPasswordInput.value) {
                   validateField(confirmPasswordInput, passwordValidations.confirm_password);
                 }
               });
             }
           }
         });

         // Validation du formulaire de profil avant soumission
         profileForm.addEventListener('submit', function(event) {
           event.preventDefault();
           
           let isFormValid = true;
           
           // Valider tous les champs obligatoires
           Object.keys(profileValidations).forEach(fieldName => {
             const field = document.getElementById(fieldName);
             if (field) {
               const isValid = validateField(field, profileValidations[fieldName]);
               if (!isValid) {
                 isFormValid = false;
               }
             }
           });

           // Si le formulaire est valide, le soumettre
           if (isFormValid) {
             profileForm.submit();
           }
         });

         // Validation du formulaire de mot de passe avant soumission
         passwordForm.addEventListener('submit', function(event) {
           event.preventDefault();
           
           let isFormValid = true;
           
           // Valider tous les champs
           Object.keys(passwordValidations).forEach(fieldName => {
             const field = document.getElementById(fieldName);
             if (field) {
               const isValid = validateField(field, passwordValidations[fieldName]);
               if (!isValid) {
                 isFormValid = false;
               }
             }
           });

           // Si le formulaire est valide, le soumettre
           if (isFormValid) {
             passwordForm.submit();
           }
         });

         // Auto-format pour le numéro de téléphone
         if (telephoneInput) {
           telephoneInput.addEventListener('input', function(e) {
             let value = e.target.value.replace(/\D/g, '');
             if (value.length > 0) {
               value = value.match(/(\d{0,2})(\d{0,2})(\d{0,2})(\d{0,2})/);
               e.target.value = !value[2] ? value[1] : 
                               !value[3] ? value[1] + ' ' + value[2] : 
                               !value[4] ? value[1] + ' ' + value[2] + ' ' + value[3] : 
                               value[1] + ' ' + value[2] + ' ' + value[3] + ' ' + value[4];
             }
           });
         }
       });
     </script>
  </div>
</body>
</html>
