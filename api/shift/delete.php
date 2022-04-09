<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Delete shift
if ($shift->delete()) {
  echo json_encode(
    array('message' => 'Shift deleted')
  );
} else {
  echo json_encode(
    array('message' => 'Shift not deleted')
  );
}