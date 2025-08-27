<?php
/**
 * Script de maintenance pour mettre à jour automatiquement les activités expirées
 * Ce script peut être exécuté via cron ou manuellement
 * 
 * Usage:
 * php scripts/update_expired_activities.php
 */

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../core/config/database.php';
require_once __DIR__ . '/../app/models/Activity.php';

// Configuration
$logFile = __DIR__ . '/../logs/expired_activities.log';

// Fonction de logging
function logMessage($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}" . PHP_EOL;
    
    // Afficher dans la console
    echo $logMessage;
    
    // Écrire dans le fichier de log
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

try {
    logMessage("=== Début de la vérification des activités expirées ===");
    
    // Connexion à la base de données
    $pdo = Database::connect();
    $activityModel = new Activity($pdo);
    
    // Vérifier et mettre à jour les activités expirées
    $updatedCount = $activityModel->updateExpiredActivities();
    
    if ($updatedCount > 0) {
        logMessage("✅ {$updatedCount} activité(s) expirée(s) ont été automatiquement désactivée(s).");
    } else {
        logMessage("ℹ️  Aucune activité expirée trouvée.");
    }
    
    // Récupérer les activités qui vont expirer dans les prochaines 24h
    $sql = "SELECT id, nom, date_activite, heure_fin 
            FROM activities 
            WHERE statut = 'active' 
            AND CONCAT(date_activite, ' ', heure_fin) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 24 HOUR)
            ORDER BY date_activite ASC, heure_fin ASC";
    
    $stmt = $pdo->query($sql);
    $upcomingExpired = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($upcomingExpired)) {
        logMessage("⚠️  Activités qui vont expirer dans les prochaines 24h :");
        foreach ($upcomingExpired as $activity) {
            $expiryTime = $activity['date_activite'] . ' ' . $activity['heure_fin'];
            logMessage("   - ID {$activity['id']}: {$activity['nom']} (expire le {$expiryTime})");
        }
    }
    
    logMessage("=== Fin de la vérification des activités expirées ===");
    
} catch (Exception $e) {
    logMessage("❌ Erreur lors de la vérification des activités expirées : " . $e->getMessage());
    exit(1);
}

logMessage("✅ Script terminé avec succès.");
exit(0);
