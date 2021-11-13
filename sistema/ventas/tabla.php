<?php 
include_once('../php/conexion.php');
    $ventas = $Venta->ventasRealizadas();
                  
                    foreach($ventas as $venta){?>
                      <tr>
                        <td><?php echo $venta->id; ?></td>
                        <td><?php echo $venta->fecha; ?></td>
                        <td><?php echo $venta->moneda; ?></td>
                        <td><?php echo $venta->costoMoneda; ?></td>
                        <td>
                          <table>
                            <thead class="grey lighten-3">
                              <th>Codigo</th>
                              <th>Producto</th>
                              <th>Cantidad</th>
                              <th># cliente</th>
                              <th>cliente</th>
                            </thead>
                            <tbody>
                              <?php
                                foreach (explode("__", $venta->productos) as $productosConcatenados){
                                $producto = explode("..", $productosConcatenados)
                              ?>
                                <tr>
                                  <td><?php echo $producto[0] ?></td>
                                  <td><?php echo $producto[1] ?></td>
                                  <td><?php echo $producto[2] ?></td>
                                  <td><?php echo $producto[3] ?></td>
                                  <td><?php echo $producto[4] ?></td>
                                </tr>
                                <?php } ?>
              
                            </tbody>
                          </table>
                        </td>
                        <td>$<?php echo $venta->total .' '; echo $venta->moneda;?></td>
                        <td><a href="<?php echo "../ventas/eliminarVenta.php?id=".$venta->id?>" class="btn red"><i class="material-icons">delete</i></a></td>
                      </tr>
                      <?php
                    }
            ?>