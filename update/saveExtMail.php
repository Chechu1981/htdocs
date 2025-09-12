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
    $gestion1 = trim($_POST['gestion1'] ?? '');
    $gestion2 = trim($_POST['gestion2'] ?? '');
    $gestion3 = trim($_POST['gestion3'] ?? '');
    $almacen1 = trim($_POST['almacen1'] ?? '');
    $almacen2 = trim($_POST['almacen2'] ?? '');
    $almacen3 = trim($_POST['almacen3'] ?? '');
    $transporte1 = trim($_POST['transporte1'] ?? '');
    $transporte2 = trim($_POST['transporte2'] ?? '');
    $transporte3 = trim($_POST['transporte3'] ?? '');

    // Validar formato de emails (solo si no están vacíos)
    $emails = [
        'gestion1' => $gestion1,
        'gestion2' => $gestion2,
        'gestion3' => $gestion3,
        'almacen1' => $almacen1,
        'almacen2' => $almacen2,
        'almacen3' => $almacen3,
        'transporte1' => $transporte1,
        'transporte2' => $transporte2,
        'transporte3' => $transporte3
    ];
    
    foreach ($emails as $field => $email) {
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El email en el campo ' . $field . ' no es válido');
        }
    }

    $conexion = new Contacts();
    
    // Verificar si ya existe un registro para esta placa
    $existingData = $conexion->getExtMails($placa);
    
    if (!empty($existingData)) {
        // Actualizar registro existente
        $result = $conexion->updateExtMail($placa, $gestion1, $gestion2, $gestion3, $almacen1, $almacen2, $almacen3, $transporte1, $transporte2, $transporte3);
        $message = 'Datos actualizados correctamente para la placa ' . $placa;
    } else {
        // Crear nuevo registro
        $result = $conexion->addExtMail($placa, $gestion1, $gestion2, $gestion3, $almacen1, $almacen2, $almacen3, $transporte1, $transporte2, $transporte3);
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
