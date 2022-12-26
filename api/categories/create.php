<?php
header('access-control-allow-origin: *');
header('content-type: application/json');
header('access-control-allow-methods: POST');
header('access-control-allow-headers: access-control-allow-headers, content-type, access-control-allow-methods, authorization, x-requested-with');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$cats = new Categories($db);

$data = json_decode(file_get_contents('php://input'));

$cats->name = $data->name;

if ($cats->create()) {
    echo json_encode(array('message' => 'Post was created.'));
} else {
    echo json_encode(array('message' => 'Post was not created.'));
}
