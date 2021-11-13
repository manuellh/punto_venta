<?php
$BD="punto_Venta";
$servidor="localhost";
$usuario="root";
$contrasena="";

$conexion=mysqli_connect($servidor,$usuario,$contrasena,$BD);

if ($conexion) {
  #echo "conectado... :)";
}else {
  echo "error... :(";
}

 ?>
