#!/bin/bash

# Variables para los colores
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

source ./usuarios.sh
source ./grupos.sh
opc=5

while [[ $opc != 0 ]]; do
    clear
    echo -e "${color_menu}Menu ${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Usuarios"
    echo -e "${color_menu}2) ${color_predeterminado}Grupos"
    echo -e "${color_menu}0) ${color_predeterminado}Salir"
    read -p "Seleccione una opción: " opc

    case $opc in
        1)
            menuUsuarios
            ;;
        2)
            menuGrupos
            ;;
        0)
            echo "Saliendo..."
            ;;
        *)  read -p "Opción no válida. Por favor, intente de nuevo." -n 1
            ;;
    esac
done
