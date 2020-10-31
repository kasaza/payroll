 <?php
session_start(); 
require_once 'users/class.user.php';
?>
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
	$no = 0;
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
		$no++;
		$totalEmp = $no;
		$totalAll += $row["totalAll"];
		$totalDed += $row["totalDed"];
		$totalBon += $row["bonus"];
		$totalInc += $row["inc_amount"];
		$totalBasic += $row["basic"];
		$totalGross += $row["gross"];
		$totalNet += $row['net'];
		$gTotal = $totalAll + $totalDed + $totalBon + $totalInc + $totalBasic + $totalGross + $totalNet;
	}  
	

$query = "SELECT * FROM reports";
$result = mysqli_query($connect, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))
{
 $chart_data .= "{ cMonth:'".date('M-Y',strtotime($row["cDate"]))."', totalBon:".$row["totalBon"].", totalInc:".$row["totalInc"].", totalAll:".$row["totalAll"].", totalDed:".$row["totalDed"].", totalBasic:".$row["totalBasic"].", totalGross:".$row["totalGross"].", totalNet:".$row["totalNet"].", gTotal:".$row["gTotal"]."}, ";
}

$result1 = mysqli_query($connect, $query);
$chart_data2 = '';
while($row = mysqli_fetch_array($result1))
{
 $chart_data2 .= "{ cMonth:'".date('Y-m',strtotime($row["cDate"]))."', totalBon:".$row["totalBon"].", totalInc:".$row["totalInc"].", totalAll:".$row["totalAll"].", totalDed:".$row["totalDed"].", totalBasic:".$row["totalBasic"].", totalGross:".$row["totalGross"].", totalNet:".$row["totalNet"].", gTotal:".$row["gTotal"]."}, ";
}


 $query = "SELECT * FROM reports ORDER BY cDate ASC";  
 $result = mysqli_query($connect, $query);  
?> 
 
