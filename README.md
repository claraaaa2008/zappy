# Manual de Usuario - Zappy

## Introducción
Zappy trata de una plataforma para minijuegos dirigida a un público menor de edad, fácil de entender y de usar, aquí se explicará su funcionamiento y un paso a paso para poder utilizarla sin mayor complicación.  

## Login (iniciar sesión): Beta
En la página principal, la apariencia del botón de iniciar sesión varía dependiendo de si hay un usuario ingresado o si por el momento aún nadie intentó entrar con su cuenta a la página. Con un usuario logueado, al hacer click en éste botón se redirigirá a una página con la información de quién está actualmente “jugando” y al salir se verá cómo en lugar del logo genérico para usuario estará la foto elegida por el jugador al momento de crear su cuenta.   

Si no hay una cuenta logueada, el botón redirigirá al usuario a  la página titulada “iniciar sesión” donde se le pedirá su nombre de usuario y su contraseña, sin embargo, si dicha persona no cuenta con una cuenta preexistente o ingresa datos erróneos, se mostrará un aviso que diga que el usuario ingresado no existe, para eso está el botón más abajo que dice “¿No tienes una cuenta? registrate aquí”, así el usuario será redirigido a la página de “Registrarse” donde ingresará los datos correspondientes (se definirán más adelante) y al terminar volverá a la página principal donde verá su foto y su nombre de usuario elegidos.  

## Sign Up (Registrarse)
Se le pedirá al usuario rellenar todos los campos con sus datos. Estos son: usuario, contraseña (mínimo 8 caracteres), nombre, sexo (beta), fecha de nacimiento y email. Una vez llenado todo con los datos, se creará la cuenta y podrá ver su nombre de usuario en el sitio principal.  

## Página principal
Nada más empezar se encontrará con la página principal en la que aparecerán varios botones con los que podrá interactuar, tales como los denominados “minijuegos” y otras opciones llamadas “configuración”, “Iniciar Sesión” o su variante “@(Usuario)”, etc. (se mencionarán los demás botones una vez la página esté finalizada).  

Los botones de minijuegos reconocidos por ser gris oscuro y estar al lado derecho de lo que sería el rostro de nuestra mascota Zappy, son llamados “Memoria”, “Monty Hall”, “Trivia”, “La Mosqueta”, y “Piedra, Papel o Tijera”, al ser seleccionados llevarán al usuario al juego en su respectiva página. A diferencia del resto, el botón de trivia primero llevará a una página de selección que pedirá que tipo de trivia quiere jugar, contando con dos tipos llamados “Preguntas” y “matemáticas”.  

Por otro lado, el botón de configuración, cuya apariencia y posición es igual a la de los botones de los minijuegos, cuenta con varias opciones para que el usuario pueda personalizar su experiencia a gusto.  

## Juegos

### Memoria.
El juego de la memoria se basa en el emparejamiento de cartas con los mismos valores dadas vuelta boca abajo, solo se puede dar vuelta dos cartas a la vez, su mecánica se basa en recurrir a una buena memoria para recordar en qué posición está cada carta y darlas vuelta en el mismo turno para poder descartarlas, cuando se emparejan todas las cartas se da por finalizado el juego en victoria, pero si no se logra emparejar todas las cartas en el tiempo acordado entonces el juego termina en derrota.  

En la página también se puede apreciar distintos actores que se mencionarán a continuación. Por un lado, en la parte superior, podemos apreciar la cantidad de movimientos realizados por el jugador. Por otro lado, está el puntaje acumulado.  

### Adivina la puerta (Monty Hall).  
En este juego se replica el famoso programa de televisión del señor Monty Hall. En este juego el usuario tendrá que elegir entre tres puertas que se le presentan con la excusa de encontrar a la mascota de la plataforma, Zappy, el usuario va a seleccionar una de éstas y otra que es errónea se abrirá, es responsabilidad del usuario entonces de decidir si va a quedarse con su apuesta inicial o cambiar de elección, después de elegir nuevamente puerta entre las dos que quedaban, se abrirán todas las puertas para revelar si el jugador logró encontrar a Zappy escondido o no.  

La interfaz cuenta con tres agentes interactivos iguales, o sea las puertas, lo que rodean a éstas son mensajes de texto que le indican al jugador de qué va el juego y cómo sus decisiones afectan a su resultado.  

### Trivia (Cuestionario de HTML).  
Después de atravesar la barrera en la que se pregunta qué clase de trivia le gustaría jugar al usuario, si selecciona la primera opción llamada “cuestionario HTML” se encontrará con una lista de preguntas que podrá responder a su propio ritmo, teniendo la oportunidad de ir y volver entre preguntas, ya que el resultado se da una vez el usuario decida entregar su formulario completo.  

