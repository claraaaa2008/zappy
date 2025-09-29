#!/bin/bash
# Script para la administración de grupos

# ========= CONFIGURACIÓN DE ESTILO =========
# Colores para los mensajes en pantalla
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"
verde="\e[32m"
rojo="\e[31m"

# Importa funciones del módulo de usuarios (para reutilizar la validación de existencia de usuarios)
source ./usuarios.sh

# ========= FUNCIÓN PRINCIPAL: Menú de Grupos =========
function menuGrupos() {
    opc=10  # Inicializa la variable para entrar al bucle

    # Bucle que mantiene activo el menú hasta que el usuario elija salir (0) o volver al menú principal (5)
    while [[ $opc != 0 && $opc != 5 ]]; do
        clear  # Limpia la pantalla antes de mostrar el menú
        echo -e "${color_menu}Grupos"
        echo -e "${color_menu}1) ${color_predeterminado}Alta Grupo"
        echo -e "${color_menu}2) ${color_predeterminado}Baja Grupo"
        echo -e "${color_menu}3) ${color_predeterminado}Agregar Usuario a Grupo"
        echo -e "${color_menu}4) ${color_predeterminado}Eliminar Usuario de Grupo"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

        # Lee la opción ingresada por el usuario
        read -p "Seleccione una opción: " opcion

        # Llama a la función correspondiente según la opción elegida
        case $opcion in
            1)
                crearGrupo 
                ;;
            2)
                eliminarGrupo
                ;;
            3)
                agregarUsuarioGrupo
                ;;
            4)
                eliminarUsuarioGrupo
                ;;
            0)
                sh menu.sh  # Al salir, vuelve al menú principal ejecutando el script principal
                ;;
            *)
                echo "Opción no válida"
                ;;
        esac
    done
}

# ========= FUNCIONES DE GESTIÓN DE GRUPOS =========

# Crea un nuevo grupo en el sistema si no existe
function crearGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
    if grep -q "^$nombreGrupo:" /etc/group; then
        echo -e "${rojo}El grupo $nombreGrupo ya existe.${color_predeterminado}"
    else
        groupadd $nombreGrupo
        echo -e "${verde}Grupo $nombreGrupo creado.${color_predeterminado}"
    fi
    echo "Presione Enter para volver al menú..."
    read
    clear
}

# Elimina un grupo existente
function eliminarGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
    if grep -q "^$nombreGrupo:" /etc/group; then
        groupdel $nombreGrupo
        echo -e "${verde}Grupo $nombreGrupo eliminado.${color_predeterminado}" 
    else
        echo -e "${rojo}El grupo $nombreGrupo no existe.${color_predeterminado}"
    fi
    echo "Presione Enter para volver al menú..."
    read
    clear
}

# Agrega un usuario existente a un grupo existente
function agregarUsuarioGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
    if grep -q "^$nombreGrupo:" /etc/group; then
        read -p "Nombre del usuario: " nombreUsuario
        # Valida que el usuario exista antes de agregarlo al grupo
        while ! usuarioExiste "$nombreUsuario" ; do
            echo -e "${rojo}El usuario $nombreUsuario no existe.${color_predeterminado}"
            read -p "Ingrese el nombre del usuario que quiere agregar: " nombreUsuario
        done
        # -aG agrega al grupo sin eliminar los anteriores
        usermod -aG $nombreGrupo $nombreUsuario
        echo -e "${verde}Usuario $nombreUsuario agregado al grupo $nombreGrupo.${color_predeterminado}"
        echo "Presione Enter para volver al menú..."
        read
        clear
    else
        echo -e "${rojo}El grupo $nombreGrupo no existe.${color_predeterminado}"
    fi
}

# Elimina a un usuario de un grupo
function eliminarUsuarioGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
    if grep -q "^$nombreGrupo:" /etc/group; then
        read -p "Nombre del usuario: " nombreUsuario
        # Valida que el usuario exista
        while ! usuarioExiste "$nombreUsuario" ; do
            echo -e "${rojo}El usuario $nombreUsuario no existe.${color_predeterminado}"
            read -p "Ingrese el nombre del usuario: " nombreUsuario
        done
        # Verifica si el usuario pertenece al grupo
        if id -nG "$nombreUsuario" | grep -qw "$nombreGrupo"; then
            # gpasswd -d elimina al usuario del grupo
            gpasswd -d $nombreUsuario $nombreGrupo
            echo -e "${verde}Usuario $nombreUsuario eliminado del grupo $nombreGrupo.${color_predeterminado}"
        else
            echo -e "${rojo}El usuario $nombreUsuario no pertenece al grupo $nombreGrupo.${color_predeterminado}"
        fi
        echo "Presione Enter para volver al menú..."
        read
        clear
    else
        echo -e "${rojo}El grupo $nombreGrupo no existe.${color_predeterminado}"
    fi
}