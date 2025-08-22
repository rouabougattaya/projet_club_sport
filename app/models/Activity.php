<?php

class Activity {
	private $pdo;

	public function __construct($pdo) {
		$this->pdo = $pdo;
	}

	public function getAll(): array {
		$sql = "SELECT a.*, u.prenom AS coach_prenom, u.nom AS coach_nom
				FROM activities a
				LEFT JOIN users u ON u.id = a.id_entraineur
				ORDER BY CASE a.statut WHEN 1 THEN 1 ELSE 2 END, a.date_activite DESC, a.heure_debut DESC, a.id DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getById(int $id): ?array {
		$sql = "SELECT a.*, u.prenom AS coach_prenom, u.nom AS coach_nom
				FROM activities a
				LEFT JOIN users u ON u.id = a.id_entraineur
				WHERE a.id = ? LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ?: null;
	}

	public function getByCoachId(int $coachId): array {
		$sql = "SELECT a.*, u.prenom AS coach_prenom, u.nom AS coach_nom
				FROM activities a
				LEFT JOIN users u ON u.id = a.id_entraineur
				WHERE a.id_entraineur = ?
				ORDER BY CASE a.statut WHEN 1 THEN 1 ELSE 2 END, a.date_activite DESC, a.heure_debut DESC, a.id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$coachId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getAvailableActivities(): array {
		$sql = "SELECT a.*, u.prenom AS coach_prenom, u.nom AS coach_nom
				FROM activities a
				LEFT JOIN users u ON u.id = a.id_entraineur
				ORDER BY a.date_activite DESC, a.heure_debut DESC, a.id DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getTrulyAvailableActivities(): array {
		$sql = "SELECT a.*, u.prenom AS coach_prenom, u.nom AS coach_nom
				FROM activities a
				LEFT JOIN users u ON u.id = a.id_entraineur
				WHERE a.statut = 'active' 
				AND a.date_activite >= CURDATE()
				ORDER BY a.date_activite ASC, a.heure_debut ASC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * Vérifie si une activité est passée (date + heure de fin dépassées)
	 */
	public function isActivityExpired(int $activityId): bool {
		$sql = "SELECT date_activite, heure_fin 
				FROM activities 
				WHERE id = ?";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$activityId]);
		$activity = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if (!$activity) {
			return true; // Si l'activité n'existe pas, considérer comme expirée
		}
		
		// Créer un timestamp pour la fin de l'activité
		$activityEndTime = $activity['date_activite'] . ' ' . $activity['heure_fin'];
		$currentTime = date('Y-m-d H:i:s');
		
		return $activityEndTime < $currentTime;
	}

	/**
	 * Met à jour automatiquement le statut des activités passées vers "terminée"
	 */
	public function updateExpiredActivities(): void {
		$sql = "UPDATE activities 
				SET statut = 0 
				WHERE statut = 1 
				AND CONCAT(date_activite, ' ', heure_fin) < NOW()";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
	}

	public function create(array $data): bool {
		$stmt = $this->pdo->prepare("INSERT INTO activities (nom, description, date_activite, heure_debut, heure_fin, capacite, statut, id_entraineur) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		return $stmt->execute([
			$data['nom'] ?? '',
			$data['description'] ?? '',
			$data['date_activite'] ?? null,
			$data['heure_debut'] ?? null,
			$data['heure_fin'] ?? null,
			isset($data['capacite']) ? (int)$data['capacite'] : 0,
			isset($data['statut']) ? (int)$data['statut'] : 1,
			(int)($data['id_entraineur'] ?? 0),
		]);
	}

	public function update(int $id, array $data): bool {
		$stmt = $this->pdo->prepare("UPDATE activities SET nom = ?, description = ?, date_activite = ?, heure_debut = ?, heure_fin = ?, capacite = ?, statut = ?, id_entraineur = ? WHERE id = ?");
		return $stmt->execute([
			$data['nom'] ?? '',
			$data['description'] ?? '',
			$data['date_activite'] ?? null,
			$data['heure_debut'] ?? null,
			$data['heure_fin'] ?? null,
			isset($data['capacite']) ? (int)$data['capacite'] : 0,
			isset($data['statut']) ? (int)$data['statut'] : 1,
			(int)($data['id_entraineur'] ?? 0),
			$id,
		]);
	}

	public function delete(int $id): bool {
		$stmt = $this->pdo->prepare("DELETE FROM activities WHERE id = ?");
		return $stmt->execute([$id]);
	}
}


