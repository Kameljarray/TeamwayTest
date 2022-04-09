<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Shift.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Shift object
$shift = new Shift($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$shift->label = $data->label;

// Create Shift
if ($shift->create()) {
  echo json_encode(
    array('message' => 'Shift Created')
  );
} else {
  echo json_encode(
    array('message' => 'Shift Not Created')
  );
}
