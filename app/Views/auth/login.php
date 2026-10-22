
<h2>Entrar no sistema</h2>

<form class="form" method="post" action="?r=login/submit">

    <input
        type="hidden"
        name="_csrf"
        value="<?= htmlspecialchars($csrf) ?>"
    >

    <label>
        E-mail
        <input
            type="email"
            name="email"
            required
            autocomplete="username"
        >
    </label>

    <label>
        Senha
        <input
            type="password"
            name="password"
            required
            autocomplete="current-password"
        >
    </label>

    <button type="submit">Entrar</button>

</form>
