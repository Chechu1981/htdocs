<?php

include_once 'connection.php';

class Contacts
{
    protected $db;

    public function __construct() {
      $this->db = Db::conectar();
    }

    public function getUser($usr, $psw){
        $sql = "SELECT DISTINCT * FROM `usuarios` WHERE nombre LIKE '$usr' AND clave LIKE '$psw'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUserBySessid($sessid){
        $uri = $_SERVER['PHP_SELF'];
        $page = strtoupper(substr(explode("/",$uri)[count(explode("/",$uri))-1],0,-4));
        $src = ".";
        !strstr("$uri",'home') == '/home.php' ? $src = ".." : '';
        strpos($uri,'center') > 0 ? $src = "../.." : '';
        $data = file_get_contents($src.'/json/sesiones.json');
        $usr = json_decode($data, true);
        $user = false;
        for($i = 0; $i < count($usr); $i++){
            //echo $usr[$i]['hash']."<p>" . $sessid;
            if($usr[$i]['hash'] == $sessid)
                $user = strtoupper($usr[$i]['nombre']);
        }
        return $user;
    }

    public function getAllUsers(){
        $sql = "SELECT DISTINCT * FROM `usuarios` ORDER BY `nombre` ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getContacts($search){
        $sql = "SELECT * FROM `route`, `rutas` WHERE route.TURN = rutas.TURN AND route.name LIKE '%$seacrh%'";
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

    public function getTyres($search)
    {
        $sql = "SELECT *,CONCAT_WS('',`ANCHO`,`PERFIL`,`RADIO`,`CODCARGA`,`INDICE VELOCIDAD`) AS `search` 
            FROM `tyres` 
            WHERE CONCAT_WS('',`ANCHO`,`PERFIL`,`RADIO`,`CODCARGA`,`INDICE VELOCIDAD`) LIKE '%$search%'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }

    public function getTyresHTML($width,$height,$diameter,$load_code,$speed_index)
    {
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

    public function getClientHTML($search)
    {
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

    public function getRepereHTML($ref){
        $ref = ltrim($ref,"0");
        $sql = "SELECT DISTINCT * FROM `repere` WHERE REPLACE(LTRIM(REPLACE(`Referencia_fabricación`,'0',' ')),' ','0') = '".$ref."'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getPassHTML($ref, $tipo){
        $placa = $tipo;
        if($tipo == 'TODOS')
            $placa = '%';
        $btn = $ref;
        if(substr($ref,0,3) == 'btn')
            $btn = substr($ref,3);

        if(substr($ref,0,3) == 'btn'){
            $sql = "SELECT * FROM `neumaticos` WHERE 
            `tipo` LIKE '$btn'
            INTERSECT
            SELECT * FROM `neumaticos` WHERE
            `placa` LIKE '$placa'
            OR `placa` = ''
            ORDER BY `marca` ASC";
        }else if($tipo != 'TODOS'){
            $sql = "SELECT * FROM `neumaticos` WHERE 
            `marca` LIKE '%$btn%'
            OR `usuario` LIKE '%$btn%'
            OR `tlf` LIKE '%$btn%'
            OR `cuenta` LIKE '%$btn%'
            OR `tipo` LIKE '%$btn%'
            INTERSECT
            SELECT * FROM `neumaticos` WHERE
            `placa` = '$placa'
            OR `placa` = ''
            ORDER BY `marca` ASC";
        }else{
            $sql = "SELECT * FROM `neumaticos` WHERE 
            `marca` LIKE '%$btn%'
            OR `usuario` LIKE '%$btn%'
            OR `tlf` LIKE '%$btn%'
            OR `cuenta` LIKE '%$btn%'
            OR `placa` LIKE '%$btn%'
            OR `tipo` LIKE '%$btn%'
            ORDER BY `marca` ASC";
        }
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newPass($item){
        $sql = "INSERT INTO `neumaticos` (`marca`,`placa`,`cuenta`,`usuario`,`pass`,`web`,`tlf`,`consultausr`,`consultapwd`,`tipo`) VALUES 
        ('$item[1]','$item[2]','$item[3]','$item[4]','$item[5]','$item[6]','$item[7]','','','$item[8]')";
        $query = $this->db->prepare($sql);  
        $query->execute();
        return "ok";
    }

    public function updatePass($item){
        $sql = "UPDATE `neumaticos` SET 
            `marca`= '$item[1]',
            `placa` = '$item[2]',
            `cuenta` = '$item[3]',
            `usuario` = '$item[4]',
            `pass` = '$item[5]',
            `web` = '$item[6]',
            `tlf` = '$item[7]',
            `tipo` = '$item[8]'
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
            (`origen`, `destino`, `cliente`, `ref`, `pvp`, `pedido`, `envio`, `recibido`, `cantidad`, `usuario`,`comentario`, `refClient`, `fragil`) 
            VALUES
            ('$items[0]','$items[1]','$items[2]','$items[3]','$items[4]','$items[5]','$items[6]','0000-00-00',$items[7], '$items[8]', '$items[9]','',FALSE)";
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
            (`origen`, `destino`, `cliente`, `refClient`, `comentario`, `ref`, `pvp`, `cantidad`, `fragil`, `usuario`, `pedido`, `recibido`, `envio`) 
            VALUES
            ('$items[0]','$items[1]','$items[2]','$items[3]','$items[4]','$items[5]','$items[6]', '$items[7]' , $fragil, '$items[9]', '', '0000-00-00', '0000-00-00 00:00:00')";
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
            (`origen`, `destino`, `cliente`, `refClient`, `comentario`, `ref`, `pvp`, `cantidad`, `fragil`, `usuario`, `pedido`, `recibido`, `envio`, `nfm`, `disgon`) 
            VALUES
            ('$items[0]','$items[1]','$items[2]','$items[3]','$items[4]','$items[5]','$items[6]', '$items[7]' , $items[8], '$items[10]', '$items[11]', '0000-00-00', '0000-00-00 00:00:00', $items[9], $items[12])";
        $query = $this->db->prepare($sql);
        $query->execute();
        return 'ok';
    }

    public function deleteAssigADV($item){
        $sql = "DELETE FROM `cesiones` WHERE `id` LIKE $item";
        $query = $this->db->prepare($sql);
        $query->execute();
        return "¡¡Eliminado!!";
    }

    public function getAssig($all,$usr,$sort){
        $order = "ORDER BY `id` DESC LIMIT 100";
        if($sort == 'origen')
            $order = "ORDER BY `origen` ASC LIMIT 100";
        if($sort == 'destino')
            $order = "ORDER BY `destino` ASC LIMIT 100";

        $sql = "SELECT * FROM `cesiones` WHERE 
        `ref` LIKE '%$all%' OR
        `origen` LIKE '%$all%' OR
        `destino` LIKE '%$all%' OR
        `cliente` LIKE '%$all%'OR
        `comentario` LIKE '%$all%'OR
        `pedido` LIKE '%$all%' AND
        `usuario` = '$usr'";

        if($all == 'all')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` NOT LIKE '0000-00-00' AND `usuario` = '$usr'";
        elseif($all == 'new')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `usuario` = '$usr'";            
        $sql .= $order;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAssigCount($usr){
      $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `usuario` = '$usr'";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

    public function getAssigCountNew($usr){
      $sql = "SELECT COUNT(*) FROM `cesiones` WHERE `envio` LIKE '0000-00-00 00:00:00' AND `recibido` LIKE '0000-00-00' AND`usuario` = '$usr'";
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
        `pedido` = '' AND
        `usuario` = '$usr' OR `usuario` LIKE ''
        ORDER BY `destino`, `origen` DESC 
        LIMIT 100";
        if($all == 'all')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` NOT LIKE '0000-00-00' AND `envio` LIKE '0000-00-00 00:00:00' AND `usuario` = '$usr' OR `usuario` LIKE '' ORDER BY `origen`, `destino` DESC ";
        elseif($all == 'new')
            $sql = "SELECT * FROM `cesiones` WHERE `recibido` LIKE '0000-00-00' AND `envio` LIKE '0000-00-00 00:00:00' AND `usuario` = '$usr' OR `usuario` LIKE '' ORDER BY `origen`, `destino` DESC ";
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

    public function updateAssig($id){
        $sql = "UPDATE `cesiones` SET `recibido`= NOW() WHERE `id`= $id";
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

    public function is_send($id){
        $sql = "SELECT * FROM `cesiones` WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function updateAssigADV2023($id,$fragil,$envio,$nfm,$pedido,$tratado,$origenBtn,$destinoBtn,$disgon){
        $fecha = date("Y-m-d H:i:s");
        if($envio == 'true')
            $sql = "UPDATE `cesiones` SET `disgon` = $disgon, `nfm` = $nfm, `fragil` = $fragil, `envio` = '$fecha', `emisor` = $origenBtn, `receptor` = $destinoBtn, `pedido` = '$pedido', `tratado` = '$tratado' WHERE `id` LIKE '$id'";
        else
            $sql = "UPDATE `cesiones` SET `disgon` = $disgon, `nfm` = $nfm, `fragil` = $fragil, `pedido` = '$pedido', `emisor` = $origenBtn, `receptor` = $destinoBtn, `tratado` = '$tratado' WHERE `id` LIKE '$id'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $sql;
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
        ORDER BY `marca`,`modelo`,`descripcion` ASC";
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
        return $sql;
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
        `F` LIKE '%$search%' OR
        `G` LIKE '%$search%' OR
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

    public function setColor($color,$usr){
        $sql = "UPDATE usuarios SET theme = '$usr' WHERE nombre = '$usr'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $color . ' ' . $usr;
    }

    public function getRoutesName($route) {
        $sql = "SELECT * FROM rutas WHERE `Turn` LIKE '%$route%'";
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
                $sql = "INSERT INTO `inmovilizados`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `prioridad`, `libre`,`reemplazamiento`,`marcado`, `marca`) VALUES ";
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
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$prioridad','$fecha_act','$reemplazamiento','$marcado', '$marca'),";
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

    public function getLastFile($placa,$ref){
        $referencia = '';
        if($ref != '')
            $referencia = "AND `referencia` = '$ref'";
        $sql = "SELECT * FROM `inmovilizados` WHERE `placa` = '$placa' ".$referencia." ORDER BY `referencia`, STR_TO_DATE(`fecha`,'%d/%m/%Y'),`npedido`, `prioridad`";
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
                $sql = "INSERT INTO `shortInmv`(`fecha`, `cuenta`, `nombre`, `referencia`, `designacion`, `fiabilidad`, `placa`, `aviso`, `vin`, `cantidad`, `npedido`, `prioridad`, `libre`, `reemplazamiento`, `marca`) VALUES ";
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
                    $sql .= "('$fecha','$cuenta','$nombre','$referencia','$designacion','$fiabilidad','$placa','$aviso','$vin','$cantidad','$npedido','$prioridad','$fecha_act','$reemplazamiento','$marca'),";
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

    public function updateShortFile($id){
      $sql = "UPDATE `shortInmv` SET `marcado` = 'SI' WHERE `id` = $id";
      $query = $this->db->prepare($sql);
      $query->execute();
      return "ok";
    }

    public function newFileInmv($up, $down, $placa){
      $date = date("Y/m/d H:i:s");
      $sql = "INSERT INTO `inmstatus` (`up`, `down`, `placa`, `date`) VALUES ('$up','$down','$placa','$date')";
      $query = $this->db->prepare($sql);
      $query->execute();
      return 'ok';
    }

    public function getStatusInm($placa){
        $sql = "SELECT `placa`,SUM(`up`),SUM(`down`), date FROM `inmstatus` WHERE `placa` = '$placa' GROUP BY `placa`, `date` ORDER BY `placa`,`date` DESC";
        if($placa == 'all')
            $sql = "SELECT 'Todos',SUM(`up`),SUM(`down`), DATE_FORMAT(`date`, '%Y-%m-%d') FROM `inmstatus` GROUP BY DATE_FORMAT(`date`, '%Y-%m-%d') ORDER BY DATE_FORMAT(`date`, '%Y-%m-%d') DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
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
        ORDER BY LENGTH(clientes.code), clientes.code ASC LIMIT 100";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
  }

  public function getClientNameByPlate($cuenta,$placa){
      $sql = "SELECT * FROM `clientes` WHERE `placa` = '$placa' AND `cuenta` = '$cuenta'";
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
        $queryClear = $this->db->prepare("DELETE FROM `tarifa` WHERE (`ctipo` != 'FI' OR `ctipo` != 'JE') AND `proveedor` = 'ALD'");
        if($ctipo == "FI" || $ctipo == "JE")
            $queryClear = $this->db->prepare("DELETE FROM `tarifa` WHERE `ctipo` = 'FI' OR `ctipo` = 'JE'");
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
    $sql = "SELECT * FROM `tarifa` WHERE REPLACE(LTRIM(REPLACE(`referencia`,'0',' ')),' ','0') = '$referencia' OR (CHAR_LENGTH(`referencia`) < 7 AND `referencia` = '$referencia')";
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
}