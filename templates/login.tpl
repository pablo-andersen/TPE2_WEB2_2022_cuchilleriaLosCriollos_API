<div class="bloqueContenido">
    <div class="listado">
        <h2>Login</h2>
        <form action="verify" method="post">
            <input class="campoFormulario" type="text" placeholder="user" name="email">
            <input class="campoFormulario" type="password" placeholder="password" name="password">
            <input class="botonFormulario" type="submit" value="Login">
        </form>
        <h4>{$error}</h4>
    </div>
</div>