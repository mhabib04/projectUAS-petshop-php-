<?php

include 'connection.php';

if ($_POST && isset($_POST['id_accessories'])) {
    $id_accessories = $_POST['id_accessories'];
    $response = [];

    $deleteAccessories = 'DELETE FROM accessories WHERE id_accessories = ?';
    $statement = $connection->prepare($deleteAccessories);

    $statement->execute([$id_accessories]);

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
