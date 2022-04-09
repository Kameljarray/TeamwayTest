<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Planning.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate  planning object
$planning = new Planning($db);

// planning query
$result = $planning->read();
// Get row count
$num = $result->rowCount();

// Check if any plannings
if ($num > 0) {
  // planning array
  $plannings_arr = array();
  // $plannings_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $planning_item = array(
      'id' => $id,
      'worker_id' => $worker_id,
      'worker_firstName' => $worker_firstName,
      'worker_lastName' => $worker_lastName,
      'shift_id' => $shift_id,
      'shift_label' => $shift_label,
      'day' => $day
    );

    // Push to "data"
    array_push($plannings_arr, $planning_item);
    // array_push($plannings_arr['data'], $planning_item);
  }

  // Turn to JSON & output
  echo json_encode($plannings_arr);
} else {
  // No plannings
  echo json_encode(
    array('message' => 'No plannings Found')
  );
}