<?php  
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('users/login');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE id_no=:id_no");
$stmt->execute(array(":id_no"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Dashboard</title>  
<?php include 'includes/dash_links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<!-- Top Navbar Start-->  
<nav class="navbar navbar-fixed-top am-top-header">
    <div class="container-fluid">
        <div id="am-navbar-collapse">
            <div class="page-header-top">
            <h1 class="header"><center>E - Payroll System <?php echo $row['role'] ?><small></small></center></h1>
            </div>
			<ul class="nav-right user-right" style="margin-right:0;">
			  <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="View your profile">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				   <strong> <?php echo $row['uname']?> ID:<?php echo $row['id_no'] ?></strong>
					<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
				  </a>
				  <ul class="dropdown-right dropdown-user">
					  <li><a href="users/logout"><i class="fa fa-sign-out fa-fw"></i><strong> Logout</strong></a>
					  </li>
				  </ul>
			  </li>
			</ul> 
			<span class="decor"></span>
        </div>
    </div>
</nav>
<!--============NAVIGATION BAR ELEMENTS=============-->
<?php include 'includes/admin_nav2.php'; ?>
<!--============OUTER MAIN CONTENT DIV=============-->  

  <!--Main Content-->   
<div class="am-content">
 <div class="row">
	<div class="page-head" >
		<ol class="breadcrumb" >
			<li><a href=""><i class="fa fa-windows fa-fw"></i>  Home</a></li>
			<li class="active"><i class="fa fa-th-list fa-fw"></i>  Dashboard</li>
		</ol>	
	</div>
	<table class="dash-table">
		<tr>
		<td><div class="col-kk-2"><p class="p-time" id="clockbox"></p></div></td>
		<td><div class="col-kk-2"><p class="p-time" >Total Employees &nbsp<?=number_format($totalEmp)?></p></div></td>
		<td><div class="col-kk-2"><p class="p-time">Total Net Salary &nbsp<?=number_format($totalNet)?></p></div></td>
		<td><div class="col-kk-2"><p class="p-time">Total Amount &nbsp<?=number_format($gTotal)?></p></div></td>
		<td><div class="col-ks-2"><p class="p-total">Total Bonus : <?=number_format($totalBon)?> .00</p></div></td>
		</tr>
		<tr>
		<td><div class="col-ks-2"><p class="p-total">Total Allowances : <?=number_format($totalAll)?> .00</p></div></td>
		<td><div class="col-ks-2"><p class="p-total">Total Deductions : <?=number_format($totalDed)?> .00</p></div></td>
		<td><div class="col-ks-2"><p class="p-total">T. Basic Salary : <?=number_format($totalBasic)?> .00</p></div></td>
		<td><div class="col-ks-2"><p class="p-total">T. Gross Income : <?=number_format($totalGross)?> .00</p></div></td>
		<td><div class="col-ks-2"><p class="p-total">T. Net Salary : <?=number_format($totalNet)?> .00</p></div></td>
		</tr>
	</table>
 </div>

<div class="main-content">
	<ul class="nav nav-tabs">
	   <li class="active"><a href="#">Dashboard</a></li>
	   <li><a href="calendar">Calendar</a></li>
	</ul>
	<div class="tab-content col-kk-12">
	<!-------DESIGNATION TABLE------>
	<div class="row">
	<div class="col-lg-6">
		<div class="box">
		<header>
			<div class="icons"><i class="icon-th-large"></i></div>
			<h5>General Monthly Payroll Data <span id="clockbox2"></span></h5>
		</header>
		<div id="div-1" class="body collapse in">
			<h4 align="center" style="border-top:1px dotted #000;">A. Area Graph Data</h4> 
			<div id="areaGraph" class="graph"></div>
			<br/> <h4 align="center" style="border-top:1px dotted #000;">B. Line Graph Data</h4>
			<div id="lineGraph" class="graph" ></div>
		  </div>	
		</div>
	</div>
	<div class="col-lg-6">
		<div class="box">
		<header>
			<div class="icons"><i class="icon-th-large"></i></div>
			<h5>General Monthly Payroll Data <span id="clockbox2"></span></h5>
		</header>
		<div id="div-1" class="body collapse in">
			<div id="lineGraph" class="graph" ></div>
			<h4 align="center" style="border-top:1px dotted #000;">B. Stacked Bar-Graph Data</h4>
			<div id="barGraph" class="graph"></div>
		    <br/> <h4 align="center" style="border-top:1px dotted #000;">C. Non-Stacked Graph Data</h4>
			<div id="barGraph2" class="graph"></div>
		  </div>	
		</div>
	</div>
<script>
Morris.Area({
 element : 'areaGraph',
 data:[<?php echo $chart_data2; ?>],
 xkey:['cMonth'],
 ykeys:['totalBon', 'totalInc', 'totalAll', 'totalDed', 'totalBasic', 'totalGross', 'totalNet', 'gTotal'],
 labels:['Bonus', 'Sal Inc.', 'Allowances', 'Deductions', 'Basic Sal', 'Gross Inc', 'Net Sal', 'Grand Total'],
formater: function (y, data) { return '$' + y }, 
hideHover:'auto',
 stacked:false
});

Morris.Line({
 element : 'lineGraph',
 data:[<?php echo $chart_data2; ?>],
 xkey:['cMonth'],
 ykeys:['totalBon', 'totalInc', 'totalAll', 'totalDed', 'totalBasic', 'totalGross', 'totalNet', 'gTotal'],
 labels:['Bonus', 'Sal Inc.', 'Allowances', 'Deductions', 'Basic Sal', 'Gross Inc', 'Net Sal', 'Grand Total'],
 hideHover:'auto',
 stacked:false
});

Morris.Bar({
 element : 'barGraph',
 data:[<?php echo $chart_data; ?>],
 xkey:['cMonth'],
 ykeys:['totalBon', 'totalInc', 'totalAll', 'totalDed', 'totalBasic', 'totalGross', 'totalNet', 'gTotal'],
 labels:['Bonus', 'Sal Inc.', 'Allowances', 'Deductions', 'Basic Sal', 'Gross Inc', 'Net Sal', 'Grand Total'],
 hideHover:'auto',
 stacked:true
});

Morris.Bar({
 element : 'barGraph2',
 data:[<?php echo $chart_data; ?>],
 xkey:['cMonth'],
 ykeys:['totalBon', 'totalInc', 'totalAll', 'totalDed', 'totalBasic', 'totalGross', 'totalNet', 'gTotal'],
 labels:['Bonus', 'Sal Inc.', 'Allowances', 'Deductions', 'Basic Sal', 'Gross Inc', 'Net Sal', 'Grand Total'],
 hideHover:'auto',
 stacked:false
});
</script>

	<div class="col-lg-12">
		<div class="box">
		<header>
			<div class="icons"><i class="icon-th-large"></i></div>
			<h5>General Monthly Payroll Data <span id="clockbox2"></span></h5>
		</header>
		<div id="div-1" class="body collapse in">
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
	</div>	
	</div>
</div>
</div>
<!-----END OF AM-CONTENT--->
</div>
<?php include 'includes/footer.php' ?>
</div>
</body>
</html>
<script type="text/javascript">
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
			document.getElementById('clockbox2').innerHTML=""+tmonth[nmonth]+", "+nyear+"";
		}

		window.onload=function(){
		GetClock();
		setInterval(GetClock,1000);
		}
		
 $(document).ready(function(){
 var table =  $('#reports').DataTable( {	 
        dom: 'lBfrtip',
        buttons: ['copy', 'csv','excel','pdf', 'print'  ],title: function(){
        'XXXXXXXXXXX';
      }
    } );
 }); 
	</script>