<?php include_once "header.php"; ?>

<div class="main-content container-fluid">
  <div class="panel">
    <div class="panel-heading">
      <h3>Ayuda y documentación</h3>
    </div>
    <div class="panel-body">
      <h4 class="text-center">Para conocer más a fondo el uso de esta aplicación puede consultar los manuales de usaurio</h4>
      <div class="row">
        <!--<div class="col-md-8 col-md-offset-2 text-center">
          <iframe src="diagramas/Manual de Usuario.pdf" width="100%" height="48px" frameborder="0"></iframe>
        </div>-->
        
          <div class="col-md-12 text-center">
            <h4>Manuales diponibles</h4>
            <a href="diagramas/Proyecto A manual de usuario.pdf" target="_blank" class="btn btn-primary btn-lg">Manual de usuario</a>
              <?php if( Escuela::esAdminstrador($_SESSION['perfiles']) ): ?>
                  <a href="diagramas/Proyecto A manual del sistema.pdf" target="_blank" class="btn btn-primary btn-lg">Manual de sistema</a>
              <?php endif; ?>

          </div>
        
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-border-color panel-border-color-primary">
    <div class="panel-heading">
      <h3>Acerca de:</h3>
      <p><b>Proyecto A+</b> es un software creado con el fin de permitir elaborar los horarios de clases de una manera rápida y sencilla.</p>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-6 bigger-text">
          <h3 class="no-margin-top">Deasrrollado por:</h3>
          <ul>
            <li>Jaime Villegas</li>
            <li>José Alarcón</li>
          </ul>
        </div>
        <div class="col-md-6 bigger-text">
          <p><b>Nombre: </b>Proyecto A+</p>
          <p><strong>Versión: 0.8</strong></p>
        </div>
      </div>

    </div>
  </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-border-color panel-border-color-success">
    <div class="panel-heading">
      <h3>Contacto</h3>
    </div>
    <div class="panel-body">
      <h3>Para solicitar más información o quejas puede contactar a:</h3>
      <ul class="bigger-text">
        <li>Vía email: <a href="mailto:samuelvillegas04@gmail.com">samuelvillegas04@gmail.com</a></li>
        <li>Vía llamada: <a href="tel:04141653364">+58 0414 165 3364</a></li>
      </ul>
      <small>Horario de atención de 12:00 pm a 5:00 pm</small>
    </div>
  </div>
    </div>
  </div>
  
  
</div>

<?php include_once "scripts.php";
include_once "footer.php"; ?>