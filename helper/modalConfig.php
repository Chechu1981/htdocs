<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$rows = $contacts->getUserBySessid($_COOKIE['id']);

$privilegio = $rows[0][7];
$opciones = '
<section id="config">
    <div class="cards" title="notas">Editar notas</div>
    <div class="cards" title="mails">Editar correos de cesiones</div>
    <div class="cards" title="colores">Colores</div>
    <div class="cards" title="rutas">Rutas</div>
    <div class="cards" title="repere">Añadir reperes</div>
    <div class="cards" title="tarifa">Actualizar tarifa</div>
    <!-- <div class="cards" title="soc">Servicios Oficiales</div> -->
    <div class="cards" title="pending">Actualizar pendientes</div>
    <div class="cards" title="clientes">Actualizar clientes~rutas</div>;
    <div class="cards" title="alertas">Alertas</div>
    <div class="cards" title="proveedores">Proveedores</div>';


if($privilegio >= 100){$opciones .= '<div class="cards" title="usuarios">Usuarios</div>';}

$opciones .= '</section>';
echo $opciones;
?>