Del lado izquierdo de la pantalla se podrá ver a Zappy y a su derecha estarán las preguntas que tendrá que contestar el jugador dentro de un globo de texto color cyan, en la parte superior del globo se ubica la pregunta dada por el sistema y debajo de eso estarán las opciones clickeables, solo se podrá seleccionar una por pregunta, por último estaría el botón de entrega que se ve como una pequeña flecha del lado derecho inferior del globo. Después de contestar a las preguntas y entregar el formulario se llevará al usuario a la página de confirmación donde se le entregarán las respuestas y su resultado, señal de que el juego llegó a su final.  

### Trivia (Cuestionario de Matemática). 
Luego de elegir cuál trivia jugar, el usuario puede elegir realizar un preguntas y respuestas (Q&A) de operaciones matemáticas. Se encontrará con tres botones para seleccionar la dificultad, una barra larga en la cual se le dará la consigna al usuario, y otra barra debajo para ingresar su respuesta junto a un botón de enviar. Para obtener la primera operación que el usuario deberá resolver, simplemente haciendo click en una de las dificultades podrá ver esa pregunta. A medida que conteste cada pregunta, la pregunta irá cambiando. También puede cambiar la pregunta haciendo click en cualquiera de las dificultades dadas.

- Fácil: Genera una pregunta fácil con números del 1 al 9 de suma, resta o multiplicación.
- Medio: Genera una pregunta de dificultad media con números del 10 al 99 también con operaciones de suma, resta o multiplicación.
- Difícil: Genera una pregunta difícil con números del 100 al 999 con las mismas operaciones de las dificultades anteriores.  

Al hacer click en el botón de “Enviar”, el programa evalúa la validez de la respuesta y se muestra en pantalla el contador de respuestas correctas o incorrectas.  

### Piedra, papel o tijera.
El usuario se encontrará a su izquierda con una mano, el cual es la “mano” del usuario y en la parte inferior derecha están las opciones que puede elegir el usuario: Piedra, papel o tijera. Arriba a la derecha podrá ver a Zappy, el cual mostrará la opción aleatoria que elija el programa. En cada esquina superior el usuario puede ver el contador de puntos entre el jugador y Zappy.  

Es importante saber las condiciones para ganar: La tijera le gana al papel, el papel le gana a la piedra, y la piedra le gana a la tijera. Si el usuario gana, el contador de “jugador” suma un punto. Si Zappy gana, el contador de “Zappy” suma un punto. Si hay empate, se acumula un punto para cada uno.  

¿Cuándo finaliza el juego? Cuando uno de los dos llega primero a los tres puntos, o si los tres llegan al mismo tiempo a los tres puntos. Cuando termina, se despliega un modal con un resumen de partida acompañado de un mensaje en el encabezado del modal. Si el usuario gana, se despliega el mensaje: “Ganaste la ronda”. Si Zappy gana “Perdiste la ronda”. Si hay empate: “Ha sido un empate, se repite la ronda”. Así también muestra la cantidad de rondas jugadas y un botón de “Inicio” para ir al index y “Volver a Jugar” para jugar de nuevo.  

### Juego de la mosqueta. 
Al entrar, el usuario puede ver tres vasos. El jugador tiene que hacer click en uno de estos e intentar adivinar dónde está la pelota escondida. Si agarra un vaso incorrecto, el jugador deberá agarrar otro vaso, y así hasta encontrar dónde está la pelota. La pelota nunca cambia de posición en la ronda. Solo cambia si se presiona el botón de “Reiniciar”.  

## Configuración (beta)
Al hacer click en el botón de Configuración o al hacer click en el usuario logueado, se podrá acceder al sitio de Configuración. A la izquierda se puede ver la opción de “Opciones de cuenta” (próximamente habrán más opciones). A la derecha, están los parámetros que se pueden modificar. Por ahora, solo se puede cambiar la contraseña y el usuario y eliminar la cuenta. Al cambiar el usuario por el nuevo indicado por el usuario, aparece un mensaje que confirma el cambio.  

Solamente es posible cambiar la contraseña si y sólo si el usuario ingresó la misma contraseña antigua en el primer campo y la nueva en los dos últimos campos (“Nueva contraseña” y “Confirmar contraseña nueva”). Nota: aparece un mensaje de confirmación si esta condición se cumple.  

Si el usuario ingresa una contraseña antigua incorrecta, o si la contraseña nueva y su confirmación no coinciden entre sí, entonces no será posible cambiar la contraseña.  

Por último, está el botón de “Eliminar Cuenta”, el cual con un simple click se puede borrar de la base de datos definitivamente la cuenta con la que el usuario está logueado.  

Más adelante se especificarán las demás funciones que serán agregadas a la página de configuración.  