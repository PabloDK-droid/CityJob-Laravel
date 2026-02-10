<form action="/login" method="POST">
    @csrf
    <input type="email" name="correo_electronico" placeholder="Correo" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Entrar</button>
</form>