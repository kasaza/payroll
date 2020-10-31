<?php
$connect = mysqli_connect("localhost", "root", "", "hrm");
if(isset($_POST["jgrp_id"]))
{
 $query = "DELETE FROM jobgroup WHERE jgrp_id = '".$_POST["jgrp_id"]."'";
 if(mysqli_query($connect, $query))
 {
 header("Location: earnings"); 
 }
}
?>