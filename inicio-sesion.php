<?php 
  include_once "app/conexion.php";
  include_once 'app/sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/logo-fav.png">
    <title>Inicio de sesión - Proyecto A+</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="splash-container">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading"><img src="img/logo-xx-a.png" alt="logo" width="200px" class="logo-img"><span class="splash-description">Por favor ingrese sus datos</span></div>
              <div class="panel-body">
                <form action="control.php" method="post">
                  <div class="form-group">
                    <input id="user" type="text" placeholder="Nombre de usuario" name="user" class="form-control">
                  </div>
                  <div class="form-group">
                    <input id="pass" type="password" placeholder="Clave" name="pass" class="form-control">
                  </div>
                  <?php if(isset($_REQUEST['error'])) { echo Sesion::mostrarErrorSesion($_REQUEST['error']); } ?>
                    <input type="hidden" name="self" value="<?php echo $_SERVER['PHP_SELF'];?>">
                  <div class="form-group login-submit">
                    <button type="submit" class="btn btn-primary btn-xl">Ingresar</button>
                  </div>
                  <!--<div class="col-xs-6 login-forgot-password"><a href="#">¿Olvidó su contraseña?</a></div>-->
                </form>
              </div>
            </div>
          </div>
        </div>
<?php include_once "scripts.php";
include_once "footer.php"; ?>