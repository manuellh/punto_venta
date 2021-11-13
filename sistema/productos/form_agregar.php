<?php
include_once("../php/conexion.php");//CONEXION 
    if (isset($_POST['agregar'])) {
        $Productos->agregarArticulos();
    }

?>
<form method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="text" name="cantidad" id="cantidad" class="form-control">
    </div>

    <div class="mb-3">
        <label for="codigo" class="form-label">Codigo del Producto</label>
        <input type="text" name="codigo" id="codigo" class="form-control">
    </div>


    <div id="btn_add" class="mb-3 d-grid gap-2 ">
        <button name="agregar" type="submit" class="btn btn-success">Agregar</button>
    </div>

</form>
