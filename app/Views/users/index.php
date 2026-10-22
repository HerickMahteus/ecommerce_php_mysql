<div class="heading"><h2>Usuários</h2><a class="button" href="?r=users/create">Novo usuário</a></div>
<table><thead><tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Criado em</th><th>Ações</th></tr></thead><tbody>
<?php foreach($users as $u): ?><tr><td><?= (int)$u['id'] ?></td><td><?= htmlspecialchars($u['name']) ?></td><td><?= htmlspecialchars($u['email']) ?></td><td><?= htmlspecialchars($u['created_at']) ?></td><td><a href="?r=users/edit&id=<?= (int)$u['id'] ?>">Editar</a>
<form class="inline" method="post" action="?r=users/delete" onsubmit="return confirm('Excluir usuário?')"><input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="danger">Excluir</button></form></td></tr><?php endforeach; ?>
</tbody></table>
