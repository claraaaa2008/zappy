# ZAPPY

Bienvenido a ZAPPY. Aquí podrá encontrar toda la ayuda que necesita para saber cómo funciona esta plataforma web.

## Guía de instalación

### Antes de instalar ZAPPY
Zappy utiliza algunos de los servicios disponibles, tales como Apache y phpMyAdmin. Por lo tanto, se requiere tener instalado el software XAMPP con los servicios de MySQL y Apache corriendo antes de la instalación de nuestra plataforma para un correcto funcionamiento.  

Por ahora, la instalación se deberá realizar de esta forma. Estamos trabajando para mejorar la experiencia del usuario en las siguientes versiones.

### Instalar ZAPPY
En la rama de la versión actual de GitHub podrá encontrar una gran cantidad de carpetas y archivos, los cuales son clave para el funcionamiento de ZAPPY.  

En la interfaz de la web del repositorio, se puede apreciar un botón verde `<> code`.
Haga click allí y podrá ver dos opciones fundamentales:  
- Open with GitHub Desktop
- Download ZIP

#### Open with GitHub Desktop
Si desea tener acceso al código desde su máquina para contribuir a la edición del repositorio y tiene el programa GitHub Desktop, le puede resultar útil abrir y clonar este repositorio localmente.

#### Download ZIP
Si no desea contribuir al repositorio y solamente quiere descargar los archivos necesarios para el funcionamiento apropiado de ZAPPY, es conveniente descargar el archivo ZIP el cual contiene todo lo necesario para entrar en nuestra experiencia lúdica.

### Una vez descargado ...
Primero aloje el ZIP en la ubicación donde esté la carpeta htdocs dentro de xampp. Probablemente esté alojado si no cambió la ubicación de los archivos de programa en `Program Files` o `Archivos de Programa`.   

Una vez colocado allí, descomprímalo haciendo click derecho en el archivo ZIP y acto seguido tocar el botón **Extraer todo** y haga click en **Extraer** si le aparece una ventana por encima del Explorador de Archivos.  

Antes de ejecutar el archivo `index\index.html.php`, active en XAMPP los botones **Start** de Apache y MySQL si no están activados los servicios.  

Luego deberá ingresar en su navegador a [phpMyAdmin](http://localhost/phpmyadmin/index.php) ingresando el siguiente enlace: http://localhost/phpmyadmin/index.php.  

Luego haga click en el botón de arriba en la interfaz que dice **SQL**. Con este ingresaremos el código necesario, que está en la carpeta ZIP descomprimida en la subcarpeta `persistencia` y `Trivia/persistencia`, cuya función será crear la base de datos dentro de su máquina física.  

#### Pasos para crear las bd necesarias:
*Aclaración: todos los archivos mencionados a continuación están alojados en la carpeta descomprimida anteriormente.*

- Copie el código del archivo ubicado en `persistencia/bd.sql`.
- Péguelo en el [editor de código SQL en phpMyAdmin](http://localhost/phpmyadmin/index.php?route=/server/sql). Luego haga click en el botón **Continuar** una vez haya realizado este procedimiento.
- Repita este procedimiento para el archivo que está en: `Trivia/persistencia/baseDatos.sql`.

Una vez realizados estos pasos, podemos usar la plataforma correctamente.  

## Ejecutar ZAPPY

Ingrese a la página principal de ZAPPY mediante el siguiente enlace: http://localhost/repositorio/proyecto1/zappy/index/index.html.php. Ahora puede disfrutar de toda la experiencia que le ofrecemos :3  

_Nota: Si usted crea una cuenta o inicia sesión, notará que el nombre "Iniciar Sesión" no se cambia por el usuario que registró. Estamos trabajando para cambiar esto en próximas actualizaciones_.