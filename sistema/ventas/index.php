<?php
  include_once('../php/conexion.php');

  session_start();
  if (!empty($_SESSION['active'])) {
      
      #VALIDAR SESSION DEL CARRITO DE COMPRAS
      if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
      $granTotal = 0;
      
?>

<!doctype html>
<html lang="en">
  <head>
    <!--Header-->
    <?php include_once("../partials/header.php"); ?>
  </head>
  <body>
  <!--Seccion del NAVBAR-->
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
      <?php $Venta->status(); ?>
    </section>

    <section>
      <div class="container mt-4">
        <div class="row">
          <div class="col-sm-12 mt-4">
          <table class="line_table">
            <thead class="grey darken-4 white-text">
              <tr>
                <th>Numero de Compra</th>
                <th>Fecha de Compra</th>
                <th>Productos Comprados</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php include_once("tabla.php"); ?>
            </tbody>
          </table>
            
          </div>
        </div>
      </div>
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