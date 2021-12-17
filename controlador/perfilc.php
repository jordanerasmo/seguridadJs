<?php
include_once 'conexion.php';
include_once 'modelo/perfil.php';

class PerfilC
{
    public $operfil = null;
    public function __construct()
    {
        $operfil = new Perfil();
    }
    public function buscar($post)
    {
        $perfilid = $post['hperfil'];
        $mysqli   = Conexion::abrir();
        $perfil   = new Perfil();
        $sql      = "SELECT perfilid, descripcion, estado FROM perfil WHERE perfilid = ?";
        $stmt     = $mysqli->prepare($sql);
        $stmt->bind_param('i', $perfilid);
        $stmt->execute();
        $rs = $stmt->get_result();
        if ($rs->num_rows > 0) {
            while ($fila = $rs->fetch_array()) {
                $perfil->setPerfilId($fila[0]);
                $perfil->setDescripcion($fila[1]);
                $perfil->setEstado($fila[2]);
            }
        }
        $stmt->close();
        return $perfil;
    }
    public function listar()
    {
        $mysqli = Conexion::abrir();
        $arr    = array();
        $arr1   = array();
        $sql    = "SELECT perfilid, descripcion, estado FROM perfil";
        $stmt   = $mysqli->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        if ($rs->num_rows > 0) {
            while ($fila = $rs->fetch_array()) {
                $arr['perfilid']    = $fila[0];
                $arr['descripcion'] = $fila[1];
                $arr['estado']      = $fila[2];
                $arr1[]             = $arr;
            }
        }
        $stmt->close();
        return $arr1;
    }
    public function listarhtml()
    {
        $tabla  = '';
        $perfil = new Perfil();
        $mysqli = Conexion::abrir();
        $sql    = "SELECT perfilid, descripcion, estado FROM perfil WHERE estado = 0";
        $stmt   = $mysqli->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        if ($rs->num_rows > 0) {
            while ($fila = $rs->fetch_array()) {
                $perfil->setPerfilId($fila[0]);
                $perfil->setDescripcion($fila[1]);
                $perfil->setEstado($fila[2]);
                $tabla .= '<tr>';
                $tabla .= '<td>' . $perfil->getPerfilId() . '</td>';
                $tabla .= '<td>' . $perfil->getDescripcion() . '</td>';
                $tabla .= '<td>' . $perfil->getEstado() . '</td>';
                $tabla .= '<td><button type="submit" name="editar">Editar</button></td>';
                $tabla .= '<td><button type="submit" name="eliminar">Eliminar</button></td>';
                $tabla .= '<td><input type="hidden" name="hperfil" value="' . $perfil->getPerfilId() . '"></td>';
                $tabla .= '</tr>';
            }
            $arr = array('success' => true, 'lista' => $tabla);
        }
        $stmt->close();
        return $arr;
    }
    public function add($post)
    {
        $arr         = array('success' => false);
        $descripcion = $post['descripcion'];
        $perfil      = new Perfil();
        $perfil->setDescripcion($descripcion);
        $mysqli = Conexion::abrir();
        $mysqli->set_charset("utf8");
        $sql  = "INSERT INTO perfil (descripcion, estado) VALUES (?,?)";
        $stmt = $mysqli->prepare($sql);
        if ($stmt !== false) {
            $estado      = 0;
            $descripcion = $perfil->getDescripcion();
            $stmt->bind_param('si', $descripcion, $estado);
            $stmt->execute();
            $stmt->close();
            $arr = array('success' => true);
        }
        return $arr;
    }
    public function eliminar($post)
    {
        $perfilid = $post['hperfil'];
        $mysqli   = Conexion::abrir();
        $mysqli->set_charset("utf8");
        $sql  = "DELETE FROM perfil WHERE perfilid = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt !== false) {
            $estado = 0;
            $stmt->bind_param('i', $perfilid);
            $stmt->execute();
            $stmt->close();
        }
        return;
    }
    public function editar($post)
    {
        $perfilid    = $post['hperfil'];
        $descripcion = $post['descripcion'];
        $mysqli      = Conexion::abrir();
        $mysqli->set_charset("utf8");
        $sql  = "UPDATE perfil SET descripcion = ? WHERE perfilid = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt !== false) {
            $stmt->bind_param('si', $descripcion, $perfilid);
            $stmt->execute();
            $stmt->close();
        }
        return;
    }
    public function select()
    {

    }
}