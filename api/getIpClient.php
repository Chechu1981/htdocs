<?php
include_once '../connection/data.php';

$contacts = new Contacts();

$rows = $contacts->getIpClients();
$htmlList = "";
foreach($rows as $ip){
  $geolocation =substr(file_get_contents('http://ip-api.com/php/'.$ip[1].'?lang=es'),5);
  $data = explode(':"',$geolocation);
  $htmlList .= "<ul class='ipList'>
    <li>".$ip[1]."</li>
    <li>".explode('"',$data[4])[0]." - ".explode('"',$data[10])[0]." - ".explode('"',$data[12])[0]." - ".explode('"',$data[20])[0]."</li>
    <li>".$ip[2]."</li>
    </ul>";
}

echo $htmlList;