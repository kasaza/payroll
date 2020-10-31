
<?php include '../users/session.php'; ?>
<?php include '../includes/functions.php'; ?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Payroll List</title>  
<?php include '../includes/links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--============MAIN WRAPPER CONTAINER=============-->
<div class="am-wrapper am-fixed-sidebar">
<!--============TOP HEADER DATA=============-->
<?php include '../includes/header.php'; ?>
<!--============LOADING FROM ALL DATABASE TABLES=============-->
<?php  
$connect = mysqli_connect("localhost", "root", "", "hrm");  
  
$query = "SELECT * FROM designation";  
$result = mysqli_query($connect, $query);   
while($row = mysqli_fetch_array($result))  
 {
	$desg_id= $row["desg_id"];
	$desg_name= $row["desg_name"];
	$desg_amount= $row["desg_amount"];
 }

$query = "SELECT * FROM jobgroup";  
$result = mysqli_query($connect, $query);  
while($row = mysqli_fetch_array($result))  
 {
	$jgrp_id= $row["jgrp_id"];
	$jgrp_name= $row["jgrp_name"];
	$jgrp_amount= $row["jgrp_amount"];
 }
	  
$query = "SELECT * FROM allowances";  
$result = mysqli_query($connect, $query);  
while($row = mysqli_fetch_array($result))  
 {
	$all_id = $row['all_id'];
	$medical = $row['medical'];
	$transport = $row['transport'];
	$risk = $row['risk'];
	$house = $row['house'];
 }
	 
$query = "SELECT * FROM deductions";  
$result = mysqli_query($connect, $query);  
while($row = mysqli_fetch_array($result))  
 {
	$ded_id = $row['ded_id'];
	$deduction = $row['deduction'];
	$amount = $row['amount'];
	$max_amount = $row['max_amount'];
 }
	 
$query = "SELECT * FROM banks";  
$result = mysqli_query($connect, $query);  
while($row = mysqli_fetch_array($result))  
 {
	$bnk_id= $row["bnk_id"];
	$bank= $row["bank"];
 }
	 
 $query = "SELECT * FROM payroll ORDER BY p_id DESC";  
 $result = mysqli_query($connect, $query);  
 
 ?> 
