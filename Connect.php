<?php
class connect{
    private $conn;

    public function conectar(){
        $this->conn = new mysqli("app_semana.mysql.dbaas.com.br","app_semana","admin_app","app_semana");

        return $this->conn;
    }

}

?>