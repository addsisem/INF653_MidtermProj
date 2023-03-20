<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, PUT, DELETE, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$author->id = $data->id;

if($author->delete()) {
    echo json_encode(
        array('message' => 'Author Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Author Not Deleted')
    ); 
}
?>