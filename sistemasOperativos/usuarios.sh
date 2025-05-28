#!/bin/bash
# Variables para los colores
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

function menuUsuarios() {
    #Fondo negro
    tput setab 0
    clear

    opc=0

    while [[ $opc != 3 ]]; do
        echo -e "${color_menu}Menu de Usuarios${color_predeterminado}"
        echo -e "${color_option}1) Crear usuario${color_predeterminado}"
        echo -e "${color_option}2) Eliminar usuario${color_predeterminado}"
        echo -e "${color_option}3) Modificar usuario${color_predeterminado}"
        echo -e "${color_option}4) Listar usuarios${color_predeterminado}"
        echo -e "${color_option}5) Volver al menú principal${color_predeterminado}"
        echo -e "${color_option}0) Salir${color_predeterminado}"

        read -p "Seleccione una opción: " opc

        case $opc in
            1)
                read -p "Ingrese el nombre del usuario que quiere crear" usuario
                while [[ usuarioExiste $usuario == 1 ]]; do
                    echo "El usuario $usuario ya existe. Por favor, elija otro nombre."
                    read -p "Ingrese el nombre del usuario que quiere crear" usuario
                done
                read -p "Desea crear un directorio para el usuario? (s/n): " crear_directorio
                case $crear_directorio in
                    s|S|si|SI)
                        useradd -m -d /home/$usuario -s /bin/bash $usuario
                        ;;
                    n|N|no|NO)
                        useradd -s /bin/bash $usuario
                        ;;
                    *)
                        echo "Opción no válida. Se creará el usuario sin directorio."
                        useradd -s /bin/bash $usuario
                        ;;
                esac
                ;;
            2)
                eliminarUsuario
                ;;
            3)
                modificarUsuario
                ;;
            4)
                listarUsuarios
                ;;
            5)
                echo "Volviendo al menú principal..."
                break
                ;;
            *)
                echo "Opción no válida. Por favor, intente de nuevo."
                read -p "Presione Enter para continuar...\n"
                ;;
        esac
    done
}

function usuarioExiste(usuario) {
    if grep -q "^$usuario:" /etc/passwd; then
        return 1
    else
        return 0
    fi
}