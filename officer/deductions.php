<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 $query = "SELECT * FROM deductions  ORDER BY ded_id DESC";  
 $result = mysqli_query($connect, $query);  
 ?> 

<?php include '../users/session.php'; ?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Deductions</title>  
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
        <li class="active"><i class="fa fa-calculator fa-fw"></i>  Deductions</li>
		<button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-danger right">New +</button>
    </ol>
	 
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
	<ul class="nav nav-tabs">
		<li><a href="earnings">Earnings</a></li>
		<li><a href="allowances"> Allowances</a></li>
		<li class="active"><a href="#">Deductions</a></li>
		<li><a href="banks">Banks</a></li>
	</ul>
<!-------END OF MAIN CONTENT------>
	<div class="tab-content col-kk-12">
	<!-------DEDUCTIONS TABLE------>
		<div class="row">
		<div class="col-lg-12">
			<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>Deductions Configurations</h5>
			</header>
			<div id="div-1" class="body collapse in">
			<div class="table-responsive " >
				<table id="deductions" class="table table-bordered table-striped">
					<thead>
					  <tr><th>#</th>
						<th>Deduction</th>
						  <th>Amount</th>
						  <th>Max-Amount</th>
						  <th>Edit</th>
						  <th>Delete</th>
					  </tr>
					</thead>
				   <tfoot>
					 <tr><th>#</th>
						<th>Deduction</th>
						  <th>Amount</th>
						  <th>Max-Amount</th>
						  <th>Edit</th>
						  <th>Delete</th>
					  </tr>
					</tfoot>
				  <?php 
					$no = 1;
				   while($row = mysqli_fetch_array($result))  
				   {  
					$ded_id = $row['ded_id'];
					$deduction = $row['deduction'];
					$amount = $row['amount'];
					$max_amount = $row['max_amount'];
				   ?>
				   <tr id="<?php echo $row["ded_id"]; ?>"> 
						<td><?php echo $no; ?></td>
						<td><?php echo $row["deduction"]; ?></td> 
						<td><?=number_format($row["amount"]); ?> .00</td>
						<td><?=number_format($row["max_amount"]); ?> .00</td> 
						<td><input type="button" name="edit" value="Edit" id="<?php echo $row["ded_id"]; ?>" class="btn btn-warning btn-xs edit_data " /></td>
						<td><input type="button" name="Delete" value="Delete" id="<?php echo $row["ded_id"]; ?>" class="btn btn-danger btn-xs delete_data " /></td>
				   </tr>
				   <?php 
					$no++;
				   }  
				   ?>  
				</table>
			</div>
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
					<h3> New Deduction</h3>
				</div> 
				<div class="modal-body" style="padding:40px 50px;">  
				   <form name="insert_form" class="form-horizontal" method="post" id="insert_form" > 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Deduction:</label>
					  <div class="col-sm-8">
					   <input type="text" name="deduction" id="deduction" class="form-control text-center" placeholder="Deduction" maxlength="20"/> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Deduction Amount:</label>
					  <div class="col-sm-8">
					   <input type="text" name="amount" id="amount" class="form-control text-center" placeholder="Amount" maxlength="8" onkeypress="return isNumber(event)" /> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label">Max-Amount:</label>
					  <div class="col-sm-8">
					   <input type="text" name="max_amount" id="max_amount" class="form-control text-center" placeholder="Max-Amount" maxlength="8" onkeypress="return isNumber(event)" /> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-4 control-label"></label>
					  <div class="col-sm-8">
						<input type="hidden" name="employee_id" id="employee_id" />  
						<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" onclick="addDeduction();" />
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
<!-------END OF MAIN CONTENT------>
</div>
</div>
<?php include '../includes/footer.php' ?>
</div>	
</body>
</html>
<script type="text/javascript">
//ADDING NEW DEDUCTION
		
	function addDeduction(){
		if($('#deduction').val() == '')  { 
			swal({title:'Oops...', text:'Deduction is required!', type: 'error', 
				 onClose: function () {document.getElementById('deduction').focus();}
				}); 
	   }else if($('#amount').val() == '')  { 
			swal({title:'Oops...', text:'Amount is required!', type: 'error', 
				 onClose: function () {document.getElementById('amount').focus();}
				});
	   }else if($('#max_amount').val() == '')  { 
			swal({title:'Oops...', text:'Max-Amount is required!', type: 'error', 
				 onClose: function () {document.getElementById('max_amount').focus();}
				});
	   }else{
	   $.ajax({  
			 url:"../admin/ded_insert.php",  
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
	  var entity = "Deductions";
	 $('#deductions').DataTable( {
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
		url:"../admin/ded_fetch.php",  
		method:"POST",  
		data:{employee_id:employee_id},  
		dataType:"json",  
		success:function(data){ 
			 $('#deduction').val(data.deduction);
			 $('#amount').val(data.amount);
			 $('#max_amount').val(data.max_amount);
			 $('#employee_id').val(data.ded_id); 
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
		 url:"../admin/ded_delete.php",
		 method:"POST",
		 data:{ded_id:id},
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