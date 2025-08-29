<?php
session_start();
require_once '../core/config/database.php';
require_once '../app/models/User.php';

$pdo = Database::connect();
$userModel = new User($pdo);

$message = '';
$error = '';
$tokenValid = false;
$user = null;

// Vérifier le token
$token = $_GET['token'] ?? '';
if (empty($token)) {
    $error = 'Token de réinitialisation manquant.';
} else {
    try {
        $user = $userModel->getUserByResetToken($token);
        if ($user) {
            $tokenValid = true;
        } else {
            $error = 'Token de réinitialisation invalide ou expiré.';
        }
    } catch (Exception $e) {
        $error = 'Erreur lors de la vérification du token.';
        error_log("Erreur reset_password token: " . $e->getMessage());
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValid) {
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($password)) {
        $error = 'Veuillez saisir un nouveau mot de passe.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        try {
            // Réinitialiser le mot de passe
            if ($userModel->resetPassword($user['id'], $password)) {
                $message = 'Votre mot de passe a été réinitialisé avec succès ! Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.';
                $tokenValid = false; // Masquer le formulaire
            } else {
                $error = 'Erreur lors de la réinitialisation du mot de passe. Veuillez réessayer.';
            }
        } catch (Exception $e) {
            $error = 'Une erreur est survenue. Veuillez réessayer plus tard.';
            error_log("Erreur reset_password update: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - Club Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            position: relative;
            overflow: hidden;
        }

        /* Arrière-plan sportif avec vidéo/image */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(135deg, rgba(248, 250, 252, 0.9) 0%, rgba(226, 232, 240, 0.8) 50%, rgba(203, 213, 225, 0.7) 100%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="sport" width="80" height="80" patternUnits="userSpaceOnUse"><circle cx="40" cy="40" r="4" fill="rgba(100,116,139,0.08)"/><rect x="20" y="20" width="40" height="40" fill="none" stroke="rgba(100,116,139,0.06)" stroke-width="1"/><path d="M25 25 L55 55 M55 25 L25 55" stroke="rgba(100,116,139,0.04)" stroke-width="1"/><circle cx="40" cy="40" r="15" fill="none" stroke="rgba(100,116,139,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23sport)"/></svg>');
            animation: float 25s ease-in-out infinite;
        }

        /* Éléments sportifs flottants */
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(100, 116, 139, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(100, 116, 139, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(100, 116, 139, 0.03) 0%, transparent 50%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(90deg); }
        }

        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 380px;
            margin: 1rem;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.3);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(100, 116, 139, 0.15);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            padding: 1.5rem 1.5rem 1rem;
            text-align: center;
            position: relative;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .brand-logo:hover {
            transform: scale(1.05);
        }

        .brand-logo i {
            font-size: 1.5rem;
            color: white;
        }

        .brand-title {
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 1;
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }

        .auth-body {
            padding: 1.5rem 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }

        .form-label {
            color: #374151;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
            display: block;
            transition: color 0.3s ease;
        }

        .form-group:focus-within .form-label {
            color: #10b981;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #f9fafb;
            font-weight: 500;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            transform: translateY(-1px);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .form-control.is-valid {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus + .input-icon {
            color: #10b981;
            transform: translateY(-50%) scale(1.1);
        }

        .form-control.is-invalid + .input-icon {
            color: #ef4444;
        }

        .form-control.is-valid + .input-icon {
            color: #10b981;
        }

        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.3rem;
            animation: shake 0.5s ease-in-out;
            font-weight: 500;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            75% { transform: translateX(3px); }
        }

        .btn-success {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-success:hover::before {
            left: 100%;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-success:active {
            transform: translateY(0);
        }

        .btn-success:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #64748b 0%, #475569 50%, #334155 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(100, 116, 139, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 1rem;
            animation: slideIn 0.4s ease-out;
            font-weight: 500;
            font-size: 0.85rem;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .back-link {
            color: #64748b;
            text-decoration: none;
            transition: color 0.3s ease;
            font-weight: 500;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .back-link:hover {
            color: #334155;
            transform: translateX(-2px);
        }

        .form-text {
            color: #6b7280;
            font-size: 0.8rem;
            margin-top: 0.3rem;
            font-weight: 400;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .strength-weak { color: #ef4444; }
        .strength-medium { color: #f59e0b; }
        .strength-strong { color: #10b981; }

        .loading {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .loading.active {
            animation: spin 1s linear infinite;
        }

        .text-muted {
            color: #6b7280 !important;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="brand-logo">
                    <i class="fas fa-lock"></i>
                </div>
                <h1 class="brand-title">Nouveau mot de passe</h1>
                <p class="brand-subtitle">
                    <?php if ($tokenValid): ?>
                        Créez votre nouveau mot de passe
                    <?php else: ?>
                        Réinitialisation du mot de passe
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="auth-body">
                <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="/projet-new-app-web1%20hlili/public/index.php?controller=auth&action=login" class="btn-success">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Aller à la connexion</span>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($tokenValid && !$message): ?>
                    <form method="POST" action="" id="resetForm">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                Nouveau mot de passe
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Votre nouveau mot de passe" 
                                   required 
                                   minlength="8">
                            <i class="fas fa-lock input-icon"></i>
                            <div class="password-strength" id="passwordStrength"></div>
                            <div class="form-text">
                                Le mot de passe doit contenir au moins 8 caractères.
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password" class="form-label">
                                Confirmer le mot de passe
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   placeholder="Confirmez votre nouveau mot de passe" 
                                   required>
                            <i class="fas fa-lock input-icon"></i>
                            <div class="form-text">
                                Saisissez à nouveau votre nouveau mot de passe.
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-success" id="submitBtn">
                            <i class="fas fa-save"></i>
                            <span>Réinitialiser le mot de passe</span>
                        </button>
                    </form>
                <?php endif; ?>
                
                <?php if (!$tokenValid && !$message): ?>
                    <div class="text-center">
                        <p class="text-muted mb-3">
                            Ce lien de réinitialisation n'est plus valide.
                        </p>
                        <a href="/projet-new-app-web1%20hlili/mail/forgot_password.php" class="btn-primary">
                            <i class="fas fa-key"></i>
                            <span>Demander un nouveau lien</span>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="text-center mt-4">
                    <a href="/projet-new-app-web1%20hlili/public/index.php?controller=auth&action=login" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        Retour à la connexion
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('resetForm');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            const submitBtn = document.getElementById('submitBtn');

            // Validation du mot de passe en temps réel
            function validatePassword(password) {
                let strength = 0;
                if (password.length >= 8) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                return strength;
            }

            function updatePasswordStrength(password) {
                const strengthDiv = document.getElementById('passwordStrength');
                if (!strengthDiv) return;

                if (password.length === 0) {
                    strengthDiv.textContent = '';
                    strengthDiv.className = 'password-strength';
                    return;
                }

                const strength = validatePassword(password);
                let feedback = '';
                let className = 'password-strength ';

                if (strength <= 2) {
                    feedback = 'Faible';
                    className += 'strength-weak';
                } else if (strength <= 3) {
                    feedback = 'Moyen';
                    className += 'strength-medium';
                } else {
                    feedback = 'Fort';
                    className += 'strength-strong';
                }

                strengthDiv.textContent = `Force du mot de passe : ${feedback}`;
                strengthDiv.className = className;
            }

            function showError(input, message) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                const errorElement = document.getElementById(input.id + '-error');
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.style.display = 'block';
                }
            }

            function showSuccess(input) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                const errorElement = document.getElementById(input.id + '-error');
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            }

            function clearValidation(input) {
                input.classList.remove('is-valid', 'is-invalid');
                const errorElement = document.getElementById(input.id + '-error');
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            }

            // Validation du mot de passe
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    clearValidation(this);
                    updatePasswordStrength(this.value);
                    if (this.value.trim()) {
                        showSuccess(this);
                    }
                });

                passwordInput.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        showError(this, 'Le mot de passe est obligatoire');
                    } else if (this.value.length < 8) {
                        showError(this, 'Le mot de passe doit contenir au moins 8 caractères');
                    } else {
                        showSuccess(this);
                    }
                });
            }

            // Validation de la confirmation du mot de passe
            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', function() {
                    clearValidation(this);
                    if (this.value.trim()) {
                        if (passwordInput && this.value === passwordInput.value) {
                            showSuccess(this);
                        } else {
                            showError(this, 'Les mots de passe ne correspondent pas');
                        }
                    }
                });

                confirmPasswordInput.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        showError(this, 'La confirmation est obligatoire');
                    } else if (passwordInput && this.value !== passwordInput.value) {
                        showError(this, 'Les mots de passe ne correspondent pas');
                    } else {
                        showSuccess(this);
                    }
                });
            }

            // Validation du formulaire
            if (form) {
                form.addEventListener('submit', function(e) {
                    let isValid = true;

                    // Valider mot de passe
                    if (passwordInput && !passwordInput.value.trim()) {
                        showError(passwordInput, 'Le mot de passe est obligatoire');
                        isValid = false;
                    } else if (passwordInput && passwordInput.value.length < 8) {
                        showError(passwordInput, 'Le mot de passe doit contenir au moins 8 caractères');
                        isValid = false;
                    }

                    // Valider confirmation
                    if (confirmPasswordInput && !confirmPasswordInput.value.trim()) {
                        showError(confirmPasswordInput, 'La confirmation est obligatoire');
                        isValid = false;
                    } else if (passwordInput && confirmPasswordInput && confirmPasswordInput.value !== passwordInput.value) {
                        showError(confirmPasswordInput, 'Les mots de passe ne correspondent pas');
                        isValid = false;
                    }

                    if (!isValid) {
                        e.preventDefault();
                        return;
                    }

                    // Animation de chargement
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        const originalContent = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-arrow-clockwise loading active"></i><span>Réinitialisation...</span>';
                        
                        // Réactiver le bouton après 5 secondes au cas où
                        setTimeout(() => {
                            if (submitBtn.disabled) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalContent;
                            }
                        }, 5000);
                    }
                });
            }

            // Auto-focus sur le premier champ
            if (passwordInput && !passwordInput.value) {
                passwordInput.focus();
            }
        });
    </script>
</body>
</html>
