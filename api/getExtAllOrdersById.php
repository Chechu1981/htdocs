<?php
//error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../connection/data.php';

try {
    $conexion = new Contacts();
    
    // Verificar que el parámetro 'id' existe
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetro id requerido']);
        exit;
    }
    
    $id = $_GET['id'];
    
    // Validar que el ID sea numérico
    if (!is_numeric($id)) {
        http_response_code(400);
        echo json_encode(['error' => 'ID debe ser numérico']);
        exit;
    }
    
    $rows = $conexion->getExtAllOrdersById($id);
    
    header('Content-Type: application/json');
    echo json_encode($rows);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
}