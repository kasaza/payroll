
<?php
//delete.php
$connect = mysqli_connect("localhost", "root", "", "hrm");
if(isset($_POST["id"]))
{
 foreach($_POST["id"] as $id)
 {
  $query = "DELETE FROM tbl_employee WHERE id = '".$id."'";
  mysqli_query($connect, $query);
 }
}
?>