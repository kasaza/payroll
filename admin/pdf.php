<?php

require('../fpdf/fpdf.php');

include("connect-db.php");

class PDF extends FPDF
{
	function Header()
	{	
		global $title;
	    $this->SetFont('Helvetica','B',16);
	    // Calculate width of title and position
	    $w = $this->GetStringWidth($title)+6;
	    $this->SetX((270-$w)/2);
	    $this->SetDrawColor(255,128,000);
	    $this->SetFillColor(000);
	    $this->SetTextColor(255);

	    $this->Image('../images/tum.png',7,6,30);
	    $this->Image('../images/logo2.png',258,6,30);
	    $this->Cell(10);
	    // Thickness of Title frame (1 mm)
    	//$this->SetLineWidth(1); 
	   // $this->Cell($w,14,$title,1,1,'C',true);
	    // Thickness of frame (1 mm)

	    $this->Ln(6);	
	    $this->SetFont('Times','B',12);
	    $this->SetTextColor(000);
	    $this->SetFillColor(193,229,252);
	    $this->Cell(0,10,'THE HUMAN RESOURCE MANAGER',0,1,'C');
	    $this->Cell(0,20,'PAYROLL RECORDS',0,1,'C');
	
	}

	function ChapterTitle($num, $label)
	{
	    $this->SetFont('Times','B',12);
	    $this->SetFillColor(154,255,154);
	    $this->Cell(0,6,"DOCUMENT $num : $label",1,1,'C',true);
	    $this->Ln(4);
	}

	function ChapterBody($file)
	{
	    $txt = file_get_contents($file);
	    $this->SetFont('Times','',12);
	    // Output justified text
	    $this->MultiCell(0,5,$txt);
	    $this->Ln();
	    $this->SetFont('','');
	    $this->Cell(0,10,'Find the Data on Page 2 Below');
	}

	function PrintChapter($num, $title, $file)
	{
	    $this->AddPage();
	    $this->ChapterTitle($num,$title);
	    $this->ChapterBody($file);
	}

	function Layout($num, $label, $file, $type, $datas){
		 $this->AddPage();
		 $this->Chapter($num,$label);
	}
/*------------------FOOTER-----------------------*/
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-20);
	    $this->SetFont('Arial','I',8);
	    $this->SetTextColor(000);
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

	    $this->SetY(-15);
	    $this->SetFont('Arial','I',8);
	    $this->SetTextColor(255,0,0);
	    $this->Cell(0,10,'KASAZA - E - Payroll',0,0,'C');

	    $this->SetY(-20);
	    $this->SetFont('Arial','I',8);
	    $this->SetTextColor(0,0,255);
	    $this->Cell(0,10,'By Sylvester Kasaza');

	    $this->SetX(-15);
		$this->SetFont('helvetica','I',8);
		//$Date=date('l\t\h\e jS');
		date_default_timezone_set('Africa/Nairobi');
		$Date=date('F j, Y, H:i:s a');
		$this->Cell(0,10,'Date:'.$Date,0,'C',0,'',0,false,'T','M');
		//$invoicenumber=time();
	}
}

// Instanciation of inherited class
$pdf = new PDF('L');
//$title = 'E-Payroll System';
//$pdf->SetTitle($title);
$pdf->SetAuthor('Kasaza Sylvester');
$pdf->AliasNbPages();
$pdf->SetFont('Times','',12);
$pdf->PrintChapter(1,'PAYROLL RECORDS','../images/jeff.txt');
$pdf->AddPage();

/*-----------------------------------------------*/
/*--------IMPORTING THE DATABASE TABLE----------*/

$count="select * from payroll LIMIT 0,100"; // SQL to get 10 records 
$width_cell=array(20,30,30,30,20,30,30,30,30,30);
$pdf->SetFont('Arial','B',12);
$pdf->SetLineWidth(0); 
$pdf->SetTextColor(000);
$pdf->SetDrawColor(000);
$pdf->SetFillColor(152,251,152); // Background color of header 
$pdf->Cell($width_cell[0],10,'ID',1,0,'C',true);// 1st header col 
$pdf->Cell($width_cell[1],10,'ID No',1,0,'C',true); 
$pdf->Cell($width_cell[2],10,'Name',1,0,'C',true); 
$pdf->Cell($width_cell[3],10,'Date',1,0,'C',true); 
$pdf->Cell($width_cell[4],10,'Bonus',1,0,'C',true); 
$pdf->Cell($width_cell[5],10,'Allowance',1,0,'C',true); 
$pdf->Cell($width_cell[6],10,'Deduction',1,0,'C',true);
$pdf->Cell($width_cell[7],10,'Salary Inc',1,0,'C',true);
$pdf->Cell($width_cell[8],10,'Basic Sal',1,0,'C',true);
$pdf->Cell($width_cell[9],10,'Net Salary',1,1,'C',true);
//// header ends ////

