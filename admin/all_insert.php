<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $medical = mysqli_real_escape_string($connect, $_POST["medical"]);
	  $transport = mysqli_real_escape_string($connect, $_POST["transport"]);
	  $risk = mysqli_real_escape_string($connect, $_POST["risk"]);
	  $house = mysqli_real_escape_string($connect, $_POST["house"]);
	 
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE allowances   
           SET medical ='$medical',
			transport ='$transport',
			risk ='$risk',
            house = '$house'
           WHERE all_id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO allowances(medical, transport, risk, house)  
           VALUES('$medical', '$transport', '$risk', '$house');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM allowances ORDER BY all_id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr> <th>Medical</th>
						  <th>Transport</th>
						  <th>Risk</th>
						  <th>House</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["medical"] . '</td> 
                          <td>' . $row["transport"] . '</td>
						  <td>' . $row["risk"] . '</td>
						  <td>' . $row["house"] . '</td>
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
      }  
      echo $output;
 }  
 ?>
 