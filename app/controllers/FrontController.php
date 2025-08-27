<?php
require_once __DIR__ . '/../../core/Flash.php';
require_once __DIR__ . '/../../core/config/database.php';
require_once __DIR__ . '/../models/Activity.php';
require_once __DIR__ . '/../models/Inscription.php';

class FrontController {

	private function requireAdherent(): void {
		if (empty($_SESSION['user'])) {
			header('Location: index.php?controller=auth&action=login');
			exit;
		}
		$role = strtolower((string)($_SESSION['user']['role'] ?? ''));
		if ($role !== 'adherent') {
			// Redirect non-adherents to dashboard (back office)
			header('Location: index.php?controller=dashboard&action=index');
			exit;
		}
	}

	public function home(): void {
		$this->requireAdherent();
		
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		$inscriptionModel = new Inscription($pdo);
		$userId = $_SESSION['user']['id'];
		
		// Mettre à jour automatiquement le statut des activités passées
		$activityModel->updateExpiredActivities();
		
		// Récupérer les activités disponibles (actives et avec de la place)
		$availableActivities = $activityModel->getAvailableActivities();
		
		// Récupérer le planning de l'adhérent (inscriptions à venir)
		$userPlanning = $inscriptionModel->getUpcomingByUser($userId);
		
		// Récupérer l'historique de l'adhérent
		$userHistory = $inscriptionModel->getHistoryByUser($userId);
		
		require __DIR__ . '/../views/front/home.php';
	}

	public function activities(): void {
		$this->requireAdherent();
		
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		
		// Mettre à jour automatiquement le statut des activités passées
		$activityModel->updateExpiredActivities();
		
		$availableActivities = $activityModel->getAvailableActivities();
		
		require __DIR__ . '/../views/front/activities.php';
	}

	public function activity(): void {
		$this->requireAdherent();
		
		$activityId = $_GET['id'] ?? null;
		if (!$activityId) {
			Flash::add('danger', 'Activité non trouvée');
			header('Location: index.php?controller=front&action=activities');
			exit;
		}
		
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		$inscriptionModel = new Inscription($pdo);
		$userId = $_SESSION['user']['id'];
		
		$activity = $activityModel->getById($activityId);
		if (!$activity) {
			Flash::add('danger', 'Activité non trouvée');
			header('Location: index.php?controller=front&action=activities');
			exit;
		}
		
		// Vérification automatique du statut de cette activité spécifique
		$wasUpdated = $activityModel->checkAndUpdateActivityStatus($activityId);
		if ($wasUpdated) {
			// Recharger l'activité pour avoir le statut mis à jour
			$activity = $activityModel->getById($activityId);
		}
		
		// Vérifier si l'activité est passée
		$isExpired = $activityModel->isActivityExpired($activityId);
		
		// Vérifier si l'utilisateur est déjà inscrit
		$isSubscribed = $inscriptionModel->hasActiveInscription($userId, $activityId);
		
		// Compter les inscriptions pour cette activité
		$inscriptionCount = $inscriptionModel->countActiveInscriptions($activityId);
		$availableSpots = $activity['capacite'] - $inscriptionCount;
		
		require __DIR__ . '/../views/front/activity.php';
	}

	public function subscribe(): void {
		$this->requireAdherent();
		
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php?controller=front&action=activities');
			exit;
		}
		
		$activityId = $_POST['activity_id'] ?? null;
		$userId = $_SESSION['user']['id'];
		
		if (!$activityId) {
			Flash::add('danger', 'Activité non spécifiée');
			header('Location: index.php?controller=front&action=activities');
			exit;
		}
		
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		$inscriptionModel = new Inscription($pdo);
		
		$activity = $activityModel->getById($activityId);
		if (!$activity) {
			Flash::add('danger', 'Activité non trouvée');
			header('Location: index.php?controller=front&action=activity&id=' . $activityId);
			exit;
		}
		
		// Vérifier si l'activité est active
		if ($activity['statut'] !== 'active') {
			Flash::add('danger', 'Cette activité n\'est plus disponible');
			header('Location: index.php?controller=front&action=activity&id=' . $activityId);
			exit;
		}
		
