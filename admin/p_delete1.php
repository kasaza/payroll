
<?php
//delete.php
$connect = mysqli_connect("localhost", "root", "", "hrm");
if(isset($_POST["p_id"]))
{
 foreach($_POST["p_id"] as $id)
 {
  $query = "DELETE FROM payroll WHERE p_id = '".$id."'";
  mysqli_query($connect, $query);
 }
}
?>