<?php
header('access-control-allow-origin: *');
header('content-type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$cats = new Categories($db);
$cats->id = isset($_GET['id']) ? $_GET['id'] : die();
$result = $cats->read_single();

if (!empty($result)) {

    $cats_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $cats_item = [
            'id' => $row['id'],
            'name' => $row['name']
        ];

        array_push($cats_arr, $cats_item);
    }

    print_r(json_encode($cats_arr));
} else {
    print_r(json_encode(array("message" => "No posts were found.")));
}
