<?php
class Transaccion{
  private $DBConexion;

  function __construct($conexion){
    $this->DBConexion = $conexion;
  }

  public function tablaTransacciones(){

    $sentencia = $this->DBConexion->prepare("SELECT * FROM transacciones");
    $sentencia->execute();
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

    if($productos){
      foreach ($productos as $producto) {
        ?>
        <tr>
            <td><?php echo $producto->id; ?></td>
            <td><?php echo $producto->fecha_hora; ?></td>
            <td><?php echo $producto->descripcion; ?></td>
            <td><?php echo $producto->detalles; ?></td>
            <td><?php echo $producto->usuario; ?></td>
        </tr>
        <?php
      }

    }else{
    ?>
      <tr>
        <td>No hay Registros</td>
      </tr>
    <?php
    }
  }
}

