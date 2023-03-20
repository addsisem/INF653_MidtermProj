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

    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    $author->read_single();
    
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    if($author->author != null) {
        print_r(json_encode($author_arr));
    } else {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }
?>