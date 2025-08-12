<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/config/database.php';
require_once __DIR__ . '/../../core/Flash.php';

class UserController {
    
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

    private function ensureSelfOrAdmin(int $targetUserId): void {
        $this->requireAuth();
        $sessionUser = $_SESSION['user'];
        $isAdmin = isset($sessionUser['role']) && $sessionUser['role'] === 'admin';
        $isSelf = isset($sessionUser['id']) && (int)$sessionUser['id'] === (int)$targetUserId;
        if (!$isAdmin && !$isSelf) {
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

    public function index() {
        $this->requireAuth();
        $pdo = Database::connect();
        $model = new User($pdo);
        $sessionUser = $_SESSION['user'];
        $isAdmin = isset($sessionUser['role']) && $sessionUser['role'] === 'admin';
        if ($isAdmin) {
            $users = $model->getAll();
            $this->render('back/users/index', ['users' => $users]);
            return;
        }
        // Non-admin: aller directement sur l'édition de mon profil
        header('Location: index.php?controller=user&action=edit&id=' . urlencode((string)$sessionUser['id']));
        exit;
    }

    public function create() {
        $this->requireAuth();
        $sessionUser = $_SESSION['user'];
        $isAdmin = isset($sessionUser['role']) && $sessionUser['role'] === 'admin';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::connect();
            $model = new User($pdo);
            $postData = $_POST;
            if (!$isAdmin) {
                // Non-admins can only create adherents (or better: forbid entirely). Here we enforce role.
                $postData['role'] = 'adherent';
            }
            $model->create($postData);
            Flash::add('success', 'Utilisateur créé avec succès');
            header('Location: index.php?controller=user&action=index');
            exit;
        }
        if (!$isAdmin) {
            // Optionally restrict access entirely
            // http_response_code(403); echo 'Accès refusé'; exit;
        }
        $this->render('back/users/create');
    }

    public function edit() {
        $pdo = Database::connect();
        $model = new User($pdo);
        $id = (int)($_GET['id'] ?? 0);
        $this->ensureSelfOrAdmin($id);
        $user = $model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sessionUser = $_SESSION['user'];
            $isAdmin = isset($sessionUser['role']) && $sessionUser['role'] === 'admin';
            $postData = $_POST;
            if (!$isAdmin) {
                // For non-admins, prevent role escalation by forcing current role
                $postData['role'] = $user['role'];
            }
            $model->update($id, $postData);
            Flash::add('success', 'Utilisateur mis à jour');
            header('Location: index.php?controller=user&action=index');
            exit;
        }

        $this->render('back/users/edit', ['user' => $user]);
    }

    public function delete() {
        $this->requireAuth(['admin']);
        $pdo = Database::connect();
        $model = new User($pdo);
        $id = $_GET['id'];
        $model->delete($id);
        Flash::add('success', 'Utilisateur supprimé');
        header('Location: index.php?controller=user&action=index');
        exit;
    }
}
