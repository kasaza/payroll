<?php  
	$connect = mysqli_connect("localhost", "root", "", "hrm");
	$query = "SELECT * FROM allowances WHERE all_id='1'";  
	$result = mysqli_query($connect, $query); 
 ?>   
 
<?php include '../users/session.php'; ?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Allowances</title>  
<?php include '../includes/links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<?php include '../includes/header.php'; ?>
<?php include '../includes/officer_nav.php'; ?>   
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-gears fa-fw"></i>  Set-Ups</a></li>
        <li class="active"><i class="fa fa-dropbox fa-fw"></i>  Allowances</li>
    </ol>
	 
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<div class="widget">
	<ul class="nav nav-tabs">
		<li><a href="earnings">Earnings</a></li>
		<li class="active"><a href="#"> Allowances</a></li>
		<li><a href="deductions">Deductions</a></li>
		<li><a href="banks">Banks</a></li>
	</ul>
	<div class="tab-content col-kk-12">
	<!-------Allowances TABLE------>
		<div class="row">
		<div class="col-sm-6">
			<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>Allowances Settings</h5>
				<?php 
				$totalDed = 0;
			   while($row = mysqli_fetch_array($result))  
			   {  
				$all_id = $row['all_id'];
				$medical = $row['medical'];
				$transport = $row['transport'];
				$risk = $row['risk'];
				$house = $row['house'];
				$totalAll = $medical + $transport + $risk + $house;
			   ?>
			   <thead>
				<tr> <input type="button" name="edit" value="Update" id="<?php echo $row["all_id"]; ?>" class="btn btn-warning edit_data fl_right" style="margin:2px 10px;"/></tr>
			   </thead>
			   <?php 
			   }  
			   ?> 
			</header>
			<div id="div-1" class="body collapse in">
			<div class="table-responsive" >
				<table id="allowances" class="table table-bordered table-striped">
					<thead>
					<!--<tr><th colspan="14"><center>Deductions Table</center></th></tr>-->
					<tr><th>#</th><th>Allowance Type</th><th>Amount (Ksh.)</th></tr>
					</thead>
					<tbody>
					<tr><td>1</td><td>Medical Allowance</td><td><?=number_format($medical)?> .00</td></tr>
					<tr><td>2</td><td>Transport Allowance</td><td><?=number_format($transport)?> .00</td></tr>
					<tr><td>3</td><td>Risk Allowance</td><td><?=number_format($risk)?> .00</td></tr>
					<tr><td>4</td><td>House Allowance</td><td><?=number_format($house)?> .00</td></tr>
					</tbody>
					 <tfoot>
					  <tr><td>#</td><td><b>Total</b></td><td><b>Ksh. <?=number_format($totalAll)?> .00</b></td></tr>
					</tfoot>
				</table>
			 </div>
			</div>
			</div>
		</div>
		<!-------JOB GROUP RANKING TABLE------>
		<div class="col-lg-6">
			<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>Job Group - Allowance</h5>
				<button type="button" name="add2" id="add2" data-toggle="modal" data-target="#add_data_Modal2" class="btn btn-info right"  style="margin-top:2px;">ADD NEW +</button>
			</header>
			<div id="div-1" class="body collapse in">
			<div class="table-responsive" >
				<table id="jobgroup" class="table table-bordered table-striped">
				<thead>
				  <tr><th>#</th>
					<th>Job Group</th>
					  <th>House Allowance</th>
					   <th>Commuter Allowance</th>
					  <th>Update</th>
				  </tr>
				</thead>
				  <?php 
				  
					$query = "SELECT * FROM jobgroup ORDER BY jgrp_id ASC";  
					$result = mysqli_query($connect, $query); 
					$no = 1;
					$totalHouse=0;
					$totalCommuter=0;
				   while($row = mysqli_fetch_array($result))  
				   {  
					$jgrp_name = $row['jgrp_name'];
					$house = $row['house'];
					$commuter = $row['commuter'];
					$totalHouse += $house;
					$totalCommuter += $commuter;
				   ?>
				   <tr> <td><?php echo $no; ?></td>
						<td><?php echo $row["jgrp_name"]; ?></td> 
						<td><?=number_format($row["house"]); ?> .00</td>
						<td><?=number_format($row["commuter"]); ?> .00</td>
						<td><input type="button" name="edit" value="Update" id="<?php echo $row["jgrp_id"]; ?>" class="btn btn-warning btn-xs edit_data2" /></td>
				   </tr>
				   <?php 
					$no++;
					$totalEmp = $no-1;
				   }  
				   ?>  
					<tfoot>
						<tr><th>#</th>
						<th>Totals:</th>
						  <th><b>Ksh. <?=number_format($totalHouse)?> .00</b></th>
						   <th><b>Ksh. <?=number_format($totalCommuter)?> .00</b></th>
						  <th></th>
					  </tr>
					</tfoot>
				</table>
			</div>
			</div>
			</div>
		</div>
		</div>
	</div>	
	<!--------ADD ALLOWANCE RCORD--------> 
	 <div id="add_data_Modal" class="modal fade" role="dialog">  
		  <div class="modal-dialog">  
			   <div class="modal-content"> 
			   
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
					<h3>Update Allowance Record</h3>
				</div> 

				<div class="modal-body" style="padding:40px 50px;">  
				   <form name="insert_form" class="form-horizontal" method="post" id="insert_form" > 
					 <div class="form-group">
					  <label class="col-sm-4 control-label">Medical Allowance</label>
					  <div class="col-sm-8">
						<input type="text" name="medical" class="form-control" required="required"  value="<?php echo $medical; ?>" onkeypress="return isNumber(event)" />
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label">Transport Allowance</label>
					  <div class="col-sm-8">
						<input type="text" name="transport" class="form-control" value="<?php echo $transport; ?>" onkeypress="return isNumber(event)" />
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label">Risk Allowance</label>
					  <div class="col-sm-8">
						<input type="text" name="risk" class="form-control" value="<?php echo $risk; ?>" onkeypress="return isNumber(event)" />
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label">House Allowance</label>
					  <div class="col-sm-8">
						<input type="text" name="house" class="form-control" value="<?php echo $house; ?>" onkeypress="return isNumber(event)" />
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label"></label>
					  <div class="col-sm-8">
						<input type="hidden" name="employee_id" id="employee_id" />  
						<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" onclick="addAllowance();" />
						<input type="reset" name="" class="btn btn-danger" value="Clear Fields">
					  </div>
					</div>      
				  </form>  
				</div>  
				<div class="modal-footer">  
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
				</div>  
			   </div>  
		  </div>  
		</div>	
		<!--------ADD JOBGROUP-Allowance RCORD--------> 
	 <div id="add_data_Modal2" class="modal fade" role="dialog">  
		  <div class="modal-dialog">  
			   <div class="modal-content"> 
			   
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
					<h3>New Loan Record</h3>
				</div> 
				
				<div class="modal-body" style="padding:40px 50px;">  
				   <form name="insert_form2" class="form-horizontal" method="post" id="insert_form2" > 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Job Group Category:</label>
					  <div class="col-sm-8">
					   <input type="text" name="jgrp_name" id="jgrp_name" class="form-control text-center" placeholder="Type" maxlength="20"/> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Amount:</label>
					  <div class="col-sm-8">
					   <input type="text" name="jgrp_amount" id="jgrp_amount" class="form-control text-center" placeholder="Amount(Ksh.)" onkeypress="return isNumber(event)" maxlength="8" readonly />  
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label">House Allowance:</label>
					  <div class="col-sm-8">
					   <input type="text" name="house" id="house" class="form-control text-center" placeholder="House All(Ksh.)" onkeypress="return isNumber(event)" maxlength="8"/>  
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label">Commuter Allowance:</label>
					  <div class="col-sm-8">
					   <input type="text" name="commuter" id="commuter" class="form-control text-center" placeholder="Commuter All(Ksh.)" onkeypress="return isNumber(event)" maxlength="8"/>  
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label"></label>
					  <div class="col-sm-8">
						<input type="hidden" name="employee_id2" id="employee_id2" />  
						<input type="submit" name="insert2" id="insert2" value="Insert" class="btn btn-success" onclick="addJGroup();" />
						<input type="reset" name="" class="btn btn-danger" value="Clear Fields">
					  </div>
					</div>      
				  </form>  
				</div>  
				<div class="modal-footer">  
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
				</div>  
			   </div>  
		  </div>  
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
//ADDING NEW DEDUCTION
	function addAllowance(){
		if($('#allowance').val() == '')  { 
			swal({title:'Oops...', text:'Allowance name is required!', type: 'error', 
				 onClose: function () {document.getElementById('allowance').focus();}
				}); 
	   }else if($('#all_amount').val() == '')  { 
			swal({title:'Oops...', text:'Amount is required!', type: 'error', 
				 onClose: function () {document.getElementById('all_amount').focus();}
				});
	   }else{
	   $.ajax({  
			 url:"../admin/all_insert.php",  
			 method:"POST",  
			 data:$('#insert_form').serialize(),  
			 beforeSend:function(){  
				  $('#insert').val("Inserting");  
			 },  
			 success:function(data){
				  $('#insert_form')[0].reset();  
				  $('#add_data_Modal').modal('hide');  
				  $('#allowances').html(data);  
			 }  
		});  
		swal('Success..!', 'Allowance Successfuly Updated!', 'success');
		}
	}
</script>
 <script type="text/javascript" language="javascript"> 
 
 $(document).ready(function(){
	  var entity = "Allowances";
	 $('#allowances').DataTable( {
        dom: 'lBfrtip',
        buttons: ['pdf', 'print']
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
		url:"../admin/all_fetch.php",  
		method:"POST",  
		data:{employee_id:employee_id},  
		dataType:"json",  
		success:function(data){ 
			 $('#allowance').val(data.allowance);
			 $('#all_amount').val(data.all_amount);
			 $('#employee_id').val(data.all_id); 
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
				 url:"../admin/all_select.php",  
				 method:"POST",  
				 data:{employee_id:employee_id},  
				 success:function(data){  
					  $('#employee_detail').html(data);  
					  $('#dataModal').modal('show');  
				 }  
			});  
	   }            
  }); 
//Delete Data From Table/Database
$(document).on('click', '.delete_data', function(){
	   var id = $(this).attr("id");
	   if(confirm("Are you sure you want to remove this?"))
	   {
		$.ajax({
		 url:"../admin/all_delete.php",
		 method:"POST",
		 data:{all_id:id},
		 success:function(data){
		  swal('Deleted!', 'Data Successfuly Deleted!', 'success');
		  $('#user_data').DataTable().destroy();
		  fetch_data();
		 }
		});
		setInterval(function(){
		 $('#alert_message').html('');
		}, 5000);
	   }
});
 }); 
 </script>
<!-------JOB RANKING SCRIPT------>
<script type="text/javascript">
//ADDING NEW EMPLOYEE
	function addJGroup(){
		if($('#jgrp_name').val() == "")  {  
			swal({title:'Oops...', text:'Job Group is required!', type: 'error', 
				 onClose: function () {document.getElementById('jgrp_name').focus();}
				});  
		}else if($('#house').val() == '')  { 
			swal({title:'Oops...', text:'House Allowance is required!', type: 'error', 
				 onClose: function () {document.getElementById('house').focus();}
				});
	   }else if($('#commuter').val() == '')  { 
			swal({title:'Oops...', text:'Commuter Allowance is required!', type: 'error', 
				 onClose: function () {document.getElementById('all_amount').focus();}
				});
	   }else{
	   $.ajax({  
			 url:"../admin/jgrp-all_insert.php",  
			 method:"POST",  
			 data:$('#insert_form2').serialize(),  
			 beforeSend:function(){  
				  $('#insert2').val("Inserting");  
			 },  
			 success:function(data){
				  $('#insert_form2')[0].reset();  
				  $('#add_data_Modal2').modal('hide');  
				  $('#jobgroup').html(data);  
			 }  
		});  
		swal({title:'Success!', text:'J-Group Successfuly Saved!', type: 'success', 
			 onClose: function () {window.location.href='allowances';}
			});  
		}
	}
	</script>
 <script type="text/javascript" language="javascript"> 
 
 $(document).ready(function(){
	  var entity = "jobgroup";
	 $('#jobgroup').DataTable( {
        dom: 'lBfrtip',
        buttons: ['pdf', 'print',]
    } );

 //Add Data Into the Datbase
  $('#add2').click(function(){  
	   $('#insert2').val("Insert");  
	   $('#insert_form2')[0].reset();  
  });
//Edit table data
$(document).on('click', '.edit_data2', function(){  
   var employee_id2 = $(this).attr("id");  
   $.ajax({  
		url:"../admin/jgrp_fetch.php",  
		method:"POST",  
		data:{employee_id2:employee_id2},  
		dataType:"json",  
		success:function(data){ 
			 $('#jgrp_name').val(data.jgrp_name);
			 $('#jgrp_amount').val(data.jgrp_amount);
			  $('#house').val(data.house);
			 $('#commuter').val(data.commuter);
			 $('#employee_id2').val(data.jgrp_id);  
			 $('#insert2').val("Update");  
			 $('#add_data_Modal2').modal('show');  
		}  
   });  
});  
//Insert Data Into Database
  $('#insert_form2').on("submit", function(event){  
	   event.preventDefault();  
  });  
/*Delete Data From Table/Database
$(document).on('click', '.delete_data2', function(){
	   var id = $(this).attr("id");
	   if(confirm("Are you sure you want to remove this?"))
	   {
		$.ajax({
		 url:"../admin/jgrp_delete.php",
		 method:"POST",
		 data:{jgrp_id:id},
		 success:function(data){
		  swal('Deleted!', 'Job Group Successfuly Deleted!', 'success');
		  $('#user_data2').DataTable().destroy();
		  fetch_data();
		 }
		});
		setInterval(function(){
		 $('#alert_message').html('');
		}, 5000);
	   }
});*/
 }); 
 </script>
	
