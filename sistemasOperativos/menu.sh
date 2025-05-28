#!/bin/bash
# Variables para los colores
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

source ./usuarios.sh
#source ./grupos.sh
opc=0

while [[ $opc != 0 ]]; do
    clear
    echo -e "${color_menu}Menu ${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Usuarios"
    echo -e "${color_menu}0) ${color_predeterminado}Salir"
    read -p "Seleccione una opción: " opc

    # opc=0  # Removed to allow user input to be processed

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
        *)  read -p "Opción no válida. Por favor, intente de nuevo." -n 1
            ;;
    esac
done
