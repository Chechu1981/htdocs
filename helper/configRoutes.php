<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$rows = $contacts->getRoutes();
?>
<div>
<?php
foreach($rows as $row){ ?>
    <ul>
        <li><?php echo $row[0]; ?></li>
        <li><?php echo $row[1]; ?></li>
        <li><input type="text" value="<?php echo $row[2]; ?>"></input></li>
        <li><input type="text" value="<?php echo $row[3]; ?>"></input></li>
    </ul>
<?php } ?>
</div>