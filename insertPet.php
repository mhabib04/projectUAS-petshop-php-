<?php

include 'connection.php';

if($_POST){

    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $breed = isset($_POST['breed']) ? $_POST['breed'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = null;
    }

    $response = [];

    $insertAccount = 'INSERT INTO pets (type, breed, price, age, image) VALUES (?, ?, ?, ?, ?)';
    $statement = $connection->prepare($insertAccount);

    try {
        $statement->execute([$type, $breed, $price, $age, $image]);

        $response['status'] = true;
        $response['message'] = 'Success';
    } catch (Exception $e){
        $response['status'] = false;
        $response['message'] = 'Failed';
    }
    
    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;
}
?>
