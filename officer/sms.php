
<?php include '../users/session.php'; ?>
<?php include '../includes/functions.php'; ?>
<?php include 'sendmail.php'; ?> 
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > SMS & Mail</title>  
<?php include '../includes/links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<?php include '../includes/header.php'; ?>
<?php include '../includes/officer_nav.php'; ?>
<!---Main Content--->
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-tasks fa-fw"></i>  Transactions</a></li>
        <li class="active"><i class="fa fa-envelope fa-fw"></i>  SMS & Mails</li>
    </ol>
</div>

<!-------MAIN CONTENT------>
<div class="main-content">
<div class="row">
  <ul class="nav nav-tabs">
	<li><a href="payroll">Transactions</a></li>
	<li class="active"><a href="#">SMS & Mail</a></li>
  </ul>
<!-------END OF MAIN CONTENT/ START OF MAIL TAB------>
  <div class="tab-content col-kk-12">
		<div class="col-lg-6">
			<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>General Mail / Individual Mail</h5>
				<ul class="nav1 pull-right">
					<li>
						<div class="btn-group">
							<a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse" href="#div-1"><i class="icon-minus"></i></a>
							 <button class="btn btn-danger btn-xs close-box"><i class="icon-remove"></i></button>
						</div>
					</li>
				</ul>
			</header>
			<div id="div-1" class="body collapse in">
			<?php echo $error; ?>
			<form method="post" name="frm_email" onsubmit="return validateMail();">
				<div class="form-group">
				<label>From Name:</label>
				<input type="text" name="name" placeholder="Enter Name" value="E-Payroll TUM" class="form-control" readonly  />
				</div>
				<div class="form-group col-sm-8 ">
					<label>Single Email:</label>
					<div class="input-group">
					<input type="text" name="email" id="email" class="form-control" placeholder="Individual Email" value="<?php echo $email; ?>" />
					<div class="input-group-addon"><button type="button" id="select" data-toggle="modal" data-target="#select_Email_Modal" class="btn btn-xs btn-blue">SELECT +</button></div>
					</div>
				</div>
				<div class=" col-sm-4 chkbox">
					<label><input type="checkbox" name="all_staff" id="all_staff" onclick="enable(this)"/>
					&nbsp;&nbsp;Mail All Staff</label>
				</div>
				<div class="form-group" style="clear:both;">
					<label>Enter Subject:</label>
					<input type="text" name="subject" id="subject" class="form-control" placeholder="General Subject" value="<?php echo $subject; ?>" />
				</div>
				<div class="form-group">
					<label>Enter Message:</label>
					<textarea id="mail2"  name="mail2" class="form-control" placeholder="Type Mail Here"  rows="5"><?php echo $mail2; ?></textarea>
				</div>
				<div class="form-group" align="center">
					<input type="reset" name="" class="btn btn-danger" value="Clear"/>
					<input type="submit" name="sendEMail" value="Send Mail" class="btn btn-success"/>
				</div>
			</form>
			</div>
			</div>
		</div>
		
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
					if (isset($_POST['all_staff2']))
						{
						require_once('AfricasTalkingGateway.php');
						$username   = "e-payroll";
						$apikey     = "d4156785bd48abb3e9815748e5e2d8f97399ced3930be1318c0851532862a780";
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
						 swal({title:'Success...!', text:'Message was Successfully Sent!', type: 'success', 
						 onClose: function () {window.location.href='sms';} });
						</script>
						<?php 
						}
						catch ( AfricasTalkingGatewayException $e )
						{						  
						  echo "<div class='alert alert-danger '><button class='close' data-dismiss='alert'>&times;</button>
								<strong>Sorry!</strong>  Encountered an <b>ERROR</b> while sending SMS: ".$e->getMessage()." </div>";
						}
					}
					else{
						$message = '';
						$recipients ='';
						require_once('AfricasTalkingGateway.php');
						$username   = "e-payroll";
						$apikey     = "d4156785bd48abb3e9815748e5e2d8f97399ced3930be1318c0851532862a780";
						$recipients = $_POST["recipients"];
						$message    = $_POST["message"];
						$gateway    = new AfricasTalkingGateway($username, $apikey);

						try 
						{ 
						  $results = $gateway->sendMessage($recipients, $message);
									
						  foreach($results as $result) {
								 
							echo "Number: " .$result->number;
							echo " Number: " .$result->number;
							echo " Status: " .$result->status;
							echo " MessageId: " .$result->messageId;
							echo " Cost: "   .$result->cost."\n";
						  }
						 ?>
						<script>
						 swal({title:'Success...!', text:'Message was Successfully Sent to User!', type: 'success', 
						 onClose: function () {window.location.href='sms';} });
						</script>
						<?php 
						}
						catch ( AfricasTalkingGatewayException $e )
						{	
						  echo "<div class='alert alert-danger '><button class='close' data-dismiss='alert'>&times;</button>
								<strong>Sorry!</strong>  Encountered an <b>ERROR</b> while sending SMS: ".$e->getMessage()." </div>";
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
					$connect = new PDO('mysql:host=localhost;dbname=hrm', 'root', '');
					$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $connect->prepare("SELECT GROUP_CONCAT(phone) AS phone FROM tbl_employee");
					$stmt->execute();
					while($row = $stmt->fetch()) {
					?> 
					<input type='text' name='phone' id='phone' class='form-control' placeholder='Enter recipients' value='<?php echo $row['phone']; ?>' readonly />
					<?php
					 }
				 ?>
				 </div>
				 <div class=" col-sm-4 chkbox">
					<label><input type="checkbox" name="all_staff2" id="all_staff2" onclick="enable2(this)"/>
					&nbsp;&nbsp;Send To All Staff</label>
				</div>
				<div class="form-group"  style="clear:both">
					<label>Recipient(s) Phone:</label>
					<div class="input-group">
					<input type="text" name="recipients" id="recipients" class="form-control" placeholder="Recipients Phone Number" value="<?php echo $recipients; ?>"  />
					<div class="input-group-addon"><button type="button" id="select2" data-toggle="modal" data-target="#select_Phone_Modal" class="btn btn-xs btn-blue">SELECT +</button></div>
					</div>
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
				<textarea name="" class="form-control" placeholder="Enter Message" readonly >Dear Sir/Madam, Your monthly Salary for this Month has been disbursed. Kindly check your bank account after 48 hours. Print your Payslip from http://localhost/hrm/users/login.php. Queries? Email kasazax@gmail.com</textarea>
			</div>
			</div>
			</div>
		</div>
  </div>

  <!--------Select Email Address--------> 
 <div id="select_Email_Modal" class="modal fade" role="dialog">  
	  <div class="modal-dialog">  
		   <div class="modal-content"> 
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
				<h3>Select Mail Recipient(s)</h3>
			</div> 
			<div class="modal-body" style="padding:40px 50px;">  
			<table id="sel_email" class="table table-bordered table-striped">
				<tr><th></th><th>ID</th><th>Name</th><th>Phone</th></tr>
				<?php 
				$connect = mysqli_connect("localhost", "root", "", "hrm");  	  
				$query = "SELECT * FROM tbl_employee";  
				$result = mysqli_query($connect, $query); 
				   while($row = mysqli_fetch_array($result))  
				   {  
				   ?>
				   <tr> 
						<td><input type="checkbox" value="<?php echo $row["email"]; ?>" ></td>
						<td><?php echo $row["id_no"]; ?></td>
						<td><?php echo $row["name"]; ?></td> 
						<td><?php echo $row["email"]; ?></td>
				   </tr>
				   <?php 
				   }  
			   ?>  
			   <tr><td colspan="4">
			   <button type="button" class="btn btn-success pull-right" data-dismiss="modal">&nbsp;OK&nbsp; <i class="icon-location-arrow "></i></button> </td>
			   </tr>
			</table>
			</div>  
			
		   </div>  
	  </div>  
	</div>	
	 <!--------Select SMS Number--------> 
	 <div id="select_Phone_Modal" class="modal fade" role="dialog">  
	  <div class="modal-dialog">  
		   <div class="modal-content"> 
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
				<h3>Select SMS Recipient(s)</h3>
			</div> 
			<div class="modal-body" style="padding:40px 50px;">  
			<table id="sel_phone" class="table table-bordered table-striped">
				<tr><th></th><th>ID</th><th>Name</th><th>Phone</th></tr>
				<?php 
				$connect = mysqli_connect("localhost", "root", "", "hrm");  	  
				$query = "SELECT * FROM tbl_employee";  
				$result = mysqli_query($connect, $query); 
				   while($row = mysqli_fetch_array($result))  
				   {  
				   ?>
				   <tr> 
						<td><input type="checkbox" value="<?php echo $row["phone"]; ?>" ></td>
						<td><?php echo $row["id_no"]; ?></td>
						<td><?php echo $row["name"]; ?></td> 
						<td><?php echo $row["phone"]; ?></td>
				   </tr>
				   <?php 
				   }  
			   ?>  
			   <tr><td colspan="4">
			   <button type="button" class="btn btn-success pull-right" data-dismiss="modal">&nbsp;OK&nbsp; <i class="icon-location-arrow "></i></button> </td>
			   </tr>
			</table>
			</div>  
			
		   </div>  
	  </div>  
	</div>	
</div>
</div>
<script>
	$(function () { formWysiwyg(); });
</script>
<!-------END OF MAIN CONTENT------>
</div>
</div>
<?php include '../includes/footer.php' ?>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		//initialize the javascript

		App.init();
		//App.dashboard2();
		App.livePreview();

	});