		// Vérifier si l'activité est passée
		if ($activityModel->isActivityExpired($activityId)) {
			Flash::add('danger', 'Cette activité est déjà terminée, vous ne pouvez plus vous inscrire');
			header('Location: index.php?controller=front&action=activity&id=' . $activityId);
			exit;
		}
		
		// Vérifier la capacité
		$inscriptionCount = $inscriptionModel->countActiveInscriptions($activityId);
		if ($inscriptionCount >= $activity['capacite']) {
			Flash::add('danger', 'Cette activité est complète');
			header('Location: index.php?controller=front&action=activity&id=' . $activityId);
			exit;
		}
		
		// Vérifier si l'utilisateur peut s'inscrire
		if (!$inscriptionModel->canUserSubscribe($userId, $activityId)) {
			Flash::add('danger', 'Vous êtes déjà inscrit à cette activité');
			header('Location: index.php?controller=front&action=activity&id=' . $activityId);
			exit;
		}
		
		// Créer l'inscription
		$success = $inscriptionModel->createInscription($activityId, $userId, 'en_attente');
		
		if ($success) {
			Flash::add('success', 'Inscription réussie ! Votre demande est en attente de confirmation.');
		} else {
			Flash::add('danger', 'Erreur lors de l\'inscription');
		}
		
