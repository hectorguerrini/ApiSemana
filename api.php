<?php
	
require_once('sql_functions.php');
$db = new sql_functions();

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
?>



