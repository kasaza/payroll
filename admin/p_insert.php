<?php  
 $connect = mysqli_connect("localhost", "root", "", "hrm");  
 if(!empty($_POST))  
 {  
      $output = '';  
	  $id_no = mysqli_real_escape_string($connect, $_POST["id_no"]);
	  $name = mysqli_real_escape_string($connect, $_POST["name"]);
      $account = mysqli_real_escape_string($connect, $_POST["account"]);
	  $bank = mysqli_real_escape_string($connect, $_POST["bank"]);
	  $designation = mysqli_real_escape_string($connect, $_POST["designation"]); 
	  $jobgroup = mysqli_real_escape_string($connect, $_POST["jobgroup"]); 
	  $date = mysqli_real_escape_string($connect, $_POST["date"]);
	  $totalAll = mysqli_real_escape_string($connect, $_POST["totalAll"]);	  
	  $totalDed = mysqli_real_escape_string($connect, $_POST["totalDed"]);
	  $medical = mysqli_real_escape_string($connect, $_POST["medical"]);
	  $transport = mysqli_real_escape_string($connect, $_POST["transport"]);
      $risk = mysqli_real_escape_string($connect, $_POST["risk"]);
	  $house = mysqli_real_escape_string($connect, $_POST["house"]);
	  $commuter = mysqli_real_escape_string($connect, $_POST["commuter"]);
	  $nhif = mysqli_real_escape_string($connect, $_POST["nhif"]); 
	  $helb = mysqli_real_escape_string($connect, $_POST["helb"]); 
	  $nssf = mysqli_real_escape_string($connect, $_POST["nssf"]);
	  $elimu = mysqli_real_escape_string($connect, $_POST["elimu"]);
	  $mwalimu = mysqli_real_escape_string($connect, $_POST["mwalimu"]);
	  $bonus = mysqli_real_escape_string($connect, $_POST["bonus"]);
	  $sal_rate = mysqli_real_escape_string($connect, $_POST["sal_rate"]);
	  $inc_amount = mysqli_real_escape_string($connect, $_POST["inc_amount"]);
	  $basic = mysqli_real_escape_string($connect, $_POST["basic"]); 
	  $gross = mysqli_real_escape_string($connect, $_POST["gross"]);
	  $net = mysqli_real_escape_string($connect, $_POST["net"]); 
	  
      if($_POST["employee_id"] != '')  
      {  
           $query = "  
           UPDATE payroll   
           SET id_no='$id_no',
		   name='$name',
		   account = '$account',
		   bank = '$bank',
		   designation='$designation',
		   jobgroup='$jobgroup',
		   date='$date',
		   totalAll = '$totalAll',
		   totalDed ='$totalDed',
		   medical='$medical',
		   transport = '$transport',
		   risk = '$risk',
		   house='$house',
		   commuter='$commuter',
		   nhif='$nhif',
		   helb='$helb',
		   nssf = '$nssf',
		   elimu='$elimu',
		   mwalimu='$mwalimu',
		   bonus='$bonus',
		   sal_rate='$sal_rate',
		   inc_amount='$inc_amount',
		   basic = '$basic',
		   gross = '$gross',
		   net = '$net'
           WHERE p_id='".$_POST["employee_id"]."'";  
      }  
      else  
      {  
           $query = "  
           INSERT INTO payroll(id_no, name, account, bank, designation, jobgroup, date, totalAll, totalDed, medical, transport, risk, house, commuter, nhif, helb, nssf, elimu, mwalimu, bonus, sal_rate, inc_amount, basic, gross, net)  
           VALUES('$id_no', '$name', '$account', '$bank', '$designation', '$jobgroup', '$date', '$totalAll', '$totalDed', '$medical', '$transport', '$risk', '$house', '$commuter', '$nhif', '$helb', '$nssf', '$elimu', '$mwalimu', '$bonus', '$sal_rate', '$inc_amount', '$basic', '$gross', '$net');  
           ";  
      }
      if(mysqli_query($connect, $query))  
      {  
           $select_query = "SELECT * FROM payroll ORDER BY p_id DESC";  
           $result = mysqli_query($connect, $select_query);  
           $output .= '  
                <table class="table table-bordered">  
                     <tr><th>ID Number</th>
						<th>Account</th>
						<th>Bank</th>
						<th>Date</th>
						<th>Allowances</th>
						<th>Deductions</th>
						<th>Bonus</th>
						<th>Salary Inc.</th>
						<th>Basic Salary</th>
						<th>Gross Income</th>
						<th>Net Salary</th>
						<th>Action</th>
                     </tr>  
           ';  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr> <td>' . $row["id_no"] . '</td> 
						  <td>' . $row["account"] . '</td>
						  <td>' . $row["bank"] . '</td>
						  <td>' . $row["date"] . '</td>
						  <td>' . $row["totalAll"] . ' .00</td>
						  <td>' . $row["totalDed"] . ' .00</td>
						  <td>' . $row["bonus"] . ' .00</td>
						  <td>' . $row["inc_amount"] . ' .00</td>
						  <td>' . $row["basic"] . ' .00</td>
						  <td>' . $row["gross"] . ' .00</td>
						  <td>' . $row["net"] . ' .00</td>
						  <td>
						  <div class="btn-group">
                          <button data-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
							<li><input type="button" name="edit" value="Edit" id="'.$row["p_id"] .'" class="btn btn-warning btn-xs edit_data action" /></li>
							<li class="divider"></li>
							<li><input type="button" name="delete" value="Delete" id="' . $row["p_id"] . '" class="btn btn-danger btn-xs delete_data action" /></li>
                          </ul>
                          </div>
						  </td>
                     </tr>  
                ';  
           }  
           $output .= '</table>';  
      }  
      echo $output;
 }  
 ?>
