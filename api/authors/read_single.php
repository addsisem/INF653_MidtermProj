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

    // Check whether the passed in url contains an id
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    $author->read_single();
    
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    if($author->author != null) {
        print_r(json_encode($author_arr, JSON_FORCE_OBJECT));
    } else {
        echo json_encode(
            array('message' => 'Author Not Found'), JSON_FORCE_OBJECT
        );
    }
?>