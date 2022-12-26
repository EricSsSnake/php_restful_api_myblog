<?php
header('access-control-allow-origin: *');
header('content-type: application/json');
header('access-control-allow-methods: DELETE');
header('access-control-allow-headers: access-control-allow-headers, content-type, access-control-allow-methods, authorization, x-requested-with');

include_once "../../config/Database.php";
include_once "../../models/Posts.php";

$database = new Database();
$db = $database->connect();

$posts = new Posts($db);

$data = json_decode(file_get_contents('php://input'));

$posts->id = $data->id;

if ($posts->delete()) {
    echo json_encode(array("message" => "Post was deleted."));
} else {
    echo json_encode(array("message" => "Post was not deleted."));
}
