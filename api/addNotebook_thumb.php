<?php
include_once '../connection/data.php';

function miniatura($archivo, $nombre, $ancho, $alto){
    $extension = pathinfo($archivo, PATHINFO_EXTENSION);
    
    if($extension=="jpg" || $extension=="jpeg") $nuevo = imagecreatefromjpeg($archivo);
    if($extension=="png") $nuevo = imagecreatefrompng($archivo);
    if($extension=="gif") $nuevo = imagecreatefromgif($archivo);
    if($extension=="webp") $nuevo = imagecreatefromjpeg($archivo);
    $thumb = imagecreatetruecolor($ancho, $alto);

    $ancho_original = imagesx($nuevo);
    $alto_original = imagesy($nuevo);

    imagecopyresampled($thumb,$nuevo,0,0,0,0,$ancho,$alto,$ancho_original,$alto_original);
    $thumb_name = "../docs/thumb_".$nombre.".".$extension."";
    
    // 90 es la calidad de compresión, Máx 100
    if($extension=="jpg" || $extension=="jpeg") imagejpeg($thumb, $thumb_name,90);
    if($extension=="png") imagepng($thumb, $thumb_name);
    if($extension=="gif") imagegif($thumb, $thumb_name);

}
  
$contacts = new Contacts();
$namefile = "";
if(isset($_POST['file'])){
    $namefile = $_POST['file'];
}else{
    if($_FILES['file']['size'] > 0){
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $namefile  = md5($_FILES['file']['name']).'.'.$ext;
        move_uploaded_file($_FILES['file']['tmp_name'], '../docs/'.$namefile.'');
        miniatura("../docs/".$namefile, explode('.',$namefile)[0], 100, 100);
    }
}
$items = [
    $_POST['marca'],
    $_POST['modelo'],
    $_POST['descripcion'],
    $_POST['referencia'],
    $namefile
];

$rows = $contacts->newNotebook($items);
echo $rows;