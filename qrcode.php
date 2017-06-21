<?php
require_once('sql_functions.php');
$db = new sql_functions();

$resposta = array("error"=>FALSE);

if(isset($_POST['email']) && isset($_POST['pontos']) && isset($_POST['id']) && isset($_POST['tabela']) ){
    $pontos = $_POST['pontos'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    $tabela = $_POST['tabela'];
    if($tabela == 'curso'){
        if($db->adcionarPontosCurso($email,$pontos,$id) == true){
            $resposta["error"] = FALSE;
            $resposta["error_msg"] = "Pontos Adcionados";
            echo json_encode($resposta);
        }else{
            $resposta["error"] = TRUE;
            $resposta["error_msg"] = "Não foi possivel adcionar pontos: QRcode ja utilizado";
            echo json_encode($resposta);

        }
    }else if($tabela == 'palestra'){
        if($db->adcionarPontosPalestra($email,$pontos,$id) == true){
            $resposta["error"] = FALSE;
            $resposta["error_msg"] = "Pontos Adcionados";
            echo json_encode($resposta);
        }else{
            $resposta["error"] = TRUE;
            $resposta["error_msg"] = "Não foi possivel adcionar pontos: QRcode ja utilizado";
            echo json_encode($resposta);
        }
    }
}else{
    $resposta["error"] = TRUE;
    $resposta["error_msg"] = "Nao recebeu dados";
    echo json_encode($resposta);
}



?>