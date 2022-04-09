<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Worker.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate  worker object
$worker = new Worker($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$worker->id = $data->id;

$worker->firstName = $data->firstName;
$worker->lastName = $data->lastName;
$worker->birthDate = $data->birthDate;

// Update worker
if ($worker->update()) {
  echo json_encode(
    array('message' => 'worker Updated')
  );
} else {
  echo json_encode(
    array('message' => 'worker Not Updated')
  );
}