<?php
require_once __DIR__ . '/../../core/Flash.php';
require_once __DIR__ . '/../../core/config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Inscription.php';
require_once __DIR__ . '/../models/Activity.php';

class DashboardController {

    private $pdo;
    private $userModel;
    private $activityModel;
    private $inscriptionModel;

    public function __construct() {
        $this->pdo = Database::connect();
        $this->userModel = new User($this->pdo);
        $this->activityModel = new Activity($this->pdo);
        $this->inscriptionModel = new Inscription($this->pdo);
    }

    private function requireAuth(): void {
        if (empty($_SESSION['user'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        // Vérifier que l'utilisateur a le rôle admin ou entraineur
        $role = strtolower(trim($_SESSION['user']['role'] ?? ''));
        if ($role !== 'admin' && $role !== 'entraineur') {
            // Afficher une erreur d'accès au lieu de rediriger
            $this->displayError('Accès refusé', 'Vous n\'avez pas les permissions nécessaires pour accéder au back-office. Seuls les administrateurs et entraîneurs peuvent y accéder.');
            exit;
        }
    }

    private function getCurrentUserData(): array {
        $currentUser = $_SESSION['user'];
        $userRole = strtolower(trim($currentUser['role'] ?? ''));
        $userId = $currentUser['id'];

        return [
            'user' => $currentUser,
            'role' => $userRole,
            'id' => $userId
        ];
    }

    private function getAdminData(): array {
        try {
            $users = $this->userModel->getAll();
        } catch (Exception $e) {
            $users = [];
        }

        try {
            $activities = $this->activityModel->getAll();
        } catch (Exception $e) {
            $activities = [];
        }

        try {
            $inscriptions = $this->inscriptionModel->getAll();
        } catch (Exception $e) {
            $inscriptions = [];
        }

        return [
            'users' => $users,
            'activities' => $activities,
            'inscriptions' => $inscriptions,
            'isAdmin' => true,
            'isEntraineur' => false
        ];
    }

    private function getEntraineurData(int $userId): array {
        try {
            $activities = $this->activityModel->getByCoachId($userId);
        } catch (Exception $e) {
            $activities = [];
        }

        try {
            if (!empty($activities)) {
                $activityIds = array_column($activities, 'id');
                $inscriptions = $this->inscriptionModel->getByActivityIds($activityIds);
            } else {
                $inscriptions = [];
            }
        } catch (Exception $e) {
            $inscriptions = [];
        }

        return [
            'users' => [],
            'activities' => $activities,
            'inscriptions' => $inscriptions,
            'isAdmin' => false,
            'isEntraineur' => true
        ];
    }

    private function getStandardUserData(int $userId): array {
        try {
            $inscriptions = $this->inscriptionModel->getAllInscriptionsByUser($userId);
            
            if (!empty($inscriptions)) {
                $activityIds = array_column($inscriptions, 'activity_id');
                $activities = $this->activityModel->getByIds($activityIds);
            } else {
                $activities = [];
            }
        } catch (Exception $e) {
            $inscriptions = [];
            $activities = [];
        }

        return [
            'users' => [],
            'activities' => $activities,
            'inscriptions' => $inscriptions,
            'isAdmin' => false,
            'isEntraineur' => false
        ];
    }

    public function index(): void {
        $this->requireAuth();
        
        try {
            $userData = $this->getCurrentUserData();
            $role = $userData['role'];
            $userId = $userData['id'];

            // Récupérer les données selon le rôle (seulement admin ou entraineur)
            if ($role === 'admin') {
                $data = $this->getAdminData();
            } elseif ($role === 'entraineur') {
                $data = $this->getEntraineurData($userId);
            } else {
                // Ce cas ne devrait jamais arriver grâce à requireAuth()
                header('Location: index.php?controller=front&action=home');
                exit;
            }

            // Extraire les variables pour la vue
            extract($data);

            // Charger le layout admin avec le contenu du tableau de bord
            ob_start();
            require __DIR__ . '/../views/back/dashboard.php';
            $content = ob_get_clean();
            
            require __DIR__ . '/../views/back/layouts/admin.php';
            
        } catch (Exception $e) {
            $this->displayError('Erreur lors du chargement du tableau de bord', $e->getMessage());
        }
    }

    private function displayError(string $title, string $message): void {
        echo '<div class="container mt-5">';
        echo '<div class="alert alert-danger">';
        echo '<h4>' . htmlspecialchars($title) . '</h4>';
        echo '<p>' . htmlspecialchars($message) . '</p>';
        echo '</div>';
        echo '<a href="index.php" class="btn btn-primary">Retour à l\'accueil</a>';
        echo '</div>';
    }
}
