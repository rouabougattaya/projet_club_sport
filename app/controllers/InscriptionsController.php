<?php
require_once __DIR__ . '/../models/Inscription.php';
require_once __DIR__ . '/../models/Activity.php';
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
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$id = (int)($_GET['id'] ?? 0);
		$insc = $inscModel->getByIdWithRelations($id);
		if (!$insc) { http_response_code(404); echo 'Inscription introuvable'; exit; }
		if (!$isAdmin && (int)$insc['activity_coach_id'] !== (int)$sessionUser['id']) { http_response_code(403); echo 'Accès refusé'; exit; }
		$inscModel->updateStatus($id, 'validée');
		Flash::add('success', 'Inscription validée');
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
}



