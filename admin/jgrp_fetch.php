  <?php  
 //view.php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(isset($_POST["employee_id2"]))  
 {  
      $query = "SELECT * FROM jobgroup WHERE jgrp_id = '".$_POST["employee_id2"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 
?>