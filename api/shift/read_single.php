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

// Get ID
$shift->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get shift
$shift->read_single();

// Create array
$shift_arr = array(
  'id' => $shift->id,
  'label' => $shift->label
);

// Make JSON
print_r(json_encode($shift_arr));