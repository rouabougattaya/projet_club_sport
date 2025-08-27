<?php
// Calcul des statistiques
$totalUsers = count($users ?? []);
$totalActivities = count($activities ?? []);
$totalInscriptions = count($inscriptions ?? []);

$activeUsers = 0;
$pendingInscriptions = 0;
$upcomingActivities = 0;
$completedActivities = 0;

if (!empty($users)) {
    foreach ($users as $user) {
        if (isset($user['statut']) && strtolower(trim($user['statut'])) === 'actif') {
            $activeUsers++;
        }
    }
}

if (!empty($inscriptions)) {
    foreach ($inscriptions as $insc) {
        if (isset($insc['statut']) && strtolower(trim($insc['statut'])) === 'en_attente') {
            $pendingInscriptions++;
        }
    }
}

if (!empty($activities)) {
    $now = new DateTime();
    foreach ($activities as $activity) {
        if (!empty($activity['date_activite']) && !empty($activity['heure_debut'])) {
            $activityStartTime = new DateTime($activity['date_activite'] . ' ' . $activity['heure_debut']);
            if ($activityStartTime > $now) {
                $upcomingActivities++;
            } else {
                $completedActivities++;
            }
        }
    }
}

$isAdmin = !empty($isAdmin) && $isAdmin;
$isEntraineur = !empty($isEntraineur) && $isEntraineur;
?>

