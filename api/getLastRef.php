<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$placas = array(
    "027130L" => ["PPCR BALEARES",'../json/027130Llast.json',"027130L"],
    "027135M" => ["PPCR BARCELONA",'../json/027135Mlast.json',"027135M"],
    "027120K" => ["PPCR GRANADA",'../json/027120Klast.json',"027120K"],
    "027015L" => ["PPCR MADRID",'../json/027015Llast.json',"027015L"],
    "027066M" => ["PPCR PATERNA",'../json/027066Mlast.json',"027066M"],
    "027110G" => ["PPCR SEVILLA",'../json/027110Glast.json',"027110G"],
    "027115E" => ["PPCR VIGO",'../json/027115Elast.json',"027115E"],
    "027125R" => ["PPCR ZARAGOZA",'../json/027125Rlast.json',"027125R"],
);


foreach($placas as $key){
    $oldFile = '';
    if(count($contacts->getLastShortRefFile($key[2],'')) > 0)
      $oldFile = $contacts->getLastShortRefFile($key[2],'')[0]['libre'];
    ?>
    <div class="btn-inmov">
      <button id="<?php echo $key[2]; ?>">
      <?php echo $key[0] . " - " . $oldFile; ?>
      </button>
      <img alt="🔽" src="../img/expand_more_FILL0_wght400_GRAD0_opsz48.png" class="btn-inmov-normal">
      <div class="carrusel-off"></div>
    </div>
    <?php
}

?>