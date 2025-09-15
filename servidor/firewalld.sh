color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

function menuFirewall {
    clear

    opc=10

    while [[ $opc != 0 && $opc != 5 ]]; do
        echo -e "${color_menu}Menú de Firewall${color_predeterminado}"
        echo -e "${color_menu}1) ${color_predeterminado}Habilitar Firewall"
        echo -e "${color_menu}2) ${color_predeterminado}Deshabilitar Firewall"
        echo -e "${color_menu}3) ${color_predeterminado}Configuración de zonas"
        echo -e "${color_menu}4) ${color_predeterminado}Configuración de servicios"
        echo -e "${color_menu}5) ${color_predeterminado}Reglas enriquecidas"
        echo -e "${color_menu}6) ${color_predeterminado}Volver al menú principal"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

        read -p "Seleccione una opción: " opc

        case $opc in
            1)
                habilitarFirewall
                ;;
            2)
                deshabilitarFirewall
                ;;
            3)
                configuracionZonas
                ;;
            4)
                configuracionServicios
                ;;
            5)
                reglasAvanzadas
                ;;
            6)
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

function habilitarFirewall() {
    echo "Habilitando el Firewall..."
    systemctl start firewalld
    systemctl enable firewalld
    echo "Firewall habilitado."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

function deshabilitarFirewall() {
    echo "Deshabilitando el Firewall..."
    systemctl stop firewalld
    systemctl disable firewalld
    echo "Firewall deshabilitado."
    echo "Presione Enter para volver al menú..."
    read
    clear
}

function configurarZonas() {
    echo -e "${color_menu}--- Listar Reglas del Firewall ---${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Listar zonas disponibles"
    echo -e "${color_menu}2) ${color_predeterminado}Listar zonas activas"
    echo -e "${color_menu}5) ${color_predeterminado}Ver configuración de una zona"
    echo -e "${color_menu}3) ${color_predeterminado}Ver a qué zona está configurada una interfaz"
    echo -e "${color_menu}4) ${color_predeterminado}Cambiar interfaz de zona"
    echo -e "${color_menu}0) ${color_predeterminado}Volver"

    read -p "Seleccione una opción: " opcionZona

    case $opcionZona in
        1)
            firewall-cmd --get-zones
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        2)
            read -p "Ingrese el nombre de la nueva zona: " nuevaZona
            firewall-cmd --permanent --new-zone="$nuevaZona"
            firewall-cmd --reload
            echo "Zona '$nuevaZona' agregada."
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        3)
            read -p "Ingrese el nombre de la zona a eliminar: " zonaEliminar
            firewall-cmd --permanent --delete-zone="$zonaEliminar"
            firewall-cmd --reload
            echo "Zona '$zonaEliminar' eliminada."
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        4)
            read -p "Ingrese el nombre de la zona a modificar: " zonaModificar
            read -p "Ingrese la interfaz de red a agregar a la zona: " interfazRed
            firewall-cmd --permanent --zone="$zonaModificar" --add-interface="$interfazRed"
            firewall-cmd --reload
            echo "Interfaz '$interfazRed' agregada a la zona '$zonaModificar'."
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        0)
            clear
            return
            ;;
        *)
            echo "Opción no válida. Por favor, intente de nuevo."
            ;;
    esac
}

function configuracionServicios() {
    echo -e "${color_menu}1) ${color_predeterminado}Listar servicios soportados"
    echo -e "${color_menu}2) ${color_predeterminado}Permitir servicio"
    echo -e "${color_menu}3) ${color_predeterminado}Eliminar zona"
    echo -e "${color_menu}4) ${color_predeterminado}Modificar zona"
    echo -e "${color_menu}0) ${color_predeterminado}Volver al menú principal"

    read -p "Seleccione una opción: " opcionZona

    case $opcionZona in
        1)
            firewall-cmd --get-zones
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        2)
            read -p "Ingrese el nombre de la nueva zona: " nuevaZona
            firewall-cmd --permanent --new-zone="$nuevaZona"
            firewall-cmd --reload
            echo "Zona '$nuevaZona' agregada."
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        0)
            clear
            menuFirewall
            ;;
        *)
            echo "Opción no válida. Por favor, intente de nuevo."
            ;;
    esac
}

function reglasAvanzadas {
    echo -e "${color_menu}--- Reglas Avanzadas del Firewall ---${color_predeterminado}"
    echo -e "${color_menu}1) ${color_predeterminado}Listar reglas avanzadas"
    echo -e "${color_menu}2) ${color_predeterminado}Agregar regla avanzada"
    echo -e "${color_menu}3) ${color_predeterminado}Eliminar regla avanzada"
    echo -e "${color_menu}0) ${color_predeterminado}Volver"

    read -p "Seleccione una opción: " opcionRegla

    case $opcionRegla in
        1)
            firewall-cmd --list-rich-rules
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        2)
            read -p "Ingrese la zona (ej: public, home): " zona
            read -p "Ingrese la IP origen (ej: 192.168.1.100): " ip
            read -p "Ingrese el puerto (ej: 22): " puerto
            read -p "Ingrese el protocolo (tcp/udp): " protocolo
            read -p "Ingrese la acción (accept/reject/drop): " accion
            firewall-cmd --permanent --add-rich-rule="rule family='ipv4' source address='$ip' port protocol='$protocolo' port='$puerto' $accion"
            firewall-cmd --reload
            echo "Regla avanzada agregada."
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        3)
            read -p "Ingrese la regla avanzada a eliminar: " reglaEliminar
            firewall-cmd --permanent --remove-rich-rule="$reglaEliminar"
            firewall-cmd --reload
            echo "Regla avanzada eliminada."
            echo "Presione Enter para volver al menú..."
            read
            clear
            ;;
        0)
            clear
            menuFirewall
            ;;
        *)
            echo "Opción no válida. Por favor, intente de nuevo."
            ;;
    esac
}

