<?php

include 'connection.php';

if($_POST){
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = null;
    }

    $response = [];

    $userQuery = $connection->prepare("SELECT * FROM users where username = ?");
    $userQuery->execute(array($username));

    if($userQuery->rowCount() != 0){
        $response['status'] = false;
        $response['message'] = $username;
    } else {
        $insertAccount = 'INSERT INTO users (username, password, name, role, image) VALUES (?, ?, ?, ?, ?)';
        $statement = $connection->prepare($insertAccount);

        try {
            $statement->execute([$username, md5($password), $name, $role, $image]);

            $response['status'] = true;
            $response['message'] = $username;
            $response['data'] = [
                'username' => $username,
                'name' => $name,
                'role' => $role
            ];
        } catch (Exception $e){
            $response['status'] = false;
            $response['message'] = "Failded to register";
        }

    }
    
    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;
}
?>