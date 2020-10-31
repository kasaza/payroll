<?php
$connect = mysqli_connect("localhost", "root", "", "hrm");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM tbl_users WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
 header("Location: advanced"); 
 }
}
?>