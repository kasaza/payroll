<?php

 function fill_idNumber($connect)  
 {  
	  $output = '';  
	  $sql = "SELECT * FROM tbl_employee";  
	  $result = mysqli_query($connect, $sql);  
	  while($row = mysqli_fetch_array($result))  
	  {  
		$output .= '<option value="'.$row["id_no"] .'">'.$row["name"].':&nbsp;&nbsp;'.$row["id_no"].'</option>';
	  }  
	  return $output;  
 }  

 //Designation Data Load 
 function fill_designation($connect)  
 {  
	  $output = '';  
	  $sql = "SELECT * FROM designation";  
	  $result = mysqli_query($connect, $sql);  
	  while($row = mysqli_fetch_array($result))  
	  {  
		   $output .= '<option value="'.$row["desg_amount"].'">'.$row["desg_name"].'</option>';  
	  }  
	  return $output;  
 }  
 
 //Job-Group Data Load  
 function fill_jobgroup($connect)  
 {  
	  $output = '';  
	  $sql = "SELECT * FROM jobgroup";  
	  $result = mysqli_query($connect, $sql);  
	  while($row = mysqli_fetch_array($result))  
	  {  
		   $output .= '<option value="'.$row["jgrp_amount"].'">'.$row["jgrp_name"].'</option>';  
	  }  
	  return $output;  
 }  
//Fill Banks
 function fill_bank($connect)  
 {  
	  $output = '';  
	  $sql = "SELECT * FROM banks";  
	  $result = mysqli_query($connect, $sql);  
	  while($row = mysqli_fetch_array($result))  
	  {  
		   $output .= '<option value="'.$row["bank"].'">'.$row["bank"].'</option>';  
	  }  
	  return $output;  
 }  
 ?>