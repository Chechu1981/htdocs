<?php
$nplacas = array(
  "PPCR BALEARES" => "027130L",
  "PPCR BARCELONA" => "027135M",
  "PPCR GRANADA" => "027120K",
  "PPCR MADRID" => "027015L",
  "PPCR PATERNA" => "027066M",
  "PPCR SEVILLA" => "027110G",
  "PPCR VIGO" => "027115E",
  "PPCR ZARAGOZA" => "027125R",
  "PPCR TODOS" => "all"
);

$placas = array(
  "Todos" => "TODAS",
  "027130L" => "PPCR BALEARES",
  "027135M" => "PPCR BARCELONA",
  "027120K" => "PPCR GRANADA",
  "027015L" => "PPCR MADRID",
  "027066M" => "PPCR PATERNA",
  "027110G" => "PPCR SEVILLA",
  "027115E" => "PPCR VIGO",
  "027125R" => "PPCR ZARAGOZA"
);

include_once '../connection/data.php';
$conexion = new Contacts();

$items = $conexion->getStatusInm($nplacas["PPCR ".strtoupper($_POST['placa'])]);

$html = '<ul class="heading listInm">
<li>placa</li>
<li>total</li>
<li>suben</li>
<li>bajan</li>
<li>fecha</li>
<li>total día</li>
</ul>';

$acumulado = 0;
$imprime = "";

for($i=0;$i < sizeof($items);$i++){
  $today = explode(' ',$items[$i][3])[0];
  if($i+1 >= sizeof($items))
    $tomorrow = "finished";
  else
    $tomorrow = explode(' ',$items[$i+1][3])[0];
  $acumulado += $items[$i][1] + $items[$i][2];
  if($tomorrow != $today){
    $imprime = $acumulado;
    $acumulado = 0;
  }
  
  $formatDate = explode('-',$today)[2]."-".explode('-',$today)[1]."-".explode('-',$today)[0]." ".@explode(' ',$items[$i][3])[1];
  $html .= "<ul class='listInm'>
      <li>".$placas[$items[$i][0]]."</li>
      <li>".$items[$i][1] + $items[$i][2]."</li>
      <li>".$items[$i][1]."</li>
      <li>".$items[$i][2]."</li>
      <li>".$formatDate."</li>
      <li>".$imprime."</li>
    </ul>";
  $imprime = "";
}

echo $html;
?>