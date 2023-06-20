<?php
require '/app/config/authenticate.php';
require '/app/config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    if (!empty($data)) {
        $campo1 = $data['id'];

        $ret = $LivrosQuery->DeleteLivro($campo1);
        
        if ($ret[0]) {
            header("HTTP/1.1 200 OK");
            header('Content-Type: application/json');
        }else {
            header("HTTP/1.1 400 Bad Request");
            header('Content-Type: application/json');
        }
        echo json_encode(array("msg"=>$ret[1]));
    }
}
?>