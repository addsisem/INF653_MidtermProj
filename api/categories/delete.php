<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, PUT, DELETE, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$category->id = $data->id;

if($category->delete()) {
    echo json_encode(
        array('id' => $category->id), JSON_FORCE_OBJECT
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Deleted'), JSON_FORCE_OBJECT
    ); 
}
?>