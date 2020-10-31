<?php  
//view.php
 if(isset($_POST["employee_id"]))  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "hrm");  
      $query = "SELECT * FROM banks WHERE bnk_id = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
				<tr>  
                     <td><label>Bank Name</label></td>  
                     <td>'.$row["bank"].'</td>  
                </tr>
				<tr>  
                     <td><label>Branch</label></td>  
                     <td>'.$row["branch"].'</td>  
                </tr> 
				<tr>  
                     <td><label>Email</label></td>  
                     <td>'.$row["bnk_email"].'</td>  
                </tr>
				<tr>  
                     <td><label>Phone</label></td>  
                     <td>'.$row["bnk_phone"].'</td>  
                </tr> 
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>
 