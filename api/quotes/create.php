<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, PUT, DELETE, GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Category.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);
    $category = new Category($db);
    $author = new Author($db);

    // If parameters were not passed in
    if($data->author_id === null || $data->category_id === null || $data->quote === null) {
        echo json_encode(
            array('message' => 'Missing Required Parameters'), JSON_FORCE_OBJECT
        );
        return false;
    }

    $quote->quote = $data->quote;
    $quote->category_id = $data->category_id;
    $quote->author_id = $data->author_id;

    $category->id = $data->category_id;
    $author->id = $data->author_id;

    // Checking for valid id's for passed in category and author
    if($category->read_single() && $author->read_single()) {
        $quote->create();

        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id
            ), JSON_FORCE_OBJECT
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Created'), JSON_FORCE_OBJECT
        ); 
    }
?>