<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$date = $contacts->getDatePending();
$date = date_create($date[0][0]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="PPCR, CITROEN, PEUGEOT, OPEL, PLACA DE RECAMBIOS, RECAMBIOS ORIGINALES">
    <meta name="author" content="Jesús Martín">
    <meta name="description" content="Listado de referencias pendientes de servir de clientes de PPCR">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../img/favicon/manifest.json" />
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link rel="stylesheet" href="../css/login1.css?101">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=captive_portal" />
    <script type="text/javascript" src="../js/pending.js?100" defer></script>   
    <title>PPCR (Placa de Piezas y Componentes de Recambio) Consulta de pendientes</title>
</head>
<body>
    <div class="logo">
        <a href="https://ppcr.es/pendientes" rel="noopener noreferrer">
            <img width="130px" height="79px" src="../img/Logo-PPCR-2022.png" alt="PPCR">
        </a>
    </div>
    <div class="top link">
        <a href="https://ppcr.stellantisandyou.es" target="_blank" rel="noopener noreferrer">
            Visita nuestra página web
            <span class="material-symbols-outlined">captive_portal</span>
        </a>
    </div>
    <div class="cuadro">
        <h2>Listado de pedidos pendientes PPCR España</h2>
        * Última actualización:  <?php echo date_format($date, "d/m/Y H:i"); ?>
        <form>
            <label for="placa" style="transform:translate(0px, 0px)">Placa PPCR</label>
            <label for="cliente">Cliente</label>
            <label for="envio"></label>
            <label for="referencia">Referencia</label>
            <label style="color:transparent;transform: translate(19px, 18px);">.</label>
            <select name="placa" id="placa">
                <option value="MADRID">Madrid</option>
                <option value="SEVILLA">Sevilla</option>
                <option value="VIGO">Galicia</option>
                <option value="GRANADA">Granada</option>
                <option value="ZARAGOZA">Zaragoza</option>
                <option value="PALMA">Palma</option>
                <option value="VALENCIA">Paterna</option>
                <option value="BARCELONA">Barcelona</option>
            </select>
            <input placeholder="Nº cliente" type="number" id="cliente">
            <input placeholder="D. envío" type="number" id="envio">
            <input placeholder="Referencia" type="text" id="referencia">
            <input type="submit" value="Consultar">
        </form>
        <div id="items"></div>
    </div>
    <footer>
        <div>
        Placas de Piezas y Componentes de Recambio PPCR <?php echo getdate()['year']; ?> 
        <a href="https://es.linkedin.com/company/ppcr-stellantis-you" class="facebook" aria-label="linkedin" data-tracking-label="linkedin" target="_blank">
                <svg focusable="false" class="svg-icon  hnf-svg-icon hnf-svg-icon--social" width="24" height="24" viewBox="0 0 24 24" fill="#243782" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.209 3C3.5413 3 3 3.5413 3 4.209v15.582C3 20.4587 3.5413 21 4.209 21h15.582c.6677 0 1.209-.5413 1.209-1.209V4.209C21 3.5413 20.4587 3 19.791 3H4.209zm4.3656 3.9963c0 .8717-.7066 1.5783-1.5783 1.5783S5.4179 7.868 5.4179 6.9963s.7067-1.5784 1.5784-1.5784 1.5783.7067 1.5783 1.5784zm4.1642 3.7611c.3022-.6044 1.315-1.3297 2.5522-1.276 1.5.065 2.0473.6696 2.3572 1.012l.0272.0299c.2945.3241.5037.9068.638 1.5448.0867.4118.0627 3.0216.0443 5.0201-.0044.4788-.0085.9226-.0107 1.2926h-2.6866v-5.0374c-.0223-.3582-.2237-1.2297-.9067-1.376-.8395-.1799-1.3097.0549-1.5783.3684-.403.4701-.4366 1.0746-.4366 1.4776v4.5672h-2.6866V9.7164h2.6866v1.041zm-7.0522 7.6232V9.7164H8.373v8.6642H5.6866z"></path>
                </svg>
            </a>
        </div>
    </footer>
    <i>* Datos obtenidos de BBDD Power Supply.</i>
</body>
</html>