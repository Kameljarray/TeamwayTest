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

// Get ID
$planning->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get planning
$planning->read_single();

// Create array
$planning_arr = array(
  'id' => $planning->id,
  'worker_id' => $planning->worker_id,
  'worker_firstName' => $planning->worker_firstName,
  'worker_lastName' => $planning->worker_lastName,
  'shift_id' => $planning->shift_id,
  'shift_label' => $planning->shift_label,
  'day' => $planning->day
);

// Make JSON
print_r(json_encode($planning_arr));