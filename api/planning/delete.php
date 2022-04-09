<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Planning.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate  planning object
$planning = new Planning($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$planning->id = $data->id;

// Delete planning
if ($planning->delete()) {
  echo json_encode(
    array('message' => 'planning Deleted')
  );
} else {
  echo json_encode(
    array('message' => 'planning Not Deleted')
  );
}