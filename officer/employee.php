<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 $query = "SELECT * FROM tbl_employee ORDER BY id DESC";  
 $result = mysqli_query($connect, $query);  
 ?> 
 
<?php include '../users/session.php'; ?>
<?php include '../includes/functions.php'; ?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Staff Records</title>  
<?php include '../includes/links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<?php include '../includes/header.php'; ?>
<?php include '../includes/officer_nav.php'; ?>
  <!--Main Content-->   
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-users fa-fw"></i>  Employee</a></li>
        <li class="active"><i class="fa fa-book fa-fw"></i>  Staff Records</li>
		 <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-danger right">New Employee +</button>
    </ol> 
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<ul class="nav nav-tabs">
		<li class="active"><a href="employee">Employee Information</a></li>
	</ul>
<!-------END OF MAIN CONTENT------>
	<div class="tab-content col-kk-12">
			 <div class="table-responsive" >
			<!--<table id="employee" class="display wrap table">-->
			<table id="employee" class="table table-striped table-bordered">
			
						<thead>
							<tr><th>#</th>
								<th>S/N</th>
								<th>ID Number</th>
								<th>Name</th>
								<th>Gender</th>
								<th>Phone Number</th>
								<th>Email Address</th>
								<th>Date</th>
								<th>Employee Type</th>
								<th>Department</th>
								<th>View</th>
								<th>Action</th>
							</tr>
						</thead>
					   <tfoot>
							<tr><th>#</th>
								<th>S/N</th>
								<th>ID Number</th>
								<th>Name</th>
								<th>Gender</th>
								<th>Phone Number</th>
								<th>Email Address</th>
								<th>Date</th>
								<th>Employee Type</th>
								<th>Department</th>
								<th>View</th>
								<th>Action</th>
							</tr>
						</tfoot>
					   <?php 
						$no = 1;
						$totalEmp = 0;
					   while($row = mysqli_fetch_array($result))  
					   {  
					   ?>
					   <tr id="<?php echo $row["id"]; ?>" > 
							<td><input type="checkbox" name="uid[]" class="delete_customer" value="<?php echo $row["id"]; ?>" /></td>
							<td><?php echo $no; ?></td>
							<td><?php echo $row["id_no"]; ?></td>  
							<td><?php echo $row["name"]; ?></td>
							<td><?php echo $row["gender"]; ?></td>
							<td><?php echo $row["phone"]; ?></td>
							<td><?php echo $row["email"]; ?></td>
							<td><?php echo $row["date"]; ?></td>
							<td><?php echo $row["type"]; ?></td>
							<td><?php echo $row["department"]; ?></td>
							<td><input type="button" name="view" value="View" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
							<td>
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><input type="button" name="edit" value="Edit" id="<?php echo $row["id"]; ?>" class="btn btn-warning btn-xs edit_data action" /></li>
									<li class="divider"></li>
									<li><input type="button" name="Delete" value="Delete" id="<?php echo $row["id"]; ?>" class="btn btn-danger btn-xs delete_data action" /></li>
								</ul>
							</div>
							</td>
					   </tr>
					   <?php 
						$no++;
						$totalEmp = $no-1;
					   }  
					   ?>  
			</table>
			<button type="button" name="btn_delete" id="btn_delete" class="btn btn-xs btn-danger pull-left"  style="margin-top:-30px;">Delete Marked</button>
			  <p class="pull-left p-total" style="color:red;">Total Number of Employees: <big><b><?=number_format($totalEmp)?> Employees</b></big></p>
		 </div>
		<!---------VIEW RECORD-------->	  
		 <div id="dataModal" class="modal fade">  
			  <div class="modal-dialog">  
				   <div class="modal-content">  
						<div class="modal-header">  
							 <button type="button" class="close" data-dismiss="modal">&times;</button>  
							 <h4 class="modal-title">Employee Details</h4>  
						</div>  
						<div class="modal-body" id="employee_detail"> </div>  
						<div class="modal-footer">  
							 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
						</div>  
				   </div>  
			  </div>  
		 </div>
		<!--------ADD NEW RCORD--------> 
		 <div id="add_data_Modal" class="modal fade" role="dialog">  
			  <div class="modal-dialog">  
				   <div class="modal-content"> 
				   
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
						<h3 align="center modal-title" >Add Employee</h3>
					</div> 
					
					<div class="modal-body" style="padding:40px 50px;">  
					   <form name="insert_form"  class="form-horizontal" method="post" id="insert_form" > 
					   
						 <div class="form-group">
						  <label class="col-sm-4 control-label">ID Number:</label>
						  <div class="col-sm-8">
						  <input type="text" name="id_no" id="id_no" class="form-control text-center"   placeholder="ID Number"  onkeypress="return isNumber(event)" maxlength="8"/>
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-sm-4 control-label">Name:</label>
						  <div class="col-sm-8">
						   <input type="text" name="name" id="name" class="form-control text-center" placeholder="Last Name"  maxlength="30"/> 
						  </div>
						</div> 
						
						<table class="pull-right">
						<tr >
							<td><label>Gender :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label><select id="gender" name="gender" class="inptxt" >
							  <option value="" >--Select Gender--</option>
							  <option value="Male">Male</option>
							  <option value="Female">Female</option>
							</select></td>
							<td><label>Date :&nbsp;&nbsp;&nbsp;&nbsp; </label><input type="date" style="width:150px" name="date" id="date" class="inptxt" placeholder="Date"/></td>
						</tr>
						</table>
						
						<div class="form-group">
						  <label class="col-sm-4 control-label">Phone Number:</label>
						  <div class="col-sm-8">
						   <input type="text" name="phone" id="phone" class="form-control text-center" placeholder="Phone Number" onkeypress="return isNumber(event)" maxlength="15"/>
						  </div>
						</div>	
						<div class="form-group">
						  <label class="col-sm-4 control-label">Email Address:</label>
						  <div class="col-sm-8">
						   <input type="text" name="email" id="email" class="form-control text-center" placeholder="Email Address"/>  
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-sm-4 control-label">Department:</label>
						  <div class="col-sm-8">
						  <?php
							$host = 'localhost'; $user = 'root'; $pass = ''; $db = 'hrm';
							$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
							?>
							<select id="department" name="department" class="form-control text-center" >
								<option value="">--Select Department--</option>
								<?php
								$result = $mysqli->query("SELECT id,department FROM departments ORDER BY id DESC") or die($mysqli->error);
								while ($row = mysqli_fetch_array($result)) {
									echo "<option value='" . $row['department'] . "'>" . $row['department'] . "</option>";
								}
								?>        
							</select>
						  </div>
						</div>
						<table class="pull-right">
						<tr >
							<td><label>Staff Type :&nbsp;&nbsp;</label>
							<select id="type"  name="type" class="inptxt2 text-center">
							  <option value="" >--Select Type--</option>
							  <option value="Job Order">Job Order</option>
							  <option value="Regular">Regular</option>
							  <option value="Casual">Casual</option>
							  <option value="Casual">Trainee</option>
							</select>
						  </td>
							<td><label>Bank :&nbsp;&nbsp;</label>
							<select name="bank" id="bank" style="width:120px" class="inptxt text-center bank" >
								<option value="0">--Bank--</option>
								<?php echo fill_bank($connect); ?>
							</select>
							</td>
						</tr>
						</table>
						<div class="form-group">
						  <label class="col-sm-4 control-label">Account:</label>
						  <div class="col-sm-8">
						   <input type="text" name="account" id="account" class="form-control text-center" placeholder="Account" maxlength="20"/>  
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-4 control-label"></label>
						  <div class="col-sm-8">
							<input type="hidden" name="employee_id" id="employee_id" />  
							<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" onclick="addEmployee();" />
							<input type="reset" name="" class="btn btn-danger" value="Clear Fields"/>
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
<!-------END OF MAIN CONTENT------>
</div>
</div>
<?php include '../includes/footer.php' ?>
</div>	
</body>
</html>

