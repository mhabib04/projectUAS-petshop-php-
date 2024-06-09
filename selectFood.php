<?php

include "connection.php";

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$response = [];

$sql = "SELECT * FROM foods";
$statement = $connection->prepare($sql);
$statement->execute();

$list_data = [];

while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
    $list_data[] = [
        'id_food' => $data['id_food'],
        'type' => $data['type'],
        'name' => $data['name'],
        'price' => $data['price'],
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