$pdf->SetFont('','',12);
$pdf->SetLineWidth(0); 
$pdf->SetTextColor(000);
$pdf->SetDrawColor(245,245,245);
$pdf->SetFillColor(245,245,245); // Background color of cells
$fill=false; // to give alternate background fill color to rows 
/// each record is one row  ///
foreach ($mysqli->query($count) as $row) {
$pdf->Cell($width_cell[0],10,$row['p_id'],1,0,'C',$fill);
$pdf->Cell($width_cell[1],10,$row['id_no'],1,0,'L',$fill);
$pdf->Cell($width_cell[2],10,$row['name'],1,0,'C',$fill);
$pdf->Cell($width_cell[3],10,$row['date'],1,0,'C',$fill);
$pdf->Cell($width_cell[4],10,$row['bonus'],1,0,'C',$fill);
$pdf->Cell($width_cell[5],10,$row['totalAll'],1,0,'C',$fill);
$pdf->Cell($width_cell[6],10,$row['totalDed'],1,0,'C',$fill);
$pdf->Cell($width_cell[7],10,$row['inc_amount'],1,0,'C',$fill);
$pdf->Cell($width_cell[8],10,$row['basic'],1,0,'C',$fill);
$pdf->Cell($width_cell[9],10,$row['net'],1,1,'C',$fill);
$fill = !$fill;// to give alternate background fill  color to rows
}

//---------- FOOTER starts------- //
$pdf->SetFont('Arial','B',12);
$pdf->SetLineWidth(0); 
$pdf->SetTextColor(000);
$pdf->SetDrawColor(000);
$pdf->SetFillColor(152,251,152);
$pdf->Cell($width_cell[0],10,'ID',1,0,'C',true);// 1st header col 
$pdf->Cell($width_cell[1],10,'ID No',1,0,'C',true); 
$pdf->Cell($width_cell[2],10,'Name',1,0,'C',true); 
$pdf->Cell($width_cell[3],10,'Date',1,0,'C',true); 
$pdf->Cell($width_cell[4],10,'Bonus',1,0,'C',true); 
$pdf->Cell($width_cell[5],10,'Allowance',1,0,'C',true); 
$pdf->Cell($width_cell[6],10,'Deduction',1,0,'C',true);
$pdf->Cell($width_cell[7],10,'Salary Inc',1,0,'C',true);
$pdf->Cell($width_cell[8],10,'Basic Sal',1,0,'C',true);
$pdf->Cell($width_cell[9],10,'Net Salary',1,1,'C',true);
//// FOOTER ends ////
/// end of records /// 
$pdf->SetTextColor(255,0,0);
$pdf->SetFont('Times','',12);
$pdf->Ln(10);//Padding-top/bottom line
$pdf->Cell(120);// Move to the right
$pdf->SetDrawColor(000);
$pdf->SetFillColor(235,236,236);
$pdf->Cell(40,10,'**END**',0,1,'C',true);

$pdf->SetTextColor(000);
$pdf->Ln(10);//Padding-top/bottom line
$pdf->Cell(1);// Move to the right
$pdf->SetLineWidth(1); //Line thickness
$pdf->Cell(80,10,'THE HUMAN RESOURCE MANAGER:',0,0,'C',true);

$pdf->Ln(20);//Move to the bottom
$pdf->Cell(80);// Move to the right
$pdf->Cell(20,10,'NAME: _______________________________________',0,0,true);
$pdf->Cell(75);
$pdf->Cell(10,10,'SIGN: __________________',0,0,true);

$pdf->Cell(24);
$pdf->SetLineWidth(1); //Line thickness
$pdf->SetFont('Times','I',12);
$pdf->Cell(70,30,'OFFICIAL STAMP',1,0,'C');

$pdf->SetFont('Times','',12);
$pdf->Ln(20);//Move to the bottom
$pdf->Cell(90);// Move to the right
$pdf->Cell(12,10,'CONTACT: +254 ___ ___ ___ ___ ___ ___ ___ ___ ___',0,0,true);
$pdf->Output();

?>
