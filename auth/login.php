<?php
$alert='';
session_start();

if (!empty($_SESSION['active'])) {

  header('location: sistema/');

}else {

    if (empty($_POST['username']) && empty($_POST['password'])) {

      $alert ='Ingrese los datos correctos';

    }else {

      include_once('conexion.php');

      $correo=$_POST['correo'];
      $password=$_POST['password'];

      $consulta = "SELECT * FROM usuarios WHERE correo = '$correo' AND password = '$password'";
      $query = mysqli_query($conexion,$consulta);
      $resultado = mysqli_num_rows($query);

      if ($resultado > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['active'] = true;
        $_SESSION['id'] = $data['id'];
        $_SESSION['nombre'] = $data['nombre'];
        $_SESSION['correo'] = $data['correo'];
        $_SESSION['password'] = $data['password'];

        header('location: sistema/');
      }else {
        $alert='El usuario y la contraseña son incorrectos';
      }
    }
}
 ?>

