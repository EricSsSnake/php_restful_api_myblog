<?php
header('access-control-allow-origin: *');
header('content-type: application/json');

include_once "../../config/Database.php";
include_once "../../models/Posts.php";

$database = new Database();
$db = $database->connect();

$posts = new Posts($db);

$posts->id = isset($_GET['id']) ? $_GET['id'] : die();

$posts->read_single();

$post_arr = [
    'id' => $posts->id,
    'title' => $posts->title,
    'author' => $posts->author,
    'body' => $posts->body,
    'category_name' => $posts->category_name,
    'category_id' => $posts->category_id,
];

print_r(json_encode($post_arr));
