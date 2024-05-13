<?php
include_once '../connection/data.php';
$data = new Contacts();

$rows = $data->getZzmat($_POST['id']);

echo json_encode($rows[0]);