<?php
require '/app/config/authenticate.php';
require '/app/config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    if (!empty($data)) {
        $campo1 = $data['idalg'];
        $campo2 = $data['dpv'];
        $campo3 = $data['det'];
        if (!isset($campo2)){
            $campo2 = "";
        } else if (!isset($campo3)){
            $campo3 = "";
        }
        $ret = $EmprestimosLivrosQuery->UpdateEmprestimo($campo1, $campo2, $campo3);
        
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