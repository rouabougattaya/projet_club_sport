<?php
require_once __DIR__ . '/../models/Activity.php';
require_once __DIR__ . '/../../core/config/database.php';
require_once __DIR__ . '/../../core/Flash.php';
require_once __DIR__ . '/../models/User.php';

class ActivitiesController {

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
		$activityModel = new Activity($pdo);
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		if ($isAdmin) {
			$activities = $activityModel->getAll();
		} else {
			$activities = $activityModel->getByCoachId((int)$sessionUser['id']);
		}
		$this->render('back/activities/index', ['activities' => $activities, 'isAdmin' => $isAdmin]);
	}

	public function create(): void {
		$this->requireAuth(['admin', 'entraineur']);
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		$userModel = new User($pdo);
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$errors = [];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$post = $_POST;
			// Expect separate fields: date_activite (YYYY-MM-DD), heure_debut (HH:MM), heure_fin (HH:MM)
			$post['date_activite'] = trim((string)($post['date_activite'] ?? '')) ?: null;
			$post['heure_debut'] = trim((string)($post['heure_debut'] ?? '')) ?: null;
			$post['heure_fin'] = trim((string)($post['heure_fin'] ?? '')) ?: null;
			if (!$isAdmin) {
				$post['id_entraineur'] = (int)$sessionUser['id'];
			}
			$coachId = (int)($post['id_entraineur'] ?? 0);
			$coach = $coachId > 0 ? $userModel->getById($coachId) : null;
			if (!$coach || ($coach['role'] ?? '') !== 'entraineur') {
				$errors[] = "L'entraîneur sélectionné est invalide.";
			}
			if (empty(trim($post['nom'] ?? ''))) {
				$errors[] = 'Le nom est requis.';
			}
			if (isset($post['capacite']) && (!is_numeric($post['capacite']) || (int)$post['capacite'] < 0)) {
				$errors[] = 'La capacité doit être un entier positif.';
			}
			if (isset($post['statut']) && !in_array($post['statut'], ['actif','inactif'], true)) {
				$errors[] = 'Le statut est invalide.';
			}
			// Optional basic time range validation
			if (!empty($post['heure_debut']) && !empty($post['heure_fin']) && $post['heure_fin'] < $post['heure_debut']) {
				$errors[] = "L'heure de fin doit être après l'heure de début.";
			}
			if (empty($errors)) {
				// Normalize statut to numeric 1/0 for storage
				$post['statut'] = ($post['statut'] ?? 'actif') === 'actif' ? 1 : 0;
				$activityModel->create($post);
				Flash::add('success', 'Activité créée');
				header('Location: index.php?controller=activities&action=index');
				exit;
			}
		}
		$coaches = $userModel->getAllByRole('entraineur');
		$this->render('back/activities/create', ['isAdmin' => $isAdmin, 'coaches' => $coaches, 'errors' => $errors, 'old' => $_POST ?? []]);
	}

	public function edit(): void {
		$this->requireAuth(['admin', 'entraineur']);
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		$userModel = new User($pdo);
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$id = (int)($_GET['id'] ?? 0);
		$activity = $activityModel->getById($id);
		if (!$activity) { http_response_code(404); echo 'Activité introuvable'; exit; }
		// Coach can only edit own activities
		if (!$isAdmin && (int)$activity['id_entraineur'] !== (int)$sessionUser['id']) { http_response_code(403); echo 'Accès refusé'; exit; }
		$errors = [];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$post = $_POST;
			// Expect separate fields: date_activite (YYYY-MM-DD), heure_debut (HH:MM), heure_fin (HH:MM)
			$post['date_activite'] = trim((string)($post['date_activite'] ?? '')) ?: null;
			$post['heure_debut'] = trim((string)($post['heure_debut'] ?? '')) ?: null;
			$post['heure_fin'] = trim((string)($post['heure_fin'] ?? '')) ?: null;
			if (!$isAdmin) {
				$post['id_entraineur'] = (int)$sessionUser['id'];
			}
			$coachId = (int)($post['id_entraineur'] ?? 0);
			$coach = $coachId > 0 ? $userModel->getById($coachId) : null;
			if (!$coach || ($coach['role'] ?? '') !== 'entraineur') {
				$errors[] = "L'entraîneur sélectionné est invalide.";
			}
			if (empty(trim($post['nom'] ?? ''))) {
				$errors[] = 'Le nom est requis.';
			}
			if (isset($post['capacite']) && (!is_numeric($post['capacite']) || (int)$post['capacite'] < 0)) {
				$errors[] = 'La capacité doit être un entier positif.';
			}
			if (isset($post['statut']) && !in_array($post['statut'], ['actif','inactif'], true)) {
				$errors[] = 'Le statut est invalide.';
			}
			// Optional basic time range validation
			if (!empty($post['heure_debut']) && !empty($post['heure_fin']) && $post['heure_fin'] < $post['heure_debut']) {
				$errors[] = "L'heure de fin doit être après l'heure de début.";
			}
			if (empty($errors)) {
				// Normalize statut to numeric 1/0 for storage
				$post['statut'] = ($post['statut'] ?? 'actif') === 'actif' ? 1 : 0;
				$activityModel->update($id, $post);
				Flash::add('success', 'Activité mise à jour');
				header('Location: index.php?controller=activities&action=index');
				exit;
			} else {
				$activity = array_merge($activity, $post);
			}
		}
		$coaches = $userModel->getAllByRole('entraineur');
		$this->render('back/activities/edit', ['activity' => $activity, 'isAdmin' => $isAdmin, 'coaches' => $coaches, 'errors' => $errors]);
	}

	public function delete(): void {
		$this->requireAuth(['admin', 'entraineur']);
		$pdo = Database::connect();
		$activityModel = new Activity($pdo);
		$sessionUser = $_SESSION['user'];
		$isAdmin = strtolower((string)($sessionUser['role'] ?? '')) === 'admin';
		$id = (int)($_GET['id'] ?? 0);
		$activity = $activityModel->getById($id);
		if (!$activity) { http_response_code(404); echo 'Activité introuvable'; exit; }
		if (!$isAdmin && (int)$activity['id_entraineur'] !== (int)$sessionUser['id']) { http_response_code(403); echo 'Accès refusé'; exit; }
		$activityModel->delete($id);
		Flash::add('success', 'Activité supprimée');
		header('Location: index.php?controller=activities&action=index');
		exit;
	}
}


