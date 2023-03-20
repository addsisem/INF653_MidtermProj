<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, PUT, DELETE, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Error-handling
if($data->author_id == null || $data->category_id == null || $data->id == null) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return false;
}

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->category_id = $data->category_id;
$quote->author_id = $data->author_id;

if($quote->update()) {
    echo json_encode(
        array('message' => 'Quote Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Updated')
    ); 
}
?>