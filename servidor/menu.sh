#!/bin/bash
# Script principal del sistema de administración de usuarios y grupos

# ========= CONFIGURACIÓN DE ESTILO =========
# Variables para los colores del menú, para hacerlo visualmente más claro
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

# ========= MODULARIDAD =========
# Se incluyen (source) dos scripts separados: uno para usuarios y otro para grupos
# Esto permite dividir responsabilidades, facilitando el mantenimiento y el trabajo en equipo
source ./usuarios.sh
source ./grupos.sh
source ./firewalld.sh
source ./respaldos.sh

# Inicializa la variable de opción con un valor distinto de 0 para entrar al bucle
opc=5

# ========= BUCLE PRINCIPAL =========
# Se muestra el menú hasta que el usuario elija la opción 0 (salir)
while [[ $opc != 0 ]]; do
    clear  # Limpia la pantalla para mostrar el menú limpio cada vez

    # ========= INTERFAZ DE USUARIO =========
    echo -e "${color_menu}Menu ${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Usuarios"
    echo -e "${color_menu}2) ${color_predeterminado}Grupos"
    echo -e "${color_menu}3) ${color_predeterminado}Firewall"
    echo -e "${color_menu}4) ${color_predeterminado}Respaldos"
    echo -e "${color_menu}0) ${color_predeterminado}Salir"

    # Lee la opción ingresada por el usuario
    read -p "Seleccione una opción: " opc

    # ========= MANEJO DE OPCIONES =========
    # Dependiendo de la opción ingresada, se llama al menú correspondiente
    case $opc in
        1)
            menuUsuarios  # Llama a la función definida en usuarios.sh
            ;;
        2)
            menuGrupos  # Llama a la función definida en grupos.sh
            ;;
        3)
            menuFirewall  # Llama a la función definida en firewalld.sh
            ;;
        4)
            menuRespaldos  # Llama a la función definida en respaldos.sh
            ;;
        0)
            echo "Saliendo..."  # Mensaje de despedida
            ;;
        *)
            # Si se ingresa una opción incorrecta, muestra un mensaje de error
            read -p "Opción no válida. Por favor, intente de nuevo." -n 1
            ;;
    esac
done