<!--============NAVIGATION BAR ELEMENTS=============-->
<?php include '../includes/officer_nav.php'; ?>
<!--============OUTER MAIN CONTENT DIV=============-->  
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-tasks fa-fw"></i>  Payroll Transactions</a></li>
        <li class="active"><i class="fa fa-book fa-fw"></i>  Transactions</li>
		<button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-danger right" title="Add New Staff Record">New Record +</button>
		<a href="../admin/pdf"  class="btn btn-danger right" target="_blank" class="fl_right" title="Print the Official Report"><i class="fa fa-print fa-fw"></i> Official Report</a>
    </ol>
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<ul class="nav nav-tabs">
		<li class="active"><a href="payroll">Transactions</a></li>
		<li ><a href="sms">SMS & Mail</a>
		</li>
	</ul>
	<div class="tab-content col-kk-12">
		<div class="table-responsive " >
		<table id="payroll" class="table table-bordered table-striped">
			<!--<table id="payroll" class="display wrap table">-->
				<thead><th colspan="14" style="color:red; border-color:blue;"><center>PAYROLL TRANSACTIONS TABLE</center></th>
					<tr><th>#</th>
						<th>No</th>
						<th>ID Number</th>
						<th>Name</th>
						<th>Date</th>
						<th>Allowances</th>
						<th>Deductions</th>
						<th>Salary Inc.</th>
						<th>Basic Salary</th>
						<th>Gross Income</th>
						<th>Net Salary</th>
						<th>PDF</th>
						<th>Action</th>
					</tr>
				</thead>
			   <tfoot>
					<tr><th>#</th>
						<th>No</th>
						<th>ID Number</th>
						<th>Name</th>
						<th>Date</th>
						<th>Allowances</th>
						<th>Deductions</th>
						<th>Salary Inc.</th>
						<th>Basic Salary</th>
						<th>Gross Income</th>
						<th>Net Salary</th>
						<th>PDF</th>
						<th>Action</th>
					</tr>
				</tfoot>

			   <?php 
				$no = 1;
				$totalEmp = 0;
				$totalAll = 0;
				$totalDed = 0;
				$totalBon = 0;
				$totalInc = 0;
				$totalBasic = 0;
				$totalGross = 0;
				$totalNet = 0;
				$gTotal = 0;
			   while($row = mysqli_fetch_array($result))  
			   {  
			   ?>
			  <tr id="<?php echo $row["p_id"]; ?>" > 
					<td><input type="checkbox" name="uid[]" class="delete_customer" value="<?php echo $row["p_id"]; ?>" /></td>
					<td><?php echo $no; ?></td>  
					<td><?php echo $row["id_no"]; ?></td>  
					<td><?php echo $row["name"]; ?></td>
					<td><?php echo $row["date"]; ?></td>
					<td><?=number_format($row["totalAll"]); ?> .00</td>
					<td><?=number_format($row["totalDed"]); ?> .00</td>
					<td><?=number_format($row["inc_amount"]); ?> .00</td>
					<td><?=number_format($row["basic"]); ?> .00</td>
					<td><?=number_format($row["gross"]); ?> .00</td>
					<td><?=number_format($row["net"]); ?> .00</td>
					<td><?php echo' <a class="btn btn-black btn-xs" target="_blank"  href="print_slip?pdf=1&id='.$row["p_id"].'">PDF</a> '?></td>
					<td>
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><input type="button" name="view" value="View" id="<?php echo $row["p_id"]; ?>" class="btn btn-info view_data btn-xs action" /></li>
							<li class="divider"></li>
							<li><input type="button" name="edit" value="Update" id="<?php echo $row["p_id"]; ?>" class="btn btn-warning btn-xs edit_data action" /></li>
							<li class="divider"></li>
							<li><input type="button" name="Delete" value="Delete" id="<?php echo $row["p_id"]; ?>" class="btn btn-danger btn-xs delete_data action" /></li>
						</ul>
					</div>
					</td>
			   </tr>
			   <?php 
				$no++;
				$totalEmp = $no-1;
				$totalAll += $row["totalAll"];
				$totalDed += $row["totalDed"];
				$totalBon += $row["bonus"];
				$totalInc += $row["inc_amount"];
				$totalBasic += $row["basic"];
				$totalGross += $row["gross"];
				$totalNet += $row['net'];
				$gTotal = $totalAll + $totalDed + $totalBon + $totalInc + $totalBasic + $totalGross + $totalNet;
			   }  
			   ?>  
			</table>
			<button type="button" name="btn_delete" id="btn_delete" class="btn btn-xs btn-danger pull-left" style="margin-top:-30px;">Delete Marked</button>
		</div>
		</br>
		
		<!--============Monthly Reports Form=========-->
		<div class="row">
		<?php 			 
		 $query = "SELECT * FROM reports ORDER BY rpt_id DESC";  
		 $result = mysqli_query($connect, $query);  
		 ?> 
		<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>PAYROLL REPORTS </h5>
			</header>
			<div id="div-1" class="body collapse in">
			<form method="post" id="report_form" name="report_form">
			<div class="table-responsive">
			<table style="color:#006400; border-color:brown;" class="table table-bordered table-striped">
				<thead><tr><th colspan="10" style="color:red; border-color:brown;"><center>
				<span style="background-color:#eee; padding:0 10px 0 10px;" name="clockbox" id="clockbox"></span> TOTAL MONTHLY REPORT TABLE</center></th></tr>
					<tr>
						<th  width="8%">Month of Report</th>
						<th width="8%">Total Employees</th>
						<th width="8%">Total Bonus</th>
						<th width="8%">Total Sal. Inc</th>
						<th width="9%">Total Allowances</th>
						<th width="9%">Total Deductions</th>
						<th>Total Basic Salary</th>
						<th>Total Gross Income</th>
						<th>Total Net Salary</th>
						<th>Grand Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Month<input type="text" class="form-control" name="cMonth" id="cMonth" readonly /><input type="hidden" name="cDate" id="cDate"/></td>
						<td>T-E<input type="text" class="form-control" name="totalEmp"  value="<?=number_format($totalEmp) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="totalBon" value="<?=number_format($totalBon) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="totalInc" value="<?=number_format($totalInc) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="totalAll" value="<?=number_format($totalAll) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="totalDed" value="<?=number_format($totalDed) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="totalBasic" value="<?=number_format($totalBasic) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="totalGross" value="<?=number_format($totalGross) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="totalNet" value="<?=number_format($totalNet) ?>" readonly ></td>
						<td>Ksh.<input type="text" class="form-control" name="gTotal" value="<?=number_format($gTotal) ?>" readonly ></td>
					</tr>
					
				</tbody>
				<tfoot>
				<tr>
					<td colspan="12" align="center"  style="color:red; border-color:brown;">
						<input type="submit" name="create_report" id="create_report" class="btn btn-success" value="Save Report"  onclick="createReport();" title="Active From 26th"/>
					</td>
				</tr>
				</tfoot>
			</table>
			</div>
			</form>
			
			<!--==========Monthly Reports Table============-->
			<div class="table-responsive">
			<table id="reports" style="color:#006400; border-color:blue;" class="table table-bordered table-striped">
				<thead><th colspan="14" style="color:red; border-color:blue;"><center>PAYROLL REPORTS TABLE</center></th>
					<tr>
						<th>#</th>
						<th>Date</th>
						<th>Month</th>
						<th>T. Emp</th>
						<th>Total Bonus</th>
						<th>Total Sal. Inc</th>
						<th>Total Allowances</th>
						<th>Total Deductions</th>
						<th>Total Basic Salary</th>
						<th>Total Gross Income</th>
						<th>Total Net Salary</th>
						<th>Grand Total</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$no = 1;
				   while($row = mysqli_fetch_array($result))  
				   {  
				   ?>
				  <tr> 
					<td><?php echo $no; ?></td>  
					<td><?php echo $row["cDate"]; ?></td>  
					<td><?php echo $row["cMonth"]; ?></td>  
					<td><?php echo $row["totalEmp"]; ?></td>
					<td><?php echo $row["totalBon"]; ?></td>
					<td><?=number_format($row["totalInc"]); ?> .00</td>
					<td><?=number_format($row["totalAll"]); ?> .00</td>
					<td><?=number_format($row["totalDed"]); ?> .00</td>
					<td><?=number_format($row["totalBasic"]); ?> .00</td>
					<td><?=number_format($row["totalGross"]); ?> .00</td>
					<td><?=number_format($row["totalNet"]); ?> .00</td>
					<td><?=number_format($row["gTotal"]); ?> .00</td>
				   </tr>
				   <?php 
					$no++;
				   }  
				   ?>  
			   </tbody>
			</table>
			</div>
			</div>
		</div>
		</div>	
	
		<!---------VIEW RECORD-------->	  
		 <div id="dataModal" class="modal fade">  
			  <div class="modal-dialog3">  
			   <div class="modal-content">  
					<div class="modal-header">  
						 <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>  
						 <h4 class="modal-title">E-Pay Slip</h4>  
					</div>  
					<div class="modal-body" id="employee_detail"> </div>  
					<div class="modal-footer"> 
					<a class="fl_left" href="" id="btnPrint" ><img src="../images/print.png"/></a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
					</div>  
			   </div>  
		  </div>  
		 </div>
	<!--============ADD NEW RCORD=================--> 
	<div id="add_data_Modal" class="modal fade" role="dialog">  
		<div class="modal-dialog2">  
		<div class="modal-content"> 
			<div class="modal-header"">
				<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
				<h3 align="center">New Payroll Record</h3>
			</div> 
		<div class="modal-body" style="padding:20px 20px;"> 
			<form name="insert_form" class="form-horizontal" method="post" id="insert_form" > 
				<div class="col-lg-12">
					<div class="panel panel-primary panel-default">
					<div class="panel-heading">Personal Information</div>
					<div class="panel-body">
						<script>/*function check() {document.getElementById("name").value=document.getElementById("id_no").value;} */</script>
						<div class="col-sm-4 input"><b>ID Number:</b>
							<select name="id_no" id="id_no" class="form-control text-center" placeholder="ID Number" onChange="check();" onkeypress="return isNumber(event)" maxlength="8">
								<option value="0">--Select Employee(ID)--</option>
								<?php echo fill_idNumber($connect); ?>
							</select>
						</div>
						<div class="col-sm-4 input"><b>Name:</b>
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-user"></i> </div>
							<input type="text" name="name" id="name" value="" class="form-control text-center" placeholder="Name" readonly /> 
						</div>
						</div>
						
						<div class="col-sm-4"><b>Designation:</b>
						<select name="designation" id="designation" class="form-control text-center designation" >
							<option value="0">--Desg--</option>
							<?php echo fill_designation($connect); ?>
						</select>
						</div>
						
						<div class="col-sm-3"><b>Job-Group:</b>
						<select name="jobgroup" id="jobgroup" class="form-control text-center jobgroup" onchange="UpdateAll();" onblur="UpdateAll();">
							<option value="0">--Jobgroup--</option>
							<?php echo fill_jobgroup($connect); ?>
						</select>
						</div>
						<div class="col-sm-3 input"><b>Account:</b>
							<input type="text" name="account" id="account" class="form-control text-center" placeholder="Account" maxlength="20" readonly /> 
						</div>
						<div class="col-sm-2"><b>Bank:</b>
						<input type="text" name="bank" id="bank" class="form-control text-center" placeholder="Bank" maxlength="20" readonly /> 
						</div>

						<!----DATE PICKER---->				
						<div class="col-sm-4 input"><b>Date:</b>
						<div class="input-group">
							<input name="date"  type="date" class=" form-control text-center " id="date" placeholder="Date"/>
							<div class="input-group-addon"><i class="fa fa-calendar"></i> </div>
						</div>
						</div>
					</div>
					</div>	
				</div>	
				<div class="col-lg-6">
				<div class="panel panel-primary panel-default">
					<div class="panel-heading">Allowances</div>
					<div class="panel-body" onkeypress="return isNumber(event)" >
					<table>
						<tr>
							<td><label>Medical :&nbsp;&nbsp; </label><input type="text" name="medical" id="all0" class="inptxt" maxlength="6" onkeyup="UpdateAll();" onblur="UpdateAll();"/></td>
							<td><label>House :&nbsp;&nbsp; </label><input type="text" name="house" id="all1" class="inptxt" maxlength="6" onkeyup="UpdateAll();" onblur="UpdateAll();"/></td>
							<td><label>Commuter :&nbsp;&nbsp; </label><input type="text" name="commuter" id="all2" class="inptxt" maxlength="6" onkeyup="UpdateAll();" onblur="UpdateAll();"/></td>
							<td><label>Risk :&nbsp;&nbsp;</label><input type="text" name="risk" id="all3" class="inptxt" maxlength="6" onkeyup="UpdateAll();" onblur="UpdateAll();"/></td>
						</tr>
						<tr>
							<td><label>Transport :&nbsp;&nbsp;</label><input type="text" name="transport" id="all4" class="inptxt" maxlength="6" onkeyup="UpdateAll();" onblur="UpdateAll();"/></td>
							<td colspan="10"><label>Total Allowances :&nbsp;&nbsp;</label> <input type="text" name="totalAll" id="totalAll" class="inptxt2 totalAll" readonly /></td>
						</tr>
					</table>
					</div>
				</div>
				<script type="text/javascript">
					function UpdateAll() {
					  var sum = 0;
					  var gn, elem;
					  for (i=0; i<5; i++) {
						gn = 'all'+i;
						elem = document.getElementById(gn);
						if (elem.value > 0) { sum += Number(elem.value); }
					  }
					  document.getElementById('totalAll').value = sum.toFixed(2);
					} 
				</script>
				</div>	
				<!--Displays checked Values in their Textboxes--->
				<script type="text/javascript">
					function getVal(chk, textbox){
					  if (chk.checked) document.getElementById(textbox).value = chk.value;
					}
				</script>
				<div class="col-lg-6">
					<div class="panel panel-primary panel-default">
					<div class="panel-heading">Deductions</div>
					<div class="panel-body" onkeypress="return isNumber(event)" >
					<table>
						<tr>
							<td><label>NHIF :&nbsp;&nbsp; </label><input type="text" name="nhif" id="ded0" class="inptxt" maxlength="6" onkeyup="UpdateDed();" onblur="UpdateDed();"/></td>
							<td><label>HELB :&nbsp;&nbsp;</label><input type="text" name="helb" id="ded1" class="inptxt" maxlength="6" onkeyup="UpdateDed();" onblur="UpdateDed();"/></td>
							<td><label>NSSF :&nbsp;&nbsp;</label><input type="text" name="nssf" id="ded2" class="inptxt" maxlength="6" onkeyup="UpdateDed();" onblur="UpdateDed();"/></td>
							<td><label>ELIMU :&nbsp;&nbsp;</label><input type="text" name="elimu" id="ded3" class="inptxt" maxlength="6" onkeyup="UpdateDed();" onblur="UpdateDed();"/></td>
						</tr>
						<tr>
							<td><label>Mwalimu :&nbsp;&nbsp;</label><input type="text" name="mwalimu" id="ded4" class="inptxt" maxlength="6" onkeyup="UpdateDed();" onblur="UpdateDed();"/></td>
							<td colspan="10"><label>Total Deductions :&nbsp;&nbsp;</label> <input type="text" name="totalDed" id="totalDed" class="inptxt2 totalDed" readonly /></td>
						</tr>
					</table>
					</div>
					</div>
					<script type="text/javascript">
					function UpdateDed() {
					  var sum = 0;
					  var gn, elem;
					  for (i=0; i<5; i++) {
						gn = 'ded'+i;
						elem = document.getElementById(gn);
						if (elem.value > 0) { sum += Number(elem.value); }
					  }
					  document.getElementById('totalDed').value = sum.toFixed(2);
					} 
					</script>
					
				</div>	
				<div class="col-lg-6">
				<div class="panel panel-primary panel-default">
					<div class="panel-heading">Bonus & Salary Increment</div>
					<div class="panel-body">
					  <div class="col-sm-4 input"><b>Bonus (Ksh.):</b>
					   <input type="text" name="bonus" id="bonus" class="form-control text-center bonus" maxlength="6" onkeypress="return isNumber(event)" value="0"/> 
					  </div>
					  <div class="col-sm-4 input"><b>Salary Inc.(%):</b>
					   <input type="text" name="sal_rate" id="sal_rate" class="form-control text-center sal_rate" onkeypress="return isNumber(event)"/>
					  </div>
					  <div class="col-sm-4 input"><b>Inc Amt.:</b>
					   <input type="text" name="inc_amount" id="inc_amount" readonly class="form-control inc_amount" />
					  </div>
					</div>
				</div>	
				</div>
				<!-------Totals Panel------>
				<div class="col-lg-6">
				<div class="panel panel-primary panel-default">
					<div class="panel-heading">Salary Totals</div>
					<div class="panel-body"  onkeypress="return isNumber(event)">
					  <div class="col-sm-4 input"><b>Basic Salary:</b>
					   <input type="text" name="basic" id="basic" class="form-control text-center basic" readonly />
					  </div>
					   <div class="col-sm-4 input"><b>Gross Income:</b>
					   <input type="text" name="gross" id="gross" class="form-control text-center gross" readonly /> 
					  </div>
					  <div class="col-sm-4 input"><b>Net Salary:</b>
					   <input type="text" name="net" id="net" class="form-control text-center  net"  readonly /> 
					  </div>
					</div>
				</div>	
				</div>
				<div class="form-group" >
				  <label class="col-sm-12 control-label"></label>
				  <div class="col-sm-8 " style="margin:20px 20px -20px 15px;">
					<input type="hidden" name="employee_id" id="employee_id" />  
					<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" onclick="addEmployee();" />
					<input type="reset" name="" class="btn btn-danger" value="Clear Fields">
				  </div>
				</div>  
			</form> 
			<script>
				
		/*===============Payroll Transactions Calculator================*/
			  $(document).ready(function(){
				var count = 1;
				
				function cal_final_total(count)
				{
				  for(j=1; j<=count; j++)
				  {
					var designation = 0;
					var jobgroup = 0;
					var totalAll = 0;
					var totalDed = 0;
					var bonus = 0;
					var sal_rate = 0;
					var inc_amount = 0;
					var basic = 0;
					var gross = 0;
					var net = 0;
					
					designation = $('#designation').val();
					jobgroup = $('#jobgroup').val();	
					totalAll = $('#totalAll').val();
					totalDed = $('#totalDed').val();
					bonus = $('#bonus').val();
					sal_rate = $('#sal_rate').val();
					
					basic = parseFloat(designation) + parseFloat(jobgroup);
					$('#basic').val(basic);
					
					if(sal_rate > 0)
					{	inc_amount = parseFloat(basic)*parseFloat(sal_rate)/100;
						$('#inc_amount').val(inc_amount);
					}
					if(totalAll > 0)
					{	gross = parseFloat(basic) + parseFloat(totalAll) + parseFloat(inc_amount);
						$('#gross').val(gross);
					}else{
						gross = parseFloat(basic)+ parseFloat(inc_amount);
						$('#gross').val(gross);	
						}
					
					if(totalDed > 0)
					{	net = parseFloat(gross) + parseFloat(bonus) - parseFloat(totalDed);
						$('#net').val(net);
					}
					else if(totalDed < 0 || gross > 0)
					{	net = parseFloat(gross) + parseFloat(bonus);
						$('#net').val(net);
					}else{
							net = parseFloat(gross);
						$('#net').val(net);
						}
						
				  } $('#final_total_amt').text(net);
				}
				$(document).on('click', '.designation', function(){cal_final_total(count);});
				$(document).on('click', '.jobgroup', function(){cal_final_total(count);});
				$('#all0,#all1,#all2,#all3').on('blur', function(){cal_final_total(count);});
				$('#ded0,#ded1,#ded2,#ded3').on('blur', function(){cal_final_total(count);});
				$('.bonus,.sal_rate').on('keyup', function(){cal_final_total(count);});
				$('.bonus,.sal_rate').on('blur', function(){cal_final_total(count);});
				$('.net').on('click', function(){cal_final_total(count);});
			  });
		
			$('#bonus').blur(function() {
			  if($('#bonus').val() == '')  { 
				setTimeout(function(){
					document.getElementById('bonus').value = "0";
				}, 1000);
			  }
			});
			$('#sal_rate').blur(function() {
			  if($('#sal_rate').val() == '')  { 
				document.getElementById('inc_amount').value = "";
			  }
			});
			</script>
		</div>  
		<div class="modal-footer">  
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
		</div>  
		</div>  
		</div>  
	</div>
	</div>
