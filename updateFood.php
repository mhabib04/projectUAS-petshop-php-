<?php

include 'connection.php';

if ($_POST) {
    $id_food = isset($_POST['id_food']) ? $_POST['id_food'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = null;
    }

    $response = [];

    $updateQuery = 'UPDATE foods SET type = ?, name = ?, price = ?, image = COALESCE(?, image) WHERE id_food = ?';
    $statement = $connection->prepare($updateQuery);

    try {
        $statement->execute([$type, $name, $price, $image, $id_food]);

        $response['status'] = true;
        $response['message'] = 'Success';
    } catch (Exception $e) {
        $response['status'] = false;
        $response['message'] = 'Failed:';
    }

    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;
}
?>
