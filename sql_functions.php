<?php
class sql_functions{
    private $conn;

    function __construct(){
        require_once('Connect.php');

        $db = new connect();

        $this->conn = $db->conectar();

    }
    function __destruct(){


    }

    public function cadastrarUser($nome, $email, $password, $cpf){
        $stmt = $this->conn->prepare("INSERT INTO participante (nome_participante,email_participante,
password_participante,cpf_participante) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss',$nome,$email,$password,$cpf);
        $result = $stmt->execute();
        $stmt->close();
        
        if($result){
            $stmt = $this->conn->prepare("SELECT * FROM participante WHERE email_participante = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }

    public function loginUser($email,$password){
        $stmt = $this->conn->prepare("SELECT * FROM participante WHERE email_participante = ?");
        $stmt->bind_param('s',$email);
        if($stmt->execute()){
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            $db_password = $user['password_participante'];
            if($db_password == $password){
                return $user;
            }
        }else{
            return NULL;
        }
    }
    public function verificarUser($email) {
        $stmt = $this->conn->prepare("SELECT email_participante from participante WHERE email_participante = ?");

        $stmt->bind_param('s', $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) { 
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    public function listarTabelas($table){
        $sql="SELECT * FROM ".$table;
        $stmt = $this->conn->query($sql);
        $print=array();
        if($stmt){
            while($row = $stmt->fetch_assoc()){
                $print[]=$row;
            }
            $stmt->close();
        }
        
        return $print;
    }    
}
?>
