
<?php
	if (isset($_POST['agregar'])) {
        $Categoria->crearCategoria();
    }
?>
<form method="post">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la Categoria</label>
        <input type="text" name="nombre" id="nombre" class="form-control">
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripcion</label>
        <input type="text" name="descripcion" id="descripcion" class="form-control">
    </div>
    <div class="mb-3">
        <label for="nombre" class="form-label">Etiqueta de Color</label>
        <select class="form-select" name="color">
            <option value="#2196f3" selected>Azul</option>
            <option value="#4caf50">Verde</option>
            <option value="#ffc107">Amarillo</option>
            <option value="#e91e63">Rosa</option>
            <option value="#f44336">Rojo</option>
            <option value="#9c27b0">Morado</option>
        </select>
    </div>
    <div class="mb-3 d-grid gap-2 ">
        <button name="agregar" type="submit" class="btn btn-success">Agregar</button>
    </div>
</form>
