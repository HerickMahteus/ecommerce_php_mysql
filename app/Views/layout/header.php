<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>E-commerce MVC</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header>
    <h1>Loja MVC</h1>
    <nav>
        <a href="?r=products">Produtos</a>
        <a href="?r=cart">Carrinho</a>
        <a href="?r=users">Usuários</a>
        <a href="?r=orders">Pedidos</a>
    </nav>
</header>
<main>

<?php if (!empty($_SESSION['flash'])): ?>
    <p class="flash"><?= htmlspecialchars($_SESSION['flash'], ENT_QUOTES, 'UTF-8') ?></p>
    <?php unset($_SESSION['flash']); endif; ?>

<?php if (!empty($_SESSION['user_id'])): ?>

    <span>
        Olá,
        <?= htmlspecialchars($_SESSION['user_name']) ?>
    </span>

    <form method="post" action="?r=logout">
        <input
            type="hidden"
            name="_csrf"
            value="<?= htmlspecialchars($_SESSION['_csrf']) ?>"
        >
        <button type="submit">Sair</button>
    </form>

<?php else: ?>

    <a href="?r=login">Entrar</a>

<?php endif; ?>

