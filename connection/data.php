<?php

include_once 'connection.php';

class Contacts
{
    protected $db;

    public function __construct() {
      $this->db = Db::conectar();
    }

    public function getUser($usr, $psw){
        $hash = md5(strtotime("now"));
        $sqlUpdate = "UPDATE `usuarios` SET `hash` = '$hash' WHERE nombre LIKE '$usr' AND clave LIKE '$psw'";
        $query = $this->db->prepare($sqlUpdate);
        $query->execute();
        $sql = "SELECT DISTINCT * FROM `usuarios` WHERE nombre LIKE '$usr' AND clave LIKE '$psw'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUserExist($user){
        $sql = "SELECT * FROM `usuarios` WHERE nombre LIKE '$user'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUserList(){
        $sql = "SELECT * FROM `usuarios` ORDER BY `puesto`,`nombre`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUserBySessid($sessid){
        $sql = "SELECT DISTINCT * FROM `usuarios` WHERE hash LIKE '$sessid'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUserById($id){
        $sql = "SELECT * FROM `usuarios` WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getProvById($id){
        $sql = "SELECT * FROM `proveedores` WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getMailByUsername($userName){
        $sql = "SELECT DISTINCT `mail` FROM `usuarios` WHERE `nombre` = '$userName'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getMailBySsid($ssid){
        $sql = "SELECT DISTINCT `mail` FROM `usuarios` WHERE `hash` = '$ssid'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllUsers(){
        $sql = "SELECT DISTINCT * FROM `usuarios` ORDER BY `nombre` ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function deleteUser($id){
        $sql = "DELETE FROM `usuarios` WHERE id = '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function deleteProv($id){
        $sql = "DELETE FROM `proveedores` WHERE id = '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function addNewProv($name,$addres,$nprov,$email){
        $sql = "INSERT INTO `proveedores` (`nombre`, `direccion`, `mail`,`nprov`) VALUES 
            ('$name', '$addres', '$email','$nprov')";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function addNewUser($user,$pass,$puesto,$email){
        $sql = "INSERT INTO `usuarios` (`nombre`, `clave`, `puesto`,`theme`,`mail`) VALUES ('$user', '$pass', '$puesto','blue','$email')";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function updateUser($id,$user,$pass,$puesto,$email){
        $sql = "UPDATE `usuarios` SET 
        `nombre` = '$user', 
        `clave` = '$pass', 
        `puesto` = '$puesto',
        `mail` = '$email' 
        WHERE `id` = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function updateProv($id,$name,$addres,$nprov,$email){
        $sql = "UPDATE `proveedores` SET 
        `nombre` = '$name', 
        `nprov` = '$nprov', 
        `direccion` = '$addres',
        `mail` = '$email' 
        WHERE `id` = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function updateColorTheme($user){
        $sql = "UPDATE `usuarios` SET `theme` = '$user' WHERE `nombre` = '$user'";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function getContacts($search){
        $sql = "SELECT * FROM `route`, `rutas` WHERE route.TURN = rutas.TURN AND route.name LIKE '%$search%'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }

    public function getContactsHTML($search){
        $sql = "SELECT * FROM `route`, `rutas` 
        WHERE route.TURN = rutas.TURN
        AND  
        name LIKE '%$search%' 
        OR addres LIKE '%$search%'
        OR city LIKE '%$search%'
        OR state LIKE '%$search%'
        OR phone LIKE '%$search%'
        OR center LIKE '%$search%'
        GROUP BY addres
        ORDER BY city ASC
        LIMIT 100";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getMailProv($proveedor){
        $sql = "SELECT DISTINCT correo_prov FROM `cesiones` WHERE refClient LIKE '$proveedor' AND origen LIKE 'EXT' ORDER BY `id` DESC LIMIT 1;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateRoute($id,$corte,$salida){
        $sql = "UPDATE rutas 
            SET `CORTE` = '$corte',
            `SALIDA` = '$salida'
             WHERE id = '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function removeRoute($id){
        $sql = "DELETE FROM rutas WHERE id = '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function addNewRoute($centro,$nombre,$cutt,$salida){
        $sql = "INSERT INTO `rutas`(`CENTRO`, `Turn`, `CORTE`, `SALIDA`) VALUES('$centro','RUTA $nombre','$cutt','$salida')";
        $query = $this->db->prepare($sql);
        $query->execute();
        echo 'ok';
    }

    public function getTyres($search){
        $sql = "SELECT *,CONCAT_WS('',`ANCHO`,`PERFIL`,`RADIO`,`CODCARGA`,`INDICE VELOCIDAD`) AS `search` 
            FROM `tyres` 
            WHERE CONCAT_WS('',`ANCHO`,`PERFIL`,`RADIO`,`CODCARGA`,`INDICE VELOCIDAD`) LIKE '%$search%'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }

    public function getTyresHTML($width,$height,$diameter,$load_code,$speed_index){
        $sql = "SELECT * FROM `tyres` WHERE `ANCHO` = '$width' AND `PERFIL` = '$height' AND `RADIO` = '$diameter' AND `CODCARGA` = '$load_code' AND `INDICE VELOCIDAD` = '$speed_index'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getRoutesHTML($search){
        $sql = "SELECT DISTINCT 
          route.code,
          rutas.CENTRO,
          rutas.CORTE,
          rutas.SALIDA,
          route.name,
          route.phone,
          route.addres,
          route.city,
          route.state,
          rutas.turn 
          FROM `route`, `rutas` 
          WHERE route.TURN = rutas.TURN 
          AND route.center = rutas.CENTRO 
          AND code LIKE '$search%' 
          ORDER BY LENGTH(route.code), route.code ASC LIMIT 100";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getClientHTML($search){
        $sql = "SELECT DISTINCT `code`,`center`,`cutt`,`exit`,`name`,`phone`,`addres`,`city`,`state`,`turn` FROM route WHERE 
        name LIKE '%$search%' 
        OR addres LIKE '%$search%'
        OR city LIKE '%$search%'
        OR state LIKE '%$search%'
        OR phone LIKE '%$search%'
        ORDER BY LENGTH(code), code ASC LIMIT 100";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getClientById($id){
        $sql = "SELECT * FROM `clientes` WHERE id = '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getRepereHTML($ref){
        $ref = ltrim($ref,"0");
        $sql = "SELECT DISTINCT * FROM `repere` WHERE REPLACE(LTRIM(REPLACE(`Referencia_fabricación`,'0',' ')),' ','0') = '".$ref."'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getPassHTML($ref, $tipo, $mail){
        $placa = $tipo;
        if($tipo == 'TODOS')
            $placa = '%';
        $btn = $ref;
        if(substr($ref,0,3) == 'btn')
            $btn = substr($ref,3);

        if(substr($ref,0,3) == 'btn'){
            $sql = "SELECT * FROM `neumaticos` WHERE 
            `tipo` LIKE '$btn' AND (`propietario` LIKE '$mail' OR `propietario` LIKE '')
            INTERSECT
            SELECT * FROM `neumaticos` WHERE
            `placa` LIKE '$placa'
            OR `placa` = ''
            ORDER BY `marca` ASC";
        }else if($tipo != 'TODOS'){
            $sql = "SELECT * FROM `neumaticos` WHERE 
            `marca` LIKE '%$btn%' AND (`propietario` LIKE '$mail' OR `propietario` LIKE '')
            OR `usuario` LIKE '%$btn%'
            OR `tlf` LIKE '%$btn%'
            OR `cuenta` LIKE '%$btn%'
            OR `tipo` LIKE '%$btn%'
            INTERSECT
            SELECT * FROM `neumaticos` WHERE
            `placa` = '$placa' AND (`propietario` LIKE '$mail' OR `propietario` LIKE '')
            OR `placa` = ''
            ORDER BY `marca` ASC";
        }else{
            $sql = "SELECT * FROM `neumaticos` WHERE 
            (`marca` LIKE '%$btn%'
            OR `usuario` LIKE '%$btn%'
            OR `tlf` LIKE '%$btn%'
            OR `cuenta` LIKE '%$btn%'
            OR `placa` LIKE '%$btn%'
            OR `tipo` LIKE '%$btn%') AND (`propietario` LIKE '$mail' OR `propietario` LIKE '')
            ORDER BY `marca` ASC";
        }
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newPass($item){
        $sql = "INSERT INTO `neumaticos` (`marca`,`placa`,`cuenta`,`usuario`,`pass`,`web`,`tlf`,`consultausr`,`consultapwd`,`tipo`,`propietario`) VALUES 
        ('$item[1]','$item[2]','$item[3]','$item[4]','$item[5]','$item[6]','$item[7]','','','$item[8]','$item[9]')";
        $query = $this->db->prepare($sql);  
        $query->execute();
        return "ok";
    }

    public function updatePass($item){
        foreach($item as $campos)
            
        $sql = "UPDATE `neumaticos` SET 
            `marca`= '$item[1]',
            `placa` = '$item[2]',
            `cuenta` = '$item[3]',
            `usuario` = '$item[4]',
            `pass` = '$item[5]',
            `web` = '$item[6]',
            `tlf` = '$item[7]',
            `tipo` = '$item[8]',
            `propietario` = '$item[9]'
            WHERE id LIKE $item[0]";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "ok";
    }

    public function deletePass($item){
        $sql = "DELETE FROM `neumaticos` WHERE `id` LIKE $item";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "¡¡Eliminado!!";
    }

    public function getPassId($id){
        $sql = "SELECT * FROM `neumaticos` WHERE 
            `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newAssig($items){
        $sql = "INSERT INTO `cesiones`
            (`origen`, `destino`, `cliente`, `ref`, `pvp`, `pedido`, `envio`, `recibido`, `cantidad`, `usuario`,`comentario`, `refClient`, `fragil`, `tratado`) 
            VALUES
            ('$items[0]','$items[1]','$items[2]','$items[3]','$items[4]','$items[5]','$items[6]','0000-00-00',$items[7], '$items[8]', '$items[9]','',FALSE, '$items[10]')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "ok";
    }

    public function newAssigADV($items){
        $fragil = 0;
        if($items[8] == 'true'){
           $fragil = 1;
        }
        $sql = "INSERT INTO `cesiones`
            (`origen`, `destino`, `cliente`, `refClient`, `comentario`, `ref`, `pvp`, `cantidad`, `fragil`, `usuario`, `pedido`, `recibido`, `envio`, `tratado`) 
            VALUES
            ('$items[0]','$items[1]','$items[2]','$items[3]','$items[4]','$items[5]','$items[6]', '$items[7]' , $fragil, '$items[9]', '', '0000-00-00', '0000-00-00 00:00:00', '$items[10]')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function newAssigADV2023($items){
        $fragil = 0;
        if($items[8] == 'true'){
           $fragil = 1;
        }
        $sql = "INSERT INTO `cesiones`
            (`origen`, 
            `destino`, 
            `cliente`, 
            `refClient`, 
            `comentario`, 
            `ref`, 
            `pvp`, 
            `cantidad`, 
            `fragil`, 
            `usuario`, 
            `pedido`, 
            `recibido`, 
            `envio`, 
            `nfm`, 
            `disgon`, 
            `designacion`, 
            `nombreCliente`, 
            `tratado`, 
            `puesto`,
            `correo_prov`) 
            VALUES
            ('$items[0]',
            '$items[1]',
            '$items[2]',
            '$items[3]',
            '$items[4]',
            '$items[5]',
            '$items[6]', 
            '$items[7]' , 
            $items[8], 
            '$items[10]', 
            '$items[11]', 
            '0000-00-00', 
            '0000-00-00 00:00:00', 
            $items[9], 
            $items[12], 
            '$items[13]', 
            '$items[14]', 
            '$items[15]', 
            '$items[16]',
            '$items[17]')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function deleteAssigADV($item,$puesto){
        $sql = "DELETE FROM `cesiones` WHERE `id` LIKE $item AND (`tratado` LIKE '$puesto' OR `usuario` LIKE '$puesto')";
        if($puesto == 'ADV')
            $sql = "DELETE FROM `cesiones` WHERE `id` LIKE $item";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $sql;
    }

    public function getAssig($all,$usr,$puesto = null,$origen,$destino,$asegurado){
        $order = " ORDER BY `id` DESC LIMIT 100";
        $asegurado === 'true' ? $asegurado = "(`disgon` = 1 OR `disgon` = 2) AND ": $asegurado = "";
        $origen != '' ? $origen = "`origen` = '$origen' AND ": $origen = "";
        $destino != '' ? $destino = "`destino` = '$destino' AND ": $destino = "";
        $sql = "SELECT * FROM `cesiones` WHERE (
                $origen
                $destino
                $asegurado
                `rechazado` = false) AND (
                REPLACE(`ref`,' ','') LIKE '%$all%' OR
                `refClient` LIKE '%$all%' OR
                `cliente` LIKE '%$all%' OR
                `comentario` LIKE '%$all%' OR
                `pedido` LIKE '%$all%')";
        if($all == 'all')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` NOT LIKE '0000-00-00' AND `rechazado` = false AND (`usuario` = '$usr' OR `tratado` = '$usr')";
        elseif($all == 'new')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `rechazado` = false AND (`usuario` = '$usr' OR `tratado` = '$usr' OR `puesto` = '$usr')";            
        elseif($all == 'stop' AND $puesto != 'ADV')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `rechazado` = true AND (`usuario` = '$usr' OR `tratado` = '$usr' OR `puesto` = '$usr')";
        elseif($all == 'stop' AND $puesto == 'ADV')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `rechazado` = true";
        $sql .= $order;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAssigCount($usr){
      $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `envio` NOT LIKE '0000-00-00 00:00:00' AND `recibido` LIKE '0000-00-00' AND (`usuario` = '$usr' OR `puesto` = '$usr')";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

    public function getAssigCountNew($usr,$puesto,$state){
        $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `envio` LIKE '0000-00-00 00:00:00' AND `recibido` LIKE '0000-00-00' AND `rechazado` = false AND`usuario` = '$usr'";
        if($puesto == 'ADV')
            $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `envio` LIKE '0000-00-00 00:00:00' AND `rechazado` = false AND `recibido` LIKE '0000-00-00' AND (`usuario` = '$usr' OR `tratado` = '$usr')";
        if($state == 'ready')
            $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `rechazado` = false AND (`usuario` = '$usr' OR `puesto` = '$puesto')";
        if($state == 'all')
            $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `envio` LIKE '0000-00-00 00:00:00' AND `rechazado` = false AND `recibido` LIKE '0000-00-00'";
        if($state == 'ready' AND $puesto == 'ADV')
            $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `rechazado` = false AND (`usuario` = '$usr' OR `tratado` = '$usr')";
        if($puesto == 'DESBORDE')
            $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `envio` LIKE '0000-00-00 00:00:00' AND `rechazado` = false AND `recibido` LIKE '0000-00-00' AND (`usuario` = '$usr' OR `tratado` = '$usr')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAssigPending($all, $usr){
        $sql = "SELECT * FROM `cesiones` WHERE 
        `ref` LIKE '%$all%' OR
        `origen` LIKE '%$all%' OR
        `destino` LIKE '%$all%' OR
        `cliente` LIKE '%$all%'OR
        `comentario` LIKE '%$all%' AND
        `rechazado` = false AND
        `pedido` = '' AND
        (`usuario` = '$usr' OR `tratado` = '$usr')
        ORDER BY `destino`, `origen` DESC 
        LIMIT 100";
        if ($all == 'all')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` NOT LIKE '0000-00-00' AND `envio` LIKE '0000-00-00 00:00:00' AND `rechazado` = false AND (`usuario` = '$usr' OR `tratado` = '$usr') ORDER BY `origen`, `destino` DESC ";
        elseif ($all == 'new' AND $usr != 'all')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `envio` LIKE '0000-00-00 00:00:00' AND `rechazado` = false AND (`usuario` = '$usr' OR `tratado` = '$usr') ORDER BY `origen`, `destino` DESC ";
        elseif ($all == 'new' AND $usr = 'all')
            $sql = "SELECT * FROM `cesiones` WHERE `envio` LIKE '0000-00-00 00:00:00' AND `rechazado` = false ORDER BY `origen`, `destino` DESC ";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAssigLast(){
        $sql = "SELECT * FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `envio` LIKE '0000-00-00 00:00:00' ORDER BY `id` DESC LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function esTratado($id){
        $sql = "SELECT * FROM `cesiones` WHERE `id` LIKE '$id' AND `tratado` NOT LIKE ''";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getZzmat($id){ 
        $sql = "SELECT * FROM `cesiones` WHERE `id` = '$id' LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newSelectPending($ip,$placa,$cliente,$referencia,$envio,$nombre){
        $sql = "INSERT INTO `statusPending` (`ip`,`plate`,`NumClient`,`ref`,`dirClient`,`date`,`free1`) 
        VALUES ('$ip','$placa','$cliente','$referencia','$envio',CURRENT_TIMESTAMP(),'$nombre')";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function selectsClientPending($day){
        $sql = "SELECT *,CONCAT(YEAR(`date`),MONTH(`date`),LPAD(DAY(`date`),2,'0')) AS 'dateNum' FROM `statusPending` WHERE CONCAT(YEAR(`date`),MONTH(`date`),LPAD(DAY(`date`),2,'0')) LIKE '$day'  ORDER BY `id` DESC;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function selectsClientPendingGroupDay(){
        $sql = "SELECT CONCAT(LPAD(DAY(`date`),2,'0'),'/',MONTH(`date`),'/',YEAR(`date`)),COUNT(*),CONCAT(YEAR(`date`),MONTH(`date`),LPAD(DAY(`date`),2,'0')) AS `num` FROM `statusPending` GROUP BY `num` ORDER BY `id` DESC;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function assigStatus($user){
        $sql = "SELECT COUNT(*),CONCAT(DAY(envio),'/',MONTH(envio),'/',YEAR(envio)) AS `fecha`, `usuario` 
            FROM `cesiones` 
            WHERE `usuario` LIKE '$user' 
            GROUP BY  YEAR(envio),MONTH(envio), DAY(envio) 
            ORDER BY `id` DESC LIMIT 90";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function assignStatusByPlate($dateIn, $dateOut){
        $sql = "SELECT COUNT(`origen`) AS `vol`,`origen` FROM `cesiones` WHERE `envio` BETWEEN '$dateIn' AND '$dateOut' GROUP BY `origen` ORDER BY `id` DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAssigStatusByPlateDestination($dateIn, $dateOut){
        $sql = "SELECT COUNT(`destino`) AS `vol`,`destino` FROM `cesiones` WHERE `envio` BETWEEN '$dateIn' AND '$dateOut' GROUP BY `destino` ORDER BY `id` DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateAssig($id){
        $sql = "UPDATE `cesiones` SET `recibido`= NOW() WHERE `id`= $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function updateAssigDeclane($id){
        $sql = "UPDATE `cesiones` SET `rechazado`= false WHERE `id`= $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function updateAssigADV($id,$value,$pedido,$envio,$pvp){
        $fecha = date("Y-m-d H:i:s");
        if($envio == 'true')
            $sql = "UPDATE `cesiones` SET `pvp` = '$pvp', `pedido` = '$pedido', `fragil` = $value, `envio` = '$fecha' WHERE `id` LIKE '$id'";
        else
            $sql = "UPDATE `cesiones` SET `pvp` = '$pvp', `pedido` = '$pedido', `fragil` = $value WHERE `id` LIKE $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function updateAssigADVall($id,$fragil,$envio,$nfm,$pedido,$tratado,$origenBtn,$destinoBtn,$origen,$disgon){
        $fecha = date("Y-m-d H:i:s");
        if($envio == 'true')
            $sql = "UPDATE `cesiones` SET `origen` = '$origen', `disgon` = $disgon, `nfm` = $nfm, `fragil` = $fragil, `envio` = '$fecha', `emisor` = $origenBtn, `receptor` = $destinoBtn, `pedido` = '$pedido', `tratado` = '$tratado' WHERE `id` LIKE '$id'";
        else
            $sql = "UPDATE `cesiones` SET `origen` = '$origen', `disgon` = $disgon, `nfm` = $nfm, `fragil` = $fragil, `pedido` = '$pedido', `emisor` = $origenBtn, `receptor` = $destinoBtn, `tratado` = '$tratado' WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function enviarDisgon($id){
        $sql = "UPDATE `cesiones` SET `envioDisgon` = true WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function updateRechazo($id,$switch,$texto,$tratado){
        $sql = "UPDATE `cesiones` SET `tratado` = '$tratado', `rechazado` = $switch, `motivo` = '$texto' WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function is_send($id){
        $sql = "SELECT * FROM `cesiones` WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateAssigADV2023($id,$fragil,$envio,$nfm,$pedido,$tratado,$origenBtn,$destinoBtn,$origen,$proveedorExterno,$disgon,$comentario){
        $fecha = date("Y-m-d H:i:s");
        if($proveedorExterno != '')
            $sql = "UPDATE `cesiones` SET `origen` = '$origen', `disgon` = $disgon, `nfm` = $nfm, `fragil` = $fragil, `emisor` = $origenBtn, `receptor` = $destinoBtn, `pedido` = '$pedido', `tratado` = '$tratado', `comentario` = '$comentario', `refClient` = '$proveedorExterno' WHERE `id` LIKE '$id'";
        else if($envio == 'true')
            $sql = "UPDATE `cesiones` SET `origen` = '$origen', `disgon` = $disgon, `nfm` = $nfm, `fragil` = $fragil, `envio` = '$fecha', `emisor` = $origenBtn, `receptor` = $destinoBtn, `pedido` = '$pedido', `tratado` = '$tratado', `comentario` = '$comentario' WHERE `id` LIKE '$id'";
        else
            $sql = "UPDATE `cesiones` SET `origen` = '$origen', `disgon` = $disgon, `nfm` = $nfm, `fragil` = $fragil, `pedido` = '$pedido', `emisor` = $origenBtn, `receptor` = $destinoBtn, `tratado` = '$tratado', `comentario` = '$comentario' WHERE `id` LIKE '$id'";
        echo $sql;
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function updateComentAssigADV2023($id,$coment){
        $sql = "UPDATE `cesiones` SET  `comentario` = '$coment' WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function getNotes(){
        $sql = "SELECT `id`, CONVERT(`notes` USING utf8) FROM `blackboard`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function saveNotes($txt,$id){
        $sql = "UPDATE `blackboard` SET `notes` = '$txt' WHERE `id`= $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function getNotebook($search){
        $sql = "SELECT DISTINCT * FROM `libreta` WHERE 
        `marca` LIKE '%$search%' OR
        `modelo` LIKE '%$search%' OR
        `descripcion` LIKE '%$search%' OR
        `referencia` LIKE '%$search%'
        ORDER BY `marca`,`modelo`,`descripcion` ASC LIMIT 100";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getNotebookId($id){
        $sql = "SELECT DISTINCT * FROM `libreta` WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newNotebook($item){
        $sql = "INSERT INTO `libreta` (`marca`,`modelo`,`descripcion`,`referencia`,`file`) VALUES 
        ('$item[0]','$item[1]','$item[2]','$item[3]','$item[4]')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "ok";
    }

    protected function deleteFile($id){
        $sql1 = "SELECT `file` FROM `libreta` WHERE `id` LIKE $id";
        $query1 = $this->db->prepare($sql1);
        $query1->execute();
        $filename = $query1->fetchAll();
        @unlink('../docs/'.$filename[0][0]);
        @unlink('../docs/thumb_'.$filename[0][0]);
    }

    public function eraseFile($id){
        $this->deleteFile($id);
    }

    public function deleteNotebook($item){
        $this->deleteFile($item);
        $sql = "DELETE FROM `libreta` WHERE `id` LIKE $item";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "¡¡Eliminado!!";
    }

    public function updateNotebook($item){
        $sql = "UPDATE `libreta` SET 
            `marca`= '$item[1]',
            `modelo` = '$item[2]',
            `descripcion` = '$item[3]',
            `referencia` = '$item[4]',
            `file` = '$item[5]'
            WHERE id LIKE $item[0]";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function getCenter($center,$search){
        $tlf = str_replace(" ","",$search);
        if(strtoupper($center) == 'CENTROS')
            $center = '%%';
        $sql = "SELECT * FROM `centros` WHERE `A` LIKE '$center' AND 
        (`C` LIKE '%$search%' OR
        `B` LIKE '%$search%' OR
        `D` LIKE '%$search%' OR
        `E` LIKE '%$search%' OR
        REPLACE(`F`,' ','') LIKE '%$search%' OR
        REPLACE(`G`,' ','') LIKE '%$search%' OR
        REPLACE(H,' ','') LIKE '%$tlf' OR
        `I` LIKE '%$search%' OR
        `J` LIKE '%$search%') 
        ORDER BY `A`,`B`,`C`,`E`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllCenter($id){
        $sql = "SELECT * FROM `centros` WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function deleteContact($id) {
        $sql = "DELETE FROM `centros` WHERE `id` LIKE $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "¡¡Eliminado!!";
    }

    public function updateContacts($item){
        $sql = "UPDATE `centros` SET 
            `A`= '$item[1]',
            `B` = '$item[2]',
            `C` = '$item[3]',
            `D` = '$item[4]',
            `E` = '$item[5]',
            `F` = '$item[6]',
            `G` = '$item[7]',
            `H` = '$item[8]',
            `I` = '$item[9]',
            `J` = '$item[10]'
            WHERE id LIKE $item[0]";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "ok";
    }

    public function newContact($item){
        $sql = "INSERT INTO `centros` (`A`,`B`,`C`,`D`,`E`,`F`,`G`,`H`,`I`,`J`) VALUES 
        ('$item[0]','$item[1]','$item[2]','$item[3]','$item[4]','$item[5]','$item[6]','$item[7]','$item[8]','$item[9]')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "ok";
    }

    public function getTheme($usr){
        $sql = "SELECT DISTINCT theme FROM `usuarios` WHERE nombre LIKE '$usr'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getProvExt(){
        $src = "SELECT * FROM `proveedores` ORDER BY `nombre` ASC";
        $query = $this->db->prepare($src);
        $query->execute();
        return $query->fetchAll();
    }

    public function getProvList(){
        $sql = "SELECT * FROM `proveedores` ORDER BY `nombre` ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function setColor($color,$usr){
        $sql = "UPDATE usuarios SET theme = '$usr' WHERE nombre = '$usr'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $color . ' ' . $usr;
    }

    public function getRoutesName($route) {
        $sql = "SELECT * FROM rutas WHERE `Turn` LIKE '%$route%' ORDER BY 'CENTRO' ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function addRepere($repere, $referencia){
        $sql = "INSERT INTO `repere`(`Referencia_fabricación`, `Referencia`) VALUES ('$repere','$referencia')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function getSoc($search,$page){
        $sql = "SELECT * FROM `distrigo_SO` WHERE 
        `nombre` LIKE '%$search%' OR
        `A` LIKE '%$search%' OR
        `CIF` LIKE '%$search%' OR
        `poblacion` LIKE '%$search%' OR
        `RRDI` LIKE '%$search%' OR
        `nombre` LIKE '%$search%' LIMIT $page,100";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function deleteSoc($id){
        $sql = "DELETE FROM `distrigo_SO` WHERE `id` = '$id'";
        $query = $this->db->query($sql);
        $query->execute();
        return 'ok';
    }

    public function newSoc($items){
        $sql = "INSERT INTO `distrigo_SO` (`placa`, `A`, `CIF`, `RRDI`, `nombre`) VALUES (
            '$items[0]', '$items[1]', '$items[2]', '$items[3]', '$items[4]')";
        $query = $this->db->query($sql);
        $query->execute();
        return 'ok';
    }

    public function updateSoc($item){
        $sql = "UPDATE `distrigo_SO` SET 
            `A`= '$item[1]',
            `RRDI` = '$item[2]',
            `nombre` = '$item[3]',
            `CIF` = '$item[4]',
            `cp` = '$item[5]',
            `poblacion` = '$item[6]',
            `RAZON` = '$item[7]',
            `placa` = '$item[8]'
            WHERE id LIKE $item[0]";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "ok";
    }

    public function updatePending($items){
        try{
            $queryClear = $this->db->prepare("DELETE FROM `pendientes`");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `pendientes`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `fentrega`, `comentario`, `cesion`) VALUES ";
                foreach ($row as $rows) {
                    $fecha = $rows["fecha"];
                    $cuenta = $rows["cuenta"];
                    $nombre = str_replace("'","`",$rows["nombre"]);
                    $referencia = $rows["referencia"];
                    $designacion = str_replace("'","`",$rows["designacion"]);
                    $fiabilidad = $rows["fiabilidad"];
                    $placa = $rows["placa"];
                    $aviso = $rows["aviso"];
                    $vin = $rows["vin"];
                    $cantidad = $rows["cantidad"];
                    $npedido = $rows["npedido"];
                    $fentrega = $rows["fentrega"];
                    $comentario = $rows["comentario"];
                    $cesion = $rows["cesion"];
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$fentrega','$comentario','$cesion'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            $sqlDate = "UPDATE `pendientes` SET `fentrega` = NOW() WHERE `referencia` LIKE 'Referencia'";
            $queryDate = $this->db->query($sqlDate);
            $queryDate->execute();
            return "Fichero Actualizado!!";
        }catch(Exception $e){
            return $e;
        }
    }

    public function getPending($placa, $cliente, $referencia,$envio){
        $sqlreferencia = "";
        $sqlcuenta = "";
        //Todos los Stellantis & You sin placa asignada
        if($cliente == '5000'){
            $placa = '%%';
            $cliente = "2189' 
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '2187' 
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '2195'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '11412'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '44813'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '86417'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '11413'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '11414'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '2177'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '34807'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '45201'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '48810'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '42123'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '44728'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '8679'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '8680'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '6760'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '8678'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '20674'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '5776'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '5777'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '7780'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '7779'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '2063'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '2051'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '8322'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '50533'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '50531'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '50532'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '50581'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '112526'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '50846'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '26265'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '6358'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '6365'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '7611'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '6364'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '10023'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '8742'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '21444'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '87239'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '87242'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '87261'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '42199'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '43282'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '9301'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '112906'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '9302'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '2203'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '13400'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '39421'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '8970'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '8963'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '78569'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '68655'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '123233'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '123234'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '93206'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '112636'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '68914'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '79130'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '76111'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '76113'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '70183";
        }
        //Stellantis & You 2195 de Madird
        if($cliente == '1000')
            $cliente = "2195'
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '11412'  
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '86417' 
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '44813' 
                OR SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '112636";

        if($envio > 0)
            $sqlcuenta = "AND (SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '$cliente') AND SUBSTRING_INDEX(pendientes.cuenta,'-',-1) LIKE '$envio'";
        
        if($envio == 0)
            $sqlcuenta = "AND (SUBSTRING_INDEX(pendientes.cuenta,'-',-1) LIKE '$cliente')";
        
        if($envio == '')
            $sqlcuenta = "AND (SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '$cliente')";
        
        if($referencia != "")
            $sqlreferencia = "AND pendientes.referencia LIKE '$referencia'";
        
        $sql = "SELECT *, STR_TO_DATE(`fecha`,'%d/%m/%Y') AS 'date' FROM `pendientes` 
        WHERE pendientes.placa LIKE '$placa' 
        $sqlcuenta $sqlreferencia 
        ORDER BY `date` DESC, pendientes.referencia ASC;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getDatePending(){
        $sql = "SELECT `fentrega` FROM `pendientes` WHERE `referencia` LIKE 'Referencia'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getSendClient($cliente,$placa){
        $sql = "SELECT DISTINCT SUBSTRING_INDEX(clientes.code,'-',-1) AS 'envio', clientes.denvio FROM `pendientes`,`clientes` WHERE clientes.code = pendientes.cuenta AND SUBSTRING_INDEX(pendientes.cuenta,'-',1) LIKE '$cliente' AND clientes.placa LIKE SUBSTRING('$placa',1,3) ORDER BY CAST(envio AS INTEGER) ASC;";
        $query = $this->db->prepare($sql);
        $query->execute();
        
        return json_encode($query->fetchAll());
    }

    public function formatRef($ref){
        $long = strlen($ref);
        if($long == 6)
            return substr($ref,0, 4) . ' ' . substr($ref,4);
        else if($long == 10)
            return substr($ref,0, 2) . ' ' . substr($ref,2,3) . ' ' . substr($ref,5,3) . ' ' . substr($ref,8);
        else
            return $ref;
    }

    public function updateInmovilment($items){
        try{
            $placaDelete = $items[1]['placa'];
            $queryClear = $this->db->prepare("DELETE FROM `inmovilizados` WHERE `placa` = '$placaDelete'");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `inmovilizados`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `prioridad`, `libre`,`reemplazamiento`,`marcado`, `marca`,`sap`) VALUES ";
                foreach ($row as $rows) {
                    $fecha = $rows["fecha"];
                    $cuenta = $rows["cuenta"];
                    $nombre = str_replace("'","`",$rows["nombre"]);
                    $referencia = $rows["referencia"];
                    $designacion = str_replace("'","`",$rows["designacion"]);
                    $fiabilidad = $rows["fiabilidad"];
                    $placa = $rows["placa"];
                    $aviso = $rows["aviso"];
                    $vin = $rows["vin"];
                    $cantidad = $rows["cantidad"];
                    $npedido = $rows["npedido"];
                    $fentrega = $rows["fentrega"];
                    $prioridad = $rows["prioridad"];
                    $fecha_act = $rows["fecha_act"];
                    $reemplazamiento = $rows["reemplazamiento"];
                    $marcado = $rows["marcado"];
                    $marca = $rows["marca"];
                    $sap = $rows["sap"];
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$prioridad','$fecha_act','$reemplazamiento','$marcado', '$marca','$sap'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            return "ok";
        }catch(Exception $e){
            return $e;
        }
    }

    public function updateInmovilmentRef($items){
        try{
            $placaDelete = $items[1]['placa'];
            $queryClear = $this->db->prepare("DELETE FROM `referenciados` WHERE `placa` = '$placaDelete'");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `referenciados`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `prioridad`, `libre`,`reemplazamiento`,`marcado`, `marca`, `comentario`, `sap`) VALUES ";
                foreach ($row as $rows) {
                    $fecha = $rows["fecha"];
                    $cuenta = $rows["cuenta"];
                    $nombre = str_replace("'","`",$rows["nombre"]);
                    $referencia = $rows["referencia"];
                    $designacion = str_replace("'","`",$rows["designacion"]);
                    $fiabilidad = $rows["fiabilidad"];
                    $placa = $rows["placa"];
                    $aviso = $rows["aviso"];
                    $vin = $rows["vin"];
                    $cantidad = $rows["cantidad"];
                    $npedido = $rows["npedido"];
                    $fentrega = $rows["fentrega"];
                    $prioridad = $rows["prioridad"];
                    $fecha_act = $rows["fecha_act"];
                    $reemplazamiento = $rows["reemplazamiento"];
                    $marcado = $rows["marcado"];
                    $marca = $rows["marca"];
                    $comentario = $rows['comentario'];
                    $sap = $rows['sap'];
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$prioridad','$fecha_act','$reemplazamiento','$marcado', '$marca', '$comentario', '$sap'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            return "ok";
        }catch(Exception $e){
            return $e;
        }
    }

    public function updatePriorityInmov($id,$priority,$name){
      $sql = "UPDATE `inmovilizados` SET `prioridad`='$priority', `marcado`='$name' WHERE `id`='$id'";
      $query = $this->db->prepare($sql);
      $query->execute();
      echo "OK";
    }

    public function getPauseAssign($id){
        $sql = "SELECT * FROM `cesiones` WHERE `id`='$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updatePauseAssign($id){
        $oldSql = "SELECT `pause` FROM `cesiones` WHERE `id`='$id'";
        $oldQuery = $this->db->prepare($oldSql);
        $oldQuery->execute();
        $oldPause = $oldQuery->fetchAll();
        $oldPause = $oldPause[0]['pause'];
        if($oldPause == 1)
            $sql = "UPDATE `cesiones` SET `pause`=0 WHERE `id`='$id'";
        else
            $sql = "UPDATE `cesiones` SET `pause`=1 WHERE `id`='$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        echo "OK";
    }

    public function getLastFile($placa,$ref){
        $referencia = '';
        if($ref != '')
            $referencia = "AND `referencia` = '$ref'";
        $sql = "SELECT * FROM `inmovilizados` WHERE `placa` = '$placa' ".$referencia." ORDER BY `referencia`, STR_TO_DATE(`fecha`,'%d/%m/%Y'),`npedido`, `prioridad`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getLastRefFile($placa, $ref){
        $referencia = '';
        if($ref != '')
            $referencia = "AND `referencia` = '$ref'";
        $sql = "SELECT * FROM `referenciados` WHERE `placa` = '$placa' ".$referencia." ORDER BY `referencia`, STR_TO_DATE(`fecha`,'%d/%m/%Y'),`npedido`, `prioridad`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateSortInmov($items,$placaGet){
        try{
            $queryClear = $this->db->prepare("DELETE FROM `shortInmv` WHERE `placa` = '$placaGet'");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `shortInmv`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `prioridad`, `libre`, `reemplazamiento`, `marca`,`sap`) VALUES ";
                foreach ($row as $rows) {
                    $fecha = $rows["fecha"];
                    $cuenta = $rows["cuenta"];
                    $nombre = str_replace("'","`",$rows["nombre"]);
                    $referencia = $rows["referencia"];
                    $designacion = str_replace("'","`",$rows["designacion"]);
                    $fiabilidad = $rows["fiabilidad"];
                    $placa = $rows["placa"];
                    $aviso = $rows["aviso"];
                    $vin = $rows["vin"];
                    $cantidad = $rows["cantidad"];
                    $npedido = $rows["npedido"];
                    $fentrega = $rows["fentrega"];
                    $prioridad = $rows["prioridad"];
                    $fecha_act = $rows["fecha_act"];
                    $reemplazamiento = $rows["reemplazamiento"];
                    $marca = $rows["marca"];
                    $sap = $rows["sap"];
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$prioridad','$fecha_act','$reemplazamiento','$marca','$sap'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            return "ok";
        }catch(Exception $e){
            return $e;
        }
    }

    public function updateShortRef($items,$placaGet){
        try{
            $queryClear = $this->db->prepare("DELETE FROM `shortref` WHERE `placa` = '$placaGet'");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `shortref`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `prioridad`, `libre`, `reemplazamiento`, `marca`, `comentario`, `sap`) VALUES ";
                foreach ($row as $rows) {
                    $fecha = $rows["fecha"];
                    $cuenta = $rows["cuenta"];
                    $nombre = str_replace("'","`",$rows["nombre"]);
                    $referencia = $rows["referencia"];
                    $designacion = str_replace("'","`",$rows["designacion"]);
                    $fiabilidad = $rows["fiabilidad"];
                    $placa = $rows["placa"];
                    $aviso = $rows["aviso"];
                    $vin = $rows["vin"];
                    $cantidad = $rows["cantidad"];
                    $npedido = $rows["npedido"];
                    $fentrega = $rows["fentrega"];
                    $prioridad = $rows["prioridad"];
                    $fecha_act = $rows["fecha_act"];
                    $reemplazamiento = $rows["reemplazamiento"];
                    $marca = $rows["marca"];
                    $comentario = $rows['comentario'];
                    $sap = $rows['sap'];
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$prioridad','$fecha_act','$reemplazamiento','$marca', '$comentario', '$sap'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            return "ok";
        }catch(Exception $e){
            return $e;
        }
    }

    public function updateFilterList($items,$placaGet){
        try{
            $queryClear = $this->db->prepare("DELETE FROM `filterlist` WHERE `placa` = '$placaGet'");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `filterlist`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `prioridad`, `libre`, `reemplazamiento`, `marca`, `comentario`, `sap`) VALUES ";
                foreach ($row as $rows) {
                    $fecha = $rows["fecha"];
                    $cuenta = $rows["cuenta"];
                    $nombre = str_replace("'","`",$rows["nombre"]);
                    $referencia = $rows["referencia"];
                    $designacion = str_replace("'","`",$rows["designacion"]);
                    $fiabilidad = $rows["fiabilidad"];
                    $placa = $rows["placa"];
                    $aviso = $rows["aviso"];
                    $vin = $rows["vin"];
                    $cantidad = $rows["cantidad"];
                    $npedido = $rows["npedido"];
                    $fentrega = $rows["fentrega"];
                    $prioridad = $rows["prioridad"];
                    $fecha_act = $rows["fecha_act"];
                    $reemplazamiento = $rows["reemplazamiento"];
                    $marca = $rows["marca"];
                    $comentario = $rows['comentario'];
                    $sap = $rows['sap'];
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$prioridad','$fecha_act','$reemplazamiento','$marca', '$comentario', '$sap'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            return "ok";
        }catch(Exception $e){
            return $e;
        }
    }

    public function getLastShortFile($placa){
      $sql = "SELECT * FROM `shortInmv` WHERE `placa` = '$placa' ORDER BY `referencia`, STR_TO_DATE(`fecha`,'%d/%m/%Y'),`npedido`, `prioridad`";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

    public function getLastShortRefFile($placa){
        $sql = "SELECT * FROM `shortref` WHERE `placa` = '$placa' ORDER BY `referencia`, STR_TO_DATE(`fecha`,'%d/%m/%Y'),`npedido`, `prioridad`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getFilterList($placa){
        $sql = "SELECT * FROM `filterlist` WHERE `placa` = '$placa' ORDER BY `referencia`, STR_TO_DATE(`fecha`,'%d/%m/%Y'),`npedido`, `prioridad`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateShortFile($id){
      $sql = "UPDATE `shortInmv` SET `marcado` = 'SI' WHERE `id` = $id";
      $query = $this->db->prepare($sql);
      $query->execute();
      return "ok";
    }

    public function updateShortRefFile($id){
      $sql = "UPDATE `filterlist` SET `marcado` = 'SI' WHERE `id` = $id";
      $query = $this->db->prepare($sql);
      $query->execute();
      return "ok";
    }

    public function newFileInmv($up, $down, $placa, $date){
      $sql = "INSERT INTO `inmstatus` (`up`, `down`, `placa`, `date`) VALUES ('$up','$down','$placa','$date')";
      $query = $this->db->prepare($sql);
      $query->execute();
      return 'ok';
    }

    public function newFileInmvDown($fichero){
        $sql = "INSERT INTO `inm_down`(`calculo`,`fecha`, `cuenta`, `nombre`, `referencia`, 
        `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, 
        `prioridad`, `marcado`, `libre`, `reemplazamiento`, `marca`)  VALUES"; 
        foreach($fichero as $fila){
            $fecha = $fila['fecha'];
            $cuenta = $fila['cuenta'];
            $nombre = $fila['nombre'];
            $referencia = $fila['referencia'];
            $designacion = $fila['designacion'];
            $fiabilidad = $fila['fiabilidad'];
            $placa = $fila['placa'];
            $aviso = $fila['aviso'];
            $vin = $fila['vin'];
            $cantidad = $fila['cantidad'];
            $npedido = $fila['npedido'];
            $prioridad = $fila['prioridad'];
            $marcado = $fila['marcado'];
            $anterior = $fila['anterior'];
            $reemplazamiento = $fila['reemplazamiento'];
            $marca = $fila['marca'];
            $calculo = $fila['calculo'];
            $sql .= "(
                '$calculo','$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa',
                '$aviso','$vin','$cantidad','$npedido','$prioridad','$marcado','$anterior','$reemplazamiento','$marca'),";
        }
        $sql = substr($sql, 0, -1) . ";";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function getRefDown($date){
        $sql = "SELECT * FROM `inm_down` WHERE `calculo` = '$date'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getRefDownByRef($ref,$client){
        $sentencia = "SELECT * FROM `inm_down` ";
        $cliente = "WHERE `referencia` = '$ref' AND `cuenta` = '$client'";
        if($client == '')
            $cliente = "WHERE `referencia` = '$ref'";
        elseif($ref == '')
            $cliente = "WHERE `cuenta` = '$client'";

        $sql = "$sentencia $cliente";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getStatusInm($placa){
        $sql = "SELECT `placa`,SUM(`up`),SUM(`down`), date, `id` FROM `inmstatus` WHERE `placa` = '$placa' GROUP BY `placa`, `date` ORDER BY `placa`,`date` DESC";
        if($placa == 'all')
            $sql = "SELECT 'Todos',SUM(`up`),SUM(`down`), DATE_FORMAT(`date`, '%Y-%m-%d'), `id` FROM `inmstatus` GROUP BY DATE_FORMAT(`date`, '%Y-%m-%d') ORDER BY DATE_FORMAT(`date`, '%Y-%m-%d') DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function deleteSelectInmov($id,$calculo){
        $sql = "DELETE FROM `inmstatus` WHERE `id` = '$id'";
        $sql2 = "DELETE FROM `inm_down` WHERE `calculo` = '$calculo'";
            echo $sql2;
        $query = $this->db->prepare($sql);
        $query->execute();
        $query = $this->db->prepare($sql2);
        $query->execute();
    }

    public function updateClientRoute($items){
        try{
            $placa = $items[0]['placa'];
            $queryClear = $this->db->prepare("DELETE FROM `clientes` WHERE `placa` = '$placa'");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `clientes`( `code`, `placa`, `cuenta`, `envio`, `telefono`, `cliente`, `direccion`, `denvio`, `poblacion`, `provincia`, `cp`, `turnoU`, `turnoN`, `tipo`, `comercial`, `email`, `cif`) VALUES ";
                foreach ($row as $rows) {
                    $placa = $rows["placa"];
                    $cuenta = $rows["cuenta"];
                    $envio = str_replace("'","`",$rows["envio"]);
                    $telefono = $rows["telefono"];
                    $cliente = str_replace("'","`",$rows["cliente"]);
                    $direccion = str_replace("'","`",$rows["direccion"]);
                    $denvio = str_replace("'","`",$rows["denvio"]);
                    $poblacion = str_replace("'","`",$rows["poblacion"]);
                    $provincia = str_replace("'","`",$rows["provincia"]);
                    $cp = $rows["cp"];
                    $turnoU = $rows["turnoU"];
                    $turnoN = $rows["turnoN"];
                    $tipo = str_replace("'","`",$rows["tipo"]);
                    $comercial = $rows["comercial"];
                    $email = $rows["email"];
                    $cif = $rows["cif"];
                    $code = $cuenta."-".$envio;
                    $sql .= "('$code', '$placa','$cuenta','$envio','$telefono','$cliente','$direccion','$denvio','$poblacion','$provincia','$cp','$turnoU','$turnoN','$tipo','$comercial','$email','$cif'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            return "Clientes de la placa ".$placa." actualizados";
        }catch(Exception $e){
            return $e;
        }
    }

    public function getRoutesHTMLtest($search){
      $sql = "SELECT DISTINCT 
        clientes.code,
        rutas.CENTRO,
        rutas.CORTE,
        rutas.SALIDA,
        clientes.cliente,
        clientes.telefono,
        clientes.direccion,
        clientes.poblacion,
        clientes.provincia,
        rutas.turn,
        clientes.id
        FROM `clientes`, `rutas` 
        WHERE CONCAT('RUTA ',clientes.turnoU) = rutas.TURN 
        AND clientes.placa = rutas.CENTRO 
        AND code LIKE '$search%' 
        ORDER BY LENGTH(clientes.code), clientes.code ASC LIMIT 500";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

    public function getClientNameByPlate($cuenta,$placa){
      $sql = "SELECT * FROM `clientes` WHERE `placa` = '$placa' AND `cuenta` = '$cuenta' ORDER BY LPAD(`envio`,3,'0') ASC";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

    public function getClientHTMLtest($search){
        $sinEspacios = str_replace(" ","",$search);
        $sql = $sql = "SELECT DISTINCT 
        clientes.code,
        rutas.CENTRO,
        rutas.CORTE,
        rutas.SALIDA,
        clientes.cliente,
        clientes.telefono,
        clientes.direccion,
        clientes.poblacion,
        clientes.provincia,
        rutas.turn,
        clientes.id
        FROM `clientes`, `rutas` 
        WHERE CONCAT('RUTA ',clientes.turnoU) = rutas.TURN 
        AND clientes.placa = rutas.CENTRO 
        AND (clientes.cliente LIKE '%$search%' 
        OR clientes.direccion LIKE '%$search%'
        OR clientes.poblacion LIKE '%$search%'
        OR clientes.provincia LIKE '%$search%'
        OR clientes.cif = '$sinEspacios'
        OR clientes.email LIKE '%$sinEspacios%'
        OR REPLACE(clientes.telefono,' ','') LIKE '%$sinEspacios%')
        ORDER BY LENGTH(code), code ASC LIMIT 100";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getRoutesHTMLId($id){
        $sql = "SELECT * FROM clientes WHERE `id` = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updatePrices($items){
        $proveedor = $items[1]["proveedor"];
        $ctipo = $items[1]["ctipo"];
        try{
            $queryClear = $this->db->prepare("DELETE FROM `tarifa` WHERE (`proveedor` = 'ALD' AND `ctipo` != 'FI') AND (proveedor = 'ALD' AND`ctipo` != 'JE')");
            if($ctipo == "FI" || $ctipo == "JE")
                $queryClear = $this->db->prepare("DELETE FROM `tarifa` WHERE (`proveedor` = 'ALD' AND `ctipo` = 'FI') OR (`proveedor` = 'ALD' AND `ctipo` = 'JE')");
            if($proveedor == "AUT")
                $queryClear = $this->db->prepare("DELETE FROM `tarifa` WHERE `proveedor` = '$proveedor'");
            $queryClear->execute();
            sleep(1);
            $batchSize = 3000;
            foreach (array_chunk($items, $batchSize) as $row) {
                $sql = "INSERT INTO `tarifa`(`referencia`, `denominacion`, `designacion`, `pvp`, `uv`, `peso`, `dto`, `refprov`, `pvpprov`, `proveedor`, `ctipo`) VALUES ";
                foreach ($row as $rows) {
                    $referencia = $rows["referencia"];
                    $denominacion = str_replace("'","`",$rows["denominacion"]);
                    $designacion = str_replace("'","`",$rows["designacion"]);
                    $pvp = $rows["pvp"];
                    $uv = $rows["uv"];
                    $peso = $rows["peso"];
                    $dto = $rows["dto"];
                    $refprov = $rows["refprov"];
                    $pvpprov = $rows["pvpprov"];
                    $ctipo = $rows["ctipo"];
                    $sql .= "('$referencia','$denominacion','$designacion','$pvp','$uv','$peso','$dto','$refprov','$pvpprov','$proveedor','$ctipo'),";
                }
                $sql = substr($sql, 0, -1) . ";";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
            $queryDelete = $this->db->prepare("DELETE FROM `tarifa` WHERE `referencia` = '000000000000000000';");
            $queryDelete->execute();
            return "¡¡ Tarifa actualizada !!";
        }catch(Exception $e){
            return $e;
        }
    }
  
    public function getRefer($referencia){
        $sql = "SELECT DISTINCT * FROM `tarifa` WHERE REPLACE(LTRIM(REPLACE(`referencia`,'0',' ')),' ','0') = REPLACE(LTRIM(REPLACE('$referencia','0',' ')),' ','0') OR (CHAR_LENGTH(`referencia`) < 7 AND `referencia` = '$referencia')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getDto($codDto){
        $sql = "SELECT * FROM `dto_compra` WHERE `codDto` = '$codDto' AND `t_pedido` LIKE 'VOR'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newRecordDownloadFile($ipClient){
        $date = date("d/m/y H:i:s");
        $sql = "INSERT INTO `ipClientes` (`ip`,`fecha`) VALUES ('$ipClient','$date');";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function getIpClients(){
        $sql = "SELECT * FROM `ipClientes` ORDER BY `id` DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getPalabrasClave(){
        $sql = "SELECT * FROM `palabrasclave`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateClavesRef($clave){
        $queryClear = $this->db->prepare("DELETE FROM `palabrasclave`");
        $queryClear->execute();
        sleep(1);
        foreach($clave as $frase){
            $sql = "INSERT INTO `palabrasclave` (`clave`) VALUES ('$frase')";
            $query = $this->db->prepare($sql);
            $query->execute();
        }
    }

    public function getTest(){
        $sql = "SELECT * FROM `tester` WHERE `id` = '1'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newTest($texto){
        $sql = "UPDATE `tester` SET `textarea` = '$texto' WHERE `id` = '1'";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function getOil($densidad,$litros,$marca){
        $sql = "SELECT * FROM `aceite_eurorepar` WHERE `grado` = '$densidad' AND `vol` LIKE '$litros' AND `marca` LIKE '$marca' ORDER BY `ACEA`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getBattery($amperios,$stopStart,$normal){
        $minAmperios = $amperios - 5;
        $maxAmperios =  $amperios + 5;
        if($normal == 'normal')
            $normal = " AND (`Stop_Start` LIKE 'no') ";
        if($stopStart == 'Option STT possible')
            $stopStart = " AND (`Stop_Start` LIKE 'SI') ";
        if($stopStart == " AND (`Stop_Start` LIKE 'SI') " && $normal == " AND `Stop_Start` LIKE 'no'"){
            $stopStart = '';
            $normal = '';
        }
        $where = " WHERE `amp` BETWEEN $minAmperios AND $maxAmperios ";
        if($amperios == 120)
            $where = " WHERE `Desicription` LIKE '%%' ";
        
        $sql = "SELECT * FROM `baterias` 
            $where 
            $stopStart $normal
            ORDER BY `amp`,`amph`,`Stop_Start` ASC;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getPartner($nombre){
        $and = " WHERE `D` LIKE '%$nombre[0]%' ";
        for($i = 1; $i < count($nombre); $i++)
            $and .= " AND `D` LIKE '%$nombre[$i]%'";
        $sql = "SELECT * FROM `centros` $and";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getCredentialsMA($plate){
        $sql = "SELECT * FROM `neumaticos` WHERE `marca` LIKE '%Mister%' AND `placa` LIKE '%$plate%'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAlert(){
        $sql = "SELECT * FROM `alert`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function updateAlert($active, $coment){
        $sql = "UPDATE `alert` SET `active` = '$active', `coment` = '$coment'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function addNewHistoryParts($items){
        echo "ok";
    }
}