<?php

class Inscription {
	private $pdo;

	public function __construct($pdo) {
		$this->pdo = $pdo;
	}

	public function getAll(?int $activityId = null, ?int $coachId = null): array {
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.id_entraineur AS activity_coach_id,
				u.nom AS user_nom, u.prenom AS user_prenom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = i.user_id";
		$where = [];
		$params = [];
		if (!empty($activityId)) { $where[] = 'i.activity_id = ?'; $params[] = $activityId; }
		if (!empty($coachId)) { $where[] = 'a.id_entraineur = ?'; $params[] = $coachId; }
		if (!empty($where)) { $sql .= ' WHERE ' . implode(' AND ', $where); }
		$sql .= " ORDER BY CASE i.statut
			WHEN 'en_attente' THEN 1
			WHEN 'validée' THEN 2
			WHEN 'annulée' THEN 3
			WHEN 'terminée' THEN 4
			ELSE 5
		END, i.date_inscription DESC, i.id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getById(int $id): ?array {
		$stmt = $this->pdo->prepare("SELECT * FROM inscriptions WHERE id = ? LIMIT 1");
		$stmt->execute([$id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ?: null;
	}

	public function getByIdWithRelations(int $id): ?array {
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.id_entraineur AS activity_coach_id, a.date_activite, 
				a.heure_debut, a.heure_fin, a.description,
				u.nom AS user_nom, u.prenom AS user_prenom, u.telephone AS user_telephone,
				coach.prenom AS coach_prenom, coach.nom AS coach_nom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = i.user_id
			LEFT JOIN users coach ON coach.id = a.id_entraineur
			WHERE i.id = ? LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ?: null;
	}

	public function createInscription(int $activityId, int $userId, string $status): bool {
		$stmt = $this->pdo->prepare("INSERT INTO inscriptions (activity_id, user_id, statut, date_inscription) VALUES (?, ?, ?, NOW())");
		return $stmt->execute([$activityId, $userId, $status]);
	}

	public function existsForUserActivity(int $userId, int $activityId, array $statuses): bool {
		$placeholders = str_repeat('?,', count($statuses) - 1) . '?';
		$sql = "SELECT COUNT(*) FROM inscriptions WHERE user_id = ? AND activity_id = ? AND statut IN ($placeholders)";
		$params = array_merge([$userId, $activityId], $statuses);
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchColumn() > 0;
	}

	public function countForActivity(int $activityId, array $statuses): int {
		$placeholders = str_repeat('?,', count($statuses) - 1) . '?';
		$sql = "SELECT COUNT(*) FROM inscriptions WHERE activity_id = ? AND statut IN ($placeholders)";
		$params = array_merge([$activityId], $statuses);
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return (int)$stmt->fetchColumn();
	}

	/**
	 * Retourne les statuts considérés comme actifs (inscriptions en cours)
	 */
	private function getActiveStatuses(): array {
		return ['en_attente', 'confirmee', 'validée', 'validee'];
	}

	/**
	 * Vérifie si un utilisateur a une inscription active pour une activité
	 */
	public function hasActiveInscription(int $userId, int $activityId): bool {
		return $this->existsForUserActivity($userId, $activityId, $this->getActiveStatuses());
	}

	/**
	 * Compte les inscriptions actives pour une activité
	 */
	public function countActiveInscriptions(int $activityId): int {
		return $this->countForActivity($activityId, $this->getActiveStatuses());
	}

	/**
	 * Récupère toutes les inscriptions pour une activité donnée avec les informations utilisateur
	 */
	public function getByActivityId(int $activityId): array {
		$sql = "SELECT i.*, 
				u.nom, u.prenom, u.email, u.telephone, u.role,
				i.statut, i.date_inscription
			FROM inscriptions i
			INNER JOIN users u ON u.id = i.user_id
			WHERE i.activity_id = ?
			ORDER BY i.date_inscription DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$activityId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * Vérifie si un utilisateur peut s'inscrire à une activité
	 * (pas d'inscription active existante)
	 */
	public function canUserSubscribe(int $userId, int $activityId): bool {
		return !$this->hasActiveInscription($userId, $activityId);
	}

	public function getUpcomingByUser(int $userId): array {
		$activeStatuses = $this->getActiveStatuses();
		$placeholders = str_repeat('?,', count($activeStatuses) - 1) . '?';
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.description, a.date_activite, a.heure_debut, a.heure_fin,
				u.nom AS coach_nom, u.prenom AS coach_prenom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = a.id_entraineur
			WHERE i.user_id = ? 
			AND i.statut IN ($placeholders)
			ORDER BY a.date_activite ASC, a.heure_debut ASC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array_merge([$userId], $activeStatuses));
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getHistoryByUser(int $userId): array {
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.description, a.date_activite, a.heure_debut, a.heure_fin,
				u.nom AS coach_nom, u.prenom AS coach_prenom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = a.id_entraineur
			WHERE i.user_id = ? 
			AND i.statut IN ('annulee', 'annulée', 'annule', 'terminee', 'terminée', 'termine', 'refusée', 'refusee', 'validée', 'validee', 'confirmee')
			ORDER BY a.date_activite DESC, i.date_inscription DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$userId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function updateStatus(int $id, string $newStatus): bool {
		$stmt = $this->pdo->prepare('UPDATE inscriptions SET statut = ? WHERE id = ?');
		return $stmt->execute([$newStatus, $id]);
	}

	public function getAllInscriptionsByUser(int $userId): array {
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.description, a.date_activite, a.heure_debut, a.heure_fin,
				u.nom AS coach_nom, u.prenom AS coach_prenom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = a.id_entraineur
			WHERE i.user_id = ? 
			ORDER BY a.date_activite DESC, i.date_inscription DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$userId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getByUserActivity(int $userId, int $activityId): ?array {
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.description, a.date_activite, a.heure_debut, a.heure_fin,
				u.nom AS coach_nom, u.prenom AS coach_prenom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = a.id_entraineur
			WHERE i.user_id = ? AND i.activity_id = ?
			ORDER BY i.date_inscription DESC LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$userId, $activityId]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ?: null;
	}

	/**
	 * Récupère toutes les inscriptions pour une liste d'IDs d'activités
	 */
	public function getByActivityIds(array $activityIds): array {
		if (empty($activityIds)) {
			return [];
		}
		
		$placeholders = str_repeat('?,', count($activityIds) - 1) . '?';
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.id_entraineur AS activity_coach_id,
				u.nom AS user_nom, u.prenom AS user_prenom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = i.user_id
			WHERE i.activity_id IN ($placeholders)
			ORDER BY CASE i.statut
				WHEN 'en_attente' THEN 1
				WHEN 'validée' THEN 2
				WHEN 'annulée' THEN 3
				WHEN 'terminée' THEN 4
				ELSE 5
			END, i.date_inscription DESC, i.id DESC";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($activityIds);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * Supprime complètement une inscription de la base de données
	 */
	public function delete(int $id): bool {
		$stmt = $this->pdo->prepare("DELETE FROM inscriptions WHERE id = ?");
		return $stmt->execute([$id]);
	}

	/**
	 * Compte le nombre total d'inscriptions d'un utilisateur
	 */
	public function countByUser(int $userId): int {
		$stmt = $this->pdo->prepare("SELECT COUNT(*) FROM inscriptions WHERE user_id = ?");
		$stmt->execute([$userId]);
		return (int)$stmt->fetchColumn();
	}

	/**
	 * Compte le nombre d'inscriptions d'un utilisateur par statut
	 */
	public function countByUserAndStatus(int $userId, string $status): int {
		$stmt = $this->pdo->prepare("SELECT COUNT(*) FROM inscriptions WHERE user_id = ? AND statut = ?");
		$stmt->execute([$userId, $status]);
		return (int)$stmt->fetchColumn();
	}

}



