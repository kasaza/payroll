<?php  
 $connect0 = mysqli_connect("localhost", "root", "", "hrm");  
 $query = "SELECT * FROM tbl_users ORDER BY id ASC";  
 $result0 = mysqli_query($connect0, $query);  
 ?>   
 
<?php include '../users/session.php'; ?>

<?php
$connect = new PDO("mysql:host=localhost;dbname=hrm", "root", "");
$get_all_table_query = "SHOW TABLES";
$statement = $connect->prepare($get_all_table_query);
$statement->execute();
$result = $statement->fetchAll();
date_default_timezone_set('Africa/Nairobi');
if(isset($_POST['table']))
{
 $output = '';
 foreach($_POST["table"] as $table)
 {
  $show_table_query = "SHOW CREATE TABLE " . $table . "";
  $statement = $connect->prepare($show_table_query);
  $statement->execute();
  $show_table_result = $statement->fetchAll();

  foreach($show_table_result as $show_table_row)
  {
   $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
  }
  $select_query = "SELECT * FROM " . $table . "";
  $statement = $connect->prepare($select_query);
  $statement->execute();
  $total_row = $statement->rowCount();

  for($count=0; $count<$total_row; $count++)
  {
   $single_result = $statement->fetch(PDO::FETCH_ASSOC);
   $table_column_array = array_keys($single_result);
   $table_value_array = array_values($single_result);
   $output .= "\nINSERT INTO $table (";
   $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
   $output .= "'" . implode("','", $table_value_array) . "');\n";
  }
 }
 $file_name = 'E-Payroll_DataBase_Backup_on_' .date('F-j-Y').'-at-'.date('H-i-s').'.sql';
 $file_handle = fopen($file_name, 'w+');
 fwrite($file_handle, $output);
 fclose($file_handle);
 header('Content-Description: File Transfer');
 header('Content-Type: application/octet-stream');
 header('Content-Disposition: attachment; filename=' . basename($file_name));
 header('Content-Transfer-Encoding: binary');
 header('Expires: 0');
 header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    ob_clean();
    flush();
    readfile($file_name);
    unlink($file_name);
}

?>
<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > User Accounts</title>  
<?php include '../includes/links.php'; ?>
</head>
<body style="" class="">
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<?php include '../includes/header.php'; ?>
<?php include '../includes/admin_nav.php'; ?>
<!---Main Content--->         
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
       <li><a href=""><i class="fa fa-laptop fa-fw"></i>  Advanced</a></li>
        <li class="active"><i class="fa fa-wrench fa-fw"></i> Sys Users & DataBase</li>
    </ol>
</div>
<!-------MAIN CONTENT------>
<div class="main-content">
   <ul class="nav nav-tabs">
	<li class="active"><a href="#">User Accounts & DataBase Backup</a></li>
  </ul>
<!-------END OF MAIN CONTENT------>
<div class="tab-content col-kk-12">
		<div class="row">
		<div class="col-sm-8">
			<div class="box">
			<header>
				<div class="icons"><i class="icon-th-large"></i></div>
				<h5>User Accounts Information</h5>
			   <thead><tr><button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-danger right" style="margin:2px 10px;">New User +</button></tr>
			   </thead>
			</header>
			<div id="div-1" class="body collapse in">
			<div class="table-responsive" >
				<table id="users" class="table table-bordered table-striped">
				<thead>
				  <tr> <th>#</th>
					  <th>S/N</th>
					  <th>Username</th>
					  <th>ID Number</th>
					  <th>Email</th>
					  <th>Phone</th>
					  <th>User Role</th>
					  <th>Action</th>
				  </tr>
				</thead>
				 <tfoot>
				  <tr> <th>#</th>
					  <th>S/N</th>
					  <th>Username</th>
					  <th>ID Number</th>
					  <th>Email</th>
					  <th>Phone</th>
					  <th>User Role</th>
					  <th>Action</th>
				  </tr>
				</tfoot>
				 <?php  
					$no = 1;
					$totalUsers = 0;
				 while($row = mysqli_fetch_array($result0))  
				 {  
				 ?>
				<tr id="<?php echo $row["id"]; ?>" >
					<td><input type="checkbox" name="uid[]" class="delete_customer" value="<?php echo $row["id"]; ?>" /></td>
					<td><?php echo $no; ?></td>
					<td><?php echo $row["uname"]; ?></td>  
					<td><?php echo $row["id_no"]; ?></td>
					<td><?php echo $row["email"]; ?></td> 
					<td><?php echo $row["phone"]; ?></td> 
					<td><?php echo $row["role"]; ?></td>
					<td>
				  <div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
					<ul class="dropdown-menu">
					  <li><input type="button" name="view" value="View" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data action" /></li>
					  <li class="divider"></li>
					  <li><input type="button" name="edit" value="Edit" id="<?php echo $row["id"]; ?>" class="btn btn-warning btn-xs edit_data action" /></li>
					  <li class="divider"></li>
					  <li><input type="button" name="Delete" value="Delete" id="<?php echo $row["id"]; ?>" class="btn btn-danger btn-xs delete_data action" /></li>
					</ul>
				   </div>
				  </td>
				 </tr>
				 <?php  
					$no++;
					$totalUsers = $no-1;
				 }  
				 ?>  
			</table>
			<button type="button" name="btn_delete" id="btn_delete" class="btn btn-xs btn-danger pull-left" style="margin-top:-30px;">Delete Marked</button>
			<p class="pull-left p-total">Total Number of Users: <big><b><?=number_format($totalUsers)?> Users</b></big></p>
			 </div>
			</div>
			</div>
		</div>
