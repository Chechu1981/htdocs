<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include_once('../helper/head.php'); ?>
</head>
<body>
    <div id="menu">
        <?php include_once '../helper/menu.php'; ?>
    </div>
    <div class="search-table">
        <div id="contacts">
            <h1>Configuración - SOC</h1>
        </div>
        <?php
        include_once '../connection/data.php';
        $contacts = new Contacts();
        $rows = $contacts->getSoc();
        ?>
        <div class="config-routes">
        <?php
        foreach($rows as $row){ ?>
            <ul>
                <li><input type="text" value="<?php echo $row[1]; ?>"></input></li>
                <li><input type="text" value="<?php echo $row[2]; ?>"></input></li>
                <li><input type="text" value="<?php echo $row[3]; ?>"></input></li>
                <li><input type="text" value="<?php echo $row[4]; ?>"></input></li>
                <li><input type="text" value="<?php echo $row[5]; ?>"></input></li>
                <li><input type="text" value="<?php echo $row[6]; ?>"></input></li>
                <li><input type="text" value="<?php echo $row[7]; ?>"></input></li>
                <li><input type="text" value="<?php echo $row[8]; ?>"></input></li>
                <li id="<?php echo $row[0]; ?>"><img src="../img/save_FILL0_wght400_GRAD0_opsz24.png" title="GUARDAR <?php echo $row[2]; ?>" alt="Guardar"></li>
            </ul>
        <?php } ?>
        </div>
    </div>
    <?php include('../helper/footer.php'); ?>
</body>
</html>