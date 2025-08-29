<?php
require_once __DIR__ . '/../models/Inscription.php';
require_once __DIR__ . '/../models/Activity.php';
require_once __DIR__ . '/../../sms/SmsService.php';
require_once __DIR__ . '/../../core/config/database.php';
require_once __DIR__ . '/../../core/Flash.php';

class InscriptionsController {

	private function requireAuth(array $roles = []): void {
		if (empty($_SESSION['user'])) {
			header('Location: index.php?controller=auth&action=login');
			exit;
		}
		if (!empty($roles) && (!isset($_SESSION['user']['role']) || !in_array($_SESSION['user']['role'], $roles, true))) {
			http_response_code(403);
			echo 'Accès refusé';
			exit;
		}
	}

	private function render(string $view, array $data = []): void {
		extract($data, EXTR_SKIP);
		ob_start();
		require __DIR__ . '/../views/' . $view . '.php';
		$content = ob_get_clean();
		require __DIR__ . '/../views/back/layouts/admin.php';
	}

	public function index(): void {
		$this->requireAuth(['admin', 'entraineur']);
		$pdo = Database::connect();
		$inscModel = new Inscription($pdo);
		$activityModel = new Activity($pdo);
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$coachId = $isAdmin ? null : (int)$sessionUser['id'];
		$inscriptions = $inscModel->getAll(null, $coachId);
		$this->render('back/inscriptions/index', [
			'inscriptions' => $inscriptions,
			'isAdmin' => $isAdmin,
		]);
	}

	public function validate(): void {
		$this->requireAuth(['admin', 'entraineur']);
		$pdo = Database::connect();
		$inscModel = new Inscription($pdo);
		$smsService = new SmsService();
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$id = (int)($_GET['id'] ?? 0);
		$insc = $inscModel->getByIdWithRelations($id);
		if (!$insc) { http_response_code(404); echo 'Inscription introuvable'; exit; }
		if (!$isAdmin && (int)$insc['activity_coach_id'] !== (int)$sessionUser['id']) { http_response_code(403); echo 'Accès refusé'; exit; }
		
		// Mettre à jour le statut
		$inscModel->updateStatus($id, 'validée');
		
		// Envoyer SMS de notification si le téléphone est disponible
		if (!empty($insc['user_telephone'])) {
			$userName = $insc['user_prenom'] . ' ' . $insc['user_nom'];
			$activityDate = date('d/m/Y', strtotime($insc['date_activite']));
			$activityTime = $insc['heure_debut'];
			$coachName = $insc['coach_prenom'] . ' ' . $insc['coach_nom'];
			
			$smsResult = $smsService->sendAcceptanceNotification(
				$userName,
				$insc['activity_nom'],
				$activityDate,
				$activityTime,
				$coachName,
				$insc['user_telephone']
			);
			
			if ($smsResult['success']) {
				Flash::add('success', 'Inscription validée et SMS envoyé avec succès');
			} else {
				Flash::add('warning', 'Inscription validée mais échec de l\'envoi du SMS: ' . $smsResult['message']);
			}
		} else {
			Flash::add('success', 'Inscription validée (pas de numéro de téléphone pour SMS)');
		}
		
		header('Location: index.php?controller=inscriptions&action=index');
		exit;
	}

	public function cancel(): void {
		$this->requireAuth(['admin', 'entraineur']);
		$pdo = Database::connect();
		$inscModel = new Inscription($pdo);
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$id = (int)($_GET['id'] ?? 0);
		$insc = $inscModel->getByIdWithRelations($id);
		if (!$insc) { http_response_code(404); echo 'Inscription introuvable'; exit; }
		if (!$isAdmin && (int)$insc['activity_coach_id'] !== (int)$sessionUser['id']) { http_response_code(403); echo 'Accès refusé'; exit; }
		$inscModel->updateStatus($id, 'annulée');
		Flash::add('success', 'Inscription annulée');
		header('Location: index.php?controller=inscriptions&action=index');
		exit;
	}

	public function refuse(): void {
		$this->requireAuth(['admin', 'entraineur']);
		$pdo = Database::connect();
		$inscModel = new Inscription($pdo);
		$smsService = new SmsService();
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$id = (int)($_GET['id'] ?? 0);
		$insc = $inscModel->getByIdWithRelations($id);
		if (!$insc) { http_response_code(404); echo 'Inscription introuvable'; exit; }
		if (!$isAdmin && (int)$insc['activity_coach_id'] !== (int)$sessionUser['id']) { http_response_code(403); echo 'Accès refusé'; exit; }
		
		// Mettre à jour le statut
		$inscModel->updateStatus($id, 'refusée');
		
		// Envoyer SMS de notification si le téléphone est disponible
		if (!empty($insc['user_telephone'])) {
			$userName = $insc['user_prenom'] . ' ' . $insc['user_nom'];
			$activityDate = date('d/m/Y', strtotime($insc['date_activite']));
			$activityTime = $insc['heure_debut'];
			$coachName = $insc['coach_prenom'] . ' ' . $insc['coach_nom'];
			
			$smsResult = $smsService->sendRejectionNotification(
				$userName,
				$insc['activity_nom'],
				$activityDate,
				$activityTime,
				$coachName,
				$insc['user_telephone']
			);
			
			if ($smsResult['success']) {
				Flash::add('success', 'Inscription refusée et SMS envoyé avec succès');
			} else {
				Flash::add('warning', 'Inscription refusée mais échec de l\'envoi du SMS: ' . $smsResult['message']);
			}
		} else {
			Flash::add('success', 'Inscription refusée (pas de numéro de téléphone pour SMS)');
		}
		
		header('Location: index.php?controller=inscriptions&action=index');
		exit;
	}
}



