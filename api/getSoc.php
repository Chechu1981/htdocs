<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$rows = $contacts->getSoc($_POST['search'],0);
?>
<ul class="heading" style="top:133px">
  <li>Nº</li>
  <li>CUENTA</li>
  <li>NOMBRE</li>
  <li>CIF</li>
  <li>CP</li>
  <li>CIUDAD</li>
  <li>Nº PLACA</li>
  <li>PLACA</li>
  <li><div id='addSoc' class='btn-plus' title='Añadir SOC'>+</div></li>
</ul>
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
    <li id="<?php echo $row[0]; ?>">
      <img src="../img/save_FILL0_wght400_GRAD0_opsz24.png" title="GUARDAR <?php echo $row[2]; ?>" alt="Guardar">
      <img id="delete" alt="eliminar" src="../img/delete_FILL0_wght400_GRAD0_opsz24.png">
    </li>
  </ul>
<?php } ?>