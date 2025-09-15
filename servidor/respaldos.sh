color_predeterminado="\e[0m"
color_menu="\e[95m"
color_option="\e[97m"

function menuRespaldos {
    clear

    opc=10

    while [[ $opc != 0 && $opc != 5 ]]; do
        echo -e "${color_menu}Menú de Respaldos${color_predeterminado}"
        echo -e "${color_menu}1) ${color_predeterminado}Hacer respaldo manual"
        echo -e "${color_menu}2) ${color_predeterminado}Configurar respaldo automatico"
        echo -e "${color_menu}5) ${color_predeterminado}Volver al menú principal"
        echo -e "${color_menu}0) ${color_predeterminado}Salir"

        read -p "Seleccione una opción: " opc

        case $opc in
            1)
                echo respaldoManual
                ;;
            2)
                echo "Configurando respaldo automático..."
                ;;
            5)
                echo "Volviendo al menú principal..."
                ;;
            0)
                echo "Saliendo del programa..."
                ;;
            *)
                echo "Opción no válida. Por favor, intente de nuevo."
                ;;
        esac
    done
}

function respaldoManual(){
    read -p "Ingrese la ruta completa del directorio a respaldar: " rutaRespaldo
    read -p "Ingrese el usuario remoto en el que se realizara el respaldo: " usuarioRemoto
    read -p "Ingrese la dirección IP del equipo remoto: " ipRemota

    tar cvf $(date +%F).tar $rutaRespaldo
    gzip $(date +%F).tar

    scp -r $(date +%F).tar.gz $usuarioRemoto@$ipRemota:~
}

function respaldoAutomatico(){
    
}