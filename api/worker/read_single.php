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

// Get ID
$worker->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get worker
$worker->read_single();

// Create array
$worker_arr = array(
  'id' => $worker->id,
  'firstName' => $worker->firstName,
  'lastName' => $worker->lastName,
  'birthDate' => $worker->birthDate
);

// Make JSON
print_r(json_encode($worker_arr));