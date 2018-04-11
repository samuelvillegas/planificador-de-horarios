<?php
include_once 'app/conexion.php';
include_once 'control_salir.php'; 
include_once 'app/usuarios.php';
include_once 'app/escuela.php';
Conexion::abrirConexion(); 
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/logo-fav.png">
  <?php
  if(isset($page_title)){
    echo "<title>$page_title</title>";
  }else{
    echo "<title>Constructor de horarios</title>";
  }
  ?>

  <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css"/>
  <link rel="stylesheet" type="text/css" href="assets/lib/jqvmap/jqvmap.min.css"/>
  <!-- forms -->
  <link rel="stylesheet" type="text/css" href="assets/lib/select2/css/select2.min.css"/>
  <link rel="stylesheet" type="text/css" href="assets/lib/bootstrap-slider/css/bootstrap-slider.css"/>

  <link rel="stylesheet" type="text/css" href="assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css"/>
  <link rel="stylesheet" href="assets/lib/alertifyjs/css/alertify.css">
  <link rel="stylesheet" href="assets/lib/alertifyjs/css/themes/default.css">
    <link rel="stylesheet" type="text/css" href="assets/lib/jquery.gritter/css/jquery.gritter.css"/>
  <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="js/node_modules/print-js/dist/print.min.css">
</head>
<body>
  <div class="be-wrapper be-fixed-sidebar">
    <nav class="navbar navbar-default navbar-fixed-top be-top-header">
      <div class="container-fluid">
        <div class="navbar-header"><a href="index.php" class="navbar-brand" style="background-image: url(img/logo-tiny.png);"></a></div>
        <div class="be-right-navbar">
          <ul class="nav navbar-nav navbar-right be-user-nav">
            <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" 
              class="dropdown-toggle">
              <img src="<?php echo Usuarios::obtenerImagen(Conexion::obtenerConexion(), $_SESSION['id_datos'] ); ?>" alt="Avatar"><span class="user-name"><?php echo $_SESSION['user']; ?></span></a>
              <ul role="menu" class="dropdown-menu">
                <li>
                  <div class="user-info">
                    <div class="user-name">
                      <?php 
                      echo $_SESSION['user']; echo " - ";Usuarios::mostrarPerfil($_SESSION['perfiles']);

                      ?>  
                    </div>
                  </div>
                </li>
                <li><a href="index.php"><span class="icon mdi mdi-face"></span>Inicio</a></li>
                <li><a href="configuracion-general.php"><span class="icon mdi mdi-settings"></span> Configuración general</a></li>
                <li><a href="salir.php"><span class="icon mdi mdi-power"></span> Cerrar sesión</a></li>
              </ul>
            </li>
          </ul>
          <div class="page-title">
            <span>
              <?php
              echo Usuarios::obtenerNombre(Conexion::obtenerConexion(), $_SESSION['id_datos'] );
              ?> - 
              <?php 
                Usuarios::mostrarPerfil($_SESSION['perfiles']);
                ?>
              </span>
          </div>
        </div>
      </div>
    </nav>
    <div class="be-left-sidebar">
      <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Inicio</a>
        <div class="left-sidebar-spacer">
          <div class="left-sidebar-scroll">
            <div class="left-sidebar-content">
              <ul class="sidebar-elements" id="nav">
                <li class="divider">Menú</li>
                <li><a href="index.php"><i class="icon mdi mdi-home"></i><span>Inicio</span></a></li>
                <li class="parent"><a href="#"><i class="icon mdi mdi-tab-unselected"></i><span>Horarios</span></a>
                  <ul class="sub-menu">
                      <li><a href="horarios-lista.php">Ver lista</a></li>
                      <?php if( Escuela::esAdminstrador($_SESSION['perfiles'])  ){
                            echo ' <li><a href="horarios-construir.php">Construir</a></li>';
                      } ?>


                  </ul>
                </li>
                <?php if( Escuela::esAdminstrador($_SESSION['perfiles']) ): ?>
              <li class="parent"><a href="#"><i class="icon mdi mdi-book"></i><span>Materias</span></a>
                <ul class="sub-menu">
                 <li><a href="materias-ver.php">Ver lista</a></li>
                    <?php if( Escuela::esAdminstrador($_SESSION['perfiles']) ){
                        echo '<li><a href="materias-registrar.php">Registrar</a></li>';
                    } ?>

               </ul>
             </li>
                  
                      <li class="parent"><a href="#"><i class="icon mdi mdi-face"></i><span>Usuarios</span></a>
                          <ul class="sub-menu">
                              <li><a href="usuarios-lista.php">Ver lista</a></li>
                              <li><a href="usuarios-registrar.php">Registrar</a></li>
                          </ul>
                      </li>
                      <li><a href="aulas-lista.php"><i class="icon mdi mdi-ungroup"></i><span>Aulas</span></a></li>
                  <?php endif; ?>
              <!--<li><a href="departamentos-perfiles.php"><i class="icon mdi mdi-flip-to-front"></i><span>Departamentos y perfiles</span></a>
              </li>-->
              <li class="parent"><a href="#"><i class="icon mdi mdi-border-all"></i><span>General</span></a>
                <ul class="sub-menu">
                    <?php if( Escuela::esAdminstrador($_SESSION['perfiles']) ): ?>
                        <li><a href="configuracion-general.php">Ajustes de la escuela</a></li>
                    <?php endif; ?>

                  <li><a href="ayuda.php">Ayuda y documentación</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="be-content">