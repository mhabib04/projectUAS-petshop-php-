<?php

include "connection.php";

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$response = [];

$type = isset($_POST['id_accessories']) ? $_POST['id_accessories'] : '';

$sql = $type ? "SELECT * FROM accessories WHERE id_accessories = ?" : "SELECT * FROM accessories";
$statement = $connection->prepare($sql);

if ($type) {
    $statement->execute([$type]);
} else {
    $statement->execute();
}

$list_data = [];

while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
    $list_data[] = [
        'id_accessories' => $data['id_accessories'],
        'name' => $data['name'],
        'price' => $data['price'],
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
