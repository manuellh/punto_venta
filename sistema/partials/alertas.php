<?php
    if(isset($_GET["status"])){
      if($_GET["status"] === "1"){
        ?>
            <div class="alert alert-success" role="alert">
                Correcto
            </div>
        <?php
      }else if($_GET["status"] === "2"){
        ?>
            <div class="alert alert-danger" role="alert">
                Ocurrio un error
            </div>
        <?php
      }else if($_GET["status"] === "3"){
        ?>
            <div class="alert alert-success" role="alert">
                Registro actualizado
            </div>
        <?php
      } else if($_GET["status"] === "4"){
        ?>
            <div class="alert alert-success" role="alert">
                Registro Eliminado
            </div>
        <?php
      }else if($_GET["status"] === "5"){
        ?>
            <div class="alert alert-danger" role="alert">
                No se puede eliminar el producto porque tiene existencias dentro del stock
            </div>
        <?php
      }else if($_GET["status"] === "6"){
        ?>
            <div class="alert alert-danger" role="alert">
                La cantidad no es valida
            </div>
            
        <?php
      }else if($_GET["status"] === "7"){
        ?>
            <div class="alert alert-danger" role="alert">
                Este producto no existe en la tienda
            </div>
            
        <?php
      }else if($_GET["status"] === "8"){
        ?>
            <div class="alert alert-warning" role="alert">
                Por el momento no contamos con exixtencia de este articulo
            </div>
            
        <?php
      }else if($_GET["status"] === "9"){
        ?>
            <div class="alert alert-success" role="alert">
                Compra realizada correctamente
            </div>
            
        <?php
      }else if($_GET["status"] === "10"){
        ?>
            <div class="alert alert-danger" role="alert">
                La cantidad excede a la existente en stock
            </div>
            
        <?php
      }else if($_GET["status"] === "11"){
        ?>
            <div class="alert alert-success" role="alert">
                Producto agregado al carrito
            </div>
            
        <?php
      }
    }
