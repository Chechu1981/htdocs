<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$rows = $contacts->getRoutesName($_POST['ruta']);
foreach($rows as $row){ ?>
    <ul>
        <li><?php echo $row[1]; ?></li>
        <li><?php echo $row[2]; ?></li>
        <li><input type="text" value="<?php echo $row[3]; ?>"></input></li>
        <li><input type="text" value="<?php echo $row[4]; ?>"></input></li>
        <li id="<?php echo $row[0]; ?>"><img src="../img/save_FILL0_wght400_GRAD0_opsz24.png" title="GUARDAR <?php echo $row[2]; ?>" alt="Guardar"></li>
        <li id="<?php echo $row[0]; ?>"><img src="../img/delete_FILL0_wght400_GRAD0_opsz24.png" title="ELIMINAR <?php echo $row[2]; ?>" alt="Eliminar"></li>
    </ul>
<?php } ?>