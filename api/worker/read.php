<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Worker.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate  worker object
$worker = new Worker($db);

// worker query
$result = $worker->read();
// Get row count
$num = $result->rowCount();

// Check if any workers
if ($num > 0) {
  // worker array
  $workers_arr = array();
  // $workers_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $worker_item = array(
      'id' => $id,
      'firstName' => $firstName,
      'lastName' => $lastName,
      'birthDate' => $birthDate
    );

    // Push to "data"
    array_push($workers_arr, $worker_item);
    // array_push($workers_arr['data'], $worker_item);
  }

  // Turn to JSON & output
  echo json_encode($workers_arr);
} else {
  // No workers
  echo json_encode(
    array('message' => 'No workers Found')
  );
}