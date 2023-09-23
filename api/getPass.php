<?php
include_once '../connection/data.php';
$list = "";
$contacts = new Contacts();
$search = str_replace("'","",$_POST['search']);
$tipo = str_replace("'","",$_POST['tipo']);
$usuario = str_replace("'","",$_POST['usuario']);

$rows = $contacts->getPassHTML($search, $tipo);
$lists = '<h1>No se han encontrado coincidencias</h1>';
if(sizeof($rows) > 0){
    $lists = '<ul class="heading" style="text-align: center;display:grid;grid-template-columns: 21% 7% 11% 21% 10% 10% 9% 7% 2%;list-style:none">
    <li>Aplicación</li>
    <li>Placa</li>
    <li>Cuenta</li>
    <li>Usuario</li>
    <li>Password</li>
    <li>Teléfono</li>
    <li></li>
    <li></li>
    <li><div id="addPass" class="btn-plus" title="Añadir registro">+</div></li>
  </ul>'; 
    foreach ($rows as $row) { 
        $lists .= '
        <ul>
            <li><a href="'. $row[9].'" target="_blank">'.strtoupper($row[1]).'</a></li>
            <li>'.$row[2].'</li>
            <li class="copy" title="copiar">'.$row[3].'</li>
            <li class="copy" title="copiar">'.$row[4].'</li>
            <li class="copy" title="copiar">'.$row[5].'</li>
            <li class="copy" title="copiar">'.$row[8].'</li>
            <li class="copy" title="copiar">'.$row[7].'</li>
            <li class="copy" title="copiar">'.$row[6].'</li>
            <li class="delete">
            <span title="eliminar registro '.$row[1].'" id="'.$row[0].'">
                <img id="delete" alt="eliminar" src="../img/delete_FILL0_wght400_GRAD0_opsz24.png">
            </span>
            <span title="Editar registro '.$row[1].'" id="'.$row[0].'">
            <img id="edit" alt="editar" src="../img/edit_square_FILL0_wght400_GRAD0_opsz24.png">
            </span>
            </li>
        </ul>';
    }
}

echo $lists;