</div>
<!-------END OF MAIN CONTENT------>
</div>
</div>
<?php include '../includes/footer.php' ?>
</div>	
</body>
</html>
	
<script type="text/javascript">
/*=========Adding New PAyroll Record========*/
	function addEmployee(){
		var selIDnumber = document.querySelector("#id_no");
		var name = document.querySelector("#name");
		var selDesignation = document.querySelector("#designation");
		var selJobgroup = document.querySelector("#jobgroup");
		var selBank = document.querySelector("#bank");
		
		   if (selIDnumber.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select ID Number!', type: 'error', 
				 onClose: function () {document.getElementById('id_no').focus();}
				});
	   }else if($('#name').val() == '')  { 
			swal({title:'Oops...', text:'Please Enter Staff Name!', type: 'error', 
				 onClose: function () {document.getElementById('name').focus();}
				});
	   } else if (selDesignation.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select Designation!', type: 'error', 
				 onClose: function () {document.getElementById('designation').focus();}
				});
	   }else if (selJobgroup.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select Job-Group!', type: 'error', 
				 onClose: function () {document.getElementById('jobgroup').focus();}
				});
	   }else if($('#account').val() == '')  { 
			swal({title:'Oops...', text:'Account Number is required!', type: 'error', 
				 onClose: function () {document.getElementById('account').focus();}
				}); 
	   }else if (selBank.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select Bank!', type: 'error', 
				 onClose: function () {document.getElementById('bank').focus();}
				});
	   }else if($('#date').val() == '')  { 
			swal({title:'Oops...', text:'Date is required!', type: 'error', 
				 onClose: function () {document.getElementById('date').focus();}
				});
	   }else if($('#bonus').val() == '')  {  
			swal({title:'Oops...', text:'Bonus is required!', type: 'error', 
				 onClose: function () {document.getElementById('bonus').focus();}
				});
       }else{
	   $.ajax({  
			 url:"../admin/p_insert.php",  
			 method:"POST",  
			 data:$('#insert_form').serialize(),  
			 beforeSend:function(){  
				  $('#insert').val("Inserting");  
			 },  
			 success:function(data){
				  $('#insert_form')[0].reset();  
				  $('#add_data_Modal').modal('hide');  
				  $('#payroll').html(data);  
			 }  
		});  
		swal('Success..!', 'Record Successfuly Saved!', 'success');
		}
	}
	
