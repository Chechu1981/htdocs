<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('./../helper/logon.php'); ?>
</head>
<body>
    <div id="menu">
        <?php include_once '../helper/menu.php'; ?>
    </div>
    <div class="search-table">
        <div id="contacts">
            <h1>Configuración.</h1>
            <h1>Actualización de clientes con rutas.</h1>
        </div>
        <div>
            <div id="dropContainer">
              <ol>
                <li>Extrae el fichero de ICAR con estos campos y en el siguente orden:
                <p style="font-size: 0.65em">Ultima Factura (Emp) |	Cliente (Cód) |	Núm. Dirección |	Tel. Profesional	| Cliente (Razón) |	Dirección |	Dirección envío	| Población |	Provincia |	C.Postal	| Turno Almacén U	| Turno Almacén | N	Agrupación | Clientes (Almacén) |	Vendedor Almacén (Cliente) |	E-mail Profesional |	CIF</p>
                </li>
                <li>Cambia la primera columna <i>"Ultima Factura (Emp)"</i> por las iniciales del centro (GRA,SEV,PAL,MAD,VAL,VIG,ZAR)</li>
                <li>Convierte el excel a fichero CSV separado por comas.</li>
                <li>Arrástralo en esta zona y pulsa <i>ACTUALIZAR</i>.</li>
              </ol>
            </div>
            <form style="text-align: center">
                <input type="file" name="pending" id="pending" style="display:none">
                <input type="submit" value="Actualizar" style="font-size: xx-large;margin:10px">
            </form>
        </div>
    </div>
    <?php include('../helper/footer.php'); ?>
</body>
</html>