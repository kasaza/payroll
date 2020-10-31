<?php  
//view.php
 if(isset($_POST["employee_id"]))  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "hrm");  
      $query = "SELECT * FROM payroll WHERE p_id = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
				<tr>  
                     <td><label>ID Number:&nbsp;&nbsp;</label>'.$row["id_no"].'</td>  
                    <td><label>Name:&nbsp;&nbsp;</label>'.$row["name"].'</td>  
                    <td><label>Date:&nbsp;&nbsp;</label>'.$row["date"].'</td>  
				<tr>  
				<tr>  
                     <td style="border-right:1px solid transparent;"><label>Account Number:&nbsp;&nbsp;</label></td>  
					 <td>'.$row["account"].'</td>
					 <td><label>Bank:&nbsp;&nbsp;</label>'.$row["bank"].'</td>  
                </tr>
				<tr>  
                    <td style="border-right:1px solid transparent;"><label>Designation Pay:&nbsp;&nbsp;</label</td>
					<td>Ksh. '.$row["designation"].' .00</td>  
					<td><label>Jobgroup Pay:&nbsp;&nbsp;</label>Ksh. '.$row["jobgroup"].' .00</td>  
                </tr>
				
                <tr>  
                    <td style="border-right:1px solid transparent;"><label>Allowances:</label></td>
					<td>
						1. Medical:&nbsp;&nbsp;Ksh. '.$row["medical"].' .00</br>
						2. Transport:&nbsp;&nbsp;Ksh. '.$row["transport"].' .00</br>
						3. Risk:&nbsp;&nbsp;Ksh. '.$row["risk"].' .00</br>
						4. House:&nbsp;&nbsp;Ksh. '.$row["house"].' .00 
					</td>
					<td><label>Total:&nbsp;&nbsp;&nbsp;</label> Ksh. '.$row["totalAll"].' .00</td>						 
                </tr>  
                <tr>  
                    <td style="border-right:1px solid transparent;"><label>Deductions:</label></td>  
					<td>
						1. NHIF:&nbsp;&nbsp;Ksh. '.$row["nhif"].' .00</br>
						2. HELB Loan:&nbsp;&nbsp;Ksh. '.$row["helb"].' .00</br>
						3. NSSF:&nbsp;&nbsp;Ksh. '.$row["nssf"].' .00</br>
						4. Elimu:&nbsp;&nbsp;Ksh. '.$row["elimu"].' .00 
					</td>
                    <td><label>Total:&nbsp;&nbsp;&nbsp;</label>Ksh. '.$row["totalDed"].' .00</td>  
                </tr>
				<tr>  
                     <td style="border-right:1px solid transparent;"><label>Bonus:</label></td>  
                     <td>Ksh. '.$row["bonus"].' .00</td>  
					 <td><label>Salary Inc.:&nbsp;&nbsp;</label> Ksh. '.$row["inc_amount"].' .00</td>   
                </tr>
				<tr>  
                     
                </tr>
				<tr>  
                    <td><label>Basic Salary:&nbsp;&nbsp;</label>Ksh. '.$row["basic"].' .00</td>  
					<td><label>Gross Income:&nbsp;&nbsp;</label>Ksh. '.$row["gross"].' .00</td>  
					<td><label>Net Salary:&nbsp;&nbsp;</label>Ksh. '.$row["net"].' .00</td>  
                </tr>
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>
 