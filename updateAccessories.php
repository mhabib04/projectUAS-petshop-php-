<?php

include 'connection.php';

if ($_POST) {
    $id_accessories = isset($_POST['id_accessories']) ? $_POST['id_accessories'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = null;
    }

    $response = [];

    $updateQuery = 'UPDATE accessories SET name = ?, price = ?, image = COALESCE(?, image) WHERE id_accessories = ?';
    $statement = $connection->prepare($updateQuery);

    try {
        $statement->execute([$name, $price, $image, $id_accessories]);

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
