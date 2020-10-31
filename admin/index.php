<?php
//index.php
$email = '';
$subject = '';
$message = '';
if(isset($_POST["submit"]))
{
		require 'PHPMailer/PHPMailerAutoload.php';
		
		$mail = new PHPMailer;
		$mail->IsSMTP();								
		$mail->Host = 'smtp.gmail.com';					
		$mail->Port = 587;								
		$mail->SMTPAuth = true;							
		$mail->Username = 'email@mail.com';			
		$mail->Password = 'password;				
		$mail->SMTPSecure = 'tls';							
		$mail->SetFrom('jeffmwn@gmail.com', 'SW Engineer');					
		$mail->Name = 'Jeff Kasaza';				
		$mail->addAddress($_POST["email"]);	
		$mail->WordWrap = 50;							
		$mail->IsHTML(true);							
		$mail->Subject = $_POST["subject"];				
		$mail->Body = $_POST["message"];	
		$mail->AltBody = 'Wow! this is awesome';	
		if($mail->Send())								
		{
			echo '<label class="text-success"> Message Sent!</label>';
		}
		else
		{
			echo '<label class="text-danger">There is an Error</label>';
			echo 'Mailer Error:'.$mail->ErrorInfo;
		}
		
		require'../PHPMailer/PHPMailerAutoload.php';

$mail= new PHPMailer();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth='true';
$mail->Username='email@mail.com;
$mail->Password='password;
$mail->SMTPSecure='tls';
$mail->Port=587;
$mail->SetFrom('TechEng@kasaza.k','SWEngineer');
$mail->addAddress('jeffkasaza@gmail.com','jeffmwn@gmail.com');
$mail->addReplyTo('Noreply@kasaza','Info');
$mail->isHTML(true);
$mail->addAttachment('logo.jpeg');
$mail->Subject='E-Payroll Test';
$mail->Body='This is your Pay - Slip <br> <h1>Kasaza Sent This</h1>';

if($mail->send())
{
	echo 'Mail Sent';
}
else
{
	echo 'Mail Send Failure';
}
		$email = '';
		$subject = '';
		$message = '';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Send an Email on Form Submission using PHP with PHPMailer</title>
		<script src="link/jquery.min.js"></script>
		<link rel="stylesheet" href="link/bootstrap.min.css" />
		<script src="link/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<div class="row">
				<div class="col-md-8" style="margin:0 auto; float:none;">
					<h3 align="center">Send an Email on Form Submission using PHP with PHPMailer</h3>
					<br />
					<form method="post">
						<div class="form-group">
							<label>Enter Email</label>
							<input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" />
						</div>
						<div class="form-group">
							<label>Enter Subject</label>
							<input type="text" name="subject" class="form-control" placeholder="Enter Subject" value="<?php echo $subject; ?>" />
						</div>
						<div class="form-group">
							<label>Enter Message</label>
							<textarea name="message" class="form-control" placeholder="Enter Message"><?php echo $message; ?></textarea>
						</div>
						<div class="form-group" align="center">
							<input type="submit" name="submit" value="Submit" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>





