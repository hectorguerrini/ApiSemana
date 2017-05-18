<?php
	
$db = mysqli_connect("app_semana.mysql.dbaas.com.br", "app_semana", "admin_app") or die("Nao foi possivel conectar ao servidos: ");
mysqli_select_db($db,"app_semana") or die("Nao foi possivel localizar banco de dados: ");
mysqli_set_charset("utf8");
$table = isset($_GET["table"]) ? $_GET["table"] : "";
$periodo = isset($_GET["periodo"]) ? $_GET["periodo"] : "";
if($table == "curso"){
    $result = mysqli_query("SELECT * FROM curso WHERE periodo_curso = '$periodo'") or die("Nao foi possivel realizar query: ");
}
else{
    $result = mysqli_query("SELECT * FROM $table") or die("Nao foi possivel realizar query: ");
}
if (mysqli_num_rows($result) == 0) {
    echo ("Nenhuma linha foi achada");
    exit;
}
$print = array();
while($row = mysqli_fetch_assoc($result)){
    $print[] = $row;
}
echo json_encode($print, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
mysqli_close($db);
?>
