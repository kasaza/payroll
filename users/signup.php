<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
  $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE id_no=:id_no");
  $stmt->execute(array(":id_no"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row['role']=="admin"){
    $reg_user->redirect('employee');
  }else if($row['role']=="user"){
    $reg_user->redirect('employee/emphome');
  }
}

if(isset($_POST['btn-signup']))
{
 $uname = trim($_POST['uname']);
 $id_no = trim($_POST['id_no']);
 $email = trim($_POST['email']);
 $password = trim($_POST['password']);
 $phone = trim($_POST['phone']);
 $role = trim($_POST['role']);

 $stmt1 = $reg_user->runQuery("SELECT * FROM tbl_users WHERE id_no=:id_no");
 $stmt1->execute(array(":id_no"=>$id_no));
 $stmt2 = $reg_user->runQuery("SELECT * FROM tbl_users WHERE email=:email");
 $stmt2->execute(array(":email"=>$email));
 $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
 $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

 if($stmt1->rowCount() > 0)
 {
  $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  User with that ID Number already exists , Please Try another one
     </div>
     ";
 } 
  else if($stmt2->rowCount() > 0)
 {
  $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  User with that Email already exists , Please Try another one
     </div>
     ";
 }else {
  if($reg_user->register($uname,$id_no,$email,$password,$phone,$role)){
    $msg = "
          <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
       <strong>Success !</strong>  You can now login.
       </div>
       ";
 }else  {
   echo "sorry , Query could no execute...";
  }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta charset="utf-8">
	<title>E-Payroll System >Staff Signup</title>  
	<link rel="icon" href="../images/mylogo.jpg" type="image/x-icon"/>
    <link href="bootstrap.min.css" rel="stylesheet">
	 <link href="../link/layout.css" rel="stylesheet">
    <link href="link/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body class="">
          <!-- Navigation -->
		<div class="navbar">
			<b><center>E-Payroll Staff Registration<a href="login" class="btn btn-register" type="submit" name="btn-login">Login</a></center></b>
		</div>
            <div class="col-md-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
					<div class="panel-heading"><center><b>REGISTER</b></center></div>
                    </div>
                    <div class="panel-body">
                    <form name="signup" onsubmit="return validateForm();" method="post">
						<?php if(isset($msg)) echo $msg;  ?>
						
							<input class="form-control" placeholder="Username" name="uname" id="uname">
							 <input class="form-control" placeholder="ID Number" name="id_no" id="id_no" onkeypress="return isNumber(event)" maxlength="8" >
							<input class="form-control" placeholder="E-mail" name="email"  id="email">
							<input class="form-control" placeholder="Phone number" name="phone" id="phone" onkeypress="return isNumber(event)" maxlength="10">
							<input type="hidden" name="role" id="role" class="form-control" value="user" />
							<input class="form-control" placeholder="Password" name="password" id="password" type="password"value="" onchange="validateForm()"/>
							 <button class="btn btn-lg btn-success btn-block" type="submit" name="btn-signup" >SIGNUP</button>
							 <input type="reset" name="" class="btn btn-danger" value="Clear Fields"/>
					
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
	var u = document.forms["signup"]["uname"].value;
	var id = document.forms["signup"]["id_no"].value;
	var id2 = /\b.{7,8}\b/;
    var e = document.forms["signup"]["email"].value;
    var atpos = e.indexOf("@");
    var dotpos = e.lastIndexOf(".");
	var p = document.forms["signup"]["phone"].value;
	var selRole = document.querySelector("#role");
	var ps = document.forms["signup"]["password"].value;
	var ps2 = /\b.{5,128}\b/;
	
    if (u.length==0) {
		alert('Please enter Your Username!')
       document.getElementById('uname').focus();
        return false;
    }else if (id.length==0) {
		alert('Please enter ID Number!')
       document.getElementById('id_no').focus();
        return false;
    }else if (!id.match(id2)) {
        alert("ID Number must be 7-8 Characters!");
		 document.getElementById('id_no').focus();
        return false;
    }else if (e.length==0) {
		alert('Please enter Your Email Addresss!')
       document.getElementById('email').focus();
        return false;
    }else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=e.length) {
		alert('Please enter a valid Email Addresss!')
       document.getElementById('email').focus();
        return false;
    }else if (p.length==0) {
		alert('Please enter Phone Number!')
       document.getElementById('phone').focus();
        return false;
    }else if (selRole.selectedIndex === 0) {
		alert('Please Select Role!')
       document.getElementById('role').focus();
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
// validate that the user made a selection other than default

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