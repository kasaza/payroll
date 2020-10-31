<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $desg_name = mysqli_real_escape_string($connect, $_POST["desg_name"]);
	  $desg_amount = mysqli_real_escape_string($connect, $_POST["desg_amount"]);
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE designation   
           SET desg_name ='$desg_name',  
		   desg_amount  = '$desg_amount'
           WHERE desg_id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO designation(desg_name, desg_amount)  
           VALUES('$desg_name', '$desg_amount');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM designation ORDER BY desg_id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr> <th>Name</th>
						  <th>Amount</th>
						  <th>Action</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["desg_name"] . '</td> 
                          <td>' . $row["desg_amount"] . '</td>
						  <td>
						  <div class="btn-group">
                          <button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
							<li><input type="button" name="edit" value="Edit" id="'.$row["desg_id"] .'" class="btn btn-warning btn-xs edit_data action" /></li>
							<li class="divider"></li>
							<li><input type="button" name="delete" value="Delete" id="' . $row["desg_id"] . '" class="btn btn-danger btn-xs delete_data action" /></li>
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
 