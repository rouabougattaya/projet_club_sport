<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

 
public function getAll() {
    $stmt = $this->pdo->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByEmail(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function getAllByRole(string $role): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = ? ORDER BY nom, prenom");
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function create($data) {
        $cin = isset($data['cin']) && $data['cin'] !== '' ? $data['cin'] : null;
        $genre = isset($data['genre']) && $data['genre'] !== '' ? $data['genre'] : null;
        $adresse = isset($data['adresse']) && $data['adresse'] !== '' ? $data['adresse'] : null;
        $telephone = isset($data['telephone']) && $data['telephone'] !== '' ? $data['telephone'] : null;

        $stmt = $this->pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, role, cin, genre, adresse, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
            $data['role'],
            $cin,
            $genre,
            $adresse,
            $telephone,
        ]);
    }

    public function update($id, $data) {
        $fields = [
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'role' => $data['role'],
            'cin' => (isset($data['cin']) && $data['cin'] !== '') ? $data['cin'] : null,
            'genre' => (isset($data['genre']) && $data['genre'] !== '') ? $data['genre'] : null,
            'adresse' => (isset($data['adresse']) && $data['adresse'] !== '') ? $data['adresse'] : null,
            'telephone' => (isset($data['telephone']) && $data['telephone'] !== '') ? $data['telephone'] : null,
        ];
        $setSql = 'nom = :nom, prenom = :prenom, email = :email, role = :role, cin = :cin, genre = :genre, adresse = :adresse, telephone = :telephone';
        if (isset($data['mot_de_passe']) && $data['mot_de_passe'] !== '') {
            $fields['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
            $setSql .= ', mot_de_passe = :mot_de_passe';
        }
        $fields['id'] = $id;
        $stmt = $this->pdo->prepare("UPDATE users SET $setSql WHERE id = :id");
        return $stmt->execute($fields);
    }

    public function updatePassword($id, $plainPassword)
    {
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET mot_de_passe = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Nouvelles méthodes pour la réinitialisation de mot de passe
    public function createPasswordResetToken($email) {
        $token = bin2hex(random_bytes(32));
        
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        return $stmt->execute([$token, $email]) ? $token : false;
    }
    
    public function getUserByResetToken($token) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE reset_token = ? LIMIT 1");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function clearResetToken($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = NULL WHERE id = ?");
        return $stmt->execute([$userId]);
    }
    
    public function resetPassword($userId, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET mot_de_passe = ?, reset_token = NULL WHERE id = ?");
        return $stmt->execute([$hash, $userId]);
    }
}
