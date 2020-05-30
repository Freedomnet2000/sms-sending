<?php

$url = $_GET['url'] ?? '';
$post = file_get_contents('php://input') ?? '';

$params = $_POST;

if ($url == 'send') {
    require 'src/controllers/SendSmsController.php';
    $controller = new SendSmsController;
    $sendResult = $controller->fireSms($params);
    echo json_encode($sendResult);
} 
elseif ($url == 'list') {
    require 'src/controllers/GetSmsController.php';

    $controller = new GetSmsController;
    $result = json_encode($controller->getSmsList());
    echo $result;
} 
else {
    require 'public/smsList.html';
}

?>