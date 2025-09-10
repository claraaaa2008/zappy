# ZAPPY

Bienvenido a ZAPPY. Aquí podrá encontrar toda la ayuda que necesita para saber cómo funciona esta plataforma web.

## Acceso al Sitio Web
Este proyecto de software contiene incluido un menú de juegos accesible desarrollado para ser ejecutable a través de github, la distribución del sistema vendrá acompañada de los archivos de documentación para facilitar la instalación del sistema y su uso.  

El nombre del proyecto final esta denominado como “Zappy”, su link aparece como: https://github.com/claraaaa2008/tree/2da-entrega donde encontrarás varios archivos, la página web completa, el README.md que es el archivo principal y el proyecto pagina.  

El lenguaje principal incluido dentro del proyecto final es CSS, ya que requiere mucho código dentro para hacer el GUI, y luego le siguen JavaScript y por último HTML.  

Compatibilidad: Su compatibilidad es de Windows 10 y 11 con Visual Studio Code.

## Introducción
Zappy trata de una plataforma para minijuegos dirigida a un público menor de edad, fácil de entender y de usar, aquí se explicará su funcionamiento y un paso a paso para poder utilizarla sin mayor complicación.  

### Página principal
Nada más empezar se encontrará con la página principal en la que aparecerán varios botones con los que podrá interactuar, tales como los denominados “minijuegos” y otras opciones llamadas “configuración”, “Iniciar Sesión” o su variante “@(Usuario)”, etc. (se mencionarán los demás botones una vez la página esté finalizada).  

Los botones de minijuegos reconocidos por ser gris oscuro y estar al lado derecho de lo que sería el rostro de nuestra mascota Zappy, son llamados “Memoria”, “Monty Hall”, “Trivia”, “La Mosqueta”, y “Piedra, Papel o Tijera”, al ser seleccionados llevarán al usuario al juego en su respectiva página. A diferencia del resto, el botón de trivia primero llevará a una página de selección que pedirá que tipo de trivia quiere jugar, contando con dos tipos llamados “Preguntas” y “matemáticas”.  

Por otro lado, el botón de configuración, cuya apariencia y posición es igual a la de los botones de los minijuegos, cuenta con varias opciones para que el usuario pueda personalizar su experiencia a gusto. Por el momento, el usuario estará habilitado para cambiar su nombre, sus sexo, fecha de nacimiento, su foto y su contraseña. Más adelante se especificarán las demás funciones que serán agregadas a la página de configuración.  

Por último, está el botón de inicio de sesión, cuya apariencia varía dependiendo de si hay un usuario ingresado o si por el momento aún nadie intentó entrar con su cuenta a la página. Con un usuario logueado, al hacer click en éste botón se redirigirá a una página con la información de quién está actualmente “jugando” y al salir se verá cómo en lugar del logo genérico para usuario estará la foto elegida por el jugador al momento de crear su cuenta. Si no hay una cuenta logueada, el botón redirigirá al usuario a  la página titulada “iniciar sesión” donde se le pedirá su nombre de usuario y su contraseña, sin embargo, si dicha persona no cuenta con una cuenta preexistente o ingresa datos erróneos, se mostrará un aviso que diga que el usuario ingresado no existe, para eso está el botón más abajo que dice “¿No tienes una cuenta? registrate aquí”, así el usuario será redirigido a la página de “Sign in” donde ingresará los datos correspondientes (se definirán más adelante) y al terminar volverá a la página principal donde verá su foto y su nombre de usuario elegidos.  

### Juegos
#### Memoria
El juego de la memoria se basa en el emparejamiento de cartas con los mismos valores dadas vuelta boca abajo, solo se puede dar vuelta dos cartas a la vez, su mecánica se basa en recurrir a una buena memoria para recordar en qué posición está cada carta y darlas vuelta en el mismo turno para poder descartarlas, cuando se emparejan todas las cartas se da por finalizado el juego en victoria, pero si no se logra emparejar todas las cartas en el tiempo acordado entonces el juego termina en derrota.  

En la página se ven distribuidos distintos actores que se mencionarán a continuación como el reloj, dedicado a señalar cuánto tiempo le lleva al jugador acabar con su partida, el contador de errores, que aumentará una unidad cada vez que el usuario no logre emparejar las cartas en un turno, obviamente las cartas, que están predeterminadas para ser 12 pares, todos éstos se encuentran centrados en la página a simple vista, por último un botón para activar y desactivar la música de fondo en la esquina superior derecha de la pantalla.  

#### Monty Hall
En este juego se replica el famoso programa de televisión del señor Monty hall (ni idea de dónde salió, perdón), en este juego el usuario tendrá que elegir entre tres puertas que se le presentan con la excusa de encontrar a la mascota de la plataforma, Zappy, el usuario va a seleccionar una de éstas y otra que es errónea se abrirá, es responsabilidad del usuario entonces de decidir si va a quedarse con su apuesta inicial o cambiar de elección, después de elegir nuevamente puerta entre las dos que quedaban, se abrirán todas las puertas para revelar si el jugador logró encontrar a Zappy escondido o no.  

La interfaz solo cuenta con tres agentes interactivos iguales, o sea las puertas, lo que rodean a éstas son mensajes de texto que le indican al jugador de qué va el juego y cómo sus decisiones afectan a su resultado.  

#### Trivia (Cuestionario).
Después de atravesar la barrera en la que se pregunta qué clase de trivia le gustaría jugar al usuario, si selecciona la primera opción llamada “cuestionario” se encontrará con una lista de preguntas que podrá responder a su propio ritmo, teniendo la oportunidad de ir y volver entre preguntas, ya que el resultado se da una vez el usuario decida entregar su formulario completo.  

Del lado izquierdo de la pantalla se podrá ver a Zappy y a su derecha estarán las preguntas que tendrá que contestar el jugador dentro de un globo de texto color cyan, en la parte superior del globo se ubica la pregunta dada por el sistema y debajo de eso estarán las opciones clickeables, solo se podrá seleccionar una por pregunta, por último estaría el botón de entrega que se ve como una pequeña flecha del lado derecho inferior del globo. Después de contestar a las preguntas y entregar el formulario se llevará al usuario a la página de confirmación donde se le entregarán las respuestas y su resultado, señal de que el juego llegó a su final.  

Se continuará con el manual más adelante.