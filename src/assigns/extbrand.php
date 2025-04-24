<?php include('../../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('../../helper/head.php'); ?>
</head>
<body>
  <?php include_once '../../helper/alert.php'; ?>
  <div id="menu">
    <?php include_once '../../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
    <h1>Compra externa - Otras marcas</h1>
      <?php include_once '../../helper/menuCesiones.php'; ?>
    </div>
    <div id="contacts-items">
      <div id="clientName" class="clientNameExt"></div>
        <form>
            <div class="form-extBuy">
              <section>
                <label for="origen">*Tipo</label>
                <select name="" id="origen">
                  <option value=""></option>
                  <option value="IAM">Recambio Paralelo</option>
                  <option value="OEM">Recambio Original</option>
                </select>
              </section>
              <section>
                <label for="marca">*Marca</label>
                <select name="" id="marca">
                  <option value="" ></option>
                  <option value="ROU" >CROU . ORENSE</option>
                  <option value="REC" >RECALVI</option>
                  <option value="MAT" >MISTER AUTO</option>
                  <option value="BGA" >BRUGÉS GAVÀ</option>
                  <option value="VAG" >GRUPO VW</option>
                  <option value="FOR" >FORD</option>
                  <option value="REN" >RENAULT</option>
                  <option value="BMW" >BMW</option>
                  <option value="AUD" >AUDI</option>
                  <option value="AIX" >AIXAM</option>
                  <option value="CHE" >CHEVROLET</option>
                  <option value="CPR" >CUPRA</option>
                  <option value="GOO" >GOOD YEAR</option>
                  <option value="HON" >HONDA</option>
                  <option value="HYU" >HYUNDAI</option>
                  <option value="JAG" >JAGUAR</option>
                  <option value="KEN" >KENDA</option>
                  <option value="KIA" >KIA</option>
                  <option value="LAF" >LAFUENTE</option>
                  <option value="LAN" >LAND ROVER</option>
                  <option value="LEX" >LEXUS</option>
                  <option value="MAR" >SPANESIMAR -MARTECH</option>
                  <option value="MAZ" >MAZDA</option>
                  <option value="MER" >MERCEDES</option>
                  <option value="MIT" >MITSUBISHI</option>
                  <option value="MOV" >MOVELCO MOBILITY</option>
                  <option value="MT"  >LIQUIDOS MT</option>
                  <option value="NIS" >NISSAN</option>
                  <option value="POR" >PORSCHE</option>
                  <option value="SAA" >SAAB</option>
                  <option value="SAM" >SAM</option>
                  <option value="SAN" >SSANYONG</option>
                  <option value="SEA" >SEAT</option>
                  <option value="SNA" >BAHCO</option>
                  <option value="SKO" >SKODA</option>
                  <option value="SUB" >SUBARU</option>
                  <option value="SUR" >SUREYA</option>
                  <option value="SUZ" >SUZUKI</option>
                  <option value="TAP" >ITAP . VIGUESA</option>
                  <option value="TOT" >TOTAL</option>
                  <option value="TOY" >TOYOTA</option>
                  <option value="VOL" >VOLVO</option>
                  <option value="VWN" >VOLKSWAGEN</option>
                  <option value="JUM" >JUMASA</option>
                  <option value="PHI" >PHIRA</option>
                  <option value="ELO" >ELOY</option>
                  <option value="SMA" >SAMOA</option>
                </select>
              </section>
              <section>
                <label for="destino">*Destino</label>
                <select name="" id="destino">
                  <option value=""></option>
                  <option value="MADRID">Madrid</option>
                  <option value="SANTIAGO">Santiago</option>
                  <option value="BARCELONA">Barcelona</option>
                  <option value="ZARAGOZA">Zaragoza</option>
                  <option value="VALENCIA">Valencia</option>
                  <option value="GRANADA">Granada</option>
                  <option value="SEVILLA">Sevilla</option>
                  <option value="PALMA">Palma</option>
                </select>
              </section>
              <section>
                <label for="client">*Cliente</label>
                <input type="text" name="cliente" id="client">
              </section>
              <section>
                <label for="pedido">*Envío</label>
                <input type="text" name="envio" id="envio" class="inputSend"></input>
              </section>
              <section>
                <label for="coment">Comentario del pedido</label>
                <textarea type="text" name="Comentario" id="coment"></textarea>
              </section>
            </div>
            <div class="form-extLine">
              <section>
                <span></span>
                <label for="ref">*Referencia PR</label>
                <label for="units">*Cant</label>
                <label for="comentLine">Descripción</label>
              </section>
              <section>
                <span>1</span>
                <input type="text" name="Referencia" id="ref">
                <input type="text" name="Cantidad" id="units">
                <input type="text" name="comentline" id="comentLine">
                <select name="familia" id="familyParts">
                  <option value=""></option>
                  <option value="CARROCERIA">Carrocería</option>
                  <option value="MECANICA">Mecánica</option>
                  <option value="REMAN">Cambio estádar</option>
                </select>
                <img src="../../img/delete_FILL0_wght400_GRAD0_opsz24.png" alt="eliminar" title="Eliminar" class="deleteLine" id="delete1">
              </section>
            </div>
          </form>
          <div style="text-align:right">
            <button id="addLine">Añadir línea</button>
          </div>
          <div>
            <button id="sendProv">Enviar al proveedor</button>
            <button id="senMail" disabled="disabled">Enviar a la placa</button>
          </div>
            <div id="cesiones"></div>
    </div>
  </div>
  <?php include('../../helper/footer.php'); ?>
</body>
</html>