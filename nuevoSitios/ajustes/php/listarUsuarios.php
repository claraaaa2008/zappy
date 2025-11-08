<?php
require_once "../../persistencia/BaseDatos.php";
$db = new BaseDatos();
$usuarios = $db->obtenerTodosLosUsuarios(); // Asegúrate de tener este método en tu clase BaseDatos

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
            <div class="grid">
                <div class="div-column">
                    <label>Modificar el nombre</label>
                    <input type="text" name="nuevoNombre_<?php echo $usr['idUsr']; ?>" value="<?php echo htmlspecialchars($usr['nom_usr']); ?>">
                </div>
                <div class="div-column">
                    <label>Modificar contraseña</label>
                    <input type="password" name="nuevaPass_<?php echo $usr['idUsr']; ?>">
                </div>
            </div>

            <button class="buttonTurquesa">Guardar Cambios</button>
            <hr>

            <div class="grid">
                <button class="buttonTurquesa" <?php if ($usr['esAdmin']) echo 'style="opacity:0.6; font-style:italic;" disabled'; ?>>
                    <?php echo $usr['esAdmin'] ? 'Ya es admin' : 'Hacer admin'; ?>
                </button>
                <button class="buttonRojo">
                    <?php echo $usr['activo'] ? 'Desactivar' : 'Reactivar'; ?>
                </button>
            </div>
        </div>
    </div>
<?php endforeach; ?>