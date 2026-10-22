<?php
declare(strict_types=1);

final class Product
{
    public function __construct(private PDO $db) {}
    public function all(): array { return $this->db->query('SELECT * FROM products ORDER BY id DESC')->fetchAll(); }
    public function find(int $id): ?array {
        $s=$this->db->prepare('SELECT * FROM products WHERE id=?'); $s->execute([$id]); return $s->fetch() ?: null;
    }
    public function create(string $name,string $description,float $price,int $stock): void {
        $s=$this->db->prepare('INSERT INTO products(name,description,price,stock) VALUES(?,?,?,?)');
        $s->execute([$name,$description,$price,$stock]);
    }
    public function update(int $id,string $name,string $description,float $price,int $stock): void {
        $s=$this->db->prepare('UPDATE products SET name=?,description=?,price=?,stock=? WHERE id=?');
        $s->execute([$name,$description,$price,$stock,$id]);
    }
    public function delete(int $id): void {
        $s=$this->db->prepare('DELETE FROM products WHERE id=?'); $s->execute([$id]);
    }
}
