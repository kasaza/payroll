<!DOCTYPE html>
<html class="" lang="en">
<head>
	<link rel="stylesheet" href="../link/bootstrap.min.css" />
	<script src="../link/sweetalert2.all.min.js"></script>
	<script src="../link/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="../link/sweetalert2.min.css">
</head>
<body style="" class="">
	<?php
	//index.php
	$error = '';
	$name = '';
	$email = '';
	$subject = '';
	$mail2 = '';
	
	require '../PHPMailer/PHPMailerAutoload.php';
	
	if(isset($_POST["sendEMail"]))
	{
		if (isset($_POST['all_staff']))
		{
		if($error == '')
		{
			
			$connect = new PDO('mysql:host=localhost;dbname=hrm', 'root', '');
			$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $connect->prepare("SELECT * FROM tbl_employee INNER JOIN payroll ON tbl_employee.id_no = payroll.id_no ");
			$stmt->execute();
			while($row = $stmt->fetch()) {
		
			$textVersion="Dear ".$row["name"].",.\r\n Your Salary of Ksh: ".$row["net"]."Has been Disbursed";
			$mail = new PHPMailer();
			$mail->isSMTP();  
			$mail->Mailer = "smtp"; 
			$mail->SMTPAuth = true;                                   
			$mail->Host = 'smtp.gmail.com'; 
			$mail->SMTPAuth = true;                            
			$mail->Username = 'email@mail.com';                 
			$mail->Password = '###';                         
			$mail->SMTPSecure = 'tls';                           
			$mail->Port = 587;                                  
			$mail->setFrom('jeffmwn@gmail.com', 'E-Payroll TUM');
			$mail->addReplyTo('noreply@kasaza.ke','Info');
			$mail->isHTML(true);   
			$mail->addAddress($row["email"]);              
			$mail->Subject = $_POST["subject"];	
			$mail->AddEmbeddedImage('../images/tum.png', 'Tum');
			$mail->Body    ='
			<div style="background-color:#eee; margin:50px; padding:20px; border:2px solid brown;">
				 <img src=\"cid:Tum\" />
			<p style="color:red; font-weight:bold;">Dear '.$row["name"].', <br><br> Your Salary for Ksh: '.$row["net"].' has been disbursed. Please contact your bank. </p></br><p> You Ccan print your payslip from https://hrm/users/login.php.</p></br>
				<table border="1" cellpadding="5" cellspacing="0">
					<tr>
					 <td colspan="2" align="center" style="font-size:18px"><br><b>E-Pay Slip</b></td>
					</tr>
					<tr>
					 <td colspan="2">
					 
					  <table cellpadding="5">
					   <tr>
						<td width="65%"></b>
						<b>ID Number :&nbsp;&nbsp;</b> '.$row["id_no"].'<br /> 
						<b>Email :&nbsp;&nbsp;</b> '.$row["email"].'<br /> 
						<b>Name :&nbsp;&nbsp;</b> '.$row["name"].'<br />
						<b>Staff No:&nbsp;&nbsp;</b>  '.$row["p_id"].'
						</td>
						<td width="35%">
						<b>Account No. :&nbsp;&nbsp;</b> '.$row["account"].'<br />
						<b>Bank Name :&nbsp;&nbsp;</b> '.$row["bank"].'<br />
						<b>Pay Date :&nbsp;&nbsp;</b> '.$row["date"].'<br />
						</td>
					   </tr>
					  </table>
					  
					  <br/>
					  <table border="1" cellpadding="5" cellspacing="0">
					<tr>  
					<td><b>Designation Pay:&nbsp;&nbsp;</b</td>
					<td>Ksh. '.$row["designation"].' .00</td>  
					<td><b>Jobgroup Pay:&nbsp;&nbsp;</b>Ksh. '.$row["jobgroup"].' .00</td>  
					</tr>

					<tr>  
					<td><b>Allowances:</b></td>
					<td>
						1. Medical:&nbsp;&nbsp;Ksh. '.$row["medical"].' .00<br>
						2. Transport:&nbsp;&nbsp;Ksh. '.$row["transport"].' .00<br>
						3. Risk:&nbsp;&nbsp;Ksh. '.$row["risk"].' .00<br>
						4. House:&nbsp;&nbsp;Ksh. '.$row["house"].' .00 
					</td>
					<td><b>Total Allowances:&nbsp;&nbsp;&nbsp;</b> Ksh. '.$row["totalAll"].' .00</td>						 
					</tr>
					  <tr>  
						<td><b>Deductions:</b></td>  
						<td>
							1. NHIF:&nbsp;&nbsp;Ksh. '.$row["nhif"].' .00<br>
							2. HELB Loan:&nbsp;&nbsp;Ksh. '.$row["helb"].' .00<br>
							3. NSSF:&nbsp;&nbsp;Ksh. '.$row["nssf"].' .00<br>
							4. Elimu:&nbsp;&nbsp;Ksh. '.$row["elimu"].' .00 
						</td>
						<td><b>Total Deductions:&nbsp;&nbsp;&nbsp;</b>Ksh. '.$row["totalDed"].' .00</td>  
					  </tr>
					  <tr>  
						 <td><b>Bonus:</b></td>  
						 <td>Ksh. '.$row["bonus"].' .00</td>  
						 <td><b>Salary Inc.:&nbsp;&nbsp;</b> Ksh. '.$row["inc_amount"].' .00</td>   
					  </tr>
					  </table>
					  <br/>
					  <table border="1" cellpadding="5" style="margin-bottom:20px;" cellspacing="0">
					  <tr>  
						<td><b>Basic Salary:&nbsp;&nbsp;</b>Ksh. '.$row["basic"].' .00</td>  
						<td><b>Gross Income:&nbsp;&nbsp;</b>Ksh. '.$row["gross"].' .00</td>  
						<td><b>Net Salary:&nbsp;&nbsp;</b>Ksh. '.$row["net"].' .00</td>  
					  </tr>
					  </table>
				   </table></div>';
			$mail->AltBody = $textVersion;
			
			if($mail->Send())								
			{
			?>
			<script>
			 swal({title:'Success...!', text:'Mail was Successfully Sent!', type: 'success', 
			 onClose: function () {window.location.href='sms';} });
			</script>
			<?php 
			}
			else
			{
				$error =  "<div class='alert alert-danger '><button class='close' data-dismiss='alert'>&times;</button>
						 <strong>Sorry!</strong>  Encountered an Error: <b>'".$mail->ErrorInfo."'</b></div>";
			}
			}
		}
		}
		else {
			if($error == '')
			{
			$mail = new PHPMailer();
			$mail->isSMTP();  
			$mail->Mailer = "smtp"; 
			$mail->SMTPAuth = true;                                   
			$mail->Host = 'smtp.gmail.com'; 
			$mail->SMTPAuth = true;                            
			$mail->Username = 'email@mail.com';                 
			$mail->Password = '###';                         
			$mail->SMTPSecure = 'tls';                           
			$mail->Port = 587;                                  
			$mail->setFrom('jeffmwn@gmail.com', 'E-Payroll');
			$mail->addReplyTo('noreply@kasaza.ke','Info');
			$mail->isHTML(true);   
			$mail->addAddress($_POST["email"]);                               
			$mail->Subject = $_POST["subject"];	
			$mail->AddEmbeddedImage('../images/tum.png', 'Tum');
			$mail->Body    ="<div style='background-color:#ccc; margin:20px; padding:10px;'>'".$_POST["mail2"]."'<br> 
			<h3 style='border-top:1px solid blue'>Kasaza Sent This</h3> <img src=\"cid:Tum\" />";	
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';	
			if($mail->Send())								
			{
			?>
			<script>
			 swal({title:'Success...!', text:'Mail was Successfully Sent to All Staff!', type: 'success', 
			 onClose: function () {window.location.href='sms';} });
			</script>
			<?php 
			}
			else
			{
				$error =  "<div class='alert alert-danger '><button class='close' data-dismiss='alert'>&times;</button>
						 <strong>Sorry!</strong>  Encountered an Error: <b>'".$mail->ErrorInfo."'</b></div>";
			}
			$name = '';
			$email = '';
			$subject = '';
			$mail2 = '';
		}
		}
	}
	?>
	</body>
	</html>
