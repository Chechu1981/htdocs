<?php
header('Content-Type: application/json');
include_once '../connection/data.php';

try {
    // Verificar que se recibió la placa
    if (!isset($_POST['placa'])) {
        throw new Exception('La placa es requerida');
    }

    $placa = trim($_POST['placa']);
    
    // Validar que la placa no esté vacía
    if (empty($placa)) {
        throw new Exception('La placa es obligatoria');
    }

    // Obtener todos los campos de email
    $gestion = array();
    $almacen = array();
    $transporte = array();
    foreach(explode("\n",trim(strtolower($_POST['gestion']))) as $mailGestion){
        array_push($gestion,$mailGestion);
    }
    foreach(explode("\n",trim(strtolower($_POST['almacen']))) as $mailAlmacen){
        array_push($almacen,$mailAlmacen);
    }
    foreach(explode("\n",trim(strtolower($_POST['transporte']))) as $mailTransporte){
        array_push($transporte,$mailTransporte);
    }
    $emails = [
        'gestion' => $gestion,
        'almacen' => $almacen,
        'transporte' => $transporte
    ];
    
    // Validar formato de emails (solo si no están vacíos)
    foreach ($emails as $field => $email) {
        foreach($email as $mail){
            if (empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El email ' . $mail . ' en el campo ' . $field . ' no es válido');
            }
        }
    }

    $conexion = new Contacts();
    
    // Verificar si ya existe un registro para esta placa
    $existingData = $conexion->getExtMails($placa);
    
    if (!empty($existingData)) {
        // Actualizar registro existente
        $result = $conexion->updateExtMail($placa, implode("\n", $gestion), implode("\n", $almacen), implode("\n", $transporte));
        $message = 'Datos actualizados correctamente para la placa ' . $placa;
    } else {
        // Crear nuevo registro
        $result = $conexion->addExtMail($placa, implode("\n", $gestion), implode("\n", $almacen), implode("\n", $transporte));
        $message = 'Datos guardados correctamente para la placa ' . $placa;
    }

    echo json_encode([
        'success' => true,
        'message' => $message
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
