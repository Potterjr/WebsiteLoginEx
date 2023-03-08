<?php
session_start();
include_once("class.db.php");
$data = new database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // register
    if (isset($_POST['id']) && isset($_POST['password']) && isset($_POST['passwordc']) && isset($_POST['role'])) {
        if ($_POST['password'] === $_POST['passwordc']) {
            $response = $data->add($_POST['id'], $_POST['password'], $_POST['role']);
            if (isset($response['status']) && $response['status'] === 'error') {
                echo json_encode(array("status" => "error", "message" => "id alrady exits"));
            } else {
                echo json_encode(array("status" => "sucess", "message" => "sucess add data"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid password"));
        }
        
        // login
        if (isset($_POST['username']) && isset($_POST['pwd'])) {
            $result = $data->login($_POST['username'], $_POST['pwd']);
            if (isset($result['status']) && $result['status'] === 'error') {
                http_response_code(400);
                echo json_encode($result);
            } else {
                $user_data = $result[0];
                echo json_encode($user_data);
                $_SESSION['id'] = $user_data['id'];
                $_SESSION['role'] = $user_data['role'];
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($data->show());
}
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $result = $data->edit(json_decode(file_get_contents("php://input"), true));
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $result = $data->del($_GET['id']);
    echo json_encode(['message' => 'Record deleted successfully']);
}
