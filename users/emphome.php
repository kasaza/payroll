<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  

session_start();
require_once '../users/class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}

$connect = new PDO('mysql:host=localhost;dbname=hrm', 'root', '');
$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE id_no=:id_no");
//$stmt = $user_home->runQuery("SELECT * FROM tbl_users INNER JOIN tbl_employee ON tbl_users.id_no = tbl_employee.id_no WHERE tbl_users.id_no=:id_no");
$stmt->execute(array(":id_no"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Payroll List</title>  
<link rel="icon" href="../images/mylogo.jpg" type="image/x-icon"/>
<!---NOT IMPORTANT--->
	<link href="../link/nanoscroller.css" media="screen" rel="stylesheet" type="text/css">
	<link href="../link/style-1.css" media="screen" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../link/layout.css" type="text/css" />
	<link rel="stylesheet" href="../link/css.css" type="text/css" />
	<!------CSS LINKS>-------->	
	<link rel="stylesheet" href="../link/bootstrap.min.css" />
	<link rel="stylesheet" href="../link/dataTables.bootstrap.min.css"/>
	<script src="../link/jquery.js"></script>
	<script src="../link/jquery.min.js"></script>
	<script src="../link/jquery.dataTables.min.js"></script>
	<script src="../link/dataTables.bootstrap.min.js"></script>  
	<script src="../link/bootstrap.min.js"></script>
	<script type="text/javascript" src="../date/search/date.js"></script>
	<!--ALERT MESSAGES-->
	<script src="../link/sweetalert2.all.min.js"></script>
	<script src="../link/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="../link/sweetalert2.min.css">
	<!--LOGIN DIV-->
	<link href="../link/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!--Must for any conversation-->
	<link rel="stylesheet" type="text/css" href="../link/buttons.dataTables.min.css"/>
	<!--<script src="link/dataTables.min.js"></script>-->
	
	<link rel="stylesheet" href="../link/assets/main.css" />
    <link rel="stylesheet" href="../link/assets/font-awesome.css" />
    <link rel="stylesheet" href="../link/assets/bootstrap-wysihtml5-0.0.2.css" />
	
	<script src="../link/assets/wysihtml5-0.3.0.min.js"></script>
    <script src="../link/assets/bootstrap-wysihtml5-hack.js"></script>
    <script src="../link/assets/editorInit.js"></script>
	
</head>
<body>
<!--------NAVIGATION DIV---------->
<div class="am-wrapper2">
<!-- Top Navbar Start-->  
<!-- Top Navbar Start-->  
<nav class="navbar navbar-fixed-top am-top-header">
    <div class="container-fluid">
		<div id="am-navbar-collapse">
			<div class="page-header-top">
				<h1 class="header"><center>E - Payroll System - Staff<small></small></center></h1>
            </div>
			<ul class="nav-right user-right" style="margin-right:0;">
			  <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="View your profile">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Welcome!  
				   <strong> <?php echo $row['uname']?> ID:<?php echo $row['id_no'] ?></strong>
					<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
				  </a>
				  <ul class="dropdown-right dropdown-user">
					  <li><a href="../users/logout.php"><i class="fa fa-sign-out fa-fw"></i><strong> Logout</strong></a>
					  </li>
				  </ul>
			  </li>
			</ul> 
			<span class="decor"></span>
        </div>
    </div>
</nav>

  <!--Main Content-->   
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-windows fa-fw"></i>  Employee</a></li>
        <li class="active"><i class="fa fa-book fa-fw"></i>  Employee Records</li>
		<a id="btnPrint1" class="btn btn-black fl_right" target="blank_" href="print_slip.php?pdf=1&id='<?php echo $row["uname"] ?>'" >Print Slip</a>  
    </ol> 
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<div class="widget">
	<div class="tab-content col-kk-12">
		<div class="col-lg-3">
		<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>Login Information</h5>
			</header>
			<div id="div-1" class="body collapse in">
				 <div class="table-responsive" >
					<table id="" class="table table-striped">
						<thead>
						<tr><td colspan="2" class="p-user"> <p align="center">Login Details</p> </td></tr>
						</thead>
						<tbody>
						<tr class="user-t"><td><b>Name/Username</b></td><td><?php echo $row['uname']; ?></td></tr>
						<tr class="user-t"><td><b>ID Number</b></td><td><?php echo $row['id_no']; ?></td></tr>
						<tr class="user-t"><td><b>Email Address</b></td><td><?php echo $row['email']; ?></td></tr>
						<tr class="user-t"><td><b>Phone Number</b></td><td><?php echo $row['phone']; ?></td></tr>
						<tr class="user-t"><td><b>Login Role</b></td><td><?php echo $row['role']; ?></td></tr>
						</tbody>
					</table>
				 </div>
			</div>	
		</div>
		 </br></br>
		<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>Payroll Information</h5>
			</header>
			<div id="div-1" class="body collapse in">
				  <?php
					$stmt2 = $user_home->runQuery("SELECT * FROM tbl_employee WHERE id_no=:id_no");
					$stmt2->execute(array(":id_no"=>$_SESSION['userSession']));
					$row = $stmt2->fetch(PDO::FETCH_ASSOC);
				 ?>
				<div class="table-responsive" >
					<table id="" class="table table-striped">
						<thead>
						<tr><td colspan="2" class="p-user2"> <p align="center">Employment Details</p> </td></tr>
						</thead>
						<tbody>
						<tr class="user-t2"><td><b>Name</b></td><td><?php echo $row['name']; ?></td></tr>
						<tr class="user-t2"><td><b>ID Number</b></td><td><?php echo $row['id_no']; ?></td></tr>
						<tr class="user-t2"><td><b>Email Address</b></td><td><?php echo $row['email']; ?></td></tr>
						<tr class="user-t2"><td><b>Phone Number</b></td><td><?php echo $row['phone']; ?></td></tr>
						<tr class="user-t2"><td><b>Date</b></td><td><?php echo $row['date']; ?></td></tr>
						<tr class="user-t2"><td><b>Department</b></td><td><?php echo $row['department']; ?></td></tr>
						<tr class="user-t2"><td><b>Type</b></td><td><?php echo $row['type']; ?></td></tr>
						</tbody>
					</table>
				</div>
			</div>	
		</div>
		</div>
		<!--Pay Slip Div-->
		<div class="col-lg-9" id="dataModal">
		<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5><span id="clockbox"></span>&nbsp Pay Slip</h5>
			</header>
			<div id="div-1" class="body collapse in">
				 <?php  	
			 $connect = new PDO('mysql:host=localhost;dbname=hrm', 'root', '');
			 $stmt = $user_home->runQuery("SELECT * FROM tbl_users INNER JOIN payroll ON tbl_users.id_no = payroll.id_no WHERE tbl_users.id_no=:id_no");
			 $stmt->execute(array(":id_no"=>$_SESSION['userSession']));
			  $all_result = $stmt->fetchAll();
			  
			  foreach($all_result as $row)
			  {
				?>  
			<div id="dataModal" class="table">  
			<table id="payroll" class="table table-bordered table-striped" >
				<thead><th colspan="14" style="border-color:#000;"><center>E - PAY SLIP</center></th>
				</thead>
				<tbody>
				<tr>  
					 <td><label>ID Number:&nbsp;&nbsp;</label><?php echo $row["id_no"] ?></td>  
					<td><label>Name:&nbsp;&nbsp;</label><?php echo $row["name"] ?></td>  
					<td><label>Pay Date:&nbsp;&nbsp;</label><?php echo $row["date"] ?></td>  
				<tr>  
				<tr>  
					 <td style="border-right:1px solid transparent;"><label>Account Number:&nbsp;&nbsp;</label></td>  
					 <td><?php echo $row["account"] ?></td>
					 <td><label>Bank:&nbsp;&nbsp;</label><?php echo $row["bank"] ?></td>  
				</tr>
				<tr>  
					<td style="border-right:1px solid transparent;"><label>Designation Pay:&nbsp;&nbsp;</label</td>
					<td>Ksh. <?php echo $row["designation"] ?> .00</td>  
					<td><label>Jobgroup Pay:&nbsp;&nbsp;</label>Ksh. <?php echo $row["jobgroup"] ?> .00</td>  
				</tr>
				
				<tr>  
					<td style="border-right:1px solid transparent;"><label>Allowances:</label></td>
					<td>
						1. Medical:&nbsp;&nbsp;Ksh. <?php echo $row["medical"] ?> .00</br>
						2. Transport:&nbsp;&nbsp;Ksh. <?php echo $row["transport"] ?> .00</br>
						3. Risk:&nbsp;&nbsp;Ksh. <?php echo $row["risk"] ?> .00</br>
						4. House:&nbsp;&nbsp;Ksh. <?php echo $row["house"] ?> .00 
					</td>
					<td><label>Total Allowances:&nbsp;&nbsp;&nbsp;</label> Ksh. <?php $row["totalAll"] ?> .00</td>						 
				</tr>  
				<tr>  
					<td style="border-right:1px solid transparent;"><label>Deductions:</label></td>  
					<td>
						1. NHIF:&nbsp;&nbsp;Ksh. <?php echo $row["nhif"] ?> .00</br>
						2. HELB Loan:&nbsp;&nbsp;Ksh. <?php echo $row["helb"] ?> .00</br>
						3. NSSF:&nbsp;&nbsp;Ksh. <?php echo $row["nssf"] ?> .00</br>
						4. Elimu:&nbsp;&nbsp;Ksh. <?php echo $row["elimu"] ?> .00 
					</td>
					<td><label>Total Deductions:&nbsp;&nbsp;&nbsp;</label>Ksh. <?php echo $row["totalDed"] ?> .00</td>  
				</tr>
				<tr>  
					 <td style="border-right:1px solid transparent;"><label>Bonus:</label></td>  
					 <td>Ksh. <?php echo $row["bonus"] ?> .00</td>  
					 <td><label>Salary Inc.:&nbsp;&nbsp;</label> Ksh. <?php echo $row["inc_amount"] ?> .00</td>   
				</tr>
				<tr>  
					 
				</tr>
				<tr>  
					<td><label>Basic Salary:&nbsp;&nbsp;</label>Ksh. <?php echo $row["basic"] ?> .00</td>  
					<td><label>Gross Income:&nbsp;&nbsp;</label>Ksh. <?php echo $row["gross"] ?> .00</td>  
					<td><label>Net Salary:&nbsp;&nbsp;</label>Ksh. <?php echo $row["net"] ?> .00</td>  
				</tr>  
				</tbody>
			</table>  
			</div> 
			 <?php  	   
			  }  
			 ?>
			</div>	
		</div>
		</div>
		</br>
		</br>
		<div class="col-lg-9">
		<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>General Monthly Payroll Data</h5>
			</header>
			<div id="div-1" class="body collapse in">
				<table id="invoice-item-table" class="table">
                    <tr><td><input type="text" name="val1" id="val1"  class="form-control val1" placeholder="First Value" onkeypress="return isNumber(event)"/></td>
					<td>
						<select name="opr" id="opr" class="form-control opr" >
							<option value="0">+</option>
							<option value="1">-</option>
							<option value="2">*</option>
							<option value="3">/</option>
						</select>
					</td></tr>
                    <td><input type="text" name="val2" id="val2"  class="form-control number_only val2" placeholder="Second Value" onkeypress="return isNumber(event)"/></td>
					<tr>
					<td><input type="submit" name="calc" id="calc" class="btn btn-black calc" value="CALC =" placeholder="Result"/></td></tr>
                    <tr><td><input type="text" name="total" id="total" class="form-control total" readonly placeholder="Result"/></td></tr>
                    
                  </table> 
			</div>	
		</div>
		</div>
		
		 <script> 
		//Calculator Codes
		  $(document).ready(function(){
			var count = 1;
			
			function total(count)
			{
				var val1 = 0;
				var selOpr = document.querySelector("#opr");
				var val2 = 0;
				var total = 0;
			
				val1 = $('#val1').val();
				opr = $('#opr').val();
				val2 = $('#val2').val();	
			if (selOpr.selectedIndex === 0) {
				total = parseFloat(val1) + parseFloat(val2);
				$('#total').val(total);
			  }
			else if (selOpr.selectedIndex === 1) {
				total = parseFloat(val1) - parseFloat(val2);
				$('#total').val(total);
			  }
			else if (selOpr.selectedIndex === 2) {
				total = parseFloat(val1) * parseFloat(val2);
				$('#total').val(total);
			  }
			else if (selOpr.selectedIndex === 3) {
				total = parseFloat(val1) / parseFloat(val2);
				$('#total').val(total);
			  }
			}

			$(document).on('click', '.calc', function(){
			  total(count);
			});
		  });
		  
        </script>
	</div>
	</div>
	</div>
	</div>
 </div> 
</div>

<div id="cpright"  class="clear">
  <p class="fl_left">Copyright &copy; 2017 - All Rights Reserved -www.msa.go.ke</p>
  <p class="fl_right">Project By Kasaza Sylvester &trade;</p>
</div>

<!--IMPORTANT FOR SMAL WINDOW DEVICES **** DO NOT REMOVE--->
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
<script>
  $(document).ready(function(){
	var count = 1;
	
	function total(count)
	{
		var val1 = 0;
		var selOpr = document.querySelector("#opr");
		var val2 = 0;
		var total = 0;
	
		val1 = $('#val1').val();
		opr = $('#opr').val();
		val2 = $('#val2').val();	
	if (selOpr.selectedIndex === 0) {
		total = parseFloat(val1) + parseFloat(val2);
		$('#total').val(total);
	  }
	else if (selOpr.selectedIndex === 1) {
		total = parseFloat(val1) - parseFloat(val2);
		$('#total').val(total);
	  }
	else if (selOpr.selectedIndex === 2) {
		total = parseFloat(val1) * parseFloat(val2);
		$('#total').val(total);
	  }
	else if (selOpr.selectedIndex === 3) {
		total = parseFloat(val1) / parseFloat(val2);
		$('#total').val(total);
	  }
	}

	$(document).on('click', '.calc', function(){
	  total(count);
	});
  });

//ADDING NEW EMPLOYEE
	function addEmployee(){
		
	   $.ajax({  
			 url:"emp_insert.php",  
			 method:"POST",  
			 data:$('#insert_form').serialize(),  
			 beforeSend:function(){  
				  $('#insert').val("Inserting");  
			 },  
			 success:function(data){
				  $('#insert_form')[0].reset();  
				  $('#add_data_Modal').modal('hide');  
				  $('#employee').html(data);  
			 }  
		});  
		}
	}
	</script>
 <script type="text/javascript" language="javascript"> 
 
 $(document).ready(function(){
	  var entity = "payroll";
	 $('#payroll').DataTable( {
        dom: 'lBfrtip',
        buttons: ['copy', 'csv','excel','pdf', 'print' ]
    } );

 //Add Data Into the Datbase
  $('#add').click(function(){  
	   $('#insert').val("Insert");  
	   $('#insert_form')[0].reset();  
  });
//Edit table data
$(document).on('click', '.edit_data', function(){  
   var employee_id = $(this).attr("id");  
   $.ajax({  
		url:"emp_fetch.php",  
		method:"POST",  
		data:{employee_id:employee_id},  
		dataType:"json",  
		success:function(data){ 
			 $('#id_no').val(data.id_no);
			 $('#name').val(data.name);
			 $('#gender').val(data.gender);  
			 $('#phone').val(data.phone);  
			 $('#email').val(data.email);  
			 $('#date').val(data.date);
			 $('#type').val(data.type);
			 $('#department').val(data.department); 
			 $('#salary').val(data.salary);  
			 $('#employee_id').val(data.id);  
			 $('#insert').val("Update");  
			 $('#add_data_Modal').modal('show');  
		}  
   });  
});  
//Insert Data Into Database
  $('#insert_form').on("submit", function(event){  
	   event.preventDefault();  
  });  
//View Data From the table
  $(document).on('click', '.view_data', function(){  
	   var employee_id = $(this).attr("id");  
	   if(employee_id != '')  
	   {  
			$.ajax({  
				 url:"emp_select.php",  
				 method:"POST",  
				 data:{employee_id:employee_id},  
				 success:function(data){  
					  $('#employee_detail').html(data);  
					  $('#dataModal').modal('show');  
				 }  
			});  
	   }            
  }); 

 }); 
 </script>
 <script>
//Current Date-Time
		tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
		tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

		function GetClock(){
			var d=new Date();
			var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
			var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

			if(nhour==0){ap=" AM";nhour=12;}
			else if(nhour<12){ap=" AM";}
			else if(nhour==12){ap=" PM";}
			else if(nhour>12){ap=" PM";nhour-=12;}

			if(nmin<=9) nmin="0"+nmin;
			if(nsec<=9) nsec="0"+nsec;

			document.getElementById('clockbox').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
		}

		window.onload=function(){
		GetClock();
		setInterval(GetClock,1000);
		}
	</script>