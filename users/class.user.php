<?php

require_once 'dbconfig.php';

class USER
{

 private $conn;

 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
    }

 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }

 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }

 public function register($uname,$id_no,$email,$password,$phone,$role)
 {
  try
  {
   $password = $password ;
   $stmt = $this->conn->prepare("INSERT INTO tbl_users(uname,id_no,email,password,phone,role)
	VALUES(:uname,:id_no,:email,:password,:phone,:role)");
   $stmt->bindparam(":uname",$uname);
   $stmt->bindparam(":id_no",$id_no);
   $stmt->bindparam(":email",$email);
   $stmt->bindparam(":password",$password);
   $stmt->bindparam(":phone",$phone);
   $stmt->bindparam(":role",$role);
   $stmt->execute();
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function login($id_no,$password)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE id_no=:id_no");
   $stmt->execute(array(":id_no"=>$id_no));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
   $type = $userRow['role'];

   if($stmt->rowCount() == 1)
   {
     if($userRow['password']==$password)
     {
       if($userRow['role']=="admin"){
         $_SESSION['userSession'] = $type;
         $_SESSION['userSession'] = $userRow['id_no'];
         echo "<script>window.location.assign('../index')</script>";
       }else if($userRow['role']=="user"){
         $_SESSION['userSession'] = $type;
         $_SESSION['userSession'] = $userRow['id_no'];
         echo "<script>window.location.assign('emphome')</script>";
       }else if($userRow['role']=="officer"){
         $_SESSION['userSession'] = $type;
         $_SESSION['userSession'] = $userRow['id_no'];
         echo "<script>window.location.assign('../officer/employee')</script>";
       }
     }
     else
     {
      header("Location: login.php?error");
      exit;
     }
   }
   else
   {
    header("Location: login.php?error");
    exit;
   }
 }catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }


 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }

 public function redirect($url)
 {
  header("Location: $url");
 }

 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
 }
}
