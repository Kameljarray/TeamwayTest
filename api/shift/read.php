<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Shift.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate shift object
$shift = new Shift($db);

// shift read query
$result = $shift->read();

// Get row count
$num = $result->rowCount();

// Check if any shifts
if ($num > 0) {
  // shift array
  $shift_arr = array();
  $shift_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $shift_item = array(
      'id' => $id,
      'label' => $label
    );

    // Push to "data"
    array_push($shift_arr['data'], $shift_item);
  }

  // Turn to JSON & output
  echo json_encode($shift_arr);
} else {
  // No shifts
  echo json_encode(
    array('message' => 'No shifts Found')
  );
}