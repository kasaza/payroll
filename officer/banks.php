<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 $query = "SELECT * FROM banks ORDER BY bnk_id DESC";  
 $result = mysqli_query($connect, $query);  
 ?> 

<?php include '../users/session.php'; ?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Banks</title>  
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
        <li class="active"><i class="fa fa-building fa-fw"></i>  Banks</li>
		<button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-danger right">NEW BANK +</button>
    </ol>
	 
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<ul class="nav nav-tabs">
		<li><a href="earnings">Earnings</a></li>
		<li><a href="allowances"> Allowances</a></li>
		<li><a href="deductions">Deductions</a></li>
		<li class="active"><a href="#">Banks</a></li>
	</ul>
<!-------END OF MAIN CONTENT------>
<div class="tab-content col-kk-12">
	<!-------DEDUCTIONS TABLE------>
		<div class="table-responsive " >
			<table id="banks" class="table table-bordered table-striped">
				<thead>
				  <tr><th>#</th>
					<th>Bank Name</th>
					  <th>Branch</th>
					  <th>Email Address</th>
					  <th>Telephone</th>
					  <th>Edit</th>
					  <th>Delete</th>
				  </tr>
				</thead>
			   <tfoot>
				 <tr><th>#</th>
					<th>Bank Name</th>
					  <th>Branch</th>
					  <th>Email Address</th>
					  <th>Telephone</th>
					  <th>Edit</th>
					  <th>Delete</th>
				  </tr>
				</tfoot>
			  <?php 
				$no = 1;
			   while($row = mysqli_fetch_array($result))  
			   {  
				$bnk_id = $row['bnk_id'];
				$bank = $row['bank'];
				$branch = $row['branch'];
			   ?>
			   <tr> <td><?php echo $no; ?></td>
					<td><?php echo $row["bank"]; ?></td> 
					<td><?php echo $row["branch"]; ?></td>
					<td><?php echo $row["bnk_email"]; ?></td> 
					<td><?php echo $row["bnk_phone"]; ?></td>
					<td><input type="button" name="edit" value="Edit" id="<?php echo $row["bnk_id"]; ?>" class="btn btn-warning btn-xs edit_data " /></td>
					<td><input type="button" name="Delete" value="Delete" id="<?php echo $row["bnk_id"]; ?>" class="btn btn-danger btn-xs delete_data " /></td>
			   </tr>
			   <?php 
				$no++;
			   }  
			   ?>  
			</table>
		 </div>
		 </div>

	<!--------ADD NEW RCORD--------> 
	 <div id="add_data_Modal" class="modal fade" role="dialog">  
		  <div class="modal-dialog">  
			   <div class="modal-content"> 
			   
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" title="Close">&times;</button>
					<h3>New Bank Record</h3>
				</div> 

				<div class="modal-body" style="padding:40px 50px;">  
				   <form name="insert_form" class="form-horizontal" method="post" id="insert_form" > 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Bank Name:</label>
					  <div class="col-sm-8">
					   <input type="text" name="bank" id="bank" class="form-control text-center" placeholder="Name" maxlength="20"/> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Bank Branch:</label>
					  <div class="col-sm-8">
					   <input type="text" name="branch" id="branch" class="form-control text-center" placeholder="Branch" maxlength="20"/> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Email Address:</label>
					  <div class="col-sm-8">
					   <input type="text" name="bnk_email" id="bnk_email" class="form-control text-center" placeholder="Email Address" maxlength="20"/> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Telephone:</label>
					  <div class="col-sm-8">
					   <input type="text" name="bnk_phone" id="bnk_phone" class="form-control text-center" placeholder="Telephone" maxlength="20"onkeypress="return isNumber(event)" /> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label"></label>
					  <div class="col-sm-8">
						<input type="hidden" name="employee_id" id="employee_id" />  
						<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" onclick="addBank();" />
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
<!-------END OF MAIN CONTENT------>
</div>
</div>
<?php include '../includes/footer.php' ?>
</div>	
</body>
</html>
<script type="text/javascript">
//ADDING NEW DEDUCTION
		
	function addBank(){
		//Email Validation Variables
		var x = document.forms["insert_form"]["bnk_email"].value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		
		if($('#bank').val() == '')  { 
			swal({title:'Oops...', text:'Bank Name is required!', type: 'error', 
				 onClose: function () {document.getElementById('bank').focus();}
				}); 
	   }else if($('#branch').val() == '')  { 
			swal({title:'Oops...', text:'Bank Branch is required!', type: 'error', 
				 onClose: function () {document.getElementById('branch').focus();}
				});
	   }else if($('#bnk_email').val() == '')  { 
			swal({title:'Oops...', text:'Email Address is required!', type: 'error', 
				 onClose: function () {document.getElementById('bnk_email').focus();}
				});
	   }else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
			swal({title:'Oops...', text:'Please Enter a Valid Email Address!', type: 'error', 
				 onClose: function () {document.getElementById('bnk_email').focus();}
				});
			return false;
       }else if($('#bnk_phone').val() == '')  { 
			swal({title:'Oops...', text:'Telephone is required!', type: 'error', 
				 onClose: function () {document.getElementById('bnk_phone').focus();}
				});
	   }else{
	   $.ajax({  
			 url:"../admin/bnk_insert.php",  
			 method:"POST",  
			 data:$('#insert_form').serialize(),  
			 beforeSend:function(){  
				  $('#insert').val("Inserting");  
			 },  
			 success:function(data){
				  $('#insert_form')[0].reset();  
				  $('#add_data_Modal').modal('hide');  
				  $('#banks').html(data);  
			 }  
		});  
		swal('Success..!', 'Record Successfuly Saved!', 'success');
		}
	}
	</script>
 <script type="text/javascript" language="javascript"> 
 
 $(document).ready(function(){
	  var entity = "Banks";
	 $('#banks').DataTable( {
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
		url:"../admin/bnk_fetch.php",  
		method:"POST",  
		data:{employee_id:employee_id},  
		dataType:"json",  
		success:function(data){ 
			 $('#bank').val(data.bank);
			 $('#branch').val(data.branch);
			 $('#bnk_email').val(data.bnk_email);
			 $('#bnk_phone').val(data.bnk_phone);
			 $('#employee_id').val(data.bnk_id); 
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
				 url:"../admin/ded_select.php",  
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
		 url:"../admin/bnk_delete.php",
		 method:"POST",
		 data:{bnk_id:id},
		 success:function(data){
		  swal('Deleted!', 'Bank Successfuly Removed!', 'success');
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