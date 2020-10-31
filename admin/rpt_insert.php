<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  
	  $totalEmp = mysqli_real_escape_string($connect, $_POST["totalEmp"]);	  
	  $cMonth = mysqli_real_escape_string($connect, $_POST["cMonth"]);
	   $cDate = mysqli_real_escape_string($connect, $_POST["cDate"]);
	  $totalBon = mysqli_real_escape_string($connect, $_POST["totalBon"]);	  
	  $totalInc = mysqli_real_escape_string($connect, $_POST["totalInc"]);
	  $totalAll = mysqli_real_escape_string($connect, $_POST["totalAll"]);	  
	  $totalDed = mysqli_real_escape_string($connect, $_POST["totalDed"]);
	  $totalBasic = mysqli_real_escape_string($connect, $_POST["totalBasic"]);	  
	  $totalGross = mysqli_real_escape_string($connect, $_POST["totalGross"]);
	  $totalNet = mysqli_real_escape_string($connect, $_POST["totalNet"]);	  
	  $gTotal = mysqli_real_escape_string($connect, $_POST["gTotal"]);
	  
		$query = "  
		INSERT INTO reports(totalEmp, cMonth, cDate, totalBon, totalInc, totalAll, totalDed, totalBasic, totalGross, totalNet, gTotal)  
		VALUES('$totalEmp', '$cMonth', '$cDate', '$totalBon', '$totalInc', '$totalAll', '$totalDed', '$totalBasic', '$totalGross', '$totalNet', '$gTotal');  
		";  
     
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM reports ORDER BY rpt_id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                    <tr>
						<th width="11%">Month of Report</th>
						<th width="5%">Total Employees</th>
						<th>Total Bonus</th>
						<th>Report Date</th>
						<th>Total Sal. Inc</th>
						<th width="5%">Total Allowances</th>
						<th width="5%">Total Deductions</th>
						<th>Total Basic Salary</th>
						<th>Total Gross Income</th>
						<th>Total Net Salary</th>
						<th>Grand Total</th>
					</tr> 
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["cMonth"] . '</td> 
						  <td>' . $row["totalEmp"] . '</td>
						  <td>' . $row["totalBon"] . '</td>
						  <td>' . $row["cDate"] . '</td>
						  <td>' . $row["totalInc"] . '  .00</td>
						  <td>' . $row["totalAll"] . ' .00</td>
						  <td>' . $row["totalDed"] . ' .00</td>
						  <td>' . $row["totalBasic"] . ' .00</td>
						  <td>' . $row["totalGross"] . ' .00</td>
						  <td>' . $row["totalNet"] . ' .00</td>
						  <td>' . $row["gTotal"] . ' .00</td>
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
      }  
      echo $output;
 }  
 ?>
