<?php  
//view.php
 if(isset($_POST["employee_id2"]))  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "hrm");  
      $query = "SELECT * FROM jobgroup WHERE jgrp_id = '".$_POST["employee_id2"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
				<tr>  
                     <td><label>ID Number</label></td>  
                     <td>'.$row["jobgroup"].'</td>  
                </tr>
				<tr>  
                     <td><label>Name</label></td>  
                     <td>'.$row["jgrp_amount"].'</td>  
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
 