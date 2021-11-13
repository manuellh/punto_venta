<?php
class Venta{
  private $DBConexion;

  function __construct($conexion){
    $this->DBConexion = $conexion;
  }

  #MENSAJES DE STATUS
  public function status(){
    include_once("partials/alertas.php");
  }

  #MOSTRAR ARTICULOS
  public function mostrarArticulos(){

    $sentencia = $this->DBConexion->prepare("SELECT * FROM productos");
    $sentencia->execute();
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

    return $productos;
  }

  #AGREGAR ARTICULOS AL CARRITO
  public function agregarProducto(){
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    if(!empty($id) && !empty($cantidad)){

      $sentencia = $this->DBConexion->prepare("SELECT * FROM productos WHERE id=:id LIMIT 1;");
      $sentencia->bindParam(':id',$id);
      $sentencia->execute();
      $producto = $sentencia->fetch(PDO::FETCH_OBJ);
      
      #Si recibimos una cantidad negativa
      if ($cantidad <= 0) {
        header("Location: ../index.php?status=6");
      
      #Si no exixte el producto
      }else if (!$producto) {
        header("Location: ../index.php?status=7");
        exit;
      
      #Si no hay stock
      }else if ($producto->stock < 1) {
        header("Location: index.php?status=8");
        exit;
      #si exede la cantidad salimos y lo indicamos
      }else if ($cantidad >$producto->stock){
        header("Location: index.php?status=10");
        exit;
      }

    #Si no hay problema
    $indice = false;

    # Buscamos el producto dentro del cartito
    for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
        if ($_SESSION["carrito"][$i]->id === $id) {
            $indice = $i;
            break;
        }
    }

    # Si no existe, lo agregamos como nuevo
    if ($indice === false && $cantidad >= 1) {
        $producto->cantidad = $cantidad;
        $producto->total = $producto->precio * $cantidad;
        array_push($_SESSION["carrito"], $producto);
        header("Location: ../index.php?status=11");
          exit;
    }else{
      #SI LLEGA AL LIMITE DEL STOCK LO INDICAMOS
      $cantidadExistente = $_SESSION["carrito"][$indice]->cantidad;
      if ($cantidadExistente + $cantidad > $producto->stock) {
          header("Location: ../index.php?status=10");
          exit;
      }
    }

        #Si no hay problema lo agregamos a la lista
        $cantidadLista= $_SESSION["carrito"][$indice]->cantidad+$cantidad;
        $_SESSION["carrito"][$indice]->cantidad=$cantidadLista;
        $_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precio;
   

    }
  }

  #GENERAMOS LA VENTA DE LOS ARTICULOS / ACTUALIZAMOS EL STOCK
  public function generarVenta(){
      $total = $_POST['total'];

      if (!empty($total)) {
        #INSERTADMOS LOS DATOS DE LA VENTA
        $sentencia = $this->DBConexion->prepare("INSERT INTO ventas (total) VALUES (:total)");
        $sentencia->bindParam(':total', $total);
        $sentencia->execute();

        #SELECCIONAMOS EL ULTIMO ID DE LAS VENTAS
        $sentencia = $this->DBConexion->prepare("SELECT id FROM ventas ORDER BY id DESC LIMIT 1;");
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

        $idVenta =  $resultado->id;
      

        foreach ($_SESSION['carrito'] as $producto) {
          $productoId = $producto->id;
          $cantidad = $producto->cantidad;
          
          #INSERTAMOS LOS DATOS A LA TABLA PRODUCTOS VENDIDOS
          $query = ("INSERT INTO productos_vendidos(id_Producto, cantidad, id_Venta) VALUES (:id_Producto, :cantidad, :id_Venta);");
          $sentencia = $this->DBConexion->prepare($query);
          $sentencia->bindParam(':id_Producto',$productoId);
          $sentencia->bindParam(':cantidad',$cantidad);
          $sentencia->bindParam(':id_Venta',$idVenta);
          $sentencia->execute();


          #ACTUALIZAMOS EL STOCK  
          $query = ("UPDATE productos SET stock = stock - :cantidad WHERE id = :id_Producto");
          $actualizarStock = $this->DBConexion->prepare($query);
          $actualizarStock->bindParam(':cantidad',$cantidad);
          $actualizarStock->bindParam(':id_Producto',$productoId);
          $actualizarStock->execute();
      }

        #CERRAMOS LA SESION DEL CARRITO
        unset($_SESSION["carrito"]);

        #INICIAMOS UNA NUEVA SESION DEL CARRITO
        $_SESSION["carrito"] = [];
        header("Location: ../index.php?status=9");    
    } 
  }


  public function ventasRealizadas(){
    $query = "SELECT
                    ventas.id,
                    ventas.fecha,
                    ventas.total,
                    GROUP_CONCAT(
                      productos.nombre, '..',
                      productos_vendidos.cantidad, '..'
                    SEPARATOR '__'
                    ) AS productos
    FROM ventas INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id
                INNER JOIN productos ON productos.id = productos_vendidos.id_Producto
                GROUP BY ventas.id ORDER BY ventas.id";
    $sentencia = $this->DBConexion->prepare($query);
      $sentencia->execute();
      $ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

      return $ventas;

  }
}