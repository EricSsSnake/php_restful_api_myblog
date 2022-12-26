<?php
header('access-control-allow-origin: *');
header('content-type: application/json');

include_once "../../config/Database.php";
include_once "../../models/Posts.php";

$database = new Database();
$db = $database->connect();

$posts = new Posts($db);
$read_result = $posts->read();

if (!empty($read_result)) {
    $posts_arr = [];

    while ($row = $read_result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = [
            'id' => $id,
            'title' => $title,
            'author' => $author,
            'body' => html_entity_decode($body),
            'category_name' => $name,
            'category_id' => $category_id
        ];

        array_push($posts_arr, $post_item);
    }

    echo json_encode($posts_arr);
} else {
    echo json_encode(['message' => 'No posts were found.']);
}
