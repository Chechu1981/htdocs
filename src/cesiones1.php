<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include_once('../helper/head.php'); ?>
</head>
<body>
  <div id="menu">
    <?php include_once '../helper/menu.php'; ?>
  </div>
  <div class="search-table">
    <div id="contacts" class="contacts">
      <h1>Cesiones</h1>
      <section class="subButtons">
        <ul>
          <li title="Nueva Cesión">Nueva</li>
          <li title="Buscar cesiones">Buscar</li>
          <li title="Cesiones recibidas por el cliente">Hechas</li>
          <li title="Cesiones pendientes de recibir">En curso</li>
          <li title="Estadísticas">Estadísticas</li>
        </ul>
      </section>
    </div>
    <div id="contacts-items">
        <form>
            <div class="form-group">
              <section>
                <label for="origen">*Origen</label>
                <label for="destino">*Destino</label>
                <select name="" id="origen">
                  <option value="MADRID">Madrid</option>
                  <option value="VIGO">Vigo</option>
                  <option value="BARCELONA">Barcelona</option>
                  <option value="ZARAGOZA">Zaragoza</option>
                  <option value="VALENCIA">Valencia</option>
                  <option value="GRANADA">Granada</option>
                  <option value="SEVILLA">Sevilla</option>
                  <option value="PALMA">Palma</option>
                </select>
                <select name="" id="destino">
                  <option value="MADRID">Madrid</option>
                  <option value="VIGO">Vigo</option>
                  <option value="BARCELONA">Barcelona</option>
                  <option value="ZARAGOZA">Zaragoza</option>
                  <option value="VALENCIA">Valencia</option>
                  <option value="GRANADA">Granada</option>
                  <option value="SEVILLA">Sevilla</option>
                  <option value="PALMA">Palma</option>
                </select>
                <div id="pclient" class="arrow-right active" style="grid-column: 1 / span 2;margin: auto;top: 2px;    border: 2px solid var(--bg-font-color);border-radius: 4px;box-shadow: 0px 0px 3px var(--bg-font-color);"></div>
                <!--<div id="provider" class="arrow-right active"></div> -->
              </section>
              <section>
                <label for="client">*Cliente</label>
                <input type="text" name="cliente" id="client">
                <div id="clientName" class="clientNameAssign"></div>
              </section>
              <section>
                <label for="ref">*Referencia</label>
                <input type="text" name="Referencia" id="ref">
                <div id="descRef" class="clientNameAssign"></div>
              </section>
              <section>
                <label for="units">Cant</label>
                <input type="text" name="Cantidad" id="units">
              </section>
              <section>
                <label for="coment">Comentarios</label>
                <textarea type="text" name="Comentario" id="coment"></textarea>
              </section>
              <section>
                <label for="nfm">NFM</label>
                <input type="checkbox" name="nfm" id="nfm">
              </section>
              <section>
                <label for="frag"><img width="40px" height="40px" alt="frágil" src="../img/wine_bar_FILL0_wght400_GRAD0_opsz40.png" alt="Frágil"></label>
                <input type="checkbox" name="Frágil" id="frag">
              </section>
              <section>
                <label for="send">.</label>
                <input type="submit" value="📩" id="send">
              </section>
            </div>
        </form>
        <div id="cesiones"></div>
    </div>
  </div>
  <?php include('../helper/footer.php'); ?>
</body>
</html>