<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $deduction = mysqli_real_escape_string($connect, $_POST["deduction"]);
	  $amount = mysqli_real_escape_string($connect, $_POST["amount"]);	
	  $max_amount = mysqli_real_escape_string($connect, $_POST["max_amount"]);
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE deductions   
           SET deduction ='$deduction ',
		   amount='$amount', 
		   max_amount='$max_amount'
           WHERE ded_id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO deductions(deduction , amount, max_amount)  
           VALUES('$deduction ', '$amount', '$max_amount');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM deductions ORDER BY ded_id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr> <th>Deduction Name</th>
						  <th>Amount</th>
						  <th>max_amount</th>
						  <th>Action</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["deduction"] . '</td> 
                          <td>' . $row["amount"] . '</td>
						  <td>' . $row["max_amount"] . '</td> 
						  <td>
						  <div class="btn-group">
                          <button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
							<li><input type="button" name="edit" value="Edit" id="'.$row["ded_id"] .'" class="btn btn-warning btn-xs edit_data action" /></li>
							<li class="divider"></li>
							<li><input type="button" name="delete" value="Delete" id="' . $row["ded_id"] . '" class="btn btn-danger btn-xs delete_data action" /></li>
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
 