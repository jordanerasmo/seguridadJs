<?php
$opcion = $_POST['param'];
switch ($opcion) {
    case 10000:
        agregarcliente();
        break;
    case 20000:
        include_once '../controlador/perfilc.php';
        $perfilc = new PerfilC();
        $retorno = $perfilc->listarhtml();
        break;
    case 20001:
        include_once '../controlador/perfilc.php';
        $perfilc = new PerfilC();
        $retorno = $perfilc->add($_POST);
        break;
}
echo json_encode($retorno);
