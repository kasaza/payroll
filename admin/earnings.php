
<?php  $connect = mysqli_connect("localhost", "root", "", "hrm"); ?>
<?php include '../users/session.php'; ?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Earnings</title>  
<?php include '../includes/links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<?php include '../includes/header.php'; ?>
<?php include '../includes/admin_nav.php'; ?>
  <!--Main Content-->   
<div class="am-content">
<div class="page-head">
	<ol class="breadcrumb">
        <li><a href=""><i class="fa fa-gears fa-fw"></i>  Set-Ups</a></li>
        <li class="active"><i class="fa fa-magic fa-fw"></i>  Earnings</li>
    </ol>
	 
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<div class="widget">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#">Earnings</a></li>
		<li><a href="allowances"> Allowances</a>
		<li><a href="deductions">Deductions</a></li>
		<li><a href="banks">Banks</a></li>
		<li><a href="../employee/departments">Departments</a></li>
		
		</li>
	</ul>
	<div class="tab-content col-kk-12">
	<!-------DESIGNATION TABLE------>
		<div class="row">
		<div class="col-lg-6">
			<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>Designation Set-Ups </h5>
				<button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-success right" style="margin-top:2px;">ADD NEW +</button>
			</header>
			<div id="div-1" class="body collapse in">
				<div class="table-responsive" >
					<table id="designation" class="table table-bordered table-striped">
						<thead>
						  <tr><th>#</th>
							<th>Designation Name</th>
							  <th>Amount</th>
							  <th>Action</th>
						  </tr>
						</thead>
					  
					  <?php 
					  
						$query = "SELECT * FROM designation ORDER BY desg_id DESC";  
						$result = mysqli_query($connect, $query); 
						$no = 1;
						$totalDesg = 0;
					   while($row = mysqli_fetch_array($result))  
					   {  
						$desg_name = $row['desg_name'];
						$desg_amount = $row['desg_amount'];
						$totalDesg += $desg_amount;
					   ?>
					   <tr  id="<?php echo $row["desg_id"]; ?>"> 
							<td><?php echo $no; ?></td>
							<td><?php echo $row["desg_name"]; ?></td> 
							<td><?=number_format($row["desg_amount"]); ?></td>
							<td>
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><input type="button" name="edit" value="Update" id="<?php echo $row["desg_id"]; ?>" class="btn btn-warning btn-xs edit_data action" /></li>
									<li class="divider"></li>
									<li><input type="button" name="Delete" value="Delete" id="<?php echo $row["desg_id"]; ?>" class="btn btn-danger btn-xs delete_data action" /></li>
								</ul>
							</div>
							</td>
					   </tr>
					   <?php 
						$no++;
						$totalEmp = $no-1;
					   }  
					   ?>  
						<tfoot>
							<tr><th>#</th>
							<th>Total Designation Pay </th>
							  <th><b>Ksh. <?=number_format($totalDesg)?> .00</b></th>
							 <th></th>
						  </tr>
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
				<h5>Job Group</h5>
				<button type="button" name="add2" id="add2" data-toggle="modal" data-target="#add_data_Modal2" class="btn btn-info right"  style="margin-top:2px;">ADD NEW +</button>
			</header>
			<div id="div-1" class="body collapse in">
			<div class="table-responsive" >
				<table id="jobgroup" class="table table-bordered table-striped">
				<thead>
				  <tr><th>#</th>
					<th>Job Group Name</th>
					  <th>Amount</th>
					   <th>Gross</th>
					  <th>Action</th>
				  </tr>
				</thead>
				  <?php 
				  
					$query = "SELECT * FROM jobgroup ORDER BY jgrp_id ASC";  
					$result = mysqli_query($connect, $query); 
					$no = 1;
					$totalJgrp = 0;
				   while($row = mysqli_fetch_array($result))  
				   {  
					$jgrp_name = $row['jgrp_name'];
					$jgrp_amount = $row['jgrp_amount'];
					$totalJgrp += $jgrp_amount;
				   ?>
				   <tr> <td><?php echo $no; ?></td>
						<td><?php echo $row["jgrp_name"]; ?></td> 
						<td><?=number_format($row["jgrp_amount"]); ?></td>
						<td><?=number_format($row["gross"]); ?></td>

						<td>
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><input type="button" name="edit" value="Update" id="<?php echo $row["jgrp_id"]; ?>" class="btn btn-warning btn-xs edit_data2 action" /></li>
								<li class="divider"></li>
								<li><input type="button" name="Delete" value="Delete" id="<?php echo $row["jgrp_id"]; ?>" class="btn btn-danger btn-xs delete_data2 action" /></li>
							</ul>
						</div>
						</td>
				   </tr>
				   <?php 
					$no++;
					$totalEmp = $no-1;
				   }  
				   ?>  
					<tfoot>
						<tr><th>#</th>
						<th>Total Job Group Pay:</th>
						  <th><b>Ksh. <?=number_format($totalJgrp)?> .00</b></th>
						  <th></th>
						  <th></th>
					  </tr>
					</tfoot>
				</table>
			</div>
			</div>
			</div>
		</div>
		</div>
		
	<!--------ADD NEW DESIGNATION RCORD--------> 
	 <div id="add_data_Modal" class="modal fade" role="dialog">  
		  <div class="modal-dialog">  
			   <div class="modal-content"> 
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
					<h3>New Designation Record</h3>
				</div> 
				<div class="modal-body" style="padding:40px 50px;">  
				   <form name="insert_form" class="form-horizontal" method="post" id="insert_form" > 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Designation Type:</label>
					  <div class="col-sm-8">
					   <input type="text" name="desg_name" id="desg_name" class="form-control text-center" placeholder="Name" maxlength="40"/> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Amount:</label>
					  <div class="col-sm-8">
					   <input type="text" name="desg_amount" id="desg_amount" class="form-control text-center" placeholder="Amount(Ksh.)" onkeypress="return isNumber(event)" maxlength="8"/>  
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-4 control-label"></label>
					  <div class="col-sm-8">
						<input type="hidden" name="employee_id" id="employee_id" />  
						<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" onclick="addDesignation();" />
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
	<!--------ADD NEW JOBGROUP RCORD--------> 
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
					   <input type="text" name="jgrp_amount" id="jgrp_amount" class="form-control text-center" placeholder="Amount(Ksh.)" onkeypress="return isNumber(event)" maxlength="8"/>  
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
	<!--------END OF JOB GROUP--------> 		
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

	<!-------DESIGNATION SCRIPT------>
	<script type="text/javascript">
	//ADDING NEW EMPLOYEE
		function addDesignation(){
			if($('#desg_name').val() == '')  { 
				swal({title:'Oops...', text:'Please Insert Designation!', type: 'error', 
					 onClose: function () {document.getElementById('desg_name').focus();}
					}); 
		   }else if($('#desg_amount').val() == '')  {  
				swal({title:'Oops...', text:'Amount is required!', type: 'error', 
					 onClose: function () {document.getElementById('desg_amount').focus();}
					});
			}else{
		   $.ajax({  
				 url:"desg_insert.php",  
				 method:"POST",  
				 data:$('#insert_form').serialize(),  
				 beforeSend:function(){  
					  $('#insert').val("Inserting");  
				 },  
				 success:function(data){
					  $('#insert_form')[0].reset();  
					  $('#add_data_Modal').modal('hide');  
					  $('#designation').html(data);  
				 }  
			});  
			swal('Success..!', 'Designation Record Successfuly Saved!', 'success');
			}
		}
	</script>
	 <script type="text/javascript" language="javascript"> 
	 
		$(document).ready(function(){
		 
			$('#designation').DataTable( {
			dom: 'lBfrtip',
			buttons: ['pdf', 'print']
		});
	 //Add Data Into the Datbase
		  $('#add').click(function(){  
			   $('#insert').val("Insert");  
			   $('#insert_form')[0].reset();  
		  });
	//Edit table data
		$(document).on('click', '.edit_data', function(){  
		   var employee_id = $(this).attr("id");  
		   $.ajax({  
				url:"desg_fetch.php",  
				method:"POST",  
				data:{employee_id:employee_id},  
				dataType:"json",  
				success:function(data){ 
					 $('#desg_name').val(data.desg_name); 
					 $('#desg_amount').val(data.desg_amount); 
					 $('#employee_id').val(data.desg_id);  
					 $('#insert').val("Update");  
					 $('#add_data_Modal').modal('show');  
				}  
		   });  
		});  
	//Insert Data Into Database
		$('#insert_form').on("submit", function(event){  
		   event.preventDefault();  
		});  
	/*==========Delete Data From Table/Database==========*/
	$(document).on('click', '.delete_data', function(){
	   var id = $(this).attr("id");
	   if(confirm("Are you sure you want to remove this?"))
	   {
		$.ajax({
		 url:"desg_delete.php",
		 method:"POST",
		 data:{desg_id:id},
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
	 </script>
<!-------JOB RANKING SCRIPT------>
<script type="text/javascript">
//ADDING NEW EMPLOYEE
	function addJGroup(){
		if($('#jgrp_name').val() == "")  {  
			swal({title:'Oops...', text:'Job Group is required!', type: 'error', 
				 onClose: function () {document.getElementById('jgrp_name').focus();}
				});  
		}else if($('#jgrp_amount').val() == '')  {  
			swal({title:'Oops...', text:'Amount is required!', type: 'error', 
				 onClose: function () {document.getElementById('jgrp_amount').focus();}
				});
	   }else{
	   $.ajax({  
			 url:"jgrp_insert.php",  
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
			 onClose: function () {window.location.href='earnings';}
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
		url:"jgrp_fetch.php",  
		method:"POST",  
		data:{employee_id2:employee_id2},  
		dataType:"json",  
		success:function(data){ 
			 $('#jgrp_name').val(data.jgrp_name);
			 $('#jgrp_amount').val(data.jgrp_amount);
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
//Delete Data From Table/Database
$(document).on('click', '.delete_data2', function(){
	   var id = $(this).attr("id");
	   if(confirm("Are you sure you want to remove this?"))
	   {
		$.ajax({
		 url:"jgrp_delete.php",
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
});
 }); 
 </script>
	
