#!/bin/bash

# Variables para los colores
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

source ./usuarios.sh
source ./grupos.sh

#Fondo negro
tput setab 0
clear

opc=0

while [[ $opc != 3 ]]; do
    clear
    echo -e "${color_menu}Menu ${color_predeterminado}"
    echo -e "${color_menu}1) ${color_option}Usuarios ${color_predeterminado}"
    read -p "Seleccione una opción: " opc

    opc=0

    case $opc in
        1)
            menuUsuarios
            ;;
        2)
            menuGrupos
            ;;
        0)
            echo "Saliendo..."
            echo -e "\033[0;107m"
            clear
            # Reset terminal background color to white
            echo -e "\033[0;107m"
            ;;
            echo "Opción no válida. Por favor, intente de nuevo."
            echo "Opción no válida."
            read -p "Presione Enter para continuar...\n"
            ;;
    esac
done
