<?php

$db = mysqli_connect("app_semana.mysql.dbaas.com.br", "app_semana", "admin_app") or die("Nao foi possivel conectar ao servidos: ".mysqli_connect_erro$
mysqli_select_db($db,"app_semana") or die("Nao foi possivel localizar banco de dados: ".mysqli_connect_error());
mysqli_set_charset($db,"utf8");
$nome = isset($_GET["nome"]) ? $_GET["nome"] : "";
$email = isset($_GET["email"]) ? $_GET["email"] : "";
$pw = isset($_GET["pw"]) ? $_GET["pw"] : "";
$cpf = isset($_GET["cpf"]) ? $_GET["cpf"] : "";

$result = mysqli_query($db,"INSERT INTO participante (name_participante,email_participante, password_participante,cpf_participante) VALUES ('$nome','$email','$pw','$cpf')") or die("Nao foi possivel realizar query: ".mysqli_error($db));

if ($result == 1) {
    $print["success"] = "Conta criada com sucesso ".$email;
}else{
    $print["error"] = "error";
}
echo json_encode($print);
mysqli_close($db);
?>





