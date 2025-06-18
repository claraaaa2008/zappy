#!/bin/bash

# Variables para los colores
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

function menuUsuarios() {
    
    clear

    opc=10 # Inicializar opc con un valor diferente de 0 para entrar al bucle

    while [[ $opc != 0 && $opc != 5 ]]; do
        echo -e "${color_menu}Menu de Usuarios${color_predeterminado}"
        echo -e "${color_menu}1) ${color_predeterminado}Crear usuario"
        echo -e "${color_menu}2) ${color_predeterminado}Eliminar usuario"
        echo -e "${color_menu}3) ${color_predeterminado}Modificar usuario"
        echo -e "${color_menu}4) ${color_predeterminado}Listar usuarios"
        echo -e "${color_menu}5) ${color_predeterminado}Volver al menú principal"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

        read -p "Seleccione una opción: " opc

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


function crearUsuario() {
    read -p "Ingrese el nombre del usuario que quiere crear: " usuario
        while usuarioExiste "$usuario"; do # no deja comtinuar al codigo si el usuario ya existe
            echo "El usuario $usuario ya existe. Por favor, elija otro nombre."
            read -p "Ingrese el nombre del usuario que quiere crear: " usuario
        done
        read -p "Desea crear un directorio para el usuario? (s/n): " crear_directorio
        case $crear_directorio in
            s|S|si|SI)
                useradd -m -d /home/$usuario -s /bin/bash $usuario
                echo "Usuario $usuario creado con directorio /home/$usuario."
                echo "Presione Enter para volver al menú..."
                read
                clear
                ;;
            n|N|no|NO)
                useradd -s /bin/bash $usuario
                clear
                echo -e "${color_menu}Usuario $usuario creado sin directorio.${color_predeterminado}"
                echo "Presione Enter para volver al menú..."
                read
                clear
                ;;
            *)
                echo "Opción no válida. Se creará el usuario sin directorio."
                useradd -s /bin/bash $usuario
                echo "Presione Enter para volver al menú..."
                read
                clear
                ;;
    esac
}

function eliminarUsuario() {
    read -p "Ingrese el nombre del usuario que quiere eliminar: " usuario
    while ! usuarioExiste "$usuario" ; do
        echo "El usuario $usuario no existe. Por favor, elija otro nombre."
        read -p "Ingrese el nombre del usuario que quiere eliminar: " usuario
    done
    userdel -r $usuario
    echo "Usuario $usuario eliminado."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

function modificarUsuario() {
    read -p "Ingrese el nombre del usuario que quiere modificar: " usuario
    while ! usuarioExiste "$usuario" ; do
        echo "El usuario $usuario no existe. Por favor, elija otro nombre."
        read -p "Ingrese el nombre del usuario que quiere modificar: " usuario
    done
    read -p "Ingrese el nuevo nombre del usuario: " nuevo_usuario
    while usuarioExiste "$nuevo_usuario"; do
        echo "El usuario $nuevo_usuario ya existe. Por favor, elija otro nombre."
        read -p "Ingrese el nuevo nombre del usuario: " nuevo_usuario
    done
    usermod -l $nuevo_usuario $usuario
    echo "Usuario $usuario modificado a $nuevo_usuario."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

function listarUsuarios() {
    echo -e "${color_menu}Lista de usuarios:${color_predeterminado}"
    cut -d ":" -f1 /etc/passwd
    echo "Presione Enter para volver al menú..."
    read
    clear
}

function usuarioExiste() {
    if grep -q "^$1:" /etc/passwd; then # se cumple si en /etc/passwd esta el usuario seguido de :
        return 0 # Usuario existe
    else
        return 1 # Usuario no existe
    fi
}