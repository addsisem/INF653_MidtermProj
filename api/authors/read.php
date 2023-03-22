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

    $result = $author->read();
    $num = $result->rowCount();

    //Checks that there were quotes returned
    if($num > 0) {
        $authors_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            array_push($authors_arr, $author_item);
        }

        echo json_encode($authors_arr);
    } else {
        echo json_encode(
            array('message' => 'Authors Not Found')
        );
    }
?>