<?php

include 'connection.php';

if ($_POST && isset($_POST['id_pet'])) {
    $id_pet = $_POST['id_pet'];
    $response = [];

    $deletePet = 'DELETE FROM pets WHERE id_pet = ?';
    $statement = $connection->prepare($deletePet);

    $statement->execute([$id_pet]);

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
