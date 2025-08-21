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
		$stmt = $this->pdo->prepare("SELECT * FROM activities WHERE id = ? LIMIT 1");
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


