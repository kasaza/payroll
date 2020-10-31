<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $department = mysqli_real_escape_string($connect, $_POST["department"]);
	  $sub = mysqli_real_escape_string($connect, $_POST["sub"]);
	  $head = mysqli_real_escape_string($connect, $_POST["head"]);	  
      $id_no = mysqli_real_escape_string($connect, $_POST["id_no"]);    
      $phone = mysqli_real_escape_string($connect, $_POST["phone"]);  
      $assistant = mysqli_real_escape_string($connect, $_POST["assistant"]);
	  $id_no2 = mysqli_real_escape_string($connect, $_POST["id_no2"]); 
	  $phone2 = mysqli_real_escape_string($connect, $_POST["phone2"]); 
	  $staff = mysqli_real_escape_string($connect, $_POST["staff"]); 	  
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE departments   
           SET department='$department',
		   sub='$sub',
		   head='$head',
		   id_no='$id_no',
           phone='$phone',   
           assistant = '$assistant',
		   id_no2 = '$id_no2',
		   phone2 = '$phone2',
           staff = '$staff'   
           WHERE id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO departments(department, sub, head, id_no, phone, assistant, id_no2, phone2, staff)  
           VALUES('$department', '$sub', '$head', '$id_no', '$phone', '$assistant', '$id_no2', '$phone2', '$staff');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM departments ORDER BY id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr> <th>Department</th>
						<th>Sub-Departments</th>
						<th>Departmental Head</th>
						<th>ID Number</th>
						<th>Contact</th>
						<th>Assistant</th>
						<th>ID Number</th>
						<th>Contact</th>
						<th>No of Staff</th>
						<th>Action</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["department"] . '</td> 
                          <td>' . $row["sub"] . '</td>
						  <td>' . $row["head"] . '</td>
						  <td>' . $row["id_no"] . '</td>
						  <td>' . $row["phone"] . '</td>
						  <td>' . $row["assistant"] . '</td>
						  <td>' . $row["id_no2"] . '</td>
						  <td>' . $row["phone2"] . '</td>
						  <td>' . $row["staff"] . '</td>
						  <td>
						  <div class="btn-group">
                          <button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
							<li><input type="button" name="view" value="View" id="'.$row["id"] .'" class="btn btn-info btn-xs edit_data action" /></li>
							<li class="divider"></li>
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
 