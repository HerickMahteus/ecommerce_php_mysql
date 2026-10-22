# E-commerce PHP + MySQL (MVC)

Projeto-base didático com PHP 8.1+, MySQL 8+ e PDO.

## Incluído
- CRUD de usuários e produtos.
- Carrinho em sessão: adicionar, atualizar, remover e esvaziar.
- Checkout transacional, validação de estoque e cópia do preço/nome nos itens do pedido.
- Listagem de pedidos realizados e exclusão de pedidos.
- Consultas preparadas, hash de senha, escape de saída e token CSRF para formulários POST.

## Instalação local
1. Instale PHP 8.1+ com extensões `pdo_mysql` e `mbstring`, além do MySQL.
2. Importe o esquema: `mysql -u root -p < database/schema.sql`.
3. Configure `config/config.php` ou defina `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
4. Inicie o servidor a partir da pasta do projeto:
   `php -S 127.0.0.1:8000 -t public`
5. Acesse `http://127.0.0.1:8000/?r=products`.

## Como testar o checkout
Crie um usuário na página Usuários. Como este projeto-base ainda não inclui login/autenticação, para testar o checkout em ambiente local você pode definir temporariamente `$_SESSION['user_id']` após criar o usuário, por exemplo adicionando temporariamente após `session_start()` em `public/index.php`:
`$_SESSION['user_id'] = 1;`
Use o ID real do usuário. Remova essa linha e implemente autenticação antes de disponibilizar publicamente.

## Rotas
- `?r=products`, `?r=products/create`, `?r=products/edit&id=1`
- `?r=users`, `?r=users/create`, `?r=users/edit&id=1`
- `?r=cart`
- `?r=orders`
- `?r=login`, `?r=login/submit`, `?r=logout`

Os métodos de escrita aceitam apenas POST.