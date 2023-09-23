<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$rows = $contacts->getAllCenter($_GET['id']);
?>
<form action="" method="post" title="update">
    <input type="hidden" id="centro" placeholder="Centro" value="<?php echo $rows[0][1]; ?>">
    <label>ENTIDAD</label><input type="text" id="entidad" placeholder="ENTIDAD" value="<?php echo $rows[0][2]; ?>">
    <label>EQUIPO</label><input type="text" id="placa" placeholder="EQUIPO" value="<?php echo $rows[0][3]; ?>">
    <label>NOMBRE</label><input type="text" id="cuenta" placeholder="NOMBRE" value="<?php echo $rows[0][4]; ?>">
    <label>PUESTO</label><input type="text" id="usr" placeholder="PUESTO" value="<?php echo $rows[0][5]; ?>">
    <label>EXT</label><input type="text" id="pwd" placeholder="EXT" value="<?php echo $rows[0][6]; ?>">
    <label>Nº LARGO</label><input type="text" id="phone" placeholder="Nº LARGO" value="<?php echo $rows[0][7]; ?>">
    <label>MÓVIL</label><input type="text" id="phone" placeholder="MÓVIL" value="<?php echo $rows[0][8]; ?>">
    <label>Nº CORTO</label><input type="text" id="phone" placeholder="Nº CORTO" value="<?php echo $rows[0][9]; ?>">
    <label>CORREO</label><input type="text" id="phone" placeholder="CORREO" value="<?php echo $rows[0][10]; ?>">
    <input type="hidden" id="<?php echo $_GET['id']; ?>" value="<?php echo $_GET['id']; ?>">
    <label></label><input type="submit" value="Modificar">
</form>