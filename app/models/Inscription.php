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

	public function getByIdWithRelations(int $id): ?array {
		$sql = "SELECT i.*, 
				a.nom AS activity_nom, a.id_entraineur AS activity_coach_id,
				u.nom AS user_nom, u.prenom AS user_prenom
			FROM inscriptions i
			INNER JOIN activities a ON a.id = i.activity_id
			INNER JOIN users u ON u.id = i.user_id
			WHERE i.id = ? LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ?: null;
	}

	public function updateStatus(int $id, string $newStatus): bool {
		$stmt = $this->pdo->prepare('UPDATE inscriptions SET statut = ? WHERE id = ?');
		return $stmt->execute([$newStatus, $id]);
	}
}



