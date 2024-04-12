<?php
  include_once '../connection/data.php';
  $conexion = new Contacts();
  $aceite = $conexion->getOil($_POST['grado'],$_POST['vol'],$_POST['marca']);
?>
<table class="table_oil">
  <tr>
    <th colspan="3">Producto</th>
    <th>ACEA</th>
    <th>API</th>
    <th>PSA</th>
    <th>FCA</th>
    <th>VW</th>
    <th>OPEL - GM</th>
    <th>RENAULT</th>
    <th>MERCEDES</th>
    <th>BMW</th>
    <th>VOLVO</th>
    <th>FORD</th>
    <th>PORSCHE</th>
    <th>ASIATICOS</th>
  </tr>
  <?php foreach ($aceite as $items){ ?>
    <tr>
      <td><?php echo $items[2];?></td>
      <td><?php echo $items[4]."L";?></td>
      <td class="ref" id="<?php echo $items[0]; ?>"><?php echo $items[6];?></td>
      <td><?php echo $items[7];?></td>
      <td><?php echo $items[8];?></td>
      <td><?php echo $items[9];?></td>
      <td><?php echo $items[10];?></td>
      <td><?php echo $items[11];?></td>
      <td><?php echo $items[12];?></td>
      <td><?php echo $items[13];?></td>
      <td><?php echo $items[14];?></td>
      <td><?php echo $items[15];?></td>
      <td><?php echo $items[16];?></td>
      <td><?php echo $items[17];?></td>
      <td><?php echo $items[18];?></td>
      <td><?php echo $items[19];?></td>
    </tr>
  <?php } ?>
</table>