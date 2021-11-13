<?php
include_once('php/conexion.php');

  session_start();
  if (!empty($_SESSION['active'])) {
    #VALIDAR SESSION DEL CARRITO DE COMPRAS
    if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
    $granTotal = 0;

    #AGREGAR PRODUCTO AL CARRITO
    if (isset($_POST['agregar'])) {
      $Venta->agregarProducto();      
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!--Header-->
    <?php include_once("./partials/header.php"); ?>
  </head>
  <body>
  <!--Seccion del NAVBAR-->
    <section>
      <nav class="navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Punto de venta</a>

        <div class="container-fluid">
          <ul class="nav navbar-nav">

              <li class="nav-item active">
                  <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="categorias/index.php">Categorias</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="productos/index.php">Productos</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="transacciones/index.php">transacciones</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="ventas/index.php">Ventas</a>
              </li>

          </ul>

          <div class="d-flex">
              <ul class="navbar-nav">
                <li>
                  <a href="ventas/carrito.php" class="btn btn-warning"> <i class="fas fa-shopping-cart"></i> </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                    <a href="../auth/logout.php" class="nav-link">Cerrar Session</a>
                  </ul>
                </li>
              </ul>
          </div>

      </nav>

      <?php $Venta->status(); ?>
    </section>

    <!--FILTRO-->
    <section>
      filtro
    </section>

    <!--ARTICULOS-->
    <section>
      <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php 
          #LISTA DE PRODUCTOS
            $productos = $Venta->mostrarArticulos();

            if($productos){
              foreach ($productos as $producto) {
                ?>
                <div class="col-sm-3">
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo $producto->imagen; ?>" class="card-img-top" alt="<?php echo $producto->nombre; ?>">
                        <div class="card-body">

                            <h5 class="card-title"><?php echo $producto->nombre; ?></h5>
                            <p class="card-text"><?php echo $producto->descripcion; ?></p>
                            
                            <form action="" method="post">
                              <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                              <label for="cantidad"> Cantidad: </label>
                              <input type="number" name="cantidad" class="form-control" min="1" value="1">
                              <button type="submit" class="btn btn-primary mt-4" name="agregar">Agregar al carrito</button>
                            </form>

                        </div>
                    </div>
                </div>
                
                <?php
              }
        
            }else{
            ?>
              <tr>
                <td>No hay Registros</td>
              </tr>
            <?php
            }
          ?>

    </section>
         
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>
<?php   
    }else{
        header('location:../index.php');
    }
?>