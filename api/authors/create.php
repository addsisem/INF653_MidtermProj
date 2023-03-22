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

// If parameters were not passed in
if($data->author === null) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return false;
}

// Assign passed in parameters
$author->author = $data->author;

if($author->create()) {

    echo json_encode(
        array(
            'id' => $author->id,
            'author' => $author->author
        ), JSON_FORCE_OBJECT
    );
} else {
    echo json_encode(
        array('message' => 'Author Not Added')
    ); 
}
?>
