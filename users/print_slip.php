<?php

session_start();
require_once '../users/class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}

$connect = new PDO('mysql:host=localhost;dbname=hrm', 'root', '');
$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE id_no=:id_no");
$stmt->execute(array(":id_no"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//pdf.php;
require_once '../admin/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Pdf extends Dompdf{
 public function __construct() {
        parent::__construct();
    }
}
//print_invoice.php
if(isset($_GET["pdf"]) && isset($_GET["id"]))
{
 $output = '';
 $stmt = $user_home->runQuery("SELECT * FROM payroll WHERE id_no = :id_no");
 $stmt->execute(array(":id_no"=>$_SESSION['userSession']));
  $all_result = $stmt->fetchAll();
  
  foreach($all_result as $row)
  {
  $output .= '
	<table width="100%" border="1" cellpadding="5" cellspacing="5" style="font-family:Jura, sans-serif;">
    <tr>
     <td colspan="2" align="center" style="font-size:18px"><img src="../images/tum.png"/><br><b>E-Pay Slip</b></td>
    </tr>
	
    <tr>
     <td colspan="2">
	 
      <table width="100%" cellpadding="5" style="border:1px dotted green;">
       <tr>
        <td width="65%"></b>
        <b>ID Number :&nbsp;&nbsp;</b> '.$row["id_no"].'<br/><br/>   
        <b>Name :&nbsp;&nbsp;</b> '.$row["name"].'<br/><br/>  
		<b>Staff No:&nbsp;&nbsp;</b>  '.$row["p_id"].'
        </td>
        <td width="35%">
        <b>Account No. :&nbsp;&nbsp;</b> '.$row["account"].'<br/><br/> 
		<b>Bank Name :&nbsp;&nbsp;</b> '.$row["bank"].'<br/><br/>  
        <b>Pay Date :&nbsp;&nbsp;</b> '.$row["date"].'<br/><br/> 
        </td>
       </tr>
      </table>
	  
      <br/>
	  <table width="100%" cellpadding="5" border="1" cellspacing="0" >
	<tr style="border:1px dotted #000;">  
	<td><b>Designation Pay:&nbsp;&nbsp;</b</td>
	<td>Ksh. '.$row["designation"].' .00</td>  
	<td><b>Jobgroup Pay:&nbsp;&nbsp;</b>Ksh. '.$row["jobgroup"].' .00</td>  
	</tr>

	<tr>  
	<td><b>Allowances:</b></td>
	<td>
		1. Medical:&nbsp;&nbsp;Ksh. '.$row["medical"].' .00<br><br/> 
		2. Transport:&nbsp;&nbsp;Ksh. '.$row["transport"].' .00<br><br/> 
		3. Risk:&nbsp;&nbsp;Ksh. '.$row["risk"].' .00<br><br/> 
		4. House:&nbsp;&nbsp;Ksh. '.$row["house"].' .00 
	</td>
	<td><b>Total Allowances:&nbsp;&nbsp;&nbsp;</b> Ksh. '.$row["totalAll"].' .00</td>						 
	</tr>
	  <tr>  
		<td><b>Deductions:</b></td>  
		<td>
			1. NHIF:&nbsp;&nbsp;Ksh. '.$row["nhif"].' .00<br><br/>
			2. HELB Loan:&nbsp;&nbsp;Ksh. '.$row["helb"].' .00<br><br/> 
			3. NSSF:&nbsp;&nbsp;Ksh. '.$row["nssf"].' .00<br><br/> 
			4. Elimu:&nbsp;&nbsp;Ksh. '.$row["elimu"].' .00 
		</td>
		<td><b>Total Deductions:&nbsp;&nbsp;&nbsp;</b>Ksh. '.$row["totalDed"].' .00</td>  
	  </tr>
	  <tr>  
		 <td><b>Bonus:</b></td>  
		 <td>Ksh. '.$row["bonus"].' .00</td>  
		 <td><b>Salary Inc.:&nbsp;&nbsp;</b> Ksh. '.$row["inc_amount"].' .00</td>   
	  </tr>
	  </table>
	  <br/>
      <table width="100%" border="" cellpadding="5" style="margin-bottom:20px; border:1px dotted green;" cellspacing="0">
	  <tr>  
		<td><b>Basic Salary:&nbsp;&nbsp;</b>Ksh. '.$row["basic"].' .00 |</td>  
		<td><b>Gross Income:&nbsp;&nbsp;</b>Ksh. '.$row["gross"].' .00 |</td>  
		<td><b>Net Salary:&nbsp;&nbsp;</b>Ksh. '.$row["net"].' .00</td>  
	  </tr>
	  </table>
   </table>';
 }
 
 $pdf = new Pdf();
 $file_name = 'E-Pay Slip-'.$row["name"].'.pdf';
 $pdf->loadHtml($output);
 $pdf->render();
 $pdf->stream($file_name, array("Attachment" => false));
 
 $canvas = $pdf->get_canvas();
 $canvas->page_script('
  if ($pdf->get_page_number() != $pdf->get_page_count()) {
    $font = Font_Metrics::get_font("helvetica", "12");                  
    $pdf->text(500, 770, "Page {PAGE_NUM} - {PAGE_COUNT}", $font, 10, array(0,0,0));
    $pdf->text(260, 770, "Canny Pack", $font, 10, array(0,0,0));
    $pdf->text(43, 770, $date, $font, 10, array(0,0,0));
  }
');
}
?>
