# Definición de colores para el menú
color_predeterminado="\e[0m"   # Restablece el color normal
color_menu="\e[95m"            # Color violeta para los títulos y opciones del menú
color_option="\e[97m"          # Color blanco para opciones secundarias (no usado en este script)

# ==============================
# MENÚ PRINCIPAL DE RESPALDOS
# ==============================
function menuRespaldos {
    clear   # Limpia la pantalla

    opc=10  # Inicializa la variable de opción con un valor que no sea 0 o 3

    # Mientras la opción elegida NO sea 0 (salir) o 3 (volver al menú principal)
    while [[ $opc != 0 && $opc != 3 ]]; do
        # Se muestran las opciones del menú
        echo -e "${color_menu}Menú de Respaldos${color_predeterminado}"
        echo -e "${color_menu}1) ${color_predeterminado}Hacer respaldo manual"
        echo -e "${color_menu}2) ${color_predeterminado}Configurar respaldo automatico"
        echo -e "${color_menu}3) ${color_predeterminado}Volver al menú principal"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

        # Solicita al usuario que ingrese la opción
        read -p "Seleccione una opción: " opc

        # Ejecuta la acción correspondiente según la opción elegida
        case $opc in
            1) respaldoManual ;;       # Llama a la función de respaldo manual
            2) respaldoAutomatico ;;   # Llama a la función de respaldo automático
            5) echo "Volviendo al menú principal..." ;; # Esta opción no se usa realmente
            0) echo "Saliendo del programa..." ;;      # Sale del programa
            *) echo "Opción no válida. Por favor, intente de nuevo." ;; # Manejo de errores
        esac
    done
}

# ==============================
# RESPALDO MANUAL
# ==============================
function respaldoManual(){
    # Solicita los datos necesarios para el respaldo
    read -p "Ingrese la ruta completa del directorio a respaldar: " rutaRespaldo
    read -p "Ingrese el usuario remoto en el que se realizara el respaldo: " usuarioRemoto
    read -p "Ingrese la dirección IP del equipo remoto: " ipRemota

    # Crea un archivo tar.gz con la fecha actual
    nombreArchivo="respaldo-$(date +%F).tar.gz"
    tar -czvf "$nombreArchivo" "$rutaRespaldo"   # Comprime el directorio

    # Envía el archivo comprimido al equipo remoto mediante SCP
    scp -r "$nombreArchivo" "$usuarioRemoto@$ipRemota:~"
}

# ==============================
# RESPALDO AUTOMÁTICO (con cron)
# ==============================
function respaldoAutomatico(){
    echo "=== Configuración de respaldo automático con cron ==="

    # Solicita los datos para la tarea automática
    read -p "Ingrese la ruta completa del directorio a respaldar: " rutaRespaldo
    read -p "Ingrese el usuario remoto: " usuarioRemoto
    read -p "Ingrese la dirección IP del equipo remoto: " ipRemota
    read -p "Ingrese la frecuencia (ej: '0 2 * * *' para diario a las 2am): " frecuencia

    # Define la ruta del script que se ejecutará automáticamente
    scriptPath="$HOME/respaldo_auto.sh"

    # Crea el script de respaldo automático con los datos proporcionados
    cat > "$scriptPath" <<EOF
#!/bin/bash
nombreArchivo="respaldo-\$(date +%F).tar.gz"
tar -czf "\$nombreArchivo" "$rutaRespaldo"
scp "\$nombreArchivo" $usuarioRemoto@$ipRemota:~
EOF

    chmod +x "$scriptPath"  # Da permisos de ejecución al script

    # Agrega el script al cron del usuario con la frecuencia especificada
    (crontab -l 2>/dev/null; echo "$frecuencia $scriptPath") | crontab -

    echo "Respaldo automático configurado con éxito."
    echo "Presione Enter para volver al menú..."
    read
    clear
}
