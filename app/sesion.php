<?php

class Sesion {

	public static function mostrarErrorSesion($error) {
		
		switch ($error) {
			case 0:
			default:
				return '<div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
                    			<div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                    			<div class="message">
                      				<button type="button" data-dismiss="alert" aria-label="Close" class="close">
                      					<span aria-hidden="true" class="mdi mdi-close"></span>
                      				</button>Usuario y contraseña no encontrados</div></div>';
				break;
			
			case 1:
				return '<div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
                    			<div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                    			<div class="message">
                      				<button type="button" data-dismiss="alert" aria-label="Close" class="close">
                      					<span aria-hidden="true" class="mdi mdi-close"></span>
                      				</button>No se han ingresado datos</div></div>';
			break;

      case 2:
        return '<div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
                          <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                          <div class="message">
                              <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                                <span aria-hidden="true" class="mdi mdi-close"></span>
                              </button>Contraseña inválida para el usuario</div></div>';
      break;
		}
	}

}

/*

<div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
                    <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                    <div class="message">
                      <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button><strong>Warning!</strong> Better check yourself, you're not looking too good.
                    </div>
                  </div>

*/