</script>
</body>
</html>
<script type="text/javascript">
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
  </script>

	<script>
//====================Emai Disable On Check===============//
	$(document).ready(function () {
		$('#all_staff').on('change', function (e) {
			$("#mail2").prop("disabled", this.checked);
			$("#email").prop("disabled", this.checked);
			$("#select").prop("disabled", this.checked);
			$("#email").val('');
			if(!this.checked){
				$("#email").val('');
			}
		});
	});
</script>
<script type="text/javascript">
//====================SMS Disable On Check===============//
	$(document).ready(function () {
		$('#all_staff2').on('change', function (e) {
			$("#recipients").prop("disabled", this.checked);
			$("#select2").prop("disabled", this.checked);
			$("#recipients").val('');
			if(!this.checked){
				$("#recipients").val('');
			}
		});
	});
	
//====================Checkbox Populate===============//	
	var arr = [];
	$('#sel_email input').change(function() {
	  if (this.checked) {
		arr.push(this.value);
	  }
	  else {
	   arr.splice(arr.indexOf(this.value), 1);
	  }
	  $('#email').val(arr + '');
	});
//====================Checkbox Populate===============//	
	var arr = [];
	$('#sel_phone input').change(function() {
	  if (this.checked) {
		arr.push(this.value);
	  }
	  else {
	   arr.splice(arr.indexOf(this.value), 1);
	  }
	  $('#recipients').val(arr + '');
	});	
