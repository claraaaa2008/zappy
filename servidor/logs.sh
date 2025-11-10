#!/bin/bash
# Script que para ver logs del sistema 
# ===========================================

# Variables para los colores del menú, para hacerlo visualmente más claro
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

LOGFILE="/var/log/zappy.log"

function menuLogs() {
        clear   # Limpia la pantalla
        if [ ! -f "$LOGFILE" ]; then
        echo "El archivo de log no existe en $LOGFILE"
        exit 1
    fi

    echo -e "${color_menu}VISOR DE LOGS ZAPPY${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Ver todos los logs"
    echo -e "${color_menu}2) ${color_predeterminado}Filtrar por fecha (YYYY-MM-DD)"
    read -p "Selecciona una opción: " opcion

    case $opcion in
        1)
            echo ""
            echo -e "${color_menu}Todos los logs ${color_predeterminado}"
            cat "$LOGFILE"
            ;;
        2)
            read -p "Ingresa la fecha a filtrar (formato YYYY-MM-DD): " fecha
            echo ""
            echo -e "${color_menu}Logs del $fecha${color_predeterminado}"
            grep "$fecha" "$LOGFILE" || echo "No hay registros para esa fecha."
            ;;
        *)
            echo "Opción inválida."
            ;;
    esac
    echo "Presiona Enter para volver al menú..."
    read
    clear
}
