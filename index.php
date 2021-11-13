<?php
include_once("./auth/login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
<title>Login</title>

<link rel="stylesheet" href="auth/style.css">

</head>
<body class="text-center">
<div class="login-form">

    <form  method="post" class="form-signin">
        <h2 class="text-center">Log in</h2>
        <div class="form-group">
          <label for="correo">Usuario</label>
          <input id="correo" type="email" name="correo" class="form-control">
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input id="password" type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
          <a href="">¿Olvisaste tu contraseña?</a>
        </div>
        <div class="card-actio mt-4">
          <input type="submit" name="Entrar" value="Entrar" class="btn btn-danger" style="width: 100%;">
        </div>
    </form>

</div>
</body>
</html>