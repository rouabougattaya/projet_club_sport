<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/config/database.php';
require_once __DIR__ . '/../../core/Flash.php';

class AuthController
{
    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/back/layouts/admin.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::connect();
            $model = new User($pdo);
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['mot_de_passe'] ?? '';

            $user = $model->getByEmail($email);

            if ($user) {
                $storedPassword = (string)($user['mot_de_passe'] ?? '');
                $passwordInfo = password_get_info($storedPassword);
                $isNativeHash = isset($passwordInfo['algo']) && $passwordInfo['algo'] !== 0;

                $isValid = false;
                if ($isNativeHash) {
                    // Verify against native password_hash formats
                    if (password_verify($password, $storedPassword)) {
                        $isValid = true;
                        // Upgrade hash if needed (e.g., cost changes)
                        if (password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                            $model->updatePassword($user['id'], $password);
                            // Refresh the user row
                            $user = $model->getByEmail($email) ?: $user;
                        }
                    }
                } else {
                    // Fallback: stored value seems plaintext. If it matches, upgrade it.
                    if ($storedPassword !== '' && hash_equals($storedPassword, $password)) {
                        $model->updatePassword($user['id'], $password);
                        $isValid = true;
                        // Refresh the user row
                        $user = $model->getByEmail($email) ?: $user;
                    }
                }

                if ($isValid) {
                    // Mitigate session fixation
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        session_regenerate_id(true);
                    }
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'nom' => $user['nom'],
                        'prenom' => $user['prenom'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                    ];
                    Flash::add('success', 'Connexion réussie. Bienvenue !');
                    header('Location: index.php?controller=user&action=index');
                    exit;
                }
            }

            Flash::add('danger', 'Identifiants invalides');
            $this->render('back/auth/login', [
                'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
            ]);
            return;
        }

        $this->render('back/auth/login');
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', true);
            }
            session_destroy();
        }
        Flash::add('success', 'Vous êtes déconnecté. À bientôt !');
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}


