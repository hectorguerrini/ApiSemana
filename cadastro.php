<?php
require_once('sql_functions.php');
$db = new sql_functions();

$resposta = array("error"=>FALSE);

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cpf'])) {
 
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $data = $_POST['data'];
    $tel = $_POST['tel'];
    $cel = $_POST['cel'];
    $sexo = $_POST['sexo'];

   
    if ($db->verificarUser($email)) {
        
        $resposta["error"] = TRUE;
        $resposta["error_msg"] = "Usuario já cadastrado com " . $email;
        echo json_encode($resposta);
    } else {
        if(strlen($password) >=4 && strlen($password) <=16){
            $user = $db->cadastrarUser($nome, $email, $password,$cpf,$rg,$data,$sexo,$tel,$cel);
        
            if ($user) {
        
                $resposta["error"] = FALSE;
                $resposta["user"]["nome"] = $user["nome_participante"];
                $resposta["user"]["email"] = $user["email_participante"];
           
                echo json_encode($resposta);
            } else {
                // user failed to store
                $resposta["error"] = TRUE;
                $resposta["error_msg"] = "Erro desconhecido ocorreu!";
                echo json_encode($resposta);
            }
        }else {
            $resposta["error"] = TRUE;
            $resposta["error_msg"] = "Insira uma senha entre 4 e 16 caracteres.";
        }
    }
} else {
    $resposta["error"] = TRUE;
    $resposta["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($resposta);
}

?>