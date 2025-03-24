<?php

$uri = $_SERVER['PHP_SELF'];
$src = ".";
!strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
strpos($uri,'center') > 0 ? $src = "../.." : '';
strpos($uri,'assigns') > 0 ? $src = "../.." : '';
include_once $src . '/connection/data.php';
$contacts = new Contacts();
$id = $_GET['id'];
$rows = $contacts->getUserBySessid($id);
$puesto = $rows[0][4];
$usuario = $rows[0][1];
$menuTodas = '';
if($puesto == 'ADV')
    $menuTodas = '<li><a href="'.$src.'/src/cesionesAll.php?id='.$id.'">Todas</a></li>';
$allAssigns = $contacts->getAssigCountNew($usuario, $puesto,'all')[0][0];
$nuevas = $contacts->getAssigCountNew($usuario,$usuario,'ready')[0][0];
?>
<picture class="head-img">
    <section>
        <img src="<?php echo $src.'/img/Logo-PPCR-2022.png'; ?>" alt="logo" id="logo">
    </section>
    <section id="userName">Agenda</section>
</picture>
<nav id="menu-items">
    <ul>
        <li><a href="<?php echo $src.'/home.php?id='.$id; ?>" >Enlaces</a></li>
        <li><a href="<?php echo $src.'/src/routeTest.php?id='.$id; ?>">Rutas</a></li>
        <li><a href="<?php echo $src.'/src/libreta.php?id='.$id; ?>">Libreta</a>
            <ul>
                <li><a href="<?php echo $src.'/src/aceite.php?id='.$id; ?>">Aceite</a></li>
                <li><a href="<?php echo $src.'/src/baterias.php?id='.$id; ?>">Baterías</a></li>
            </ul>
        </li>
        <li style="width:82px;display:grid;grid-template-columns:84% 16%" id="cesionesActivas">
            <a href="<?php echo $src.'/src/cesionesADV.php?id='.$id ?>" title="<?php echo $allAssigns; ?>">Cesiones</a><span id="userAssignsready" class="round heart" title="<?php echo $nuevas; ?>"><?php echo $nuevas > 100 ? '+99' : $nuevas; ?></span>
            <ul>
                <li><a href="<?php echo $src.'/src/extbrand.php?id='.$id ?>">Otras marcas</a></li>
                <?php echo $menuTodas; ?>
                <li><a href="<?php echo $src.'/src/assigns/buscar.php?id='.$id ?>">Buscar</a></li>
                <li><a href="<?php echo $src.'/src/assigns/ready.php?id='.$id ?>">En curso</a></li>
                <li><a href="<?php echo $src.'/src/assigns/finish.php?id='.$id ?>">Rechazadas</a></li>
                <li><a href="<?php echo $src.'/src/assigns/status.php?id='.$id ?>">Estadísticas</a></li>
            </ul>
        </li>    
        <li>
            <a href="<?php echo $src.'/src/inmovilizados.php?id='.$id ?>">Inmovilizados</a>
            <ul>
                <li>
                    <a href="<?php echo $src.'/src/referenciados.php?id='.$id ?>">Referenciados</a>
                </li>
                <li>
                    <a href="<?php echo $src.'/src/inmStatus.php?id='.$id ?>">Datos</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo $src.'/src/centros.php?id='.$id ?>">Centros</a>
            <ul>
                <li><a href="<?php echo $src.'/src/center/central.php?id='.$id ?>">Central</a></li>
                <li><a href="<?php echo $src.'/src/center/madrid.php?id='.$id ?>">Madrid</a></li>
                <li><a href="<?php echo $src.'/src/center/sevilla.php?id='.$id ?>">Sevilla</a></li>
                <li><a href="<?php echo $src.'/src/center/vigo.php?id='.$id ?>">Santiago</a></li>
                <li><a href="<?php echo $src.'/src/center/granada.php?id='.$id ?>">Granada</a></li>
                <li><a href="<?php echo $src.'/src/center/zaragoza.php?id='.$id ?>">Zaragoza</a></li>
                <li><a href="<?php echo $src.'/src/center/palma.php?id='.$id ?>">Palma</a></li>
                <li><a href="<?php echo $src.'/src/center/paterna.php?id='.$id ?>">Paterna</a></li>
                <li><a href="<?php echo $src.'/src/center/barcelona.php?id='.$id ?>">Barcelona</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div class="form-control">
    <input type="text" name="repere" id="repere" placeholder=" ">
    <label for="repere">Repere</label>
    <span id="referencia" ></span>
</div>
<div class="note">
    <img alt="Enviar correo de B-parts a la placa de Madrid" src="<?php echo $src."/img/b-parts-brand-logo.png"; ?>" id="mailBParts" title="Enviar un correo a la placa de Madrid indicando que llega un B-Parts">
    <span id="mailMostrador">
      <img alt="Enviar correo al mostrador" src="<?php echo $src."/img/moving_ministry_24dp_FILL0_wght400_GRAD0_opsz24.png"; ?>" id="mailMostrador" title="Enviar un correo al mostrador">
      <menu name="submenuSendMailTo" id="submenu" class="submenu submenu_hidden">
        <p id="madrid" title="Enviar correo al mostrador de Madrid">MADRID</p>
        <p id="santiago" title="Enviar correo al mostrador de Santiago">SANTIAGO</p>
        <p id="malaga" title="Enviar correo al mostrador de Málaga (628 620 699)">MÁLAGA</p>
        <p id="zaragoza" title="Enviar correo al mostrador de Zaragoza">ZARAGOZA</p>
      </menu>
    </span>
    <span id="notes">
      <img alt="notas" src="<?php echo $src."/img/note_alt_FILL0_wght400_GRAD0_opsz48.png" ?>" id="notes" title="Notas">
    </span>
    <span>
        <img alt="calc" src="<?php echo $src."/img/table_FILL0_wght400_GRAD0_opsz48.png" ?>" id="calc" title="OPR & CV>Kw">
    </span>
    <img alt="configuracion" src=<?php echo $src."/img/settings_FILL0_wght400_GRAD0_opsz24.png" ?> title="Configuración"></img>
</div>
<img alt="logout" src=<?php echo $src."/img/logout_FILL0_wght400_GRAD0_opsz48.png" ?> title="Salir"></img>