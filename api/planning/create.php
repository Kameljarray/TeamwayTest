<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Planning.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate planning object
$planning = new Planning($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$planning->worker_id = $data->worker_id;
$planning->shift_id = $data->shift_id;
$planning->day = $data->day;

// Check the existence of a planning with same worker and same day
if ($planning->check_worker_shift()) {
  echo json_encode(
    array('message' => 'A worker Can not have more than one shift per day')
  );
  return;
}
// Create planning
if ($planning->create()) {
  echo json_encode(
    array('message' => 'planning Created')
  );
} else {
  echo json_encode(
    array('message' => 'planning Not Created')
  );
}
