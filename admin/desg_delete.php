<?php
$connect = mysqli_connect("localhost", "root", "", "hrm");
if(isset($_POST["desg_id"]))
{
 $query = "DELETE FROM designation WHERE desg_id = '".$_POST["desg_id"]."'";
 if(mysqli_query($connect, $query))
 {
 header("Location: earnings"); 
 }
}
?>