/*=========DataTable Variables=======*/
$(document).ready(function(){
 var table =  $('#payroll').DataTable( {	 
        dom: 'lBfrtip',
        buttons: ['copy', 'csv','excel','pdf', 'print'
               /* {text: 'Refresh', action: function ( e, dt, node, config ) {dt.ajax.reload();}}*/
        ]
    } );
/*=========Add Data Into the Datbase=======*/
  $('#add').click(function(){  
	   $('#insert').val("Insert");  
	   $('#insert_form')[0].reset();  
  });
/*=========Edit table data=========*/
$(document).on('click', '.edit_data', function(){  
   var employee_id = $(this).attr("id");  
   $.ajax({  
		url:"../admin/p_fetch.php",  
		method:"POST",  
		data:{employee_id:employee_id},  
		dataType:"json",  
		success:function(data){ 
			 $('#id_no').val(data.id_no);
			 $('#name').val(data.name);
			 $('#designation').val(data.designation); 
			 $('#jobgroup').val(data.jobgroup);
			 $('#account').val(data.account); 
			 $('#bank').val(data.bank); 
			 $('#date').val(data.date);
			 $('#all0').val(data.medical);
			 $('#all1').val(data.house); 
			 $('#all2').val(data.commuter);
			 $('#all3').val(data.risk); 
			 $('#all4').val(data.transport);
			 $('#totalAll').val(data.totalAll); 			 
			 $('#ded0').val(data.nhif); 
			 $('#ded1').val(data.helb);
			 $('#ded2').val(data.nssf);
			 $('#ded3').val(data.elimu); 
			 $('#ded4').val(data.mwalimu);
			 $('#totalDed').val(data.totalDed);
			 $('#bonus').val(data.bonus);
			 $('#sal_rate').val(data.sal_rate);
			 $('#inc_amount').val(data.inc_amount);
			 $('#basic').val(data.basic);
			 $('#gross').val(data.gross);  
			 $('#net').val(data.net); 
			 $('#employee_id').val(data.p_id);  
			 $('#insert').val("Update");  
			 $('#add_data_Modal').modal('show');  
		}  
   });  
});  

/*=========Insert Data Into Database========*/
  $('#insert_form').on("submit", function(event){  
	   event.preventDefault();  
  });  
/*=========View Data From the table=========*/
  $(document).on('click', '.view_data', function(){  
	   var employee_id = $(this).attr("id");  
	   if(employee_id != '')  
	   {  
			$.ajax({  
				 url:"../admin/p_select.php",  
				 method:"POST",  
				 data:{employee_id:employee_id},  
				 success:function(data){  
					  $('#employee_detail').html(data);  
					  $('#dataModal').modal('show');  
				 }  
			});  
	   }            
  }); 
  
/*==========Delete Data From Table/Database==========*/
	$(document).on('click', '.delete_data', function(){
	   var id = $(this).attr("id");
	   if(confirm("Are you sure you want to remove this?"))
	   {
		$.ajax({
		 url:"../admin/p_delete.php",
		 method:"POST",
		 data:{p_id:id},
		 success:function(data){
		  swal('Deleted!', 'Record Successfuly Deleted!', 'success');
		  $('tr#'+id+'').css('background-color', '#ccc');
		  $('tr#'+id+'').fadeOut('slow');
		 }
		});
		setInterval(function(){
		 $('#alert_message').html('');
		}, 5000);
	   }
	});
 }); 
 
 /*===========Delete Marked========*/
	$(document).ready(function(){
	 $('#btn_delete').click(function(){
	  if(confirm("Are you sure you want to delete this?"))
	  {
	   var id = [];
	   $(':checkbox:checked').each(function(i){
		id[i] = $(this).val();
	   });
	   
	   if(id.length === 0) //tell you if the array is empty
	   {
		swal('Error..!', 'Please Select atleast one Record to Delete!', 'error');
	   }
	   else
	   {
		$.ajax({
			 url:'../admin/p_delete1.php',
			 method:'POST',
			 data:{p_id:id},
			 success:function()
			 {
			  for(var i=0; i<id.length; i++)
			  {
			   $('tr#'+id[i]+'').css('background-color', '#ccc');
			   $('tr#'+id[i]+'').fadeOut('slow');
			  }
			 }
		});
	   }
	  } else{ return false; }
	 }); 
	});
