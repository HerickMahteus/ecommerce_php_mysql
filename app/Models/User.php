<?php
declare(strict_types=1);

final class User
{
    public function __construct(private PDO $db) {}

    public function all(): array {
        return $this->db->query('SELECT id, name, email, created_at FROM users ORDER BY id DESC')->fetchAll();
    }
    public function find(int $id): ?array {
        $s = $this->db->prepare('SELECT id, name, email FROM users WHERE id = ?');
        $s->execute([$id]); return $s->fetch() ?: null;
    }
    public function create(string $name, string $email, string $password): void {
        $s = $this->db->prepare('INSERT INTO users (name,email,password_hash) VALUES (?,?,?)');
        $s->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
    public function update(int $id, string $name, string $email, ?string $password): void {
        if ($password !== null && $password !== '') {
            $s = $this->db->prepare('UPDATE users SET name=?, email=?, password_hash=? WHERE id=?');
            $s->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT),$id]);
        } else {
            $s = $this->db->prepare('UPDATE users SET name=?, email=? WHERE id=?');
            $s->execute([$name,$email,$id]);
        }
    }
    public function delete(int $id): void {
        $s = $this->db->prepare('DELETE FROM users WHERE id=?'); $s->execute([$id]);
    }
}
