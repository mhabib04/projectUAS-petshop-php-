<?php

include "connection.php";

// Tambahkan header untuk no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

$response = [];

$sql = "SELECT * FROM pets";
$statement = $connection->prepare($sql);
$statement->execute();

$list_data = [];

while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
    $list_data[] = [
        'id_pet' => $data['id_pet'],
        'type' => $data['type'],
        'breed' => $data['breed'],
        'price' => $data['price'],
        'age' => $data['age'],
        'image' => base64_encode($data['image'])
    ];
}

if (empty($list_data)) {
    $response = [
        'status' => false,
        'message' => 'Data kosong.'
    ];
} else {
    $response = [
        'status' => true,
        'data' => $list_data
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>
