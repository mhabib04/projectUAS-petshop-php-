<?php

include 'connection.php';

if ($_POST && isset($_POST['id_food'])) {
    $id_food = $_POST['id_food'];
    $response = [];

    $deleteFood = 'DELETE FROM foods WHERE id_food = ?';
    $statement = $connection->prepare($deleteFood);

    $statement->execute([$id_food]);

    $rowCount = $statement->rowCount();

    if ($rowCount > 0) {
        $response['status'] = true;
        $response['message'] = 'Success';
    } else {
        $response['status'] = false;
        $response['message'] = 'Not Found';
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

?>
