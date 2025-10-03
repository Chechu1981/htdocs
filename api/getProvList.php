<?php
include_once '../connection/data.php';

$contacts = new Contacts();
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$placa = $data['placa'] ?? '';
$rows = $contacts->getProvList($placa);

$charsetExtract = array("'");
$count = 1;

?>
<ul class="list prov_list header">
    <li></li>
    <li>NOMBRE</li>
    <li>MARCA</li>
    <li>TIPO</li>
    <li>DIRECCIÓN</li>
    <li>CORREO</li>
</ul>

<?php for ($i = 0;count($rows) > $i;$i++) { ?>
    <ul class="list prov_list">
        <li><?= $count++ ?></li>
        <li id="<?= $rows[$i][0] ?>"><?= strtoupper($rows[$i]['nombre']) ?></li>
        <li><?= strtoupper($rows[$i]['marca']) ?></li>
        <li><?= strtoupper($rows[$i]['tipo']) ?></li>
        <li><?= strtoupper($rows[$i]['tlf']) ?></li>
        <li><?= strtolower($rows[$i]['direccion']) ?></li>
        <li><?= strtolower($rows[$i]['mail']) ?></li>
        <li>
            <img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar">
            <img src="../img/edit_square_FILL0_wght400_GRAD0_opsz24.png" alt="editar">
        </li>
    </ul>
<?php } ?>