<?php
header('access-control-allow-origin: *');
header('content-type: application/json');
header('access-control-allow-methods: POST');
header('access-control-allow-headers: access-control-allow-headers, content-type, access-control-allow-methods, authorization, x-requested-with');

include_once "../../config/Database.php";
include_once "../../models/Posts.php";

$database = new Database();
$db = $database->connect();

$posts = new Posts($db);

$data = json_decode(file_get_contents("php://input"));

$posts->title = $data->title;
$posts->author = $data->author;
$posts->body = $data->body;
$posts->category_id = $data->category_id;

if ($posts->create()) {
    echo json_encode(array('message' => 'Posts was created.'));
} else {
    echo json_encode(array('message' => 'Posts was not created.'));
}
