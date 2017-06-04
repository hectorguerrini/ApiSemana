<?php
	
require_once('sql_functions.php');
$db = new sql_functions();
 
//$table =  ? $_GET["table"] : "";

/*if($table == "curso"){
    
}elseif($table == "participante"){
    $nome = isset($_GET["nome"]) ? $_GET["nome"] : "";
    $email = isset($_GET["email"]) ? $_GET["email"] : "";
    $pw = isset($_GET["pw"]) ? $_GET["pw"] : "";
    $cpf = isset($_GET["cpf"]) ? $_GET["cpf"] : "";
    $result = mysqli_query($db,"INSERT INTO participante (nome_participante,email_participante, password_participante,cpf_participante) VALUES ('$nome','$email','$pw','$cpf')") or die("Nao foi possivel realizar query: ".mysqli_error($db));
}
*/


if(isset($_GET["table"])){  
    $table = $_GET["table"];
    if($table == 'curso'){
        if(isset($_GET["periodo"])){
            $periodo = $_GET["periodo"];
            $resposta = $db->listarCursos($periodo);
        }
            
    }else{
        $resposta = $db->listarTabelas($table);
    }
    
	echo json_encode($resposta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}


/*if (mysqli_num_rows($result) == 0) {
    echo ("Nenhuma linha foi achada");
    exit;
}
$print = array();
while($row = mysqli_fetch_assoc($result)){
    $print[] = $row;
}*/
//echo json_encode($print, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>



