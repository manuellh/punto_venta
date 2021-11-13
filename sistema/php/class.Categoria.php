<?php
class Categoria{
  private $DBConexion;

  function __construct($conexion){
    $this->DBConexion = $conexion;
  }

  public function alertas(){
    include_once("../partials/alertas.php");
  }

  #TABLA DE CATEGORIAS
  public function mostrarCategotia(){
    $sentencia = $this->DBConexion->prepare("SELECT * FROM categorias");
    $sentencia->execute();
    $categorias = $sentencia->fetchAll(PDO::FETCH_OBJ);
    if($categorias){
      foreach ($categorias as $categoria) {
        ?>
        <tr>
          <td><?php echo $categoria->id; ?></td>
          <td><?php echo $categoria->nombre; ?></td>
          <td><?php echo $categoria->descripcion; ?></td>
          <td> <i class="fas fa-tag" style="color:<?php echo $categoria->color; ?>"></i></td>
          <td>
            <a href="<?php echo "../categorias/editar.php?id=" . $categoria->id;?>" class="btn btn-warning">Editar</a> 
          </td>
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

  #CREACION DE NUEVAS CATEGORIAS
  public function crearCategoria(){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];

    if(!empty($nombre) && !empty($descripcion) && !empty($color)){
      $query = "INSERT INTO categorias (nombre,descripcion,color) VALUES (:nombre,:descripcion,:color)";
      $consulta = $this->DBConexion->prepare($query);
      $consulta->bindParam(':nombre',$nombre);
      $consulta->bindParam(':descripcion', $descripcion);
      $consulta->bindParam(':color',$color);
      $consulta->execute();

      if(!$consulta){
        header("Location: ./categorias/index.php?estatus=1");
      }

    }else{
      ?>
        <script>
          alert ("Llene los campos que faltan");  
        </script>
      <?php
    }
  }

  #EDITAR CATEGORIA
  public function editarCategoria(){
    $id = $_GET["id"];
    $query = "SELECT * FROM categorias WHERE id=:id";
    $consulta = $this->DBConexion->prepare($query);
    $consulta->bindParam(':id',$id);
    $consulta->execute();
    $categoria = $consulta->fetch(PDO::FETCH_OBJ);

    if($categoria){
      ?>
        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value=" <?php echo $categoria->id ?> ">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Categoria</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $categoria->nombre ?>">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $categoria->descripcion ?>">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Etiqueta de Color Actual</label>
                <div class="row center">
                  <div class="col-sm-4">
                    <i class="fas fa-tag fa-2x" style="color:<?php echo $categoria->color; ?>"></i>
                  </div>
                  <div class="col-sm-5">
                    <select class="form-select" name="color">
                        <option selected>Seleccionar Nuevo Color</option>
                        <option value="#2196f3">Azul</option>
                        <option value="#4caf50">Verde</option>
                        <option value="#ffc107">Amarillo</option>
                        <option value="#e91e63">Rosa</option>
                        <option value="#f44336">Rojo</option>
                        <option value="#9c27b0">Morado</option>
                    </select>
                  </div>
                </div>

            </div>
            <div id="btn_add" class="mb-3 btn-group">
                <button id="actualizar" name="actualizar" type="submit" class="btn btn-success">Actualizar</button>
                <button name="eliminar" type="submit" class="btn btn-danger">Borrar</button>
                <a href="../categorias/index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
      <?php
    }
    

  }

  #ACTUALIZAR CATEGORIA
  public function actualizarCategoria(){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $color = $_POST['color'];

    if(!empty($id) && !empty($nombre) && !empty($descripcion) && !empty($color)){
      $query = "UPDATE categorias SET nombre=:nombre,
                                      descripcion=:descripcion,
                                      color=:color
                                      WHERE id=:id";
      $consulta = $this->DBConexion->prepare($query);
      $consulta->bindParam(':id',$id);
      $consulta->bindParam(':nombre',$nombre);
      $consulta->bindParam(':descripcion', $descripcion);
      $consulta->bindParam(':color',$color);
      $consulta->execute();

      if($consulta){
        header("Location: ../categorias/index.php?estatus=3");
      }

    }else{
      ?>
      
      <script>
        alert ("Llene los campos que faltan");  
      </script>
      <?php
    }
  }
  
  public function eliminarCategoria(){
    ?> <script> confirm("Esta seguro de elimiar esta categoria"); </script> <?php
    $id = $_POST['id'];
    $query = "DELETE FROM categorias WHERE id=:id";
    $consulta = $this->DBConexion->prepare($query);
    $validacion = $consulta->bindParam(':id',$id);
    $consulta->execute();

    if($consulta){
      header("Location: ../categorias/index.php?estatus=3");
    }

  }

}
 ?>
