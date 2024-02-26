<style>
  body{
    font-family: 'Arial';
  }

  .list{
    list-style: none;
    display: grid;
    grid-template-columns: 8% 8% 7% 11% 9% 9% 5% 6% 7% 14% 5% 4% 4%;
    align-items: center;
    justify-items: center;
    font-size: smaller;
    margin: 0;
    padding: 2px 0;
  }

  ul:nth-child(even){
    background-color:teal;
    color: white;
  }
  
  ul:nth-child(odd){
    background-color:#9b9bbd;
  }
  
  .header{
    background-color:grey !important;
  }

  ul:hover{
    background-color: #2a2abd;
    color: white;
  }

  .listDown{
    
  }
</style>
<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$getPlacaName = array(
  "027130L" => "PPCR BALEARES",
  "027135M" => "PPCR BARCELONA",
  "027120K" => "PPCR GRANADA",
  "027015L" => "PPCR MADRID",
  "027066M" => "PPCR PATERNA",
  "027110G" => "PPCR SEVILLA",
  "027115E" => "PPCR VIGO",
  "027125R" => "PPCR ZARAGOZA"
);

$htmlList = '<ul class="list header">
<li>f.bajada</li>
<li>fecha</li>
<li>cuenta</li>
<li>Cliente</li>
<li>referencia</li>
<li>designacion</li>
<li>fiabilidad</li>
<li>placa</li>
<li>aviso</li>
<li>vin</li>
<li>pedido DMS</li>
<li>antes</li>
<li>ahora</li>
</ul>';

$rows = $contacts->getRefDownByRef($_GET['ref'], $_GET['cliente']);
if(count($rows) > 0){
  foreach ($rows as $row) {
        $htmlList .= '<ul class="list">';
        $htmlList .= '<li>'.$row[1] .'</li>';
        $htmlList .= '<li>'.$row[2] .'</li>';
        $htmlList .= '<li>'.$row[3] .'</li>';
        $htmlList .= '<li>'.$row[4] .'</li>';
        $htmlList .= '<li>'.$row[5] .'</li>';
        $htmlList .= '<li>'.$row[6] .'</li>';
        $htmlList .= '<li>'.$row[7] .'</li>';
        $htmlList .= '<li>'.$getPlacaName[$row[8]] .'</li>';
        $htmlList .= '<li>'.$row[9] .'</li>';
        $htmlList .= '<li>'.$row[10] .'</li>';
        $htmlList .= '<li>'.$row[12] .'</li>';
        $htmlList .= '<li>'.$row[15] .'</li>';
        $htmlList .= '<li>'.$row[13] .'</li>';
        $htmlList .= '</ul>';
    }
}else{
    $htmlList .= "No hay trazas";
}

echo $htmlList;