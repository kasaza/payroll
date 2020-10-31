
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > SMS & Mail</title>  
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
<div class="am-wrapper am-fixed-sidebar">

		<?php
			//index.php
			$phone = '';
			$message = '';
			$recipients ='';
			if(isset($_POST["sendSMS"]))
			{
			
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
		?>
		<form method="post"  name="sms" onsubmit="return validateSMS();">
			
			<div class="form-group"  style="clear:both">
				<div class="input-group">Recipient(s) Phone:
				<input type="text" name="recipients" id="recipients" class="form-control" placeholder="Recipients Phone Number" value="<?php echo $recipients; ?>"  />
				</div>
			</div>
			<div class="form-group">
			  <label class="col-sm-4 control-label">Recipient:</label>
			  <div class="col-sm-8">
			  <?php
				$host = 'localhost'; $user = 'root'; $pass = ''; $db = 'hrm';
				$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
				?>
				<select id="sel_phone" name="sel_phone" class="form-control text-center" >
					<option value="">--Select Department--</option>
					<?php
					$result = $mysqli->query("SELECT id,phone, name FROM tbl_employee ORDER BY id DESC") or die($mysqli->error);
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value='" . $row['phone'] . "'>" . $row['name'] . "</option>";
					}
					?>        
				</select>
			  </div>
			</div>
			<div class="form-group" style="clear:both">
				Enter Message:
				<textarea name="message" id="message" class="form-control" placeholder="Message"><?php echo $message; ?></textarea>
			</div>
			<div class="form-group" align="center">
				<input type="reset" name="" class="btn btn-danger" value="Clear"/>
				<input type="submit" name="sendSMS" value="Send-SMS" class="btn btn-blue" />
			</div>
			
		</form>
		  <script type="text/javascript">
		$(document).ready(function () {
			$("#sel_phone").change(function () {
			  $('#recipients').val($("#sel_phone").val());


			});

		});
		  </script>

</div>
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

<script type="text/javascript">
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
