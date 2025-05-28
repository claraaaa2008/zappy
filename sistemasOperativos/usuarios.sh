#!/bin/bash
# Variables para los colores
color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

function menuUsuarios() {
    #Fondo negro
    #tput setab 0
    #clear

    opc=0

    while [[ $opc != 3 ]]; do
        echo -e "${color_menu}Menu de Usuarios${color_predeterminado}"
        echo -e "${color_menu}1) ${color_predeterminado}Crear usuario"
        echo -e "${color_menu}2) ${color_predeterminado}Eliminar usuario"
        echo -e "${color_menu}3) ${color_predeterminado}Modificar usuario"
        echo -e "${color_menu}4) ${color_predeterminado}Listar usuarios"
        echo -e "${color_menu}5) ${color_predeterminado}Volver al menú principal"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

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
                read -p "Ingrese el nombre del usuario que quiere eliminar: " usuario
                while [[ usuarioExiste $usuario == 0 ]]; do
                    echo "El usuario $usuario no existe. Por favor, elija otro nombre."
                    read -p "Ingrese el nombre del usuario que quiere eliminar: " usuario
                done
                userdel -r $usuario
                ;;
            3)
                read -p "Ingrese el nombre del usuario que quiere modificar: " usuario
                while [[ usuarioExiste $usuario == 0 ]]; do
                    echo "El usuario $usuario no existe. Por favor, elija otro nombre."
                    read -p "Ingrese el nombre del usuario que quiere modificar: " usuario
                done
                read -p "Ingrese el nuevo nombre del usuario: " nuevo_usuario
                while [[ usuarioExiste $nuevo_usuario == 1 ]]; do
                    echo "El usuario $nuevo_usuario ya existe. Por favor, elija otro nombre."
                    read -p "Ingrese el nuevo nombre del usuario: " nuevo_usuario
                done
                usermod -l $nuevo_usuario $usuario
                ;;
            4)
                echo -e "${color_menu}Lista de usuarios:${color_predeterminado}"
                cut -d ":" -f1 /etc/passwd 
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