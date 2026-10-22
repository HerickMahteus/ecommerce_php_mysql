<h2><?= $product?'Editar produto':'Novo produto' ?></h2><form class="form" method="post" action="?r=products/<?= $product?'update':'store' ?>">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>"><?php if($product): ?><input type="hidden" name="id" value="<?= (int)$product['id'] ?>"><?php endif; ?>
<label>Nome<input name="name" required maxlength="160" value="<?= htmlspecialchars($product['name']??'') ?>"></label>
<label>Descrição<textarea name="description"><?= htmlspecialchars($product['description']??'') ?></textarea></label>
<label>Preço (R$)<input type="number" name="price" min="0" step="0.01" required value="<?= htmlspecialchars((string)($product['price']??'0.00')) ?>"></label>
<label>Estoque<input type="number" name="stock" min="0" required value="<?= (int)($product['stock']??0) ?>"></label><button>Salvar</button> <a href="?r=products">Cancelar</a></form>
