<?php
require_once('sql_functions.php');
$db = new sql_functions();

$resposta = array("error"=>FALSE);

if(isset($_POST['email']) && isset($_POST['pontos']) && isset($_POST['curso'])){
    $pontos = $_POST['pontos'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];

    if($db->adcionarPontos($email,$pontos,$curso) == true){
        $resposta["error"] = FALSE;
        echo json_encode($resposta);
    }
}else{
    $resposta["error"] = TRUE;
    $resposta["error_msg"] = "Nao recebeu dados";
    echo json_encode($resposta);
}



?>