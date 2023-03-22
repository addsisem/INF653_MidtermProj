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

    // Find quotes from a specific author that are in also in a specific category
    if(isset($_GET['author_id']) && isset($_GET['category_id'])) {
        $quote->author_id = $_GET['author_id'];
        $quote->category_id = $_GET['category_id'];
        $result = $quote->readCategoryAuthors();
        $num = $result->rowCount();
        
    // Find quotes from a specific author
    } else if(isset($_GET['author_id'])) {
        $quote->author_id = $_GET['author_id'];
        $result = $quote->readAuthor();
        $num = $result->rowCount();

    // Find quotes from a specific category
    } else if(isset($_GET['category_id'])) {
        $quote->category_id = $_GET['category_id'];
        $result = $quote->readCategory();
        $num = $result->rowCount();

    // Find all quotes
    } else {
        $result = $quote->read();
        $num = $result->rowCount();
    }

    //Checks that there were quotes returned
    if($num > 0) {
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            array_push($quotes_arr, $quote_item);
        }

        echo json_encode($quotes_arr);
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found'), JSON_FORCE_OBJECT
        );
    }
?>