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

// If parameters were not passed in
if(!isset($data->category)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters'), JSON_FORCE_OBJECT
    );
    return false;
}

$category->category = $data->category;

if($category->create()) {

    echo json_encode(
        array(
            'id' => $category->id,
            'category' => $category->category
        ), JSON_FORCE_OBJECT
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Added'), JSON_FORCE_OBJECT
    ); 
}
?>