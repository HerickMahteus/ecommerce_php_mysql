<div class="heading"><h2>Produtos</h2><a class="button" href="?r=products/create">Novo produto</a></div>
<div class="grid"><?php foreach($products as $p): ?><article class="card"><h3><?= htmlspecialchars($p['name']) ?></h3>
<p><?= nl2br(htmlspecialchars($p['description']??'')) ?></p><p class="price">R$ <?= number_format((float)$p['price'],2,',','.') ?></p><p>Estoque: <?= (int)$p['stock'] ?></p>
<form method="post" action="?r=cart/add"><input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['_csrf']) ?>"><input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>"><label>Qtd. <input type="number" name="quantity" value="1" min="1" max="<?= (int)$p['stock'] ?>" required></label><button <?= (int)$p['stock']<1?'disabled':'' ?>>Adicionar ao carrinho</button></form>
<p><a href="?r=products/edit&id=<?= (int)$p['id'] ?>">Editar</a></p>
<form method="post" action="?r=products/delete" onsubmit="return confirm('Excluir este produto?')"><input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['_csrf']) ?>"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="danger">Excluir</button></form></article><?php endforeach; ?></div>
