<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Shift.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate shift object
$shift = new Shift($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to UPDATE
$shift->id = $data->id;

$shift->label = $data->label;

// Update shift
if ($shift->update()) {
  echo json_encode(
    array('message' => 'shift Updated')
  );
} else {
  echo json_encode(
    array('message' => 'shift not updated')
  );
}