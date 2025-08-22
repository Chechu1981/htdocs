<?php

$uri = $_SERVER['PHP_SELF'];
$src = ".";
!strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
strpos($uri,'center') > 0 ? $src = "../.." : '';
strpos($uri,'assigns') > 0 ? $src = "../.." : '';
include_once $src . '/connection/data.php';

$menuTodas = '';
$menuOtrasMarcas = '';
if($puesto == 'ADV'){
    $menuTodas = '<li><a href="'.$src.'/src/cesionesAll.php?id='.$id.'" class="dropdown-link"><i class="fa-solid fa-globe"></i>Todas</a></li>';
    //$menuOtrasMarcas = '<li><a href="'.$src.'/src/assigns/extbrand.php">Otras marcas</a></li>';
}
$allAssigns = $contacts->getAssigCountNew($user, $puesto,'all')[0][0];
$nuevas = $contacts->getAssigCountNew($user,$user,'ready')[0][0];
?>

<header class="modern-header">
    <section>
        <img src="<?php echo $src.'/img/Logo-PPCR-2022.png'; ?>" alt="logo" id="logo">
    </section>
    <nav id="modern-nav">
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span class="menu-line"></span>
            <span class="menu-line"></span>
            <span class="menu-line"></span>
        </label>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?php echo $src.'/home.php'?>" class="nav-link">
                    <i class="fas fa-link"></i> Enlaces
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $src.'/src/routeTest.php'?>" class="nav-link">
                    <i class="fas fa-route"></i> Rutas
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="<?php echo $src.'/src/libreta.php'?>" class="nav-link">
                    <i class="fas fa-book"></i> Libreta
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $src.'/src/aceite.php'?>" class="dropdown-link"><i class="fas fa-oil-can"></i> Aceite</a></li>
                    <li><a href="<?php echo $src.'/src/baterias.php'?>" class="dropdown-link"><i class="fas fa-car-battery"></i> Baterías</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="cesionesActivas">
                <a href="<?php echo $src.'/src/cesionesADV.php' ?>" class="nav-link" title="<?php echo $allAssigns; ?>">
                    <i class="fas fa-exchange-alt"></i> Cesiones
                    <span id="userAssignsready" class="badge" title="<?php echo $nuevas; ?>"><?php echo $nuevas > 100 ? '+99' : $nuevas; ?></span>
                </a>
                <ul class="dropdown-menu">
                    <?= $menuOtrasMarcas . $menuTodas; ?>
                    <li><a href="<?php echo $src.'/src/assigns/buscar.php' ?>" class="dropdown-link"><i class="fas fa-search"></i> Buscar</a></li>
                    <li><a href="<?php echo $src.'/src/assigns/ready.php' ?>" class="dropdown-link"><i class="fas fa-tasks"></i> En curso</a></li>
                    <li><a href="<?php echo $src.'/src/assigns/finish.php' ?>" class="dropdown-link"><i class="fas fa-times-circle"></i> Rechazadas</a></li>
                    <li><a href="<?php echo $src.'/src/assigns/status.php' ?>" class="dropdown-link"><i class="fas fa-chart-line"></i> Estadísticas</a></li>
                </ul>
            </li>
            <?php if($puesto == 'ADV'){ ?>
            <li class="nav-item dropdown">
                <a href="<?php echo $src.'/src/inmovilizados.php' ?>" class="nav-link"><i class="fas fa-ban"></i> Inmovilizados</a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $src.'/src/referenciados.php' ?>" class="dropdown-link"><i class="fas fa-tags"></i> Referenciados</a></li>
                    <li><a href="<?php echo $src.'/src/inmStatus.php' ?>" class="dropdown-link"><i class="fas fa-database"></i> Datos</a></li>
                </ul>
            </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a href="<?php echo $src.'/src/centros.php' ?>" class="nav-link"><i class="fas fa-building"></i> Centros</a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $src.'/src/center/central.php' ?>" class="dropdown-link"><i class="fas fa-city"></i> Central</a></li>
                    <li><a href="<?php echo $src.'/src/center/madrid.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Madrid</a></li>
                    <li><a href="<?php echo $src.'/src/center/sevilla.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Sevilla</a></li>
                    <li><a href="<?php echo $src.'/src/center/vigo.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Santiago</a></li>
                    <li><a href="<?php echo $src.'/src/center/granada.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Málaga</a></li>
                    <li><a href="<?php echo $src.'/src/center/zaragoza.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Zaragoza</a></li>
                    <li><a href="<?php echo $src.'/src/center/palma.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Palma</a></li>
                    <li><a href="<?php echo $src.'/src/center/paterna.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Paterna</a></li>
                    <li><a href="<?php echo $src.'/src/center/barcelona.php' ?>" class="dropdown-link"><i class="fas fa-warehouse"></i> Barcelona</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="userName" class="username" title="Menú de usuario"><?php echo $user ?><i class="fa-solid fa-bars"></i>
        <div id="submenu" class="note hide">
            <span class="boutons"><img alt="Enviar correo de B-parts a la placa de Madrid" src="<?php echo $src."/img/b-parts-brand-logo.png"; ?>" id="mailBParts" title="Enviar un correo a la placa de Madrid indicando que llega un B-Parts">B-Parts</span>
            <span class="boutons"><img alt="Enviar correo de Jumasa a la placa de Madrid" src="<?php echo $src."/img/jumasa.png"; ?>" id="mailJumasa" title="Enviar un correo a la placa de Madrid indicando que llega un recambio de Jumasa">Jumasa</span>
            <span class="boutons" alt="Repere" id="repere" title="Localizar una referencia demiante un repere"><i class="fa-solid fa-arrow-down-up-across-line" style="font-size: x-large;"></i>Reperes</span>
            <span id="mailMostrador" class="boutons" alt="Enviar correo al mostrador" id="mailMostrador">
                <i class="fa-solid fa-store" style="font-size: x-large;"></i>
                Mostrador
                <menu name="submenuSendMailTo" id="submenu_mostrador" class="submenu_mostrador submenu_mostrador_hidden">
                    <p id="madrid" title="Enviar correo al mostrador de Madrid">MADRID</p>
                    <p id="santiago" title="Enviar correo al mostrador de Santiago">SANTIAGO</p>
                    <p id="malaga" title="Enviar correo al mostrador de Málaga (628 620 699)">MÁLAGA</p>
                    <p id="zaragoza" title="Enviar correo al mostrador de Zaragoza">ZARAGOZA</p>
                </menu>
            </span>
            <span class="boutons" alt="notas" id="notes" title="Notas"><i class="fa-solid fa-book" style="font-size: x-large;"></i>Notas</span>
            <span class="boutons" alt="calc" id="calc" title="OPR & CV>Kw"><i class="fa-solid fa-calculator" style="font-size: x-large;"></i>Calculadora</span>
            <span class="boutons" alt="configuracion" id="configBtn" title="Configuración"><i class="fa-solid fa-gear" style="font-size: x-large;"></i>Configuración</span>
            <span class="boutons" alt="logout" id="logout" title="Salir"><i class="fa-solid fa-arrow-right-from-bracket" style="font-size: x-large;"></i>Salir</span>
        </div>
    </div>
</header>
