<?php
class sesion {
	 private $appid;

	 function __construct() {
		 session_start ();
	 	 $this->appid = 'PHP_Tamboapp_app_10209ISMLMONGUGC1988';
	  }
	  public function set($nombre, $valor) {
		 $_SESSION [$this->appid.$nombre] = $valor;
	  }
	  public function get($nombre) {
		 if (isset ( $_SESSION [$this->appid.$nombre] )) {
			return $_SESSION [$this->appid.$nombre];
		 } else {
			 return false;
		 }
	  }
	  public function elimina_variable($nombre) {
		  unset ( $_SESSION [$this->appid.$nombre] );
	  }
	  public function termina_sesion() {
		  $_SESSION = array();
		  session_destroy ();
	  }
}
?>