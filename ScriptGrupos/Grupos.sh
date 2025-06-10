#!/bin/bash

echo -e "\e[95mGrupos"
echo -e "\e[95m1) \e[97mAlta Grupo"
echo -e "\e[95m2) \e[97mBaja Grupo"
echo -e "\e[95m3) \e[97mAgregar Usuario a Grupo"
echo -e "\e[95m4) \e[97mEliminar Usuario de Grupo"
echo -e "\e[95m5) \e[97mSalir"
read -p "Opción: " opcion
case $opcion in
  1)
 crearGrupo ;;
  2)
   eliminarGrupo
    ;;
  3)
    agregarUsuarioGrupo
    ;;
  4)
    eliminarUsuarioGrupo
    ;;
  5)
    sh menu.sh
    ;;
  *)
    echo "Opción no válida"
    ;;
esac

def crearGrupo(){
 read -p "Nombre del grupo: " nombreGrupo
  if grep -q "^$nombreGrupo:" /etc/group; then
    echo "El grupo $nombreGrupo ya existe."
    else
    groupadd $nombreGrupo
    echo "Grupo $nombreGrupo creado"
    fi
}
def eliminarGrupo(){
 read -p "Nombre del grupo: " nombreGrupo
    if grep -q "^$nombreGrupo:" /etc/group; then
    groupdel $nombreGrupo
    echo "Grupo $nombreGrupo eliminado" 
   else
    echo "El grupo $nombreGrupo no existe."
   fi
}

def agregarUsuarioGrupo(){
read -p "Nombre del grupo: " nombreGrupo
    read -p "Nombre del usuario: " nombreUsuario
    usermod -aG $nombreGrupo $nombreUsuario
    echo "Usuario $nombreUsuario agregado al grupo $nombreGrupo"
}

def eliminarUsuarioGrupo(){
  read -p "Nombre del grupo: " nombreGrupo
    read -p "Nombre del usuario: " nombreUsuario
    gpasswd -d $nombreUsuario $nombreGrupo
    echo "Usuario $nombreUsuario eliminado del grupo $nombreGrupo"
    ;;
}