</script>
<script>
	function validateMail() {
		var e = document.forms["email"]["email"].value;
		var atpos = e.indexOf("@");
		var dotpos = e.lastIndexOf(".");
		var all_staff = document.forms["email"]["all_staff"].value;
		var s = document.forms["email"]["subject"].value;
		var m = document.forms["email"]["mail2"].value;
		
		if (s.length==0) {
			swal({title:'Error..!', text:'Please enter Mail Subject!', type: 'error', 
				 onClose: function () {document.getElementById('subject').focus();}
				});
			return false;
		}
		return true;
	
	 $('#email').on("submit", function(event){  event.preventDefault();});  
	 $('#email')[0].reset();
	}
	
	

	</script>	

<!----SMS DIV----->	
 <script>
function validateSMS() {
	var m = document.forms["sms"]["message"].value;
	
	if (m.length==0) {
		swal({title:'Error..!', text:'Please Type General Message!..', type: 'error', 
			onClose: function () {document.getElementById('message').focus();}
			});
		return false;
	}
	return true;
}

</script>
	<script>
	function validateSMS2() {
		var rec = document.forms["sms"]["recipients"].value;
		var rec2 = /\b.{10,15}\b/;
		var m = document.forms["sms"]["message"].value;
		
		if (rec.length==0) {
			swal({title:'Error..!', text:'Please enter Recipient Number!', type: 'error', 
				 onClose: function () {document.getElementById('recipients').focus();}
				});
           return false;
		}else if (!rec.match(rec2)) {
			swal({title:'Error..!', text:'Phone Number must be 10-15 Characters!', type: 'error', 
				 onClose: function () {document.getElementById('recipients').focus();}
				});
           return false;
		}else if (m.length==0) {
			swal({title:'Error..!', text:'Please Type Message!', type: 'error', 
				 onClose: function () {document.getElementById('message').focus();}
				});
			return false;
		}
		return true;
	}

	</script>
