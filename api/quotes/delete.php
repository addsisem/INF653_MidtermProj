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

$quote->id = $data->id;

if($quote->delete()) {
    echo json_encode(
        array('message' => 'Quote Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Deleted')
    ); 
}
?>