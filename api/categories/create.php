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

// Error-handling
if($data->category == null) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return false;
}

$category->category = $data->category;

if($category->create()) {
    echo json_encode(
        array('message' => 'Category Added')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Added')
    ); 
}
?>