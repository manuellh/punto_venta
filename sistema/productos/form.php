<?php
    if (isset($_POST['agregar'])) {
        $Productos->crearProducto();
        $Productos->detalles();
    }

?>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la Producto</label>
        <input type="text" name="nombre" id="nombre" class="form-control">
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripcion</label>
        <input type="text" name="descripcion" id="descripcion" class="form-control">
    </div>

    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="text" name="precio" id="precio" class="form-control">
    </div>

    <div class="mb-3">
        <label for="nombre" class="form-label">Asignar a Categoria</label>
        <select class="form-select" name="categoria">
            <?php $Productos->buscarCategorias(); ?>   
        </select>
         
    </div>

    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen</label>
        <input type="file" name="imagen" id="imagen" class="form-control">
    </div>

    <div id="btn_add" class="mb-3 d-grid gap-2 ">
        <button name="agregar" type="submit" class="btn btn-success">Agregar</button>
    </div>

</form>
