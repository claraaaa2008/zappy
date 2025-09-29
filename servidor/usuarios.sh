#!/bin/bash
# Script para la administración de usuarios

# ========= CONFIGURACIÓN DE ESTILO =========
# Variables para dar color a los textos del menú en la terminal
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

# ========= FUNCIÓN PRINCIPAL: Menú de Usuarios =========
function menuUsuarios() {
    clear  # Limpia la terminal para mostrar el menú limpio

    opc=10 # Inicializa la opción con un valor que permita entrar al bucle

    # Bucle que muestra el menú hasta que el usuario elija volver (5) o salir (0)
    while [[ $opc != 0 && $opc != 5 ]]; do
        echo -e "${color_menu}Menu de Usuarios${color_predeterminado}"
        echo -e "${color_menu}1) ${color_predeterminado}Crear usuario"
        echo -e "${color_menu}2) ${color_predeterminado}Eliminar usuario"
        echo -e "${color_menu}3) ${color_predeterminado}Modificar usuario"
        echo -e "${color_menu}4) ${color_predeterminado}Listar usuarios"
        echo -e "${color_menu}5) ${color_predeterminado}Volver al menú principal"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

        read -p "Seleccione una opción: " opc

        # Según la opción seleccionada, se llama a la función correspondiente
        case $opc in
            1)
                crearUsuario
                ;;
            2)
                eliminarUsuario
                ;;
            3)
                modificarUsuario
                ;;
            4)
                listarUsuarios
                ;;
            5)
                echo "Volviendo al menú principal..."
                ;;
            0)
                clear
                echo "Saliendo del programa..."
                ;;
            *)
                echo "Opción no válida. Por favor, intente de nuevo."
                ;;
        esac
    done
}

# ========= FUNCIONES DE ADMINISTRACIÓN =========

# Función para crear un nuevo usuario en el sistema
function crearUsuario() {
    read -p "Ingrese el nombre del usuario que quiere crear: " usuario

    # Se valida que el usuario no exista antes de continuar
    while usuarioExiste "$usuario"; do
        echo "El usuario $usuario ya existe. Por favor, elija otro nombre."
        read -p "Ingrese el nombre del usuario que quiere crear: " usuario
    done

    # Pregunta si desea crear un directorio home para el nuevo usuario
    read -p "Desea crear un directorio para el usuario? (s/n): " crear_directorio

    # Según la respuesta, se crea el usuario con o sin directorio
    case $crear_directorio in
        s|S|si|SI)
            # -m crea el directorio home, -d especifica el path, -s define la shell
            useradd -m -d /home/$usuario -s /bin/bash $usuario
            echo "Usuario $usuario creado con directorio /home/$usuario."
            ;;
        n|N|no|NO)
            useradd -s /bin/bash $usuario  # Crea el usuario sin directorio home
            echo -e "${color_menu}Usuario $usuario creado sin directorio.${color_predeterminado}"
            ;;
        *)
            echo "Opción no válida. Se creará el usuario sin directorio."
            useradd -s /bin/bash $usuario
            ;;
    esac

    echo "Presione Enter para volver al menú..."
    read
    clear
}

# Función para eliminar un usuario del sistema
function eliminarUsuario() {
    read -p "Ingrese el nombre del usuario que quiere eliminar: " usuario

    # Verifica que el usuario exista antes de intentar eliminarlo
    while ! usuarioExiste "$usuario" ; do
        echo "El usuario $usuario no existe. Por favor, elija otro nombre."
        read -p "Ingrese el nombre del usuario que quiere eliminar: " usuario
    done

    userdel -r $usuario  # -r también borra el directorio home
    echo "Usuario $usuario eliminado."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

# Función para modificar (renombrar) un usuario
function modificarUsuario() {
    read -p "Ingrese el nombre del usuario que quiere modificar: " usuario

    # Valida que el usuario exista
    while ! usuarioExiste "$usuario" ; do
        echo "El usuario $usuario no existe. Por favor, elija otro nombre."
        read -p "Ingrese el nombre del usuario que quiere modificar: " usuario
    done

    # Solicita el nuevo nombre del usuario
    read -p "Ingrese el nuevo nombre del usuario: " nuevo_usuario

    # Asegura que el nuevo nombre no esté ya en uso
    while usuarioExiste "$nuevo_usuario"; do
        echo "El usuario $nuevo_usuario ya existe. Por favor, elija otro nombre."
        read -p "Ingrese el nuevo nombre del usuario: " nuevo_usuario
    done

    usermod -l $nuevo_usuario $usuario  # Renombra el usuario
    echo "Usuario $usuario modificado a $nuevo_usuario."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

# Función para listar todos los usuarios del sistema
function listarUsuarios() {
    echo -e "${color_menu}Lista de usuarios:${color_predeterminado}"
    cut -d ":" -f1 /etc/passwd  # Extrae y muestra solo los nombres de usuario
    echo "Presione Enter para volver al menú..."
    read
    clear
}

# Función auxiliar que verifica si un usuario existe en el sistema
function usuarioExiste() {
    if grep -q "^$1:" /etc/passwd; then
        return 0  # Usuario encontrado
    else
        return 1  # Usuario no encontrado
    fi
}
