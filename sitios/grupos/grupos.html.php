<?php
session_start();

// Si el usuario no está logueado, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.html.php");
    exit;
}

// Guardamos los datos del usuario en variables
$usuario = $_SESSION['usuario'];
$nombre = $usuario['nom_real'] ?: $usuario['nom_usr'];
$fotoPerfil = isset($usuario['fotoPerfil']) && $usuario['fotoPerfil'] !== ""
    ? "../../img/perfiles/" . htmlspecialchars($usuario['fotoPerfil'])
    : "../../img/perfiles/default.png";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" href="../../img/ZappyConCara.png">
    <link rel="stylesheet" href="../../css/modoOscuro.css">
    <link rel="stylesheet" href="css/estilos1.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <title>Mi Grupo - Zappy</title>
</head>

<body class="div-column">
    <header class="div-row align">
        <div class="div-row">
            <a href="../index/index.html.php">
                <h1>ZAPPY</h1>
            </a>
            <div class="separador-vertical"></div>
            <h2>Mi grupo</h2>
        </div>
        <div class="div-row">
            <p><?php echo htmlspecialchars($nombre); ?></p>
            <?php
            $fotoPerfil = isset($usuario['fotoPerfil']) && $usuario['fotoPerfil'] !== ""
                ? "../../img/perfiles/" . htmlspecialchars($usuario['fotoPerfil'])
                : "../../img/perfiles/default.png"; // imagen por defecto
            ?>
            <div class="circulo">
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil" class="circle-img">
            </div>

        </div>
    </header>

    <main class="div-column">
        <h5>¡Aún no perteneces a ningún grupo!</h5>
        <h6>Es más divertido con amigos. Únete o crea un grupo con ellos</h6>

        <div class="div-row align">
            <!-- Crear grupo -->
            <div class="div-column boxTurquesa box">
                <h3>Crear un grupo</h3>
                <label for="nombreGrupo">Nombre del grupo</label>
                <input type="text" id="nombreGrupo" placeholder="grupo123">

                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" placeholder="¡Hola mundo!">

                <button class="buttonTurquesa" id="btnCrear">
                    <span class="material-symbols-rounded">group_add</span>
                    Crear
                </button>
            </div>

            <!-- Unirse a grupo -->
            <div class="div-column boxTurquesa box">
                <h3>Unirse a un grupo</h3>
                <label for="codigoGrupo">Código del grupo</label>
                <input type="text" id="codigoGrupo" placeholder="ABC123">

                <button class="buttonTurquesa" id="btnUnirse">
                    <span class="material-symbols-rounded">search</span>
                    Unirse
                </button>
            </div>
        </div>

        <!-- Mis grupos -->
        <div class="div-column boxTurquesa box" id="misGruposContainer">
            <h3>Mis grupos</h3>
            <div id="misGruposList">
                <!-- Grupos se cargan aquí -->
            </div>
        </div>
    </main>

    <script src="../../js/theme.js"></script>
    <script src="js/logica.js"></script>
</body>

</html>