
<?php
  $conn = mysqli_connect('localhost','root','','hrm');
  $request=$_POST['request'];
  $query="select * from jobgroup where jgrp_amount='$request'";
  $output=mysqli_query($conn,$query);

  while($fetch = mysqli_fetch_assoc($output))
  { 
	echo $fetch['commuter'];
  }
 ?>