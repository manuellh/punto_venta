 <?php
 $host = 'localhost';
 $username = 'root';
 $password = '';
 $database = 'punto_Venta';

 try {
   $conexion = new PDO("mysql:host=$host;dbname=$database;", $username, $password);
 } catch (PDOException $e) {
   die('Connection Failed: ' . $e->getMessage());
 }


 include_once("class.Categoria.php");
 $Categoria = new Categoria($conexion);

 include_once("class.Productos.php");
 $Productos = new Producto($conexion);

 include_once("class.Transacciones.php");
 $Transaccion = new Transaccion($conexion);

 include_once("class.Ventas.php");
 $Venta = new Venta($conexion);


  ?>
