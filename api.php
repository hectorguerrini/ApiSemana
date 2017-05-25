<?php
	
$db = mysqli_connect("app_semana.mysql.dbaas.com.br", "app_semana", "admin_app") or die("Nao foi possivel conectar ao servidos: ".mysqli_connect_error());
mysqli_select_db($db,"app_semana") or die("Nao foi possivel localizar banco de dados: ".mysqli_connect_error());
mysqli_set_charset($db,"utf8");
$table = isset($_GET["table"]) ? $_GET["table"] : "";

switch($table){
    case "curso":
	$periodo = isset($_GET["periodo"]) ? $_GET["periodo"] : "";
	$result = mysqli_query($db,"SELECT * FROM curso WHERE periodo_curso = '$periodo'") or die("Nao foi possivel realizar query: ".mysqli_error($db));
	if (mysqli_num_rows($result) == 0) {
	    echo ("Nenhuma linha foi achada");
    	    exit;
	}
	$print = array();
	while($row = mysqli_fetch_assoc($result)){
    	    $print[] = $row;
	}	
	break;
    case "participante":
	$ac = isset($_GET["ac"]) ? $_GET["ac"] : "";
	if($ac == "cadastro"){
	
	    $nome = isset($_GET["nome"]) ? $_GET["nome"] : "";
            $email = isset($_GET["email"]) ? $_GET["email"] : "";
            $pw = isset($_GET["pw"]) ? $_GET["pw"] : "";
            $cpf = isset($_GET["cpf"]) ? $_GET["cpf"] : "";
            $result = mysqli_query($db,"INSERT INTO participante (nome_participante,email_participante,
password_participante,cpf_participante) VALUES ('$nome','$email','$pw','$cpf')") or die("Nao foi possivel realizar query: ".mysqli_error($db));
	    if ($result == 1) {
    		$print["success"] = "Conta criada com sucesso ".$email;
	    }else{
    		$print["error"] = "error";
	    }
	}
	if($ac == "login"){
	    $email = isset($_GET["email"]) ? $_GET["email"] : "";
            $pw = isset($_GET["pw"]) ? $_GET["pw"] : "";
	    $result = mysqli_query($db,"SELECT * FROM participante WHERE email_participante = '$email' and password_participante = '$pw' ") or die("Nao foi possivel realizar query: ".mysqli_error($db));
	    if (mysqli_num_rows($result) > 0) {
    	        $print["success"] = "Bem Vindo ".$email;
	    }else{
		$print["erro"] = "Erro";
	    }
	
	}
	break;
    default:
	$result = mysqli_query($db,"SELECT * FROM $table") or die("Nao foi possivel realizar query: ".mysqli_error($db));
	if (mysqli_num_rows($result) == 0) {
    	    echo ("Nenhuma linha foi achada");
            exit;
	}
	$print = array();
	while($row = mysqli_fetch_assoc($result)){
            $print[] = $row;
	}
	break;
}

/*if($table == "curso"){
    
}elseif($table == "participante"){
    $nome = isset($_GET["nome"]) ? $_GET["nome"] : "";
    $email = isset($_GET["email"]) ? $_GET["email"] : "";
    $pw = isset($_GET["pw"]) ? $_GET["pw"] : "";
    $cpf = isset($_GET["cpf"]) ? $_GET["cpf"] : "";
    $result = mysqli_query($db,"INSERT INTO participante (nome_participante,email_participante, password_participante,cpf_participante) VALUES ('$nome','$email','$pw','$cpf')") or die("Nao foi possivel realizar query: ".mysqli_error($db));
}
else{
    $result = mysqli_query($db,"SELECT * FROM $table") or die("Nao foi possivel realizar query: ".mysqli_error($db));
}

if (mysqli_num_rows($result) == 0) {
    echo ("Nenhuma linha foi achada");
    exit;
}
$print = array();
while($row = mysqli_fetch_assoc($result)){
    $print[] = $row;
}*/
echo json_encode($print, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
mysqli_close($db);
?>



