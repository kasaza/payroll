<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $id_no = mysqli_real_escape_string($connect, $_POST["id_no"]);
	  $name = mysqli_real_escape_string($connect, $_POST["name"]);
      $gender = mysqli_real_escape_string($connect, $_POST["gender"]);    
      $phone = mysqli_real_escape_string($connect, $_POST["phone"]);  
      $email = mysqli_real_escape_string($connect, $_POST["email"]);  
      $date = mysqli_real_escape_string($connect, $_POST["date"]);
	  $type = mysqli_real_escape_string($connect, $_POST["type"]); 
	  $department = mysqli_real_escape_string($connect, $_POST["department"]); 
	   $bank = mysqli_real_escape_string($connect, $_POST["bank"]);
	  $account = mysqli_real_escape_string($connect, $_POST["account"]); 
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE tbl_employee   
           SET id_no='$id_no',
		   name='$name',
		   gender='$gender',
           phone='$phone',   
           email = '$email',
		   date = '$date',
		   type = '$type',
		   department = '$department',
		   bank = '$bank',
		   account = '$account'
          WHERE id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO tbl_employee(id_no, name, gender, phone, email, date, type, department, bank, account)  
           VALUES('$id_no', '$name', '$gender', '$phone', '$email', '$date', '$type', '$department', '$bank', '$account');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM tbl_employee ORDER BY id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr> <th>ID Number</th>
						  <th>Name</th>
                          <th>Gender</th>  
                          <th>Phone Number</th>
						  <th>Email Address</th>
						  <th>Date</th>
                          <th>Employee Type</th>
						  <th>Department</th> 
						  <th>Action</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["id_no"] . '</td> 
                          <td>' . $row["name"] . '</td>
						  <td>' . $row["gender"] . '</td>
						  <td>' . $row["phone"] . '</td>
						  <td>' . $row["email"] . '</td>
						  <td>' . $row["date"] . '</td>
						  <td>' . $row["type"] . '</td>
						  <td>' . $row["department"] . '</td>
						  <td>
						  <div class="btn-group">
                          <button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
							<li><input type="button" name="edit" value="Edit" id="'.$row["id"] .'" class="btn btn-warning btn-xs edit_data action" /></li>
							<li class="divider"></li>
							<li><input type="button" name="delete" value="Delete" id="' . $row["id"] . '" class="btn btn-danger btn-xs delete_data action" /></li>
                          </ul>
                          </div>
						  </td>
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
      }  
      echo $output;
 }  
 ?>
 