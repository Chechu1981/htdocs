
<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('./../helper/head.php'); ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Proveedores - Configuración</h1>
      <button id="userList">Lista de proveedores</button>
    </div>
    <div class="note-body">
        <form action="" method="post" title="update">
          <label for="placa">NOMBRE DE LA PLACA</label>
            <select name="placa" id="placa">
              <option value="" disabled selected>Selecciona una placa</option>
              <option value="MADRID">MADRID</option>
              <option value="BARCELONA">BARCELONA</option>
              <option value="VALENCIA">VALENCIA</option>
              <option value="SEVILLA">SEVILLA</option>
              <option value="ZARAGOZA">ZARAGOZA</option>
              <option value="MALAGA">MALAGA</option>
              <option value="GALICIA">GALICIA</option>
              <option value="PALMA">PALMA</option>
            </select>
          <label for="nombre">NOMBRE DEL PROVEEDOR</label>
            <input type="text" id="nombre" placeholder="Nombre del proveedor" value="" autocomplete="off">
          <label for="nprov">NÚMERO DE PROVEEDOR ICAR</label>
            <input type="number" id="nprov" placeholder="Número de proveedor" value="" autocomplete="off">
          <label for="marca">MARCA</label>
            <select data-test="make" aria-label="cars-make-filter" name="marca" id="marca">
              <option value="" selected=""></option>
              <optgroup label="Top Marcas">
                <option value="AUDI">Audi</option>
                <option value="BMW">BMW</option>
                <option value="FERRARI">Ferrari</option>
                <option value="MERCEDES-BENZ">Mercedes-Benz</option>
                <option value="MINI">MINI</option>
                <option value="PEUGEOT">Peugeot</option>
                <option value="PORSCHE">Porsche</option>
                <option value="RENAULT">Renault</option>
                <option value="TOYOTA">Toyota</option>
                <option value="VOLKSWAGEN">Volkswagen</option>
              </optgroup>
              <optgroup label="Otras Marcas">
                <option value="9FF">9ff</option>
                <option value="ABARTH">Abarth</option>
                <option value="AC">AC</option>
                <option value="ACM">ACM</option>
                <option value="ACURA">Acura</option>
                <option value="AIWAYS">Aiways</option>
                <option value="AIXAM">Aixam</option>
                <option value="ALBA">Alba Mobility</option>
                <option value="ALFA">Alfa Romeo</option>
                <option value="ALPINA">Alpina</option>
                <option value="ALPINE">Alpine</option>
                <option value="AMPHICAR">Amphicar</option>
                <option value="ANGELELLI">Angelelli Automobili</option>
                <option value="ARIEL">Ariel Motor</option>
                <option value="ARTEGA">Artega</option>
                <option value="ASpark">Aspark</option>
                <option value="ASPID">Aspid</option>
                <option value="ASTON">Aston Martin</option>
                <option value="AUDI">Audi</option>
                <option value="AURUS">Aurus</option>
                <option value="AUSTIN">Austin</option>
                <option value="AUTOBIANCHI">Autobianchi</option>
                <option value="BAIC">BAIC</option>
                <option value="BAW">BAW</option>
                <option value="BEDFORD">Bedford</option>
                <option value="BELLIER">Bellier</option>
                <option value="BENTLEY">Bentley</option>
                <option value="BERTONE">Bertone</option>
                <option value="BESTUNE">Bestune</option>
                <option value="BMW">BMW</option>
                <option value="BOLDMEN">Boldmen</option>
                <option value="BOLLORÉ">Bolloré</option>
                <option value="BORGWARD">Borgward</option>
                <option value="BRILLIANCE">Brilliance</option>
                <option value="BRISTOL">Bristol</option>
                <option value="BRUTE">Brute</option>
                <option value="BUGATTI">Bugatti</option>
                <option value="BUICK">Buick</option>
                <option value="BYD">BYD</option>
                <option value="CADILLAC">Cadillac</option>
                <option value="CARAVANS-WOHNM">Caravans-Wohnm</option>
                <option value="CARVER">Carver</option>
                <option value="CASALINI">Casalini</option>
                <option value="CATERHAM">Caterham</option>
                <option value="CENNTRO">Cenntro</option>
                <option value="CHANGHE">Changhe</option>
                <option value="CHATENET">Chatenet</option>
                <option value="CHERY">Chery</option>
                <option value="CHEVROLET">Chevrolet</option>
                <option value="CHRYSLER">Chrysler</option>
                <option value="CIRELLI">Cirelli</option>
                <option value="CITROEN">Citroen</option>
                <option value="CITYEL">CityEL</option>
                <option value="CORVETTE">Corvette</option>
                <option value="CUPRA">CUPRA</option>
                <option value="DACIA">Dacia</option>
                <option value="DAEWOO">Daewoo</option>
                <option value="DAF">DAF</option>
                <option value="DAIHATSU">Daihatsu</option>
                <option value="DAIMLER">Daimler</option>
                <option value="DALLARA">Dallara</option>
                <option value="DANGEL">Dangel</option>
                <option value="CHAPELLE">De la Chapelle</option>
                <option value="TOMASO">De Tomaso</option>
                <option value="DELOREAN">Delorean</option>
                <option value="DEVINCI">Devinci Cars</option>
                <option value="DFSK">DFSK</option>
                <option value="DODGE">Dodge</option>
                <option value="DONGFENG">Dongfeng</option>
                <option value="DONKERVOORT">Donkervoort</option>
                <option value="DRAUTOMOBILES">DR Automobiles</option>
                <option value="DSAUTOMOBILES">DS Automobiles</option>
                <option value="DUTTON">Dutton</option>
                <option value="EGO">e.GO</option>
                <option value="EBRO">Ebro</option>
                <option value="ECONELO">Econelo</option>
                <option value="EDRAN">Edran</option>
                <option value="ELARIS">Elaris</option>
                <option value="EMBUGGY">Embuggy</option>
                <option value="EMC">EMC</option>
                <option value="ESTRIMA">Estrima</option>
                <option value="EVETTA">Evetta</option>
                <option value="EVO">EVO</option>
                <option value="FARIZON">Farizon</option>
                <option value="FER">Ferrari</option>
                <option value="FIAT">Fiat</option>
                <option value="FISKER">Fisker</option>
                <option value="FORD">Ford</option>
                <option value="FORTHING">Forthing</option>
                <option value="FOTON">Foton</option>
                <option value="GACGONOW">Gac Gonow</option>
                <option value="GALLOPER">Galloper</option>
                <option value="GAPPY">Gappy</option>
                <option value="GAZ">GAZ</option>
                <option value="GEM">GEM</option>
                <option value="GEMBALLA">GEMBALLA</option>
                <option value="GENESIS">Genesis</option>
                <option value="GIANA">Giana</option>
                <option value="GILLET">Gillet</option>
                <option value="GIOTTI_VICTORIA">Giotti Victoria</option>
                <option value="GMC">GMC</option>
                <option value="GOUPIL">Goupil</option>
                <option value="GREATWALL">Great Wall</option>
                <option value="GRECAV">Grecav</option>
                <option value="GTA">GTA</option>
                <option value="GWM">GWM</option>
                <option value="HAIMA">Haima</option>
                <option value="HAMANN">Hamann</option>
                <option value="HAVAL">Haval</option>
                <option value="HIPHI">Hiphi</option>
                <option value="HOLDEN">Holden</option>
                <option value="HONDA">Honda</option>
                <option value="HONGQI">Hongqi</option>
                <option value="HUMMER">HUMMER</option>
                <option value="HURTAN">Hurtan</option>
                <option value="HYUNDAI">Hyundai</option>
                <option value="ICH-X">ICH-X</option>
                <option value="INEOS">Ineos</option>
                <option value="INFINITI">Infiniti</option>
                <option value="INNOCENTI">Innocenti</option>
                <option value="INVICTA">Invicta</option>
                <option value="ISO_RIVOLTA">Iso Rivolta</option>
                <option value="ISUZU">Isuzu</option>
                <option value="IVECO">Iveco</option>
                <option value="IZH">IZH</option>
                <option value="JAC">JAC</option>
                <option value="JAOCOO">Jaecoo</option>
                <option value="JAGUAR">Jaguar</option>
                <option value="JEEP">Jeep</option>
                <option value="JENSEN">Jensen</option>
                <option value="KARMA">Karma</option>
                <option value="KGM">KGM</option>
                <option value="KIA">Kia</option>
                <option value="KOENIGSEGG">Koenigsegg</option>
                <option value="KTM">KTM</option>
                <option value="LADA">Lada</option>
                <option value="LAMBORGHINI">Lamborghini</option>
                <option value="LANCIA">Lancia</option>
                <option value="LAND_ROVER">Land Rover</option>
                <option value="LDV">LDV</option>
                <option value="LEAPMOTOR">Leapmotor</option>
                <option value="LEVC">LEVC</option>
                <option value="LEXUS">Lexus</option>
                <option value="LI">Li</option>
                <option value="LIFAN">Lifan</option>
                <option value="LIGIER">Ligier</option>
                <option value="LINCOLN">Lincoln</option>
                <option value="LINZDA">Linzda</option>
                <option value="LIVAN">Livan</option>
                <option value="LORINSER">Lorinser</option>
                <option value="LOTUS">Lotus</option>
                <option value="LUCID">Lucid</option>
                <option value="LYNK_CO">Lynk &amp; Co</option>
                <option value="M_ERO">M-Ero</option>
                <option value="MAHINDRA">Mahindra</option>
                <option value="MAN">MAN</option>
                <option value="MANSORY">Mansory</option>
                <option value="MARTIN">Martin</option>
                <option value="MARTIN_MOTORS">Martin Motors</option>
                <option value="MASERATI">Maserati</option>
                <option value="MATRA">Matra</option>
                <option value="MAXUS">Maxus</option>
                <option value="MAYBACH">Maybach</option>
                <option value="MAZDA">Mazda</option>
                <option value="MCLAREN">McLaren</option>
                <option value="MEGA">Mega</option>
                <option value="MELEX">Melex</option>
                <option value="MERCEDES_BENZ">Mercedes-Benz</option>
                <option value="MERCURY">Mercury</option>
                <option value="MG">MG</option>
                <option value="MICRO">Micro</option>
                <option value="MICROCAR">Microcar</option>
                <option value="MILITEM">Militem</option>
                <option value="MINARI">Minari</option>
                <option value="MINAUTO">Minauto</option>
                <option value="MINI">MINI</option>
                <option value="MITSUBISHI">MITSUBISHI</option>
                <option value="MITSUOKA">MITSUOKA</option>
                <option value="MOBILIZE">MOBILIZE</option>
                <option value="MORGAN">MORGAN</option>
                <option value="MOSKVICH">Moskvich</option>
                <option value="MP_LAFER">MP Lafer</option>
                <option value="MPM_MOTORS">MPM Motors</option>
                <option value="NIO">NIO</option>
                <option value="NISSAN">Nissan</option>
                <option value="NSU">NSU</option>
                <option value="OLDSMOBILE">Oldsmobile</option>
                <option value="OLDTIMER">Oldtimer</option>
                <option value="OMODA">Omoda</option>
                <option value="OPEL">Opel</option>
                <option value="ORA">Ora</option>
                <option value="PAGANI">Pagani</option>
                <option value="PANTHER_WESTWINDS">Panther Westwinds</option>
                <option value="PEUGEOT">Peugeot</option>
                <option value="PGO">PGO</option>
                <option value="PIAGGIO">Piaggio</option>
                <option value="PLYMOUTH">Plymouth</option>
                <option value="POLestar">Polestar</option>
                <option value="PONTIAC">Pontiac</option>
                <option value="PORSCHE">Porsche</option>
                <option value="PROTON">Proton</option>
                <option value="PUCH">Puch</option>
                <option value="RAM">RAM</option>
                <option value="REGIS">Regis</option>
                <option value="RELIANT">Reliant</option>
                <option value="RENAULT">Renault</option>
                <option value="RIVIAN">Rivian</option>
                <option value="ROLLS_ROYCE">Rolls-Royce</option>
                <option value="ROVER">Rover</option>
                <option value="RUF">Ruf</option>
                <option value="SAAB">Saab</option>
                <option value="SANTANA">Santana</option>
                <option value="SEAT">SEAT</option>
                <option value="SEGWAY">Segway</option>
                <option value="SELVO">Selvo</option>
                <option value="SERES">Seres</option>
                <option value="SEVIC">Sevic</option>
                <option value="SGS">SGS</option>
                <option value="SHELBY">Shelby</option>
                <option value="SHUANGHUAN">Shuanghuan</option>
                <option value="SILENCE">Silence</option>
                <option value="SIMPLICI">Simplici</option>
                <option value="SINGER">Singer</option>
                <option value="SKODA">Skoda</option>
                <option value="SKYWELL">Skywell</option>
                <option value="SMART">SMART</option>
                <option value="SPEEDART">SPEEDART</option>
                <option value="SPORTEQUIPE">SPORTEQUIPE</option>
                <option value="SPYKER">SPYKER</option>
                <option value="SSANGYONG">SSANGYONG</option>
                <option value="STORMBORN">STORMBORN</option>
                <option value="STREETSCOOTER">STREETSCOOTER</option>
                <option value="STUDEBAKER">STUDEBAKER</option>
                <option value="SUBARU">SUBARU</option>
                <option value="SUZUKI">SUZUKI</option>
                <option value="SWM">SWM</option>
                <option value="TALBOT">TALBOT</option>
                <option value="TASSO">TASSO</option>
                <option value="TATA">TATA</option>
                <option value="TAZZARI_EV">Tazzari EV</option>
                <option value="TECHART">TECHART</option>
                <option value="TESLA">TESLA</option>
                <option value="TIGER">TIGER</option>
                <option value="TOGG">TOGG</option>
                <option value="TOWN_LIFE">Town Life</option>
                <option value="TOYOTA">Toyota</option>
                <option value="TRABANT">Trabant</option>
                <option value="TRAILER_ANHAENGER">Trailer-Anhänger</option>
                <option value="TRIUMPH">Triumph</option>
                <option value="TRUCKS_LKW">Trucks-Lkw</option>
                <option value="TVR">TVR</option>
                <option value="UAZ">UAZ</option>
                <option value="VANDEN_PLAS">Vanden Plas</option>
                <option value="VANDERHALL">Vanderhall</option>
                <option value="VAZ">VAZ</option>
                <option value="VEM">VEM</option>
                <option value="VINFAST">VinFast</option>
                <option value="VOLKSWAGEN">Volkswagen</option>
                <option value="VOLVO">Volvo</option>
                <option value="VOYAH">Voyah</option>
                <option value="WARTBURG">Wartburg</option>
                <option value="WELTMEISTER">Weltmeister</option>
                <option value="WENCKSTERN">Wenckstern</option>
                <option value="WESTFIELD">Westfield</option>
                <option value="WEY">Wey</option>
                <option value="WIESMANN">Wiesmann</option>
                <option value="XBUS">XBus</option>
                <option value="XEV">XEV</option>
                <option value="XIAOMI">Xiaomi</option>
                <option value="XPENG">Xpeng</option>
                <option value="ZASTAVA">Zastava</option>
                <option value="ZAZ">ZAZ</option>
                <option value="ZEekr">Zeekr</option>
                <option value="ZHIDOU">Zhidou</option>
                <option value="ZOTYE">Zotye</option>
                <option value="OTROS">OTROS</option>
              </optgroup>
            </select>
          <label for="tipo">TIPO</label>
            <select name="tipo" id="tipo">
              <option value="" disabled selected>Selecciona un tipo</option>
              <option value="OEM">RECAMBIO ORIGINAL</option>
              <option value="IAM">RECAMBIO ALTERNATIVO</option>
            </select>
          <label for="email">CORREO ELECTRÓNICO</label>
            <input type="text" id="email" placeholder="Correo electrónico" value="" autocomplete="off">
          <label for="tlf">TELÉFONO</label>
            <input type="text" id="tlf" placeholder="Teléfono" value="" autocomplete="off">
          <label for="direccion">DIRECCIÓN</label>
              <input name="direccion" id="direccion" placeholder="Dirección"></input>
          <label for="entrega">RECOGIDA EN EL PROVEEDOR</label>
            <input type="checkbox" id="entrega" value="" autocomplete="off">
          <label for="btnform"></label><input type="submit" value="Crear" id="btnform">
        </form>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>
