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

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nom'], $data['prenom'], $data['email'],
            password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
            $data['role']
        ]);
    }

    public function update($id, $data) {
        $fields = ['nom' => $data['nom'], 'prenom' => $data['prenom'], 'email' => $data['email'], 'role' => $data['role']];
        $setSql = 'nom = :nom, prenom = :prenom, email = :email, role = :role';
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
}
