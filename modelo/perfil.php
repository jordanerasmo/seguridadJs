<?php

class Perfil{
	private $perfilid;
	private $descripcion;
	private $estado;

	public function __construct(){
		$this->perfilid = 0;
		$this->descripcion = '';
		$this->estado = 0;
	}
	public function getPerfilId(){
		return $this->perfilid;
	}
	public function setPerfilId($perfilid){
		$this->perfilid = $perfilid;
	}
	public function getDescripcion(){
		return $this->descripcion;
	}
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function setEstado($estado){
		$this->estado = $estado;
	}
}
?>