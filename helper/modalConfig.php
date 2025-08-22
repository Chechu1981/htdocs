<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$rows = $contacts->getUserBySessid($_COOKIE['id']);

$privilegio = $rows[0][7];
$opciones = '
<section id="config" class="btn-config">
    <div class="cards" title="colores" id="changeColor">Colores</div>
    <div class="cards" title="rutas" id="rutas">Rutas</div>
    <div class="cards" title="repere" id="update_repere">Añadir reperes</div>
    ';


if($privilegio >= 100){$opciones .= '<div class="cards" title="pending" id="pending">Actualizar pendientes</div>
    <div class="cards" title="clientes" id="clientes">Actualizar clientes~rutas</div>
    <div class="cards" title="tarifa" id="tarifa">Actualizar tarifa</div>
    <div class="cards" title="mails" id="mails">Editar correos de cesiones</div>
    <div class="cards" title="notas" id="notas">Editar notas</div>
    <div class="cards" title="alertas" id="alertas">Alertas</div>
    <div class="cards" title="proveedores" id="proveedores">Proveedores</div>
    <div class="cards" title="usuarios" id="usuarios">Usuarios</div>';}

$opciones .= '</section>';
echo $opciones;
?>
