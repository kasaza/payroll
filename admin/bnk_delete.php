<?php
$connect = mysqli_connect("localhost", "root", "", "hrm");
if(isset($_POST["bnk_id"]))
{
 $query = "DELETE FROM banks WHERE bnk_id = '".$_POST["bnk_id"]."'";
 if(mysqli_query($connect, $query))
 {
 header("Location: banks"); 
 }
}
?>