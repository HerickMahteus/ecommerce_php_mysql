<?php
declare(strict_types=1);

final class Order
{
    public function __construct(private PDO $db) {}

    public function all(): array {
        return $this->db->query(
            'SELECT o.id,o.user_id,u.name AS user_name,o.total,o.status,o.created_at
             FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.id DESC'
        )->fetchAll();
    }
    public function forUser(int $userId): array {
        $s=$this->db->prepare('SELECT * FROM orders WHERE user_id=? ORDER BY id DESC');
        $s->execute([$userId]); return $s->fetchAll();
    }
    public function items(int $orderId): array {
        $s=$this->db->prepare('SELECT * FROM order_items WHERE order_id=?'); $s->execute([$orderId]); return $s->fetchAll();
    }
    public function create(int $userId, array $cart): int {
        if (!$cart) throw new RuntimeException('O carrinho está vazio.');
        $this->db->beginTransaction();
        try {
            $ids=array_map('intval',array_keys($cart));
            $marks=implode(',',array_fill(0,count($ids),'?'));
            $s=$this->db->prepare("SELECT id,name,price,stock FROM products WHERE id IN ($marks) FOR UPDATE");
            $s->execute($ids); $products=[];
            foreach($s->fetchAll() as $p) $products[(int)$p['id']]=$p;
            $total=0.0;
            foreach($cart as $id=>$qty) {
                $id=(int)$id; $qty=(int)$qty;
                if($qty<1 || !isset($products[$id])) throw new RuntimeException('Produto inválido no carrinho.');
                if($products[$id]['stock']<$qty) throw new RuntimeException('Estoque insuficiente para '.$products[$id]['name'].'.');
                $total += (float)$products[$id]['price']*$qty;
            }
            $s=$this->db->prepare("INSERT INTO orders(user_id,total,status) VALUES(?,?,'realizado')");
            $s->execute([$userId,$total]); $orderId=(int)$this->db->lastInsertId();
            $item=$this->db->prepare('INSERT INTO order_items(order_id,product_id,product_name,unit_price,quantity) VALUES(?,?,?,?,?)');
            $stock=$this->db->prepare('UPDATE products SET stock=stock-? WHERE id=?');
            foreach($cart as $id=>$qty) {
                $p=$products[(int)$id]; $qty=(int)$qty;
                $item->execute([$orderId,$p['id'],$p['name'],$p['price'],$qty]);
                $stock->execute([$qty,$p['id']]);
            }
            $this->db->commit(); return $orderId;
        } catch(Throwable $e) {
            if($this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }
    public function delete(int $id): void {
        $s=$this->db->prepare('DELETE FROM orders WHERE id=?'); $s->execute([$id]);
    }
}
