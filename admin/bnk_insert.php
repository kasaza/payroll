<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $bank = mysqli_real_escape_string($connect, $_POST["bank"]);
	  $branch = mysqli_real_escape_string($connect, $_POST["branch"]);	
	  $bnk_email = mysqli_real_escape_string($connect, $_POST["bnk_email"]);
	  $bnk_phone = mysqli_real_escape_string($connect, $_POST["bnk_phone"]);
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE banks   
           SET bank ='$bank ',
		   branch='$branch', 
		   bnk_email='$bnk_email',
		   bnk_phone='$bnk_phone' 
           WHERE bnk_id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO banks(bank , branch, bnk_email, bnk_phone)  
           VALUES('$bank ', '$branch', '$bnk_email', '$bnk_phone');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM banks ORDER BY bnk_id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr> <th>Bank Name</th>
						  <th>Branch</th>
						  <th>Email</th>
						  <th>Phone</th>
						  <th>Action</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["bank"] . '</td> 
                          <td>' . $row["branch"] . '</td>
						  <td>' . $row["bnk_email"] . '</td> 
                          <td>' . $row["bnk_phone"] . '</td>
						  <td>
						  <div class="btn-group">
                          <button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
							<li><input type="button" name="edit" value="Edit" id="'.$row["bnk_id"] .'" class="btn btn-warning btn-xs edit_data action" /></li>
							<li class="divider"></li>
							<li><input type="button" name="delete" value="Delete" id="' . $row["bnk_id"] . '" class="btn btn-danger btn-xs delete_data action" /></li>
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
 