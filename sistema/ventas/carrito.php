<?php
  include_once("../php/conexion.php");//CONEXION
  session_start();
  if (!empty($_SESSION['active'])) {
    
        #VALIDAR SESSION DEL CARRITO DE COMPRAS
        if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
        $total = 0;

        if (isset($_POST['generar'])) {
            $Venta->generarVenta();
        }else if(isset($_POST['guardar'])){
            
        }

?>
<!doctype html>
<html lang="en">
  <head>
    <!--Header-->
    <?php include_once("../partials/header.php"); ?>
  </head>
  <body>
    <!--Seccion del NAVBAR-->
    <section>
      <nav class="navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Punto de venta</a>

        <div class="container-fluid">
          <ul class="nav navbar-nav">

              <li class="nav-item active">
                  <a class="nav-link" href="../index.php">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="../categorias/index.php">Categorias</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="../productos/index.php">Productos</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="../transacciones/index.php">transacciones</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="../ventas/index.php">Ventas</a>
              </li>

          </ul>

          <div class="d-flex">
              <ul class="navbar-nav">
                <li>
                  <a href="../ventas/carrito.php" class="btn btn-warning"> <i class="fas fa-shopping-cart"></i> </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                    <a href="../../auth/logout.php" class="nav-link">Cerrar Session</a>
                  </ul>
                </li>
              </ul>
          </div>

      </nav>
    </section>
    
    <section>
      <div class="container mt-4">
      <h1 class="display-2">Lista de compras</h1>
        <div class="row">
          <div class="col-sm-12 mt-4">
              <div class="card text-dark bg-light mb-3">
                  <div class="card-body">
                  <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach($_SESSION["carrito"] as $indice => $articulo){ 
                                $total += $articulo->total;
                            ?>
                            <tr>
                                <td> <img src="../<?php echo $articulo->imagen ?>" alt="<?php echo $articulo->nombre ?>" width="100">  </td>
                                <td><?php echo $articulo->nombre ?></td>
                                <td><?php echo $articulo->descripcion ?></td>
                                <td><?php echo $articulo->cantidad ?></td>
                                <td>$<?php echo $articulo->total ?></td>
                                <td>
                                    <a class="btn btn-danger" href="quitarDelCarrito.php?indice=<?php echo $articulo->id?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>   
                        </tbody>

                    </table>
                  </div>
              </div>


            <h3>Total: $<?php echo $total; ?></h3>

            <form action="" method="post">
                <input type="hidden" name="total" value="<?php echo $total ?>">

                <div class="btn-group">
                    <button class="btn btn-success" name="generar">Generar Compra</button>
                    <button class="btn btn-warning" name="guardar">Guardar lista</button>
                    <a class="btn btn-secondary" href="../index.php">Cancelar</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </section>

    <section>
        <?php include_once("../partials/footer.php"); ?>
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