<!--------TOTAL ALLOWACES PANEL-------->
			<div class="col-sm-4">
				<div class="box">
				<header>
					<div class="icons"><i class="icon-th-large"></i></div>
					<h5>DataBase Backup</h5>
				</header>
				<div id="div-1" class="body collapse in">
					<form method="post" id="export_form">
					 <h3>Select DataBase to Export</h3>
					<?php
					 $no = 1; 
					foreach($result as $table)
					{
					?>
					 <div class="checkbox"><label><?php echo $no;?>.</label>&nbsp;
					  <label><input type="checkbox" class="checkbox_table" name="table[]" value="<?php echo $table["Tables_in_hrm"]; ?>" /> <?php echo $table["Tables_in_hrm"]; ?></label>
					 </div>
					<?php
					 $no++;
					}
					?>
					 <div class="form-group">
					  <input type="submit" name="submit" id="submit" class="btn btn-success" style="margin-left:50px;" value="Export" />
					 </div>
					</form>	
				</div>
				</div>
			</div>
		</div>
		<!---DataBase Backup---->
			<script>
			$(document).ready(function(){
			 $('#submit').click(function(){
			  var count = 0;
			  $('.checkbox_table').each(function(){
			   if($(this).is(':checked'))
			   {
				count = count + 1;
			   }
			  });
			  if(count > 0)
			  {
			   $('#export_form').submit();
			  }
			  else
			  {
				swal('Export Error..!', 'Please Select Atleast one DataBase table for Export!', 'error');
			   return false;
			  }
			 });
			});
		 </script>
		
 <!---------VIEW RECORD-------->	  
		 <div id="dataModal" class="modal fade">  
			  <div class="modal-dialog">  
				   <div class="modal-content">  
						<div class="modal-header">  
							 <button type="button" class="close" data-dismiss="modal">&times;</button>  
							 <h4 class="modal-title">User Record</h4>  
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
        <h3 align="center">New System User</h3>
      </div> 
      
            <div class="modal-body" style="padding:40px 50px;">  
               <form name="insert_form" class="form-horizontal" method="post" id="insert_form" > 
         
                 <div class="form-group">
                  <label class="col-sm-4 control-label">Username :</label>
                  <div class="col-sm-8">
                  <input type="text" name="uname" id="uname" class="form-control text-center"   placeholder="Username" />
                  </div>
                </div>
				 <div class="form-group">
                  <label class="col-sm-4 control-label">ID Number :</label>
                  <div class="col-sm-8">
                  <input type="text" name="id_no" id="id_no" class="form-control text-center"   placeholder="ID Number" onkeypress="return isNumber(event)" maxlength="8"/>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Email Address :</label>
                  <div class="col-sm-8">
                  <input type="text" name="email" id="email" class="form-control text-center"   placeholder="Email Address" />
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Phone Number :</label>
                  <div class="col-sm-8">
                  <input type="text" name="phone" id="phone" class="form-control text-center"   placeholder="Phone Number" onkeypress="return isNumber(event)" maxlength="10"/>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-4 control-label">User Role:</label>
                  <div class="col-sm-8">
                    <select id="role" name="role" class="form-control text-center" >
                      <option value="" selected>--Select User Role--</option>
					  <option value="user">Staff</option>
					  <option value="officer">Payroll Officer</option>
					   <option value="admin">Admin</option>
                    </select>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Password :</label>
                  <div class="col-sm-8">
                  <input type="password" name="password" id="password" class="form-control text-center"   placeholder="Password" />
                  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-4 control-label"></label>
				  <div class="col-sm-8">
				  <input type="hidden" name="employee_id" id="employee_id" />  
				  <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" onclick="addEmployee();" />
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
	
	var u = document.forms["insert_form"]["uname"].value;
	var id = document.forms["insert_form"]["id_no"].value;
	var re = /\b.{7,8}\b/;
    var e = document.forms["insert_form"]["email"].value;
    var atpos = e.indexOf("@");
    var dotpos = e.lastIndexOf(".");
	var phn = document.forms["insert_form"]["phone"].value;
	var pn = /\b.{10}\b/;
	var selRole = document.querySelector("#role");
	var ps = document.forms["insert_form"]["password"].value;
	var re2 = /\b.{5,128}\b/;
	
    if (u.length==0) {
		swal({title:'Oops...', text:'Please enter Username!', type: 'error', 
        onClose: function () {document.getElementById('uname').focus();}
        }); 
    }else if (id.length==0) {
		swal({title:'Oops...', text:'Please enter ID Number!', type: 'error', 
        onClose: function () {document.getElementById('id_no').focus();}
        }); 
    }else if (!id.match(re)) {
        alert("ID Number must be 7-8 Characters!");
		 document.getElementById('id_no').focus();
    }else if (e.length==0) {  
		swal({title:'Oops...', text:'Email Address is required!', type: 'error', 
		onClose: function () {document.getElementById('email').focus();}
		});
	}else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=e.length) {
		alert('Please enter a valid Email Addresss!')
		document.getElementById('email').focus();
    }else if(phn.length==0)  {  
		swal({title:'Oops...', text:'Phone Number is required!', type: 'error', 
		onClose: function () {document.getElementById('phone').focus();}
		});
	}else if (!phn.match(pn)) {
		alert("Phone Number must be 10 Characters!");
		 document.getElementById('phone').focus();
	}else if (selRole.selectedIndex === 0) {
		swal({title:'Oops...', text:'Please Select User Role!', type: 'error', 
		onClose: function () {document.getElementById('role').focus();}
		});
	}else if (ps.length==0) {
		swal({title:'Oops...', text:'Please Enter User Password!', type: 'error', 
		onClose: function () {document.getElementById('password').focus();}
		});
    }else if (!ps.match(re2)) {
        alert("Password must be at least 5 Characters!");
		 document.getElementById('password').focus();
        return false;
    }else{
     $.ajax({  
       url:"a_insert.php",  
       method:"POST",  
       data:$('#insert_form').serialize(),  
       beforeSend:function(){  
          $('#insert').val("Inserting");  
       },  
       success:function(data){
          $('#insert_form')[0].reset();  
          $('#add_data_Modal').modal('hide');  
          $('#users').html(data);  
       }  
    });  
    swal('Success..!', 'User Successfuly Added!', 'success');
    }
  }
  </script>
 <script type="text/javascript" language="javascript"> 
 
 $(document).ready(function(){
   
	 	 $('#users').DataTable( {
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
    url:"a_fetch.php",  
    method:"POST",  
    data:{employee_id:employee_id},  
    dataType:"json",  
    success:function(data){ 
       $('#uname').val(data.uname);
       $('#id_no').val(data.id_no);
       $('#email').val(data.email);
       $('#phone').val(data.phone);  
	   $('#password').val(data.password);
       $('#role').val(data.role);
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
         url:"a_select.php",  
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
     url:"a_delete.php",
     method:"POST",
     data:{id:id},
     success:function(data){
      swal('Deleted!', 'User Successfuly Deleted!', 'success');
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
		swal('Error..!', 'Please Select atleast one User to Remove!', 'error');
	   }
	   else
	   {
		$.ajax({
			 url:'a_delete1.php',
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