</script>

<!---MONTHLY REPORT SAVINGS---->
<script type="text/javascript">	  
 $(document).ready(function(){
 var table =  $('#reports').DataTable( {	 
        dom: 'lBfrtip',
        buttons: ['copy', 'csv','excel','pdf', 'print' ]
    } );
 }); 
 /*==========Disable CreateReport Button=========*/
	var today = new Date();
	var day = today.getDate();
	var month = today.getMonth()+1; //January is 0!
	var year = today.getFullYear();

	today = year + '-' + month + '-' + day;
	$('#cMonth').val(month);
	$('#cDate').val(today);
	
	if(day <= 26) {
	  $("#create_report").attr("disabled", "disabled");
		} else {
			$("#create_report").removeAttr("disabled");
	} 
	
/*========Insert Report Data===========*/
	function createReport(){
		if(confirm("Create Report for this Month?"))
	   {
	   $.ajax({  
			 url:"../admin/rpt_insert.php",  
			 method:"POST",  
			 data:$('#report_form').serialize(), 

			 success:function(data){
				  $('#report_form')[0].reset();  
				  $('#add_data_Modal').modal('hide');  
				  $('#reports').html(data);  
			 }  
		});  
		swal({title:'Success!', text:'Monthly Report Successfuly Saved!', type: 'success', 
			 onClose: function () {}
			});  
		}
	}
	/*if(day === 5) {
	 $.ajax({  
			 url:"rpt_insert.php",  
			 method:"POST",  
			 data:$('#report_form').serialize(), 
			 success:function(data){
				  $('#report_form')[0].reset();  
				  $('#add_data_Modal').modal('hide');  
				  $('#reports').html(data);  
			 }  
		});  
		swal({title:'Success!', text:'Monthly Report Successfuly Saved!', type: 'success', 
			 onClose: function () {}
			}); 
	} */
	
/*========Important For Swal===========*/
	$('#report_form').on("submit", function(event){  
		event.preventDefault();  
	 });  
	$(document).ready(function(){ });  
</script>
