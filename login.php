<?php

include 'connection.php';

if ($_POST) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $response = [];

    // Check if username exists
    $userQuery = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $userQuery->execute([$username]);
    $query = $userQuery->fetch();

    if ($userQuery->rowCount() == 0) {
        $response['status'] = false;
        $response['message'] = 'Username not registered';
    } else {
        $passwordDB = $query['password'];

        if (md5($password) === $passwordDB) {
            $response['status'] = true;
            $response['message'] = 'Login Successfully';
            $responseData = [
                'id_user' => $query['id_user'],
                'username' => $query['username'],
                'name' => $query['name'],
                'role' => $query['role']
            ];
            
            if (!empty($query['image'])) {
                $responseData['image'] = base64_encode($query['image']);
            } else {
                $responseData['image'] = "";
            }
            
            $response['data'] = $responseData;
        } else {
            $response['status'] = false;
            $response['message'] = 'Incorrect password';
        }
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}
?>
