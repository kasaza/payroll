<?php  $connect = mysqli_connect("localhost", "root", "", "hrm");   ?>
<?php include 'sendmail.php'; ?> 
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > SMS & Mail</title>  
<link rel="icon" href="../images/mylogo.jpg" type="image/x-icon"/>
<link href="../link/nanoscroller.css" media="screen" rel="stylesheet" type="text/css">
	<link href="../link/style-1.css" media="screen" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../link/layout.css" type="text/css" />
	<!------CSS LINKS>-------->	
	<link rel="stylesheet" href="../link/bootstrap.min.css" />
	<link rel="stylesheet" href="../link/dataTables.bootstrap.min.css"/>
	<script src="../link/jquery.js"></script>
	<script src="../link/jquery.min.js"></script>
	<script src="../link/jquery.dataTables.min.js"></script>
	<script src="../link/dataTables.bootstrap.min.js"></script>  
	<script src="../link/bootstrap.min.js"></script>
	<script type="text/javascript" src="../date/search/date.js"></script>
	
	<link href="../link/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="../link/assets/main.css" />
    <link rel="stylesheet" href="../link/assets/font-awesome.css" />
     <link rel="stylesheet" href="../link/assets/bootstrap-wysihtml5-0.0.2.css" />
	
	<script src="../link/assets/wysihtml5-0.3.0.min.js"></script>
    <script src="../link/assets/bootstrap-wysihtml5-hack.js"></script>
    <script src="../link/assets/editorInit.js"></script>
</head>
<body style="" class="">
  <div class="tab-content col-kk-12">
		<div class="col-lg-6">
			<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>General SMS</h5>
				<ul class="nav1 pull-right">
					<li>
						<div class="btn-group">
							<a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse" href="#div-3"><i class="icon-minus"></i></a>
							 <button class="btn btn-danger btn-xs close-box"><i class="icon-remove"></i></button>
						</div>
					</li>
				</ul>
			</header>
			<div id="div-3" class="body collapse in">
	<?php
		//index.php
		$phone = '';
		$message = '';
		$recipients ='';
		if(isset($_POST["sendSMS"]))
		{
		if (isset($_POST['all_staff']))
			{
			require_once('AfricasTalkingGateway.php');
			$username   = "e-payroll";
			$apikey     = "#######";
			$recipients = $_POST["phone"];
			$message    = $_POST["message"];
			$gateway    = new AfricasTalkingGateway($username, $apikey);

			try 
			{ 
			  $results = $gateway->sendMessage($recipients, $message);
						
			  foreach($results as $result) {
				echo " Number: " .$result->number;
				echo " Status: " .$result->status;
				echo " MessageId: " .$result->messageId;
				echo " Cost: "   .$result->cost."\n";
			  }
			  ?>
			<script>
			 swal({title:'Success...!', text:'Messa was Successfully Sent!', type: 'success', 
			 onClose: function () {window.location.href='mail.php';} });
			</script>
			<?php 
			}
			catch ( AfricasTalkingGatewayException $e )
			{
			  echo "<label class='text-danger'>Encountered an ERROR while sending SMS: ".$e->getMessage()."</label>";
			}
		}
		else{
			$message = '';
			$recipients ='';
			require_once('AfricasTalkingGateway.php');
			$username   = "e-payroll";
			$apikey     = "########";
			$recipients = $_POST["recipients"];
			$message    = $_POST["message"];
			$gateway    = new AfricasTalkingGateway($username, $apikey);

			try 
			{ 
			  $results = $gateway->sendMessage($recipients, $message);
						
			  foreach($results as $result) {
				echo " Number: " .$result->number;
				echo " Status: " .$result->status;
				echo " MessageId: " .$result->messageId;
				echo " Cost: "   .$result->cost."\n";
			  }
			
			}
			catch ( AfricasTalkingGatewayException $e )
			{	
			  echo "<label class='text-danger'>Encountered an ERROR while sending SMS: ".$e->getMessage()."</label>";
			}
		}
		}
	?>

			<form method="post"  name="sms" onsubmit="return validateSMS();">
				<div class="form-group">
					<label>From Name :</label>
					<input type="text" class="form-control" value="E-Payroll" readonly  />
				</div>
				<div class="form-group  col-sm-8 " style="margin-left:-10px; ">
				<label>Recipients (All Staff):</label>
				<?php
					$query = "SELECT GROUP_CONCAT(`phone`) AS `phone` FROM `tbl_employee`;";  
					$result = mysqli_query($connect, $query);   
					while($row = mysqli_fetch_array($result))  
					 {
					?> 
					<input type='text' name='phone' id='phone' class='form-control' placeholder='Enter recipients' value='<?php echo $row['phone']; ?>' readonly />
					<?php
					 }
				 ?>
				 </div>
				 <div class=" col-sm-4 chkbox">
					<label><input type="checkbox" name="all_staff" id="all_staff" onclick="enable(this)"/>
					&nbsp;&nbsp;Send To All Staff</label>
				</div>
				<div class="form-group"  style="clear:both">
					<label>Recipient(s) Phone:</label>
					<input type="text" name="recipients" id="recipients" class="form-control" placeholder="Recipients Phone Number" value="<?php echo $recipients; ?>"  />
				</div>
				<div class="form-group" style="clear:both">
					<label>Enter Message:</label>
					<textarea name="message" id="message" class="form-control" placeholder="Message"><?php echo $message; ?></textarea>
				</div>
				<div class="form-group" align="center">
					<input type="reset" name="" class="btn btn-danger" value="Clear"/>
					<input type="submit" name="sendSMS" value="Send-SMS" class="btn btn-blue" />
				</div>
			</form>
			<div class="form-group">
				<label>Enter Message</label>
				<textarea name="" class="form-control" placeholder="Enter Message" readonly >Dear Sir/Madam, Your monthly Salary for this Month has been disbursed. Kindly check your bank account after 48 hours. Print your Payslip from https://e-payroll/login.ke. Queries? Email kasaza@e-pay.ke</textarea>
			</div>
			</div>
			</div>
		</div>
		<script type="text/javascript">
	/*$(function () {
		$("#all_staff").click(function () {
			if ($(this).is(":checked")) {
				$("#email").attr("disabled", "disabled");
			} else {
				$("#email").removeAttr("disabled");
				$("#email").focus();
			}
		});
	});*/
	
	function enable(all_staff) {
		var recipients = document.getElementById("recipients");
		recipients.disabled = all_staff.checked;
			recipients.value = '';
		if (!recipients.disabled) {
			recipients.focus();
			}
	}
</script>
  </div>
<!----SMS DIV----->	
	 <script>
	function validateSMS() {
		var m = document.forms["sms"]["message"].value;
		
		if (m.length==0) {
			alert('Please Type Text Message!.....')
		   document.getElementById('message').focus();
			return false;
		}
		return true;
	}
	</script>
	<script>
	function validateSMS2() {
		var rec = document.forms["sms2"]["recipients2"].value;
		var rec2 = /\b.{10,15}\b/;
		var m = document.forms["sms2"]["message2"].value;
		
		if (rec.length==0) {
		   alert('Please enter Recipient Number!')
		   document.getElementById('recipients2').focus();
           return false;
		}else if (!rec.match(rec2)) {
           alert("Phone Number must be 10-15 Characters!");
		   document.getElementById('recipients2').focus();
           return false;
		}else if (m.length==0) {
			alert('Please enter Message!')
		   document.getElementById('message2').focus();
			return false;
		}
		return true;
	}
	</script>
