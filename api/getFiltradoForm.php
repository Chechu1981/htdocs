<?php
include_once '../connection/data.php';
$consulta = new Contacts();
$palabrasClave = $consulta->getPalabrasClave();
?>
<form action="">
<?php  
for($i = 0; $i < 10; $i++) {
    echo $i + 1;
    list($palabra, $id) = array("","");
    if(isset($palabrasClave[$i][1])){
      $palabra = $palabrasClave[$i][1];
      $id = $palabrasClave[$i][0];
    }
    ?><input type="text" id="<?php echo $id; ?>" value="<?php echo $palabra; ?>"><?php
  }
?>
  <input type="submit" value="Guardar">
</form>