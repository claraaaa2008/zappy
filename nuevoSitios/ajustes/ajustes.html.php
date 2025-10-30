<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes - ZAPPY</title>
    <link rel="website icon" href="../../img/ZappyConCara.png">
    <link rel="stylesheet" href="../css/modoOscuro.css">
    <link rel="stylesheet" href="css/estilosAjustes.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <link href="https://fonts.cdnfonts.com/css/cutta" rel="stylesheet">
</head>

<body>
    <header class="div-row content">
        <div class="div-row titlePage">
            <a href="../index/index.html.php">
                <h1>ZAPPY</h1>
            </a>
            <div class="separador-vertical"></div>
            <h2>Ajustes</h2>
        </div>
        <div class="div-row currentUsr">
            <p id="nombre-header">usuario123</p>
            <img id="foto-perfil-header" src="../../img/perfiles/default.png" alt="Imagen de usuario Zappy" style="width: 25px;" />
        </div>
    </header>

    <nav class="div-row content">
        <span class="material-symbols-rounded" id="icon-person" onclick="fill_icons(event)">person</span>
        <span class="material-symbols-rounded" id="icon-ui" onclick="fill_icons(event)">computer</span>
        <span class="material-symbols-rounded" id="icon-admin" onclick="fill_icons(event)">shield_person</span>
        <span class="material-symbols-rounded" id="icon-logout" onclick="abrirModal('logout', event)">logout</span>
    </nav>

    <main>
        <!-- Sección Usuario -->
        <section id="usuario" class="div-column">
            <h3>Usuario</h3>

            <form id="form-usuario" action="php/cambiarInfoUsuario.php" class="div-column" enctype="multipart/form-data">
                <div class="div-row">
                    <div class="div-column perfil" style="align-items: center; gap: 10px;">
                        <img id="foto-perfil-ajustes" class="circle" src="../../img/perfiles/default.png" alt="Foto de perfil">
                        <button type="button" id="boton-cambiar-foto">Cambiar foto</button>
                        <input type="file" id="input-foto-perfil" style="display:none;" accept="image/*">
                    </div>

                    <div class="div-column campos">
                        <div class="div-column campo">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Cambia tu nombre">
                        </div>

                        <div class="div-column campo">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" placeholder="Cambia tu correo">
                        </div>

                        <div class="div-row content align">
                            <div class="div-column campo">
                                <label for="genero">Género</label>
                                <select name="genero" id="genero">
                                    <option value="" disabled selected>Selecciona tu género</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="div-column campo">
                                <label for="fecha_nacimiento">¿Cuándo naciste?</label>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="buttonTurquesa">Guardar cambios</button>
            </form>

            <hr>

            <!-- Formulario cambiar contraseña -->
            <form id="form-contrasena" action="php/cambiarContraseña.php" method="post" class="div-column campos">
                <h4>Cambiar contraseña</h4>
                <div class="div-column campo">
                    <label for="contraseña_actual">Contraseña Actual</label>
                    <input type="password" id="contraseña_actual" name="contraseña_actual"
                        placeholder="Ingresa tu contraseña actual">
                </div>

                <div class="div-column campo">
                    <label for="nueva_contraseña">Nueva Contraseña</label>
                    <input type="password" id="nueva_contraseña" name="nueva_contraseña"
                        placeholder="Ingresa tu nueva contraseña">
                </div>

                <div class="div-column campo">
                    <label for="confirmar_contraseña">Confirmar Nueva Contraseña</label>
                    <input type="password" id="confirmar_contraseña" name="confirmar_contraseña"
                        placeholder="Confirma tu nueva contraseña">
                </div>

                <button type="submit" class="buttonTurquesa">Cambiar contraseña</button>
            </form>

            <hr>

            <!-- Eliminar cuenta -->
            <form action="php/eliminarCuenta.php" method="post">
                <button type="submit" class="buttonRojo">Eliminar cuenta</button>
            </form>
        </section>

        <!-- Sección Interfaz -->
        <section id="interfaz">
            <form class="div-column">
                <h3>Interfaz</h3>

                <div class="div-column box boxTurquesa glowTurquesa">
                    <h4>Tema</h4>
                    <div class="div-row">
                        <!-- Claro -->
                        <div class="div-column">
                            <svg id="svg-claro" class="tema-svg" width="100%" height="100%" viewBox="0 0 404 195" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="1" y="1" width="402" height="193" rx="15" fill="#F4A503" />
                                <rect x="1" y="1" width="402" height="193" rx="15" stroke="#49D9D9" stroke-width="2"
                                    class="border" />
                                <rect x="64" y="27.5" width="149" height="140" rx="14.5" fill="#404040" stroke="#25858F"
                                    stroke-width="3" />
                                <circle cx="290" cy="61.5" r="23" stroke="#2E2E2E" stroke-width="2" />
                                <line x1="248" y1="100" x2="332" y2="100" stroke="#2E2E2E" stroke-width="19"
                                    stroke-linecap="round" />
                                <line x1="248" y1="124" x2="332" y2="124" stroke="#2E2E2E" stroke-width="19"
                                    stroke-linecap="round" />
                                <line x1="248" y1="148" x2="332" y2="148" stroke="#2E2E2E" stroke-width="19"
                                    stroke-linecap="round" />
                            </svg>
                            <caption>Claro</caption>
                        </div>

                        <!-- Oscuro -->
                        <div class="div-column">
                            <svg id="svg-oscuro" class="tema-svg" width="100%" height="100%" viewBox="0 0 404 195" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="1" y="1" width="402" height="193" rx="15" fill="#2E2E2E" />
                                <rect x="1" y="1" width="402" height="193" rx="15" stroke="#49D9D9" stroke-width="2" />
                                <rect x="64" y="27.5" width="149" height="140" rx="14.5" fill="#404040" stroke="#25858F"
                                    stroke-width="3" />
                                <circle cx="290" cy="61.5" r="23" stroke="#F4A503" stroke-width="2" />
                                <line x1="248" y1="100" x2="332" y2="100" stroke="#F4A503" stroke-width="19"
                                    stroke-linecap="round" />
                                <line x1="248" y1="124" x2="332" y2="124" stroke="#F4A503" stroke-width="19"
                                    stroke-linecap="round" />
                                <line x1="248" y1="148" x2="332" y2="148" stroke="#F4A503" stroke-width="19"
                                    stroke-linecap="round" />
                            </svg>
                            <caption>Oscuro</caption>
                        </div>
                    </div>
                </div>

                <div class="div-column box boxTurquesa glowTurquesa">
                    <h4>Juego</h4>
                    <h5>Fondo de pantalla</h5>
                    <div class="div-row">
                        <img src="../../img/ajustes/agregarImg.png" alt="">
                        <img src="../../img/ajustes/agregarColor.png" alt="">
                    </div>
                </div>

                <button type="submit" class="buttonTurquesa">Guardar Cambios</button>
            </form>
        </section>

        <section class="div-column" id="admin">
            <h3>Administracion de plataforma</h3>
            <div class="div-column">
                <h4>Agrega un juego</h4>
                <p></p>
                <button class="buttonTurquesa"></button>
            </div>
            <form class="div-column">
                <h4>Gestion de usuarios</h4>
                <p>Ingrese un usuario para gestionar</p>
                <input type="text" name="usuario" id="usuario">
                <!--Por defecto que se desplieguen todos los usuarios y cuando busca un usuario que aparezca solo ese usuario-->
                
                <div class="box glowTurquesa div-column">
                    <div class="div-row align">
                        <div class="div-row">
                            <img src="" alt="">
                            <p>usuario123</p>
                        </div>
                        <p class="puntaje">xxxxx</p>
                    </div>
                    <div class="div-row">
                        <!--Atributos de usuario-->
                    </div>
                </div>
            </form>
        </section>
    </main>

    <!-- Modal cambiar nombre -->
    <div class="modal" id="cambiarNombre">
        <div class="container">
            <div class="box boxTurquesa div-column campo" style="max-height: none;">
                <label for="usuario">Introduzca el nuevo usuario:</label>
                <input type="text" name="usuario" id="usuario">
                <button type="submit" class="buttonTurquesa">Guardar</button>
            </div>
        </div>
    </div>

    <!-- Modal logout -->
    <div class="modal" id="logout">
        <div class="container">
            <div class="box boxTurquesa div-column" style="max-height: none;">
                <p>¿Estás seguro de que deseas <br><b>Cerrar Sesión</b>?</p>
                <div class="div-row align content botones">
                    <button class="buttonRojo">Aceptar</button>
                    <form action="php/logout" method="post">
                        <button class="buttonTurquesa" onclick="cerrarModal('logout')" type="submit">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/logica.js"></script>
    <script src="../js/theme.js"></script>
</body>

</html>