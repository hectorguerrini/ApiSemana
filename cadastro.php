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
            if($db->validarEmail($email) == true){
                if(verificarCPF($cpf)== true){
                    $user = $db->cadastrarUser($nome, $email, $password,$cpf,$rg,$data,$sexo,$tel,$cel);
                
                    if ($user) {
        
                        $resposta["error"] = FALSE;
                        $resposta["user"]["nome"] = $user["nome_participante"];
                        $resposta["user"]["email"] = $user["email_participante"];
                        if($db->adcionarPontos($email,10) == true){
                        $resposta["user"]["pontos"] = "10";
                        }   
                        echo json_encode($resposta);
                    } else {
                    
                        $resposta["error"] = TRUE;
                        $resposta["error_msg"] = "Erro desconhecido ocorreu!";
                        echo json_encode($resposta);
                    }
                }else{
                    $resposta["error"] = TRUE;
                    $resposta["error_msg"] = "CPF invalido!!";
                    echo json_encode($resposta);
                }
            }else{
                $resposta["error"] = TRUE;
                $resposta["error_msg"] = "Insira um email valido.(ex: nome@email.com)";
                echo json_encode($resposta);
            }
        }else {
            $resposta["error"] = TRUE;
            $resposta["error_msg"] = "Insira uma senha entre 4 e 16 caracteres.";
            echo json_encode($resposta);
        }
    }
} else {
    $resposta["error"] = TRUE;
    $resposta["error_msg"] = "Insira os dados necessarios.";
    echo json_encode($resposta);
}


function verificarCPF( $cpf ) { 
    
    $cpf= str_replace("-", "", $cpf);
    $cpf = str_replace(".", "", $cpf); 
    
    if ( strlen( $cpf ) != 11 ) {
        return false; 
    } 
    
    $codigo = substr($cpf, 0, 9);
    
    $soma = 0;
    $numero = 10; 
    for ($i=0; $i < 9; $i++) {
         $soma += ( $codigo[$i]*$numero-- ); 
    } 
    $resto = $soma%11;
    if($resto < 2) {
        $codigo .= "0";
    }else{
        $codigo .= (11-$resto);
    }
    
    $soma = 0;
    $numero = 11;
    for ($i=0; $i < 10; $i++) { 
        $soma += ( $codigo[$i]*$numero-- ); 
    } 
    $resto = $soma%11;
    if($resto < 2){
        $codigo .= "0"; 
    }else{ 
        $codigo .= (11-$resto);
    }
    if ( $codigo === $cpf ) { 
        return true;
    } else { 
         return false;
    } 
} 
       
?>