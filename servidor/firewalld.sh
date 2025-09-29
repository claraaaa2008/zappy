# Definición de colores para mejorar la visualización en el menú
color_predeterminado="\e[0m"   # Restablece el color a normal
color_menu="\e[95m"            # Color violeta para títulos y opciones
color_option="\e[97m"          # Color blanco para opciones secundarias

# ==============================
# FUNCIÓN PRINCIPAL DEL MENÚ
# ==============================
function menuFirewall {
    clear   # Limpia la pantalla

    opc=10  # Variable inicial con un valor cualquiera distinto a 0 o 6

    # Mientras la opción elegida NO sea 0 (salir) o 6 (volver al menú principal)
    while [[ $opc != 0 && $opc != 6 ]]; do
        # Se muestran las opciones del menú
        echo -e "${color_menu}Menú de Firewall${color_predeterminado}"
        echo -e "${color_menu}1) ${color_predeterminado}Habilitar Firewall"
        echo -e "${color_menu}2) ${color_predeterminado}Deshabilitar Firewall"
        echo -e "${color_menu}3) ${color_predeterminado}Configuración de zonas"
        echo -e "${color_menu}4) ${color_predeterminado}Configuración de servicios"
        echo -e "${color_menu}5) ${color_predeterminado}Reglas enriquecidas"
        echo -e "${color_menu}6) ${color_predeterminado}Volver al menú principal"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

        # Se pide al usuario que elija una opción
        read -p "Seleccione una opción: " opc

        # Se ejecuta la acción correspondiente según la opción
        case $opc in
            1) habilitarFirewall ;;           # Llama a la función habilitarFirewall
            2) deshabilitarFirewall ;;        # Llama a la función deshabilitarFirewall
            3) configuracionZonas ;;          # Llama a la función configuracionZonas
            4) configuracionServicios ;;      # Llama a la función configuracionServicios
            5) reglasAvanzadas ;;             # Llama a la función reglasAvanzadas
            6) echo "Volviendo al menú principal..." ;; # Sale al menú anterior
            0) clear; echo "Saliendo del programa..." ;; # Termina el programa
            *) echo "Opción no válida. Por favor, intente de nuevo." ;; # Manejo de errores
        esac
    done
}

# ==============================
# FUNCIONES DEL MENÚ PRINCIPAL
# ==============================

# Activa el firewall y lo habilita en el arranque
function habilitarFirewall() {
    echo "Habilitando el Firewall..."
    systemctl start firewalld     # Inicia el servicio
    systemctl enable firewalld    # Lo habilita al iniciar el sistema
    echo "Firewall habilitado."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

# Desactiva el firewall y lo quita del arranque
function deshabilitarFirewall() {
    echo "Deshabilitando el Firewall..."
    systemctl stop firewalld      # Detiene el servicio
    systemctl disable firewalld   # Lo deshabilita en el inicio del sistema
    echo "Firewall deshabilitado."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

# ==============================
# CONFIGURACIÓN DE ZONAS
# ==============================
function configuracionZonas() {
    clear
    echo -e "${color_menu}--- Configuración de Zonas del Firewall ---${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Listar zonas disponibles"
    echo -e "${color_menu}2) ${color_predeterminado}Listar zonas activas"
    echo -e "${color_menu}3) ${color_predeterminado}Ver configuración de una zona"
    echo -e "${color_menu}4) ${color_predeterminado}Ver a qué zona está configurada una interfaz"
    echo -e "${color_menu}5) ${color_predeterminado}Cambiar interfaz de zona"
    echo -e "${color_menu}0) ${color_predeterminado}Volver"

    read -p "Seleccione una opción: " opcionZona

    case $opcionZona in
        1) firewall-cmd --get-zones ;;                        # Muestra todas las zonas disponibles
        2) firewall-cmd --get-active-zones ;;                 # Muestra solo las zonas activas
        3) read -p "Ingrese el nombre de la zona: " zonaVer   # Pregunta zona y muestra detalles
           firewall-cmd --zone="$zonaVer" --list-all ;;
        4) read -p "Ingrese la interfaz: " interfaz           # Pregunta interfaz y muestra su zona
           firewall-cmd --get-zone-of-interface="$interfaz" ;;
        5) read -p "Ingrese el nombre de la zona a modificar: " zonaModificar
           read -p "Ingrese la interfaz de red a agregar a la zona: " interfazRed
           firewall-cmd --permanent --zone="$zonaModificar" --add-interface="$interfazRed"
           firewall-cmd --reload
           echo "Interfaz '$interfazRed' agregada a la zona '$zonaModificar'." ;;
        0) clear; return ;;                                  # Vuelve al menú anterior
        *) echo "Opción no válida. Por favor, intente de nuevo." ;;
    esac

    echo "Presione Enter para volver al menú..."
    read
    clear
}

