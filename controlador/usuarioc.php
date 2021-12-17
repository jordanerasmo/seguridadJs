<?php
include_once('conexion.php');
include_once('modelo/usuario.php');
include_once('controlador/perfilc.php');

class UsuarioC{
	var $operfil = null;
	public function __construct(){
		$driver = new mysqli_driver();
    	$driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
	}
	public function buscar($post){
		$usuarioid = $post['husuario'];
		$mysqli = Conexion::abrir();
		$usuario = new Usuario();
		$sql = "SELECT `apellido`, `nombre`, `usuario`, `clave`, `perfilid`, `estado`  FROM `usuario` WHERE = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i',$usuarioid);
		$stmt->execute();
		$rs = $stmt->get_result();
		if($rs->num_rows>0){
			while($fila=$rs->fetch_array()){
				$usuario->setApellido($fila[0]);
				$usuario->setNombre($fila[1]);
				$usuario->setUsuario($fila[2]);
				$usuario->setClave($fila[3]);
			}
		}
		$stmt->close();
		return $usuario;
	}
	public function listar(){
		$mysqli = Conexion::abrir();
		$arr = array();
		$arr1 = array();
		$sql = "SELECT perfilid, descripcion, estado FROM perfil";
		$stmt = $mysqli->prepare($sql);
		$stmt->execute();
		$rs = $stmt->get_result();
		if($rs->num_rows>0){
			while($fila=$rs->fetch_array()){
				$arr['perfilid'] = $fila[0];
				$arr['descripcion'] = $fila[1];
				$arr['estado'] = $fila[2];
				$arr1[] = $arr;
			}
		}
		$stmt->close();
		return $arr1;
	}
	public function listarhtml(){
		$tabla = '';
		$usuario = new Usuario();
		$mysqli = Conexion::abrir();
		$sql = "SELECT `usuarioid`, `apellido`, `nombre`, `usuario`, `clave`, `perfilid`, `estado`  FROM `usuario` WHERE estado = 0";
		$stmt = $mysqli->prepare($sql);
		$stmt->execute();
		$rs = $stmt->get_result();
		if($rs->num_rows>0){
			while($fila=$rs->fetch_array()){
				$usuario->setUsuarioId($fila[0]);
				$usuario->setApellido($fila[1]);
				$usuario->setNombre($fila[2]);
				$usuario->setUsuario($fila[3]);
				$usuario->setClave($fila[4]);



				$usuario->perfil->buscar($fila[5]);
				$usuario->setEstado($fila[6]);
				$tabla .= '<tr>';
				$tabla .= '<form method="post">';
				$tabla .= '<td>'.$usuario->getUsuarioId().'</td>';
				$tabla .= '<td>'.$usuario->getApellido().'</td>';
				$tabla .= '<td>'.$usuario->getNombre().'</td>';
				$tabla .= '<td>'.$usuario->getUsuario().'</td>';
				$tabla .= '<td>'.$usuario->getClave().'</td>';
				$tabla .= '<td>'.$usuario->getPerfil()->getDescripcion().'</td>';
				$tabla .= '<td>'.$usuario->getEstado().'</td>';
				$tabla .= '<td><button type="submit" name="editar">Editar</button></td>';
				$tabla .= '<td><button type="submit" name="eliminar">Eliminar</button></td>';
				$tabla .= '<td><input type="hidden" name="hperfil" value="'.$usuario->getUsuarioId().'"></td>';
				$tabla .= '</form>';
				$tabla .= '</tr>';
			}
		}
		$stmt->close();		
		return $tabla;
	}
	public function add($post){
		$descripcion = $post['descripcion'];
		$operfil->setDescripcion($descripcion);		
		$mysqli = Conexion::abrir();
		$mysqli->set_charset("utf8");
		$sql = "INSERT INTO perfil (descripcion, estado) VALUES (?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt!== FALSE){			
			$estado = 0;		
			$stmt->bind_param('si',$operfil->getDescripcion(),$estado);
			$stmt->execute();
			$stmt->close();
			$arr = array('success'=>true);
		}
		return $arr;
	}
	public function eliminar($post){
		$perfilid = $post['hperfil'];
		$mysqli = Conexion::abrir();
		$mysqli->set_charset("utf8");
		$sql = "DELETE FROM perfil WHERE perfilid = ?";
		$stmt = $mysqli->prepare($sql);
		if($stmt!== FALSE){
			$estado = 0;		
			$stmt->bind_param('i',$perfilid);
			$stmt->execute();
			$stmt->close();			
		}
		return;
	}
	public function editar($post){
		$perfilid = $post['hperfil'];
		$descripcion = $post['descripcion'];
		$mysqli = Conexion::abrir();
		$mysqli->set_charset("utf8");
		$sql = "UPDATE perfil SET descripcion = ? WHERE perfilid = ?";
		$stmt = $mysqli->prepare($sql);
		if($stmt!== FALSE){						
			$stmt->bind_param('si',$descripcion,$perfilid);
			$stmt->execute();
			$stmt->close();
		}
		return;
	}
	public function select(){
		$ret = '';
		$mysqli = Conexion::abrir();
		$sql = "SELECT perfilid, descripcion FROM perfil WHERE estado = 0";
		$stmt = $mysqli->prepare($sql);
		if($stmt!==FALSE){
			$stmt->execute();
			$rs = $stmt->get_result();
			while($fila=$rs->fetch_array()){
				$ret .= '<option value="'.$fila[0].'">'.$fila[1].'</option>';
			}
		}
		return $ret;
	}
	public function validar($post){
		try{
			$error = false;
			$us = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if($us===FALSE || is_null($us)) $error = true;
			$clave = $post['clave'];
			if(!$error){		
				$mysqli = Conexion::abrir();
				$sql = "SELECT usuario, nombre, apellido FROM usuario ";
				$sql .= "WHERE usuario = ? and clave = ?";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ss',$us,$clave);
				$stmt->execute();
				$rs = $stmt->get_result();
				if($rs->num_rows>0){
					while($fila=$rs->fetch_array()){
						$usuario = new Usuario();
						$usuario->setUsuario($fila[0]);
						$usuario->setNombre($fila[1]);
						$usuario->setApellido($fila[2]);
					}
				}else{
					$usuario = false;
				}
				//$stmt->close();
			}else{
				$usuario = $error;
			}

		}catch(Exception $e){
			$usuario =  $e->getMessage();
		}
		finally{
			if(isset($stmt))
				$stmt->close();
		}

		return $usuario;
	}
}
?>