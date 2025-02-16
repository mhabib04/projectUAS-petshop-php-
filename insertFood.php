<?php

include 'connection.php';

if ($_POST) {

    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = null;
    }

    $response = [];

    $insertAccount = 'INSERT INTO foods (type, name, price, image) VALUES (?, ?, ?, ?)';
    $statement = $connection->prepare($insertAccount);

    try {
        $statement->execute([$type, $name, $price, $image]);

        $response['status'] = true;
        $response['message'] = 'Success';

    } catch (Exception $e) {
        $response['status'] = false;
        $response['message'] = 'Failed';
    }
    
    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;
}
?>