		header('Location: index.php?controller=front&action=activity&id=' . $activityId);
		exit;
	}

	public function planning(): void {
		$this->requireAdherent();
		
		$pdo = Database::connect();
		$inscriptionModel = new Inscription($pdo);
		$userId = $_SESSION['user']['id'];
		
		// Récupérer le planning (SEULEMENT inscriptions validées et en attente)
		$userPlanning = $inscriptionModel->getUpcomingByUser($userId);
		
		// Récupérer quelques statistiques pour debug (SEULEMENT les statuts du planning)
		$inscriptionsEnAttente = array_filter($userPlanning, function($ins) {
			return $ins['statut'] === 'en_attente';
		});
		$inscriptionsConfirmees = array_filter($userPlanning, function($ins) {
			return in_array($ins['statut'], ['confirmee', 'validée', 'validee']);
		});
		
		// DEBUG: Récupérer TOUTES les inscriptions pour diagnostiquer
		$allInscriptions = $inscriptionModel->getAllInscriptionsByUser($userId);
		$allStatuses = array_unique(array_column($allInscriptions, 'statut'));
		
		require __DIR__ . '/../views/front/planning.php';
	}

	public function history(): void {
		$this->requireAdherent();
		
		$pdo = Database::connect();
		$inscriptionModel = new Inscription($pdo);
		$userId = $_SESSION['user']['id'];
		
		$userHistory = $inscriptionModel->getHistoryByUser($userId);
		
		require __DIR__ . '/../views/front/history.php';
	}

	public function cancel(): void {
		$this->requireAdherent();
		
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php?controller=front&action=planning');
			exit;
		}
		
		$inscriptionId = $_POST['inscription_id'] ?? null;
		$userId = $_SESSION['user']['id'];
		
		if (!$inscriptionId) {
			Flash::add('danger', 'Inscription non spécifiée');
			header('Location: index.php?controller=front&action=planning');
			exit;
		}
		
		$pdo = Database::connect();
		$inscriptionModel = new Inscription($pdo);
		
		// Vérifier que l'inscription appartient à l'utilisateur
		$inscription = $inscriptionModel->getById($inscriptionId);
		if (!$inscription || $inscription['user_id'] != $userId) {
			Flash::add('danger', 'Inscription non trouvée');
			header('Location: index.php?controller=front&action=planning');
			exit;
		}
		
		// Vérifier que l'inscription peut être annulée (en attente ou validée)
		if (!in_array($inscription['statut'], ['en_attente', 'confirmee', 'validée', 'validee'])) {
			Flash::add('danger', 'Cette inscription ne peut plus être annulée');
			header('Location: index.php?controller=front&action=planning');
			exit;
		}
		
		// SUPPRIMER complètement l'inscription de la base de données
		$success = $inscriptionModel->delete($inscriptionId);
		
		if ($success) {
			Flash::add('success', 'Inscription supprimée avec succès');
		} else {
			Flash::add('danger', 'Erreur lors de la suppression');
		}
		
		header('Location: index.php?controller=front&action=planning');
		exit;
	}

	public function profile(): void {
		$this->requireAdherent();
		
		$pdo = Database::connect();
		$userId = $_SESSION['user']['id'];
		
		// Récupérer les informations de l'utilisateur
		require_once __DIR__ . '/../models/User.php';
		$userModel = new User($pdo);
		$user = $userModel->getById($userId);
		
		// Récupérer les statistiques de l'utilisateur
		$inscriptionModel = new Inscription($pdo);
		$totalInscriptions = $inscriptionModel->countByUser($userId);
		$inscriptionsValidees = $inscriptionModel->countByUserAndStatus($userId, 'validée');
		$inscriptionsEnAttente = $inscriptionModel->countByUserAndStatus($userId, 'en_attente');
		
		require __DIR__ . '/../views/front/profile.php';
	}

	public function updateProfile(): void {
		$this->requireAdherent();
		
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		$userId = $_SESSION['user']['id'];
		$pdo = Database::connect();
		require_once __DIR__ . '/../models/User.php';
		$userModel = new User($pdo);
		
		// Récupérer les données du formulaire
		$nom = trim($_POST['nom'] ?? '');
		$prenom = trim($_POST['prenom'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$telephone = trim($_POST['telephone'] ?? '');
		$adresse = trim($_POST['adresse'] ?? '');
		$cin = trim($_POST['cin'] ?? '');
		$genre = $_POST['genre'] ?? '';
		
		// Validation des données
		if (empty($nom) || empty($prenom) || empty($email)) {
			Flash::add('danger', 'Les champs Nom, Prénom et Email sont obligatoires');
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			Flash::add('danger', 'L\'adresse email n\'est pas valide');
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		// Vérifier si l'email existe déjà (sauf pour l'utilisateur actuel)
		$existingUser = $userModel->getByEmail($email);
		if ($existingUser && $existingUser['id'] != $userId) {
			Flash::add('danger', 'Cette adresse email est déjà utilisée');
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		// Mettre à jour le profil
		$userData = [
			'nom' => $nom,
			'prenom' => $prenom,
			'email' => $email,
			'telephone' => $telephone,
			'adresse' => $adresse,
			'cin' => $cin,
			'genre' => $genre
		];
		
		$success = $userModel->update($userId, $userData);
		
		if ($success) {
			// Mettre à jour les données de session
			$_SESSION['user']['nom'] = $nom;
			$_SESSION['user']['prenom'] = $prenom;
			$_SESSION['user']['email'] = $email;
			
			Flash::add('success', 'Profil mis à jour avec succès');
		} else {
			Flash::add('danger', 'Erreur lors de la mise à jour du profil');
		}
		
		header('Location: index.php?controller=front&action=profile');
		exit;
	}

	public function changePassword(): void {
		$this->requireAdherent();
		
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		$userId = $_SESSION['user']['id'];
		$currentPassword = $_POST['current_password'] ?? '';
		$newPassword = $_POST['new_password'] ?? '';
		$confirmPassword = $_POST['confirm_password'] ?? '';
		
		// Validation
		if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
			Flash::add('danger', 'Tous les champs sont obligatoires');
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		if ($newPassword !== $confirmPassword) {
			Flash::add('danger', 'Les nouveaux mots de passe ne correspondent pas');
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		if (strlen($newPassword) < 6) {
			Flash::add('danger', 'Le nouveau mot de passe doit contenir au moins 6 caractères');
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		$pdo = Database::connect();
		require_once __DIR__ . '/../models/User.php';
		$userModel = new User($pdo);
		
		// Vérifier l'ancien mot de passe
		$user = $userModel->getById($userId);
		if (!password_verify($currentPassword, $user['mot_de_passe'])) {
			Flash::add('danger', 'Le mot de passe actuel est incorrect');
			header('Location: index.php?controller=front&action=profile');
			exit;
		}
		
		// Mettre à jour le mot de passe
		$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
		$success = $userModel->updatePassword($userId, $hashedPassword);
		
		if ($success) {
			Flash::add('success', 'Mot de passe modifié avec succès');
		} else {
			Flash::add('danger', 'Erreur lors de la modification du mot de passe');
		}
		
		header('Location: index.php?controller=front&action=profile');
		exit;
	}
}
?>



