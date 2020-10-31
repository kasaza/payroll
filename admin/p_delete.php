<?php
$connect = mysqli_connect("localhost", "root", "", "hrm");
if(isset($_POST["p_id"]))
{
 $query = "DELETE FROM payroll WHERE p_id = '".$_POST["p_id"]."'";
 if(mysqli_query($connect, $query))
 {
 header("Location: payroll"); 
 }
}
?>