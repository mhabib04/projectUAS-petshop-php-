<?php

include "connection.php";

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$response = [];

$type = isset($_POST['id_pet']) ? $_POST['id_pet'] : '';

$sql = $type ? "SELECT * FROM pets WHERE id_pet = ?" : "SELECT * FROM pets";
$statement = $connection->prepare($sql);

if ($type) {
    $statement->execute([$type]);
} else {
    $statement->execute();
}

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
        'data' => [],
        'message' => 'data kosong'
    ];
} else {
    $response = [
        'status' => true,
        'data' => $list_data
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>