# ==============================
# CONFIGURACIÓN DE SERVICIOS
# ==============================
function configuracionServicios() {
    clear
    echo -e "${color_menu}1) ${color_predeterminado}Listar servicios soportados"
    echo -e "${color_menu}2) ${color_predeterminado}Permitir servicio"
    echo -e "${color_menu}3) ${color_predeterminado}Bloquear servicio"
    echo -e "${color_menu}0) ${color_predeterminado}Volver al menú principal"

    read -p "Seleccione una opción: " opcionServicio

    case $opcionServicio in
        1) firewall-cmd --get-services ;;                     # Lista los servicios disponibles
        2) read -p "Ingrese el nombre del servicio: " nuevoServicio
           firewall-cmd --permanent --zone=public --add-service="$nuevoServicio"
           firewall-cmd --reload
           echo "Servicio '$nuevoServicio' agregado." ;;
        3) read -p "Ingrese el nombre del servicio a bloquear: " servicioBloquear
           firewall-cmd --permanent --zone=public --remove-service="$servicioBloquear"
           firewall-cmd --reload
           echo "Servicio '$servicioBloquear' bloqueado." ;;
        0) clear; return ;;
        *) echo "Opción no válida. Por favor, intente de nuevo." ;;
    esac

    echo "Presione Enter para volver al menú..."
    read
    clear
}

# ==============================
# REGLAS AVANZADAS (rich rules)
# ==============================
function reglasAvanzadas {
    clear
    echo -e "${color_menu}--- Reglas Avanzadas del Firewall ---${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Listar reglas avanzadas"
    echo -e "${color_menu}2) ${color_predeterminado}Agregar regla avanzada"
    echo -e "${color_menu}3) ${color_predeterminado}Eliminar regla avanzada"
    echo -e "${color_menu}0) ${color_predeterminado}Volver"

    read -p "Seleccione una opción: " opcionRegla

    case $opcionRegla in
        1) firewall-cmd --list-rich-rules ;;   # Lista todas las reglas avanzadas
        2) # Pide datos al usuario para crear una regla avanzada
           read -p "Ingrese la zona (ej: public, home): " zona
           read -p "Ingrese la IP origen (ej: 192.168.1.100): " ip
           read -p "Ingrese el puerto (ej: 22): " puerto
           read -p "Ingrese el protocolo (tcp/udp): " protocolo
           read -p "Ingrese la acción (accept/reject/drop): " accion
           firewall-cmd --permanent --add-rich-rule="rule family='ipv4' source address='$ip' port port='$puerto' protocol='$protocolo' $accion"
           firewall-cmd --reload
           echo "Regla avanzada agregada." ;;
        3) # Elimina una regla avanzada escribiendo la regla completa
           read -p "Ingrese la regla avanzada a eliminar: " reglaEliminar
           firewall-cmd --permanent --remove-rich-rule="$reglaEliminar"
           firewall-cmd --reload
           echo "Regla avanzada eliminada." ;;
        0) clear; return ;;
        *) echo "Opción no válida. Por favor, intente de nuevo." ;;
    esac

    echo "Presione Enter para volver al menú..."
    read
    clear
}
