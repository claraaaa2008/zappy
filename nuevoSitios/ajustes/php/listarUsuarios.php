<?php
require_once "../../persistencia/BaseDatos.php";  // Ajustá ruta si es necesario
$db = new BaseDatos();
$usuarios = $db->obtenerTodosLosUsuarios();

if (empty($usuarios)) {
    echo "<p>No hay usuarios registrados.</p>";
    return;
}

foreach ($usuarios as $usr):
?>
    <div class="box glowTurquesa div-column usuario">
        <div class="div-row align content">
            <div class="div-row">
                <div class="div-column" style="align-items: flex-start;">
                    <p class="nomUsr" <?php if (!$usr['activo']) echo 'style="text-decoration: line-through;"'; ?>>
                        <?php echo htmlspecialchars($usr['nom_usr']); ?>
                        <?php if (!$usr['activo']) echo '<span style="color:red; font-size:0.9em;"> (inactivo)</span>'; ?>
                    </p>

                    <?php if ($usr['esAdmin'] == 1): ?>
                        <p id="tipoUsr">Admin</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="div-column campos">
            <!-- Formulario para modificar datos del usuario -->
            <form class="form-admin-usuario" action="php/actualizarUsuarioAdmin.php" method="post">
                <input type="hidden" name="idUsr" value="<?php echo $usr['idUsr']; ?>">

                <div class="grid">
                    <div class="div-column">
                        <label>Modificar el nombre</label>
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($usr['nom_usr']); ?>">
                    </div>
                    <div class="div-column">
                        <label>Modificar contraseña</label>
                        <input type="password" name="contrasena" placeholder="Dejar vacío si no se cambia">
                    </div>
                </div>

                <button type="submit" class="buttonTurquesa">Guardar Cambios</button>
            </form>

            <hr>

            <!-- Botones para hacer admin o desactivar/reactivar -->
            <div class="grid">
                <!-- 🔹 Hacer admin -->
                <form action="php/hacerAdmin.php" method="post" style="display:inline;">
                    <input type="hidden" name="idUsr" value="<?php echo $usr['idUsr']; ?>">
                    <button type="submit" class="buttonTurquesa"
                        <?php if ($usr['esAdmin']) echo 'style="opacity:0.6; font-style:italic;" disabled'; ?>>
                        <?php echo $usr['esAdmin'] ? 'Ya es admin' : 'Hacer admin'; ?>
                    </button>
                </form>

                <!-- 🔹 Desactivar / Reactivar -->
                <form action="php/desactivarUsuario.php" method="post" style="display:inline;">
                    <input type="hidden" name="idUsr" value="<?php echo $usr['idUsr']; ?>">
                    <button type="submit" class="buttonRojo">
                        <?php echo $usr['activo'] ? 'Desactivar' : 'Reactivar'; ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
