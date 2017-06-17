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

    public function cadastrarUser($nome, $email, $password, $cpf,$rg,$data,$sexo,$tel,$cel){
       
            
        $stmt = $this->conn->prepare("INSERT INTO participante (nome_participante,email_participante,
password_participante,cpf_participante,rg_participante,birthdate_participante,sexo_participante,telefone_participante,
celular_participante) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssss',$nome,$email,$password,$cpf,$rg,$data,$sexo,$tel,$cel);
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
    public function adcionarPontos($email,$pontos,$curso){
        $stmt = $this->conn->query("SELECT pontos_participante FROM participante WHERE email_participante = '$email'");
        $p = $stmt->fetch_assoc();
        $stmt->close();

        $novoPont = $p['pontos_participante'] + $pontos;  
        $sql = "UPDATE participante SET pontos_participante = '$novoPont' WHERE email_participante = '$email'";
        $stmt = $this->conn->query($sql);

      


        $sql = "INSERT INTO participante_curso(id_curso,email_participante) VALUES ('$curso','$email')";
        $stmt = $this->conn->query($sql);    
       

        if($stmt){
            $stmt->close();
            return true;
        }else{
            
            return false;
        }
  } 
  public function listarRanking(){
      $sql = "SELECT nome_participante,pontos_participante,email_participante FROM participante ORDER BY pontos_participante DESC";
      $stmt = $this->conn->query($sql);
      $ranking = array();
      if($stmt){
          while($row = $stmt->fetch_assoc()){
              $ranking[]=$row;
          }
          $stmt->close();
      }
      return $ranking;
  }
  public function validarEmail($str)
{

    $rule = '/^([0-9,a-z,A-Z,_,-,.]+)([.,_,-]([0-9,a-z,A-Z,_,-,.]+))';
    $rule.= '*[@]([0-9,a-z,A-Z]+)([.,-]([0-9,a-z,A-Z]+))';
    $rule.= '*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$/';

    return (preg_match($rule, $str)? true : false);

}

}

?>
