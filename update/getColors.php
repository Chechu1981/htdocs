<?php
$data = file_get_contents("../json/correos.json");
$products = json_decode($data, true);
?>
<div style="display: grid;grid-template-columns: 50% 50%;">
  <div title="color" class="cards" style="background-color: blue">Azul</div>
  <div title="color" class="cards" style="background-color: green">Verde</div>
  <div title="color" class="cards" style="background-color: red">Rojo</div>
  <div title="color" class="cards" style="background-color: black">Negro</div>
</div>