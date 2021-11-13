<?php
class Producto{
  private $DBConexion;

  function __construct($conexion){
    $this->DBConexion = $conexion;
  }

  public function alertas(){
    include_once("../partials/alertas.php");
  }

  ################################TABLA DE PRODUCTOS################################
  public function mostrarProducto(){

    $sentencia = $this->DBConexion->prepare("SELECT * FROM productos");
    $sentencia->execute();
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

    if($productos){
      foreach ($productos as $producto) {
        ?>
        <tr>
            <td><?php echo $producto->id; ?></td>
            <td> <img width="50" src="../<?php echo $producto->imagen; ?>" alt="<?php echo $producto->nombre; ?>"> </td>
            <td><?php echo $producto->nombre; ?></td>
            <td><?php echo $producto->descripcion; ?></td>
            <td><?php echo $producto->precio; ?></td>
            <td><?php echo $producto->stock; ?></td>

              <?php
              #### BUSCAR EL LA CATEGORIA POR MEDIO DE LA FK ####
              $id =  $producto->fk_Id_Categoria;
              $sentencia = $this->DBConexion->prepare("SELECT * FROM categorias Where id=:id");
              $sentencia->bindParam(':id',$id);
              $sentencia->execute();
              $categorias = $sentencia->fetchAll(PDO::FETCH_OBJ);

              foreach ($categorias as $categoria){
                echo '<td>'.$categoria->nombre.'</td>'; 
                echo '<td><i class="fas fa-tag" style="color:'.$categoria->color.'"></i></td>'; 
              }
              ?>

            <td>
                <a href="<?php echo "../productos/editar.php?id=" . $producto->id;?>" class="btn btn-warning">Editar</a> 
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

  ################################# CREACION DE UN NUEVO PRODUCTO ################################
  public function crearProducto(){

    $imagen = $_FILES['imagen']['name'];//Obtenemos el nombre
    $archivo = $_FILES['imagen']['tmp_name']; //optenemos el archivo
    $ruta = "productos/imagenes"; //ruta de guardado del las imagenes

    $ruta = $ruta."/".$imagen; //../productos/imagenes/imagen.jpg
    move_uploaded_file($archivo,$ruta);//movemos el archivo

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    if(!empty($nombre) && !empty($descripcion) && !empty($precio) && !empty($imagen)){
      $query = "INSERT INTO productos (nombre,descripcion,precio,imagen,fk_Id_Categoria) VALUES (:nombre,:descripcion,:precio,:imagen,:categoria)";
      $consulta = $this->DBConexion->prepare($query);
      $consulta->bindParam(':nombre',$nombre);
      $consulta->bindParam(':descripcion', $descripcion);
      $consulta->bindParam(':precio',$precio);
      $consulta->bindParam(':imagen',$ruta);
      $consulta->bindParam(':categoria',$categoria);
      $consulta->execute();

      if($consulta){
        header("Location: ../productos/index.php?estatus=1");
      }
    }
  }

  ################################# EDITAR PRODUCTO ################################
  public function editarProducto(){
    $id = $_GET["id"];
    $query = "SELECT * FROM productos WHERE id=:id";
    $consulta = $this->DBConexion->prepare($query);
    $consulta->bindParam(':id',$id);
    $consulta->execute();
    $productos = $consulta->fetch(PDO::FETCH_OBJ);

    if($productos){
      ?>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value=" <?php echo $productos->id;?> ">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Producto</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value=" <?php echo $productos->nombre;?> ">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value=" <?php echo $productos->descripcion;?> ">
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" name="precio" id="precio" class="form-control" value=" <?php echo $productos->precio;?> ">
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Cambiar Categoria</label>
            <select class="form-select" name="categoria">
                <?php
                    $sentencia = $this->DBConexion->prepare("SELECT * FROM categorias");
                    $sentencia->execute();
                    $categorias = $sentencia->fetchAll(PDO::FETCH_OBJ);

                    foreach ($categorias as $categoria){
                        ?>  
                            <option value=" <?php echo $categoria->id?> "> <?php echo $categoria->nombre?> </option>
                        <?php
                    }
                ?>
            </select>
            
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control">
        </div>

        <div id="btn_add" class="mb-3 btn-group">
            <button id="actualizar" name="actualizar" type="submit" class="btn btn-success">Actualizar</button>
            <button name="eliminar" type="submit" class="btn btn-danger">Borrar</button>
            <a href="../productos/index.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>

        </form>
      <?php
    }
  }

  ################################# ACTUALIZAR PRODUCTO ################################
  public function actualizarProducto(){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    if(!empty($nombre) && !empty($descripcion) && !empty($precio)){
      $imagen = $_FILES['imagen']['name'];//Obtenemos el nombre
      $archivo = $_FILES['imagen']['tmp_name']; //optenemos el archivo
      $ruta = "../productos/imagenes"; //ruta de guardado del las imagenes

      $ruta = $ruta."/".$imagen; //../productos/imagenes/imagen.jpg
      move_uploaded_file($archivo,$ruta);//movemos el archivo

      $query = "UPDATE productos SET nombre=:nombre,
                                      descripcion=:descripcion,
                                      precio=:precio,
                                      imagen=:imagen,
                                      fk_Id_Categoria:categoria
                                      WHERE id=:id)";
      $consulta = $this->DBConexion->prepare($query);
      $consulta->bindParam(':id',$id);
      $consulta->bindParam(':nombre',$nombre);
      $consulta->bindParam(':descripcion', $descripcion);
      $consulta->bindParam(':precio',$precio);
      $consulta->bindParam(':imagen',$ruta);
      $consulta->bindParam(':categoria',$categoria);
      $consulta->execute();
    }
  }

  ################################# ELIMINAR PRODUCTO ################################
  public function eliminarProducto(){
    $id = $_POST["id"];

    $consulta = $this->DBConexion->prepare("SELECT * FROM productos WHERE id=:id");
    $consulta->bindParam(':id',$id);
    $consulta->execute();
    $producto = $consulta->fetch(PDO::FETCH_OBJ);

    if($producto->stock > 0){
      header("Location: ../productos/index.php?status=5");
    }else{
      $query = "DELETE FROM productos WHERE id=:id";
      $consulta = $this->DBConexion->prepare($query);
      $consulta->bindParam(':id',$id);
      $consulta->execute();

      if($consulta){
        header("Location: ../productos/index.php?estatus=4");
      }
    }
  }

  ################################# ACCIONES ADICIONALES ################################

  #BUSCAR CATEGORIA
  public function buscarCategorias(){
    $sentencia = $this->DBConexion->prepare("SELECT * FROM categorias");
    $sentencia->execute();
    $categorias = $sentencia->fetchAll(PDO::FETCH_OBJ);

    foreach ($categorias as $categoria){
        ?>  
            <option value=" <?php echo $categoria->id?> "> <?php echo $categoria->nombre?> </option>
        <?php
    }
  }

  #AGREGAR ARTICULOS AL STOCK
  public function agregarArticulos(){
    $id = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];

    if(!empty($id) && !empty($cantidad)){
      $query = "UPDATE productos SET stock = stock + :cantidad WHERE id = :id";
      $consulta = $this->DBConexion->prepare($query);
      $consulta->bindParam(':id',$id);
      $consulta->bindParam(':cantidad', $cantidad);
      $consulta->execute();
    }
  }

  #AGREGAR DETALLES A LAS TRANSACCIONES
  public function detalles(){
    session_start();
    $usuario = $_SESSION['nombre'];
    $descripcion = "Insertar producto";
    $nombre = $_POST['nombre'];

    $consultaProducto = $this->DBConexion->prepare("SELECT * FROM productos WHERE nombre=:nombre");
    $consultaProducto->bindParam(':nombre',$nombre);
    $consultaProducto->execute();
    $movimiento = array();
  
    while($row=$consultaProducto->fetch(PDO::FETCH_ASSOC)){
      $movimiento['Producto'][] = $row;	
    }

    $detalles = json_encode($movimiento);

    $query = "INSERT INTO transacciones (descripcion,detalles,usuario) VALUES (:descripcion,:detalles,:usuario)";
    $consultaDetalle = $this->DBConexion->prepare($query);
    $consultaDetalle->bindParam(':descripcion', $descripcion);
    $consultaDetalle->bindParam(':detalles', $detalles);
    $consultaDetalle->bindParam(':usuario', $usuario);
    $consultaDetalle->execute();
  }
}
 ?>
