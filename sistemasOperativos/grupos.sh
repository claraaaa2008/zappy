#!/bin/bash

# Variables para los colores
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

function menuGrupos() {
    opc=10 # Inicializar opc con un valor diferente de 0 para entrar al bucle

    while [[ $opc != 0 && $opc != 5 ]]; do # Se ejecuta mientras la opcion no sea salir ni volver al menú principal
    clear
    echo -e "${color_menu}Grupos"
    echo -e "${color_menu}1) ${color_predeterminado}Alta Grupo"
    echo -e "${color_menu}2) ${color_predeterminado}Baja Grupo"
    echo -e "${color_menu}3) ${color_predeterminado}Agregar Usuario a Grupo"
    echo -e "${color_menu}4) ${color_predeterminado}Eliminar Usuario de Grupo"
    echo -e "${color_menu}0) ${color_predeterminado}Salir"

    read -p "Seleccione una opción: " opcion
    
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
                sh menu.sh
                ;;
            *)
                echo "Opción no válida"
                ;;
        esac
    done
}

function crearGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
        if grep -q "^$nombreGrupo:" /etc/group; then
            echo "El grupo $nombreGrupo ya existe."
        else
            groupadd $nombreGrupo
            echo "Grupo $nombreGrupo creado"
        fi
    echo "Presione Enter para volver al menú..."
    read
    clear
}
function eliminarGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
        if grep -q "^$nombreGrupo:" /etc/group; then
            groupdel $nombreGrupo
            echo "Grupo $nombreGrupo eliminado" 
        else
            echo "El grupo $nombreGrupo no existe."
        fi
    echo "Presione Enter para volver al menú..."
    read
    clear
}

function agregarUsuarioGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
    read -p "Nombre del usuario: " nombreUsuario
    usermod -aG $nombreGrupo $nombreUsuario
    echo "Usuario $nombreUsuario agregado al grupo $nombreGrupo"
}

function eliminarUsuarioGrupo(){
    read -p "Nombre del grupo: " nombreGrupo
    read -p "Nombre del usuario: " nombreUsuario
    gpasswd -d $nombreUsuario $nombreGrupo
    echo "Usuario $nombreUsuario eliminado del grupo $nombreGrupo"
}