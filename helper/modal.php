<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$rows = $contacts->getPassId($_GET['id']);
?>
<form action="" method="post" title="update">
    <label>TIPO</label>
    <select name="tipo" id="tipo">
        <option value="<?php echo $rows[0][10]; ?>" selected><?php echo strToUpper($rows[0][10]); ?></option>
        <option value="transporte">TRANSPORTE</option>
        <option value="neumaticos">NEUMÁTICOS</option>
        <option value="catalogo">CATÁLOGO</option>
        <option value="ppcr">PPCR</option>
        <option value="stellantis">STELLANTIS</option>
    </select>
    <label>Web</label><input type="text" id="web" placeholder="WEB" value="<?php echo $rows[0][9]; ?>">
    <label>Marca</label><input type="text" id="marca" placeholder="MARCA" value="<?php echo $rows[0][1]; ?>">
    <label>Placa</label><input type="text" id="placa" placeholder="PLACA" value="<?php echo $rows[0][2]; ?>">
    <label>Cuenta</label><input type="text" id="cuenta" placeholder="CUENTA" value="<?php echo $rows[0][3]; ?>">
    <label>Usuario</label><input type="text" id="usr" placeholder="USUARIO" value="<?php echo $rows[0][4]; ?>">
    <label>Contraseña</label><input type="text" id="pwd" placeholder="CONTRASEÑA" value="<?php echo $rows[0][5]; ?>">
    <label>Teléfono</label><input type="text" id="phone" placeholder="TELÉFONO" value="<?php echo $rows[0][8]; ?>">
    <input type="hidden" id="<?php echo $_GET['id']; ?>" value="<?php echo $_GET['id']; ?>">
    <label></label><input type="submit" value="Modificar">
</form>