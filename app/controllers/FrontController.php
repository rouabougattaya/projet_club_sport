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
			// Redirect non-adherents to back office home
			header('Location: index.php?controller=user&action=index');
			exit;
		}
	}

	public function home(): void {
		$this->requireAdherent();
		
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		$inscriptionModel = new Inscription($pdo);
		$userId = $_SESSION['user']['id'];
		
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
		
		// Vérifier si l'utilisateur est déjà inscrit
		$isSubscribed = $inscriptionModel->existsForUserActivity($userId, $activityId, ['en_attente', 'confirmee']);
		
		// Compter les inscriptions pour cette activité
		$inscriptionCount = $inscriptionModel->countForActivity($activityId, ['en_attente', 'confirmee']);
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
		
		// Vérifier la capacité
		$inscriptionCount = $inscriptionModel->countForActivity($activityId, ['en_attente', 'confirmee']);
		if ($inscriptionCount >= $activity['capacite']) {
			Flash::add('danger', 'Cette activité est complète');
			header('Location: index.php?controller=front&action=activity&id=' . $activityId);
			exit;
		}
		
		// Vérifier si l'utilisateur est déjà inscrit
		if ($inscriptionModel->existsForUserActivity($userId, $activityId, ['en_attente', 'confirmee'])) {
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
}
?>



