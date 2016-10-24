<?php

class OfertasControl{
	
	private $oferta;
	private $usuario;
	private $errores = [];

	public function __construct(){
		
		//$this->oferta = new Oferta();
		//$this->usuario = new Usuario();
	}
	
	public function Inicio(){
		
		$this->Menu();			
	}
	
	public function Menu(){
		
		require "views/Menu.php";
	}
}
