<h2><?= $user?'Editar usuário':'Novo usuário' ?></h2><form class="form" method="post" action="?r=users/<?= $user?'update':'store' ?>">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>"><?php if($user): ?><input type="hidden" name="id" value="<?= (int)$user['id'] ?>"><?php endif; ?>
<label>Nome<input name="name" required value="<?= htmlspecialchars($user['name']??'') ?>"></label>
<label>E-mail<input type="email" name="email" required value="<?= htmlspecialchars($user['email']??'') ?>"></label>
<label>Senha <?= $user?'(deixe em branco para manter)':'' ?><input type="password" name="password" <?= $user?'':'required' ?> minlength="8" autocomplete="new-password"></label>
<button>Salvar</button> <a href="?r=users">Cancelar</a></form>
