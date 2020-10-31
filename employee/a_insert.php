<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $uname = mysqli_real_escape_string($connect, $_POST["uname"]);
	  $id_no = mysqli_real_escape_string($connect, $_POST["id_no"]);
	  $email = mysqli_real_escape_string($connect, $_POST["email"]);	  
      $phone = mysqli_real_escape_string($connect, $_POST["phone"]);    
      $role = mysqli_real_escape_string($connect, $_POST["role"]);  
      $password = mysqli_real_escape_string($connect, $_POST["password"]);  
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE tbl_users   
           SET uname='$uname',
		   id_no='$id_no',
           email = '$email',
		   phone='$phone',   
		   role = '$role',
		   password = '$password'
           WHERE id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO tbl_users(uname, id_no, email, phone, role, password)  
           VALUES('$uname', '$id_no', '$email', '$phone', '$role', '$password');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM tbl_users ORDER BY id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr><th>S/N</th>
						<th>Username</th>
						<th>ID Number</th>
						<th>Email</th>
						<th>Phone</th>
						<th>User Role</th>
						<th>Action</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["uname"] . '</td> 
                          <td>' . $row["id_no"] . '</td>
						  <td>' . $row["email"] . '</td>
						  <td>' . $row["phone"] . '</td>
						  <td>' . $row["role"] . '</td>
						  <td>' . $row["password"] . '</td>
						  
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
 