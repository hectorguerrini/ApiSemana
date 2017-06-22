<?php
require_once('sql_functions.php');
$db = new sql_functions();
 

$resposta = array("error" => FALSE);
 
if (isset($_POST['email']) && isset($_POST['password'])) {
 
   
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    
    $user = $db->loginUser($email, $password);
 
    if ($user != false) {
        // use is found
        $resposta["error"] = FALSE;
       
        $resposta["error_msg"] = "Conectado com Sucesso!.";
       
        echo json_encode($resposta);
    } else {
        // user is not found with the credentials
        $resposta["error"] = TRUE;
        $resposta["error_msg"] = "Credenciais de login Incorretas. ";
        echo json_encode($resposta);
    }
} else {
    // required post params is missing
    $resposta["error"] = TRUE;
    $resposta["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($resposta);
}
?>
