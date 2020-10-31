
<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 $query = "SELECT * FROM departments ORDER BY id DESC";  
 $result = mysqli_query($connect, $query);  
 ?> 
 <?php include '../users/session.php'; ?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Departments</title>  
<?php include '../includes/links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<!-- Top Navbar Start-->  
<?php include '../includes/header.php'; ?>
<?php include '../includes/admin_nav.php'; ?>
  <!--Main Content-->   
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-gears fa-fw"></i>  Set-Ups</a></li>
        <li class="active"><i class="fa fa-tags fa-fw"></i>  Departments</li>
		<button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-danger right">NEW DEPARTMENT +</button>
    </ol>
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<ul class="nav nav-tabs">
		<li  class="active"><a href="#">Departments</a></li>
	</ul>
<!-------END OF MAIN CONTENT------>
	<div class="tab-content col-kk-12">
		<div class="ibox-content">
			 <div class="table-responsive" >
			<!--<table id="departments" class="display wrap table">-->
			<table id="departments" class="table table-bordered table-striped">
						<thead>
							<tr><th>#</th>
								<th>S/N</th>
								<th>Department</th>
								<th>Sub-Departments</th>
								<th>Departmental Head</th>
								<th>ID Number</th>
								<th>Contact</th>
								<th>Assistant</th>
								<th>ID Number</th>
								<th>No of Staff</th>
								<th>View</th>
								<th>Action</th>
							</tr>
						</thead>
					   <tfoot>
							<tr><th>#</th>
								<th>S/N</th>
								<th>Department</th>
								<th>Sub-Departments</th>
								<th>Departmental Head</th>
								<th>ID Number</th>
								<th>Contact</th>
								<th>Assistant</th>
								<th>ID Number</th>
								<th>No of Staff</th>
								<th>View</th>
								<th>Action</th>
							</tr>
						</tfoot>
					   <?php 
						$no = 1;
						$totalDeps = 0;
					   while($row = mysqli_fetch_array($result))  
					   {  
					   ?>
					   <tr id="<?php echo $row["id"]; ?>" > 
							<td><input type="checkbox" name="uid[]" class="delete_customer" value="<?php echo $row["id"]; ?>" /></td>
							<td><?php echo $no; ?></td>
							<td><?php echo $row["department"]; ?></td>  
							<td><?php echo $row["sub"]; ?></td>
							<td><?php echo $row["head"]; ?></td> 
							<td><?php echo $row["id_no"]; ?></td>
							<td><?php echo $row["phone"]; ?></td>
							<td><?php echo $row["assistant"]; ?></td>
							<td><?php echo $row["id_no2"]; ?></td>
							<td><?php echo $row["staff"]; ?></td>
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
						$totalDeps = $no-1;
					   }  
					   ?>  
			</table>
			<button type="button" name="btn_delete" id="btn_delete" class="btn btn-xs btn-danger pull-left" style="margin-top:-30px;">Delete Marked</button>
			<p class="pull-left p-total" style="">Total Departments: <big><b><?=number_format($totalDeps)?> Department (s)</b></big></p>
           
			
			
		 </div>
		<!---------VIEW RECORD-------->	  
		 <div id="dataModal" class="modal fade">  
			  <div class="modal-dialog">  
				   <div class="modal-content">  
						<div class="modal-header" style="padding:20px 50px;">  
							 <button type="button" class="close" data-dismiss="modal">&times;</button>  
							 <h3 class="modal-title"><center>Departmental Information</center></h3>  
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
				   
					<div class="modal-header" style="padding:20px 50px;">
						<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
						<h3 align="center">New Department</h3>
					</div> 
					
					<div class="modal-body" style="padding:40px 50px;">  
					   <form name="insert_form"  class="form-horizontal" method="post" id="insert_form" > 
						<div class="form-group">
						  <label class="col-sm-4 control-label">Department:</label>
						  <div class="col-sm-8">
						   <input type="text" name="department" id="department" class="form-control text-center" placeholder="Department"  maxlength="30"/> 
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-4 control-label">Sub-Departments:</label>
						  <div class="col-sm-8">
						   <textarea name="sub" id="sub" class="form-control text-center" placeholder="Sub-Departments...."  maxlength="30"></textarea>
						  </div>
						</div>	
						<div class="form-group">
						  <label class="col-sm-4 control-label">Departmental Head:</label>
						  <div class="col-sm-8">
						   <input type="text" name="head" id="head" class="form-control text-center" placeholder="Departmental Head"  maxlength="20"/> 
						  </div>
						</div> 
						 <div class="form-group">
						  <label class="col-sm-4 control-label">ID Number:</label>
						  <div class="col-sm-8">
						  <input type="text" name="id_no" id="id_no" class="form-control text-center"   placeholder="ID Number"  onkeypress="return isNumber(event)" maxlength="8"/>
						  </div>
						</div>
						
						<div class="form-group">
						  <label class="col-sm-4 control-label">Phone Number:</label>
						  <div class="col-sm-8">
						   <input type="text" name="phone" id="phone" class="form-control text-center" placeholder="Phone Number" maxlength="10"/> 
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-4 control-label">Assistant:</label>
						  <div class="col-sm-8">
						   <input type="text" name="assistant" id="assistant" class="form-control text-center" placeholder="Assistant Departmental Head"  maxlength="20"/> 
						  </div>
						</div> 
						 <div class="form-group">
						  <label class="col-sm-4 control-label">ID Number:</label>
						  <div class="col-sm-8">
						  <input type="text" name="id_no2" id="id_no2" class="form-control text-center"   placeholder="Assistant ID Number"  onkeypress="return isNumber(event)" maxlength="8"/>
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-4 control-label">Phone Number:</label>
						  <div class="col-sm-8">
						   <input type="text" name="phone2" id="phone2" class="form-control text-center" placeholder="Assistant Phone Number" onkeypress="return isNumber(event)" maxlength="15"/>
						  </div>
						</div>	
						<div class="form-group">
						  <label class="col-sm-4 control-label">Number of Staff:</label>
						  <div class="col-sm-8">
						   <input type="text" name="staff" id="staff" class="form-control text-center" placeholder="Total Number of Staff"/>  
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
</div>
<!-------END OF MAIN CONTENT------>
</div>
</div>
<?php include '../includes/footer.php' ?>
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
//ADDING NEW EMPLOYEE
	function addEmployee(){
		var id = document.forms["insert_form"]["id_no"].value;
		var re = /\b.{7,8}\b/;
		
		var id2 = document.forms["insert_form"]["id_no2"].value;
		var re2 = /\b.{7,8}\b/;
		
		if($('#department').val() == '')  { 
			swal({title:'Oops...', text:'Department Name is required!', type: 'error', 
				 onClose: function () {document.getElementById('department').focus();}
				});
		}else if($('#sub').val() == '')  { 
			swal({title:'Oops...', text:'Sub-Departments is required!', type: 'error', 
				 onClose: function () {document.getElementById('sub').focus();}
				});
	   }else if($('#head').val() == '')  { 
			swal({title:'Oops...', text:'Departmental Head is required!', type: 'error', 
				 onClose: function () {document.getElementById('head').focus();}
				});
	   }else if($('#id_no').val() == "")  {  
			swal({title:'Oops...', text:'ID Number is required!', type: 'error', 
				 onClose: function () {document.getElementById('id_no').focus();}
				});  
		}else if (!id.match(re)) {
			alert("ID Number must be 7-8 Characters!");
			 document.getElementById('id_no').focus();
			return false;
		}else if($('#phone').val() == '')  {  
			swal({title:'Oops...', text:'Phone Number is required!', type: 'error', 
				 onClose: function () {document.getElementById('phone').focus();}
				});
	   }else if($('#assistant').val() == '')  { 
			swal({title:'Oops...', text:'Assistant Departmental Head is required!', type: 'error', 
				 onClose: function () {document.getElementById('assistant').focus();}
				}); 
	   }else if($('#id_no2').val() == '')  { 
			swal({title:'Oops...', text:'Assistant ID Number is required!', type: 'error', 
				 onClose: function () {document.getElementById('id_no2').focus();}
				});
	   }else if (!id2.match(re2)) {
			alert("ID Number must be 7-8 Characters!");
			 document.getElementById('id_no2').focus();
			return false;
		}else if($('#phone2').val() == '')  {  
			swal({title:'Oops...', text:'Assistant Phone Number is required!', type: 'error', 
				 onClose: function () {document.getElementById('phone2').focus();}
				});
	   }else if($('#staff').val() == '')  {  
			swal({title:'Oops...', text:'Total Number of Staff is required!', type: 'error', 
				 onClose: function () {document.getElementById('staff').focus();}
				});
	   }else{
	   $.ajax({  
			 url:"d_insert.php",  
			 method:"POST",  
			 data:$('#insert_form').serialize(),  
			 beforeSend:function(){  
				  $('#insert').val("Inserting");  
			 },  
			 success:function(data){
				  $('#insert_form')[0].reset();  
				  $('#add_data_Modal').modal('hide');  
				  $('#insert_form').html(data);  
			 }  
		});  
		swal({title:'Success!', text:'Department Successfuly Added!', type: 'success', 
			 onClose: function () {window.location.href='departments';}
			}); 
		}
	  }

	</script>
 <script type="text/javascript" language="javascript"> 
 
 $(document).ready(function(){
	 
	 $('#departments').DataTable( {
        dom: 'lBfrtip',
        buttons: ['copy', 'csv','excel','pdf', 'print',
                {
                    text: 'Refresh',
                    action: function ( e, dt, node, config ) {
                        dt.ajax.reload();
                    }
                }
        ]
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
		url:"d_fetch.php",  
		method:"POST",  
		data:{employee_id:employee_id},  
		dataType:"json",  
		success:function(data){ 
			 $('#department').val(data.department);
			 $('#sub').val(data.sub);
			 $('#head').val(data.head);
			 $('#id_no').val(data.id_no);  
			 $('#phone').val(data.phone);  
			 $('#assistant').val(data.assistant);  
			 $('#id_no2').val(data.id_no2);
			 $('#phone2').val(data.phone2);
			 $('#staff').val(data.staff); 
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
				 url:"d_select.php",  
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
		 url:"d_delete.php",
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
		swal('Error..!', 'Please Select atleast one Department to Delete!', 'error');
	   }
	   else
	   {
		$.ajax({
			 url:'delete1.php',
			 method:'POST',
			 data:{id:id},
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