<div class="dashboard-container">
    
    <!-- Header principal -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="welcome-section">
                <h1 class="main-title">Tableau de Bord</h1>
                <p class="subtitle">
                    <?php if ($isAdmin): ?>
                        Administration générale de l'application
                    <?php elseif ($isEntraineur): ?>
                        Gestion de vos activités et participants
                    <?php else: ?>
                        Votre espace personnel
                    <?php endif; ?>
                </p>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <span class="avatar-text"><?= strtoupper(substr($_SESSION['user']['prenom'], 0, 1)) ?></span>
                </div>
                <div class="user-details">
                    <div class="user-name"><?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></div>
                    <div class="user-role"><?= htmlspecialchars($_SESSION['user']['role']) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="stats-section">
        <h2 class="section-title">Statistiques Générales</h2>
        <div class="stats-grid">
            <?php if ($isAdmin): ?>
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $totalUsers ?></div>
                    <div class="stat-label">Utilisateurs</div>
                    <div class="stat-detail"><?= $activeUsers ?> actifs</div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="stat-card stat-secondary">
                <div class="stat-icon">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $totalActivities ?></div>
                    <div class="stat-label">
                        <?php if ($isEntraineur): ?>
                            Mes Activités
                        <?php else: ?>
                            Activités
                        <?php endif; ?>
                    </div>
                    <div class="stat-detail"><?= $upcomingActivities ?> à venir</div>
                </div>
            </div>
            
            <div class="stat-card stat-tertiary">
                <div class="stat-icon">
                    <i class="bi bi-list-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $totalInscriptions ?></div>
                    <div class="stat-label">
                        <?php if ($isEntraineur): ?>
                            Participants
                        <?php else: ?>
                            Inscriptions
                        <?php endif; ?>
                    </div>
                    <div class="stat-detail"><?= $pendingInscriptions ?> en attente</div>
                </div>
            </div>
            
            <div class="stat-card stat-quaternary">
                <div class="stat-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $completedActivities ?></div>
                    <div class="stat-label">
                        <?php if ($isEntraineur): ?>
                            Terminées
                        <?php else: ?>
                            Participations
                        <?php endif; ?>
                    </div>
                    <div class="stat-detail">
                        <?php if ($isEntraineur): ?>
                            Activités passées
                        <?php else: ?>
                            Activités suivies
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides - CORRIGÉ -->
    <div class="actions-section">
        <h2 class="section-title">Actions Rapides</h2>
        <div class="actions-grid">
            <?php if ($isAdmin): ?>
            <a href="index.php?controller=activities&action=create" class="action-btn action-primary">
                <i class="bi bi-plus-circle"></i>
                <span class="action-text">Nouvelle Activité</span>
            </a>
            <a href="index.php?controller=user&action=create" class="action-btn action-secondary">
                <i class="bi bi-person-plus"></i>
                <span class="action-text">Nouvel Utilisateur</span>
            </a>
            <?php elseif ($isEntraineur): ?>
            <a href="index.php?controller=activities&action=create" class="action-btn action-primary">
                <i class="bi bi-plus-circle"></i>
                <span class="action-text">Nouvelle Activité</span>
            </a>
            <a href="index.php?controller=activities&action=index" class="action-btn action-secondary">
                <i class="bi bi-list-ul"></i>
                <span class="action-text">Mes Activités</span>
            </a>
            <?php endif; ?>
            
            <a href="index.php?controller=inscriptions&action=index" class="action-btn action-tertiary">
                <i class="bi bi-people"></i>
                <span class="action-text">
                    <?php if ($isEntraineur): ?>
                        Gérer Participants
                    <?php else: ?>
                        Gérer Inscriptions
                    <?php endif; ?>
                </span>
            </a>
            
            <a href="index.php?controller=activities&action=index" class="action-btn action-quaternary">
                <i class="bi bi-calendar-event"></i>
                <span class="action-text">
                    <?php if ($isEntraineur): ?>
                        Voir Mes Activités
                    <?php else: ?>
                        Voir Activités
                    <?php endif; ?>
                </span>
            </a>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <div class="content-grid">
            
            <!-- Activités récentes -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php if ($isEntraineur): ?>
                            Mes Activités Récentes
                        <?php else: ?>
                            Activités Récentes
                        <?php endif; ?>
                    </h3>
                    <a href="index.php?controller=activities&action=index" class="card-link">
                        <?php if ($isEntraineur): ?>
                            Voir mes activités
                        <?php else: ?>
                            Voir tout
                        <?php endif; ?>
                    </a>
                </div>
                <div class="card-body">
                    <?php if (!empty($activities) && count($activities) > 0): ?>
                        <div class="activity-list">
                            <?php 
                                $recentActivities = array_slice($activities, 0, 5);
                                foreach ($recentActivities as $activity): 
                            ?>
                                <div class="activity-item">
                                    <div class="activity-info">
                                        <div class="activity-name"><?= htmlspecialchars($activity['nom'] ?? 'Sans nom') ?></div>
                                        <div class="activity-meta">
                                            <?php if (!empty($activity['date_activite'])): ?>
                                                <span class="meta-item"><?= date('d/m/Y', strtotime($activity['date_activite'])) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($activity['heure_debut'])): ?>
                                                <span class="meta-item"><?= htmlspecialchars($activity['heure_debut']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="activity-status <?= (isset($activity['statut']) && trim($activity['statut']) === 'active') ? 'status-active' : 'status-inactive' ?>">
                                        <?= (isset($activity['statut']) && trim($activity['statut']) === 'active') ? 'Actif' : 'Inactif' ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>Aucune activité trouvée</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Inscriptions en attente -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php if ($isEntraineur): ?>
                            Participants en Attente
                        <?php else: ?>
                            Inscriptions en Attente
                        <?php endif; ?>
                    </h3>
                    <a href="index.php?controller=inscriptions&action=index" class="card-link">
                        <?php if ($isEntraineur): ?>
                            Voir mes participants
                        <?php else: ?>
                            Voir tout
                        <?php endif; ?>
                    </a>
                </div>
                <div class="card-body">
                    <?php 
                        $pendingInscriptionsList = [];
                        if (!empty($inscriptions)) {
                            foreach ($inscriptions as $insc) {
                                if (isset($insc['statut']) && strtolower(trim($insc['statut'])) === 'en_attente') {
                                    $pendingInscriptionsList[] = $insc;
                                }
                            }
                        }
                    ?>
                    <?php if (!empty($pendingInscriptionsList)): ?>
                        <div class="inscription-list">
                            <?php 
                                $recentPending = array_slice($pendingInscriptionsList, 0, 5);
                                foreach ($recentPending as $insc): 
                            ?>
                                <div class="inscription-item">
                                    <div class="inscription-info">
                                        <div class="inscription-name"><?= htmlspecialchars(trim(($insc['user_prenom'] ?? '') . ' ' . ($insc['user_nom'] ?? ''))) ?></div>
                                        <div class="inscription-activity"><?= htmlspecialchars($insc['activity_nom'] ?? 'Activité inconnue') ?></div>
                                    </div>
                                    <div class="inscription-status status-pending">En attente</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>Aucune inscription en attente</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Section entraîneur -->
    <?php if ($isEntraineur): ?>
    <div class="trainer-section">
        <h2 class="section-title">Mes Statistiques d'Entraîneur</h2>
        <div class="trainer-stats">
            <div class="trainer-stat">
                <div class="trainer-stat-number"><?= $totalActivities ?></div>
                <div class="trainer-stat-label">Activités Créées</div>
            </div>
            <div class="trainer-stat">
                <div class="trainer-stat-number"><?= $totalInscriptions ?></div>
                <div class="trainer-stat-label">Total Participants</div>
            </div>
            <div class="trainer-stat">
                <div class="trainer-stat-number"><?= $upcomingActivities ?></div>
                <div class="trainer-stat-label">Activités à Venir</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
/* Dashboard CSS Corrigé - v4.0 - Compatible avec le nouveau template admin.php */
:root {
    --primary-blue: #4f46e5;
    --secondary-blue: #6366f1;
    --tertiary-blue: #7c3aed;
    --quaternary-blue: #8b5cf6;
    --light-blue: #e0e7ff;
    --dark-blue: #3730a3;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --bg-light: #f8fafc;
    --border-color: #e2e8f0;
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 16px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: var(--bg-light);
    min-height: 100vh;
    overflow-x: hidden;
}

.dashboard-header {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--quaternary-blue) 100%);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
    color: white;
    box-shadow: var(--shadow-lg);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.welcome-section .main-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 6px 0;
    letter-spacing: -0.025em;
}

.subtitle {
    font-size: 1rem;
    opacity: 0.9;
    margin: 0;
    font-weight: 400;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.user-avatar {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.avatar-text {
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
}

.user-details {
    text-align: right;
}

.user-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 4px;
}

.user-role {
    font-size: 0.9rem;
    opacity: 0.8;
    text-transform: capitalize;
}

.stats-section, .actions-section, .main-content, .trainer-section {
    margin-bottom: 24px;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 16px;
    letter-spacing: -0.025em;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 18px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 18px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    border-left: 4px solid;
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-primary { border-left-color: var(--primary-blue); }
.stat-secondary { border-left-color: var(--secondary-blue); }
.stat-tertiary { border-left-color: var(--tertiary-blue); }
.stat-quaternary { border-left-color: var(--quaternary-blue); }

.stat-icon {
    width: 45px;
    height: 45px;
    background: var(--light-blue);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue);
    font-size: 1.5rem;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1;
    margin-bottom: 6px;
}

.stat-label {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 3px;
}

.stat-detail {
    font-size: 0.9rem;
    color: var(--text-light);
}

/* ACTIONS RAPIDES - CORRIGÉ ET VISIBLE */
.actions-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.action-btn {
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 16px 12px;
    text-decoration: none;
    color: var(--text-dark);
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    min-height: 60px;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    text-decoration: none;
    color: var(--text-dark);
}

.action-btn i {
    font-size: 1.2rem;
}

.action-primary { 
    border-color: var(--primary-blue); 
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    color: white;
}
.action-primary:hover { color: white; }

.action-secondary { 
    border-color: var(--secondary-blue); 
    background: linear-gradient(135deg, var(--secondary-blue) 0%, var(--tertiary-blue) 100%);
    color: white;
}
.action-secondary:hover { color: white; }

.action-tertiary { 
    border-color: var(--tertiary-blue); 
    background: linear-gradient(135deg, var(--tertiary-blue) 0%, var(--quaternary-blue) 100%);
    color: white;
}
.action-tertiary:hover { color: white; }

.action-quaternary { 
    border-color: var(--quaternary-blue); 
    background: linear-gradient(135deg, var(--quaternary-blue) 0%, var(--primary-blue) 100%);
    color: white;
}
.action-quaternary:hover { color: white; }

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 20px;
}

.content-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow);
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.card-header {
    background: var(--bg-light);
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
}

.card-link {
    color: var(--primary-blue);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 8px;
    background: var(--light-blue);
    transition: all 0.2s ease;
}

.card-link:hover {
    background: var(--primary-blue);
    color: white;
    text-decoration: none;
}

.card-body {
    padding: 20px;
}

.activity-list, .inscription-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.activity-item, .inscription-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: var(--bg-light);
    border-radius: 10px;
    transition: background-color 0.2s ease;
}

.activity-item:hover, .inscription-item:hover {
    background: #f1f5f9;
}

.activity-info, .inscription-info {
    flex: 1;
}

.activity-name, .inscription-name {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 4px;
    font-size: 1rem;
}

.activity-meta, .inscription-activity {
    font-size: 0.9rem;
    color: var(--text-light);
}

.meta-item {
    margin-right: 16px;
}

.activity-status, .inscription-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: var(--light-blue);
    color: var(--primary-blue);
}

.status-inactive {
    background: #f3f4f6;
    color: var(--text-light);
}

.status-pending {
    background: #fef3c7;
    color: #d97706;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-light);
}

.empty-state p {
    font-size: 1rem;
    margin: 0;
}

.trainer-section {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.trainer-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 18px;
    margin-top: 20px;
}

.trainer-stat {
    text-align: center;
    padding: 18px;
    background: var(--bg-light);
    border-radius: 10px;
    border: 2px solid var(--border-color);
}

.trainer-stat-number {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-bottom: 6px;
}

.trainer-stat-label {
    font-size: 0.9rem;
    color: var(--text-light);
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 12px;
    }
    
    .dashboard-header {
        padding: 20px;
    }
    
    .header-content {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .welcome-section .main-title {
        font-size: 1.6rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    }
    
    .trainer-stats {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .stat-card {
        flex-direction: column;
        text-align: center;
    }
    
    .action-btn {
        padding: 20px 16px;
        min-height: 70px;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
