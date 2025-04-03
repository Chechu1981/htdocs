<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$rows = $contacts->getUserList();

$charsetExtract = array("'");
$count = 1;

?>
<ul class="user_list header">
    <li></li>
    <li>USUARIO</li>
    <li>PUESTO</li>
    <li>CORREO</li>
    <li>PRIVILEGIO</li>
    <li>FECHA</li>
    <li></li>
</ul>

<?php for ($i = 0;count($rows) > $i;$i++) { ?>
    <ul class="user_list">
        <li><?= $count++ ?></li>
        <li id="<?= $rows[$i][0] ?>"><?= strtoupper($rows[$i]['nombre']) ?></li>
        <li><?= strtoupper($rows[$i]['puesto']) ?></li>
        <li><?= strtolower($rows[$i]['mail']) ?></li>
        <li><?= strtolower($rows[$i]['privilegio']) ?></li>
        <li><?= $rows[$i]['date'] ?></li>
        <li>
            <img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar">
            <img src="../img/edit_square_FILL0_wght400_GRAD0_opsz24.png" alt="editar">
        </li>
    </ul>
<?php } ?>