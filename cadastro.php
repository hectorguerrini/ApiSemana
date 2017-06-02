<?php
require_once('sql_functions.php');
$db = new sql_functions();

$resposta = array("error"=>FALSE);

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cpf'])) {
 
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpf = $_POST['cpf'];

   
    if ($db->verificarUser($email)) {
        
        $resposta["error"] = TRUE;
        $resposta["error_msg"] = "Usuario já cadastrado com " . $email;
        echo json_encode($resposta);
    } else {
        
        $user = $db->cadastrarUser($nome, $email, $password,$cpf);
        
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
    }
} else {
    $resposta["error"] = TRUE;
    $resposta["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($resposta);
}

?>