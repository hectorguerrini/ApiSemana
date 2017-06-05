<?php
class sql_functions{
    private $conn;

    function __construct(){
        require_once('Connect.php');

        $db = new connect();
        
        $this->conn = $db->conectar();
        $this->conn->set_charset("utf8");

    }
    function __destruct(){


    }

    public function cadastrarUser($nome, $email, $password, $cpf,$rg,$data,$tel,$cel){
        if(strlen($password) >=4 && strlen($password) <=16){
        $stmt = $this->conn->prepare("INSERT INTO participante (nome_participante,email_participante,
password_participante,cpf_participante,rg_participante,birthdate_participante,telefone_participante,
celular_participante) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss',$nome,$email,$password,$cpf,$rg,$data,$tel,$cel);
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
        }else{
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
    public function listarCursos($periodo){
        $sql="SELECT * FROM curso WHERE periodo_curso = '$periodo'";  
        
        $stmt = $this->conn->query($sql);
        $curso=array();

        if($stmt){  
            while($row = $stmt->fetch_assoc()){
                $curso[]=$row; 
            }
            $stmt->close();
        }
        
        return $curso;
    }
    public function adcionarPontos(){
        $sql = "UPDATE participante SET pontos_participante = 50 WHERE id_participante = 1";
    
        $stmt = $this->conn->query($sql);

       
    } 
}
?>
