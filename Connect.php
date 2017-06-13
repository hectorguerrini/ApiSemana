<?php
class connect{
    private $conn;

    public function conectar(){
        $this->conn = new mysqli("179.188.16.118","semanamaua2","app_semana","semanamaua2");

        return $this->conn;
    }

}

?>