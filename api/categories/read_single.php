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

    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    $category->read_single();
    
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    if($category->category != null) {
        print_r(json_encode($category_arr, JSON_FORCE_OBJECT));
    } else {
        echo json_encode(
            array('message' => 'Category Not Found'), JSON_FORCE_OBJECT
        );
    }
?>