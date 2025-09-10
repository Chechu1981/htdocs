<?php include('../../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  include('../../helper/head.php'); 

  $id = $_GET['id'] ?? '';
  if($id == ''){
    header('Location: ./orderList.php');
  }
  ?>
</head>
<body>
  <?php include_once '../../helper/alert.php'; ?>
  <?php include_once '../../helper/menu.php'; ?>
  <div class="search-table">
    <div id="contacts" class="contacts">
    <h1>Compra externa - Editar pedidos</h1>
      <?php include_once '../../helper/menuExt.php'; ?>
    </div>
    <div>
      <div class="listOrderExt" id="search-results">
        <div id="clientName" class="clientNameExt"></div>
      <div id="numPedido" style="display:none"><?= $_GET['id'] ?></div>
        <form>
            <div class="form-extBuy">
              <section>
                <label for="destino">*Placa</label>
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
                <label for="envio">*Dirección de entrega</label>
                <select name="envio" id="envio" >
                  <option value=""></option>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </section>
              <section>
                <label for="coment">Comentario del pedido</label>
                <textarea type="text" name="Comentario" id="coment"></textarea>
              </section>
            </div>
            <div id="prov0" class="form-extLine">
              <div class="provHeader">
                <section>
                  <label for="tipo0">*Tipo</label>
                  <select name="" id="tipo0">
                    <option value=""></option>
                    <option value="IAM">Recambio Paralelo</option>
                    <option value="OEM">Recambio Original</option>
                  </select>
                </section>
                <section>
                  <label for="marca0">*Marca</label>
                  <select name="" id="marca0">
                    <option value="" ></option>
                  </select>
                </section>
                <section>
                  <label for="proveedor0">Proveedor</label>
                  <select name="proveedor" id="proveedor0">
                    <option value=""></option>
                  </select>
                </section>
              </div>
              <div id="formLine0" class="formLine">
                <section>
                  <span></span>
                  <label>Referencia PR</label>
                  <label>Cant</label>
                  <label>Descripción</label>
                  <label>Familia</label>
                  <label>PVP</label>
                  <label>Dto Compra</label>
                  <label for="dtoVenta">*Dto Venta</label>
                </section>
              </div>
              <div class="addLine">
              <button id="addLine">Añadir línea</button>
              </div>
              <div class="submitOrder">
                <button id="selectProv">Confirmar al proveedor</button>
                <button id="addOrder">Confirmar pedido</button>
              </div>
            </div>
          </form>
          <div style="text-align:right">
            <button id="addProvider" style="display: none;">Añadir proveedor</button>
          </div>
    </div>
      </div>
    </div>
  </div>
  <?php include('../../helper/footer.php'); ?>
</body>
</html>