<?php
ini_set('display_errors', 1);
session_start();
require_once 'class.user.php';
$user_login = new USER();
if($user_login->is_logged_in()!="")
{
  $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE id_no=:id_no");
  $stmt->execute(array(":id_no"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row['role']=="admin"){
    $user_login->redirect('../index');
  }else if($row['role']=="user"){
    $user_login->redirect('emphome');
  }else if($row['role']=="officer"){
    $user_login->redirect('../officer/employee');
  }
}

if(isset($_POST['btn-login']))
{
 $id_no = trim($_POST['id_no']);
 $password = trim($_POST['password']);

 if($user_login->login($id_no,$password))
 {
  #$user_login->redirect('signup.php');
 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta charset="utf-8">
	<title>E-Payroll System >Staff Login</title>  
	<link rel="icon" href="../images/mylogo.jpg" type="image/x-icon"/>
    <link href="bootstrap.min.css" rel="stylesheet">
	 <link href="../link/layout.css" rel="stylesheet">
    <link href="link/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
  <!-- Navigation -->
  <div class="navbar">
	<b><center>E-Payroll Login<a href="signup" class="btn btn-register" type="submit" name="btn-login">Register</a></center></b>
  </div>
	<div class="col-md-4 ">
		<div class="login-panel panel panel-default">
			<div class="panel-heading"><center><b>LOGIN</b></center></div>
			<div class="panel-body">
				<form name="login" onsubmit="return validateForm();" method="post">
			
					  <?php
							if(isset($_GET['error']))
					  {
					   ?>
						<div class='alert alert-danger'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Wrong Details!</strong>
					   </div>
					  <?php
					  }
					  ?>
						<input class="form-control" placeholder="ID Number" name="id_no" id="id_no" onkeypress="return isNumber(event)" maxlength="8">
						<input class="form-control" placeholder="Password" name="password" type="password" id="password">
						<button class="btn btn-success " type="submit" name="btn-login">Login</button>
						</br></br>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		  <div class="copyrght">
			<ul><li>&copy; Kasaza Sylvester  <?php echo date('Y'); ?></li></ul>
		 </div>
	</div>
</body>
</html>
<script>
function validateForm() {
	
	var id = document.forms["login"]["id_no"].value;
	var id2 = /\b.{7,8}\b/;
   
	var ps = document.forms["login"]["password"].value;
	var ps2 = /\b.{5,128}\b/;
	
     if (id.length==0) {
		alert('Please enter ID Number!')
       document.getElementById('id_no').focus();
        return false;
    }else if (!id.match(id2)) {
        alert("ID Number must be 7-8 Characters!");
		 document.getElementById('id_no').focus();
        return false;
    }else if (ps.length==0) {
		alert('Please enter a Password!')
       document.getElementById('password').focus();
        return false;
    }else if (!ps.match(ps2)) {
        alert("Password must be at least 5 Characters!");
		 document.getElementById('password').focus();
        return false;
    }
	return true;
}
</script>
<script type="text/javascript">
	//Only numbers Validator
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	//Only letters Validator
	function isLetter(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return true;
    }
	return false;
	}
</script>