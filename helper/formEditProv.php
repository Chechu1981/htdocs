<?php include_once ('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include('./../helper/head.php');
  $userData = $contacts->getProvById($_GET['userId']);
  $tipo = ['IAM', 'OEM'];
  $lista = [
    'MADRID',
    'SANTIAGO',
    'BARCELONA',
    'ZARAGOZA',
    'VALENCIA',
    'MÁLAGA',
    'PALMA',
    'SEVILLA'
  ];
  $marcas = ["AUDI", "BMW", "FERRARI", "MERCEDES-BENZ", "MINI", "PEUGEOT", "PORSCHE", "RENAULT", "TOYOTA", "VOLKSWAGEN", "9FF", "ABARTH", "AC", "ACM", "ACURA", "AIWAYS", "AIXAM", "ALBA", "ALFA", "ALPINA", "ALPINE", "AMPHICAR", "ANGELELLI", "ARIEL", "ARTEGA", "ASpark", "ASPID", "ASTON", "AUDI", "AURUS", "AUSTIN", "AUTOBIANCHI", "BAIC", "BAW", "BEDFORD", "BELLIER", "BENTLEY", "BERTONE", "BESTUNE", "BMW", "BOLDMEN", "BOLLORÉ", "BORGWARD", "BRILLIANCE", "BRISTOL", "BRUTE", "BUGATTI", "BUICK", "BYD", "CADILLAC", "CARAVANS-WOHNM", "CARVER", "CASALINI", "CATERHAM", "CENNTRO", "CHANGHE", "CHATENET", "CHERY", "CHEVROLET", "CHRYSLER", "CIRELLI", "CITROEN", "CITYEL", "CORVETTE", "CUPRA", "DACIA", "DAEWOO", "DAF", "DAIHATSU", "DAIMLER","DALLARA","DANGEL","DE LA CHAPELLE","DE TOMASO","DELOREAN","DEVINCI CARS","DFSK","DODGE","DONGFENG","DONKERVOORT","DR AUTOMOBILES","DS AUTOMOBILES","DUTTON","E.GO","EBRO","ECONELO","EDRAN","ELARIS","EMBUGGY","EMC","ESTRIMA","EVETTA","EVO","FARIZON","FERRARI","FIAT","FISKER","FORD","FORTHING","FOTON","GAC GONOW","GALLOPER","GAPPY","GAZ","GEM","GEMBALLA","GENESIS","GIANA","GILLET","GIOTTI VICTORIA","GMC","GOUPIL","GREAT WALL","GRECAV","GTA","GWM","HAIMA","HAMANN","HAVAL","HIPHI","HOLDEN","HONDA","HONGQI","HUMMER","HURTAN","HYUNDAI","ICH-X","INEOS","INFINITI","INNOCENTI","INVICTA","ISO RIVOLTA","ISUZU","IVECO","IZH","JAC","JAOCOO","JAGUAR","JEEP","JENSEN","KARMA","KGM","KIA","KOENIGSEGG","KTM","LADA","LAMBORGHINI","LANCIA","LAND ROVER","LDV","LEAPMOTOR","LEVC","LEXUS","LI","LIFAN","LIGIER","LINCOLN","LINZDA","LIVAN","LORINS","LOTUS","LUCID","LYNK & CO","M-ERO","MAHINDRA", "MAN","MANSORY","MARTIN","MARTIN MOTORS","MASERATI","MATRA","MAXUS","MAYBACH","MAZDA","MCLAREN","MEGA","MELEX","MERCEDES-BENZ","MERCURY","MG","MICRO","MICROCAR","MILITEM","MINARI","MINAUTO","MINI","MITSUBISHI","MITSUOKA","MOBILIZE","MORGAN","MOSKVICH","MP LAFER","MPM MOTORS","NIO","NISSAN","NSU","OLDSMOBILE","OLDTIMER","OMODA","OPEL","ORA","PAGANI","PANTHER WESTWINDS","PEUGEOT","PGO","PIAGGIO","PLYMOUTH","POLESTAR","PONTIAC","PORSCHE","PROTON","PUCH","RAM","REGIS","RELIANT","RENAULT", "RIVIAN", "ROLLS-ROYCE", "ROVER", "RUF", "SAAB", "SANTANA", "SEAT", "SEGWAY", "SELVO", "SERES", "SEVIC", "SGS", "SHELBY", "SHUANGHUAN", "SILENCE", "SIMPLICI", "SINGER", "SKODA", "SKYWELL", "SMART", "SPEEDART", "SPORTEQUIPE", "SPYKER", "SSANGYONG", "STORMBORN", "STREETSCOOTER", "STUDEBAKER", "SUBARU", "SUZUKI", "SWM", "TALBOT", "TASSO", "TATA", "TAZZARI EV", "TECHART", "TESLA", "TIGER", "TOGG", "TOWN LIFE", "TOYOTA", "TRABANT", "TRAILER-ANHÄNGER", "TRIUMPH", "TRUCKS-LKW", "TVR", "UAZ", "VANDEN PLAS", "VANDERHALL", "VAZ", "VEM", "VINFAST", "VOLKSWAGEN",  "VOLVO",  "VOYAH" ,"WARTBURG" ,"WELTMEISTER" ,"WENCKSTERN" ,"WESTFIELD" ,"WEY", "WIESMANN" ,"WILLYS" ,"XBUS" ,"XIAOPENG" ,"YAMAHA" ,"YULON" ,"ZASTAVA" ,"ZAZ" ,"ZEDRIVE" ,"ZENVO" ,"ZOTYE"];
  $marcasTop = ["AUDI", "BMW", "FERRARI", "MERCEDES-BENZ", "MINI", "PEUGEOT", "PORSCHE", "RENAULT", "TOYOTA", "VOLKSWAGEN"];
  ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Proveedores - Configuración</h1>
      <button id="userList">Lista de Proveedores</button>
    </div>
    <div class="note-body">
      <form action="" method="post" title="update">
          <label for="nombre">NOMBRE DE PROVEEDOR</label>
            <input type="username" id="nombre" placeholder="Nombre de proveedor" value="<?= $userData[0][1] ?>">
          <label for="nprov">NÚMERO DE PROVEEDOR ICAR</label>
            <input type="number" id="nprov" placeholder="Número de proveedor" value="<?= $userData[0][10] ?>" autocomplete="off">
          <label for="email">CORREO ELECTRÓNICO</label>
            <input type="text" id="email" placeholder="Correo electrónico" value="<?= $userData[0][5] ?>" autocomplete="off">
          <label for="direccion">DIRECCIÓN</label>
              <input name="direccion" id="direccion" placeholder="Dirección" value="<?= $userData[0][6] ?>">
          <label for="tlf">TELÉFONO</label>
              <input name="tlf" id="tlf" placeholder="Teléfono" value="<?= $userData[0][4] ?>">
          <label for="marca">MARCA</label>
              <select data-test="make" aria-label="cars-make-filter" name="marca" id="marca">
              <option value="" selected=""></option>
              <optgroup label="Top Marcas">
                <?php foreach($marcasTop as $marcaTop){ 
                  $selected = ($userData[0][2] == $marcaTop) ? 'selected' : '';
                  echo "<option value='$marcaTop' $selected>$marcaTop</option>";
                } ?>
              </optgroup>
              <optgroup label="Otras Marcas">
                <?php foreach($marcas as $marca){
                  $marca_value = str_replace('-','',str_replace('.','',str_replace(" ", "", $marca)));
                  if(strlen($marca) < 3)
                    $marca_value = $marca.'A';
                  if(!in_array($marca, $marcasTop)){
                    $selected = ($userData[0][2] == $marca) ? 'selected' : '';
                    echo "<option value='$marca_value' $selected>$marca</option>";
                  }
                } ?>
              </optgroup>
            </select>
          <label for="tipo">TIPO</label>
            <select name="tipo" id="tipo">
              <?php foreach($tipo as $item): ?>
                <option value="<?= $item ?>" <?= ($userData[0][3] == $item) ? 'selected' : '' ?>><?= $item ?></option>
              <?php endforeach; ?>
            </select>
          <label for="placa">PLACA</label>
            <select name="placa" id="placa">
              <?php foreach ($lista as $equipo) { ?>
                <?php if ($equipo == $userData[0]['placa']) { ?>
                  <option value="<?= $equipo ?>" selected ><?= $equipo ?></option>
                  <?php } else { ?>
                    <option value="<?= $equipo ?>"><?= $equipo ?></option>
                  <?php } ?>
              <?php } ?>
            </select>
          <label for="recogida">RECOGIDA</label>
              <input type="checkbox" name="recogida" id="entrega" <?= ($userData[0]['recogida'] == 'S') ? 'checked' : '' ?>>
          <label for="btnform"></label><input type="submit" value="Modificar" id="btnform">
      </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