<script>
$(function() {
	  $(document).ready(function () {
	   var todaysDate = new Date();
		var year = todaysDate.getFullYear();                       
		var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);
		var day = ("0" + todaysDate.getDate()).slice(-2);      
		var maxDate = (year +"-"+ month +"-"+ day); 
		$('#date').attr('max',maxDate);
	  });
	});

</script>
	
<script type="text/javascript">

//ADDING NEW EMPLOYEE
	function addEmployee(){
		var id = document.forms["insert_form"]["id_no"].value;
		var re = /\b.{7,8}\b/;
		//Email Validation Variables
		var x = document.forms["insert_form"]["email"].value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		//List Selection Variables
		var selGender = document.querySelector("#gender");
		var selType = document.querySelector("#type");
		var selDivision = document.querySelector("#department");
		var selBank = document.querySelector("#bank");
		
		if($('#id_no').val() == "")  {  
			swal({title:'Oops...', text:'ID Number is required!', type: 'error', 
				 onClose: function () {document.getElementById('id_no').focus();}
				});  
		}else if (!id.match(re)) {
			alert("ID Number must be 7-8 Characters!");
			 document.getElementById('id_no').focus();
			return false;
		}else if($('#name').val() == '')  { 
			swal({title:'Oops...', text:'Lastname is required!', type: 'error', 
				 onClose: function () {document.getElementById('name').focus();}
				}); 
	   }else if (selGender.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select Gender!', type: 'error', 
				 onClose: function () {document.getElementById('gender').focus();}
				});
	   }else if($('#date').val() == '')  {  
			swal({title:'Oops...', text:'Date is required!', type: 'error', 
				 onClose: function () {document.getElementById('date').focus();}
				});
	   }else if($('#phone').val() == '')  {  
			swal({title:'Oops...', text:'Phone Number is required!', type: 'error', 
				 onClose: function () {document.getElementById('phone').focus();}
				});
	   }else if($('#email').val() == '')  {  
			swal({title:'Oops...', text:'Email Address is required!', type: 'error', 
				 onClose: function () {document.getElementById('email').focus();}
				});
	   }else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
			swal({title:'Oops...', text:'Please Enter a Valid Email Address!', type: 'error', 
				 onClose: function () {document.getElementById('email').focus();}
				});
			return false;
       }else if (selDivision.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select Department!', type: 'error', 
				 onClose: function () {document.getElementById('department').focus();}
				});
	   }else if (selType.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select Type!', type: 'error', 
				 onClose: function () {document.getElementById('type').focus();}
				});
	   }else if (selBank.selectedIndex === 0) {
			swal({title:'Oops...', text:'Please Select Bank!', type: 'error', 
				 onClose: function () {document.getElementById('bank').focus();}
				});
	   }else if($('#account').val() == '')  {  
			swal({title:'Oops...', text:'Account Number is Required!', type: 'error', 
				 onClose: function () {document.getElementById('account').focus();}
				});
	   }else{
	   $.ajax({  
			 url:"../employee/e_insert.php",  
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
		swal('Success..!', 'Employee Successfuly Saved!', 'success');
		}
	}
	</script>
 <script type="text/javascript" language="javascript"> 
 
 $(document).ready(function(){
	  var entity = "Employees";
	 $('#employee').DataTable( {
        dom: 'lBfrtip',
        buttons: ['copy', 'csv','excel','pdf', 'print']
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
		url:"../employee/e_fetch.php",  
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
			 $('#bank').val(data.bank);  
			 $('#account').val(data.account);
			 $('#employee_id').val(data.id);  
			 $('#insert').val("Update");  
			 $('#add_data_Modal').modal('show');  
			 
			$('.modal-title').text("Update Image");
			$('#insert').val("Update");
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
			 url:"../employee/e_select.php",  
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
		 url:"../employee/e_delete.php",
		 method:"POST",
		 data:{id:id},
		 success:function(data){
		  swal('Deleted!', 'Department Successfuly Deleted!', 'success');
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
  <!---Delete Marked---->
<script>
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
		swal('Error..!', 'Please Select atleast one checkbox!', 'error');
	   }
	   else
	   {
		$.ajax({
			 url:'../employee/e_delete1.php',
			 method:'POST',
			 data:{id:id},
			 success:function()
			 {
			  for(var i=0; i<id.length; i++)
			  {
			   $('tr#'+id[i]+'').css('background-color', '#ccc');
			   $('tr#'+id[i]+'').fadeOut('slow');
			   $('#images').html(data);
			  }
			 }
		});
	   }
	  } else{ return false; }
	 }); 
	});
</script>