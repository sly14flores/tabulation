<?php

require('../fpdf181/fpdf.php');
require('../../db.php');

$con = new pdo_db();

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('pglu.png',80,10);
	
	global $title, $subtitle;
	
    // Arial bold 15
	$this->Ln(25);
    $this->SetTextColor(66,66,66);
    $this->SetFont('Arial','B',18);
    $this->Cell(0,5,$title,0,1,'C');
    $this->Ln(2);
    $this->SetFont('Arial','I',12);	
    $this->Cell(0,5,date("F j, Y"),0,1,'C');
    $this->Ln(5);
	$this->SetDrawColor(92,92,92);
	$this->Line(5,30,205,30);
	$this->Ln(5);
    $this->SetFont('Arial','B',16);
    $this->Cell(0,6,$subtitle,0,1,'C');

}

// Page footer
function Footer()
{
	if ($this->isFinished) {
		$this->SetDrawColor(92,92,92);
		
		$this->Line(80,240,130,240);
		$this->SetY(-55);
		$this->SetFont('','B',10);
		$this->Cell(0,5,"Tabulator",0,1,'C');			
		
		$this->Line(75,270,135,270);
		$this->SetY(-25);
		$this->SetFont('','B',10);
		$this->Cell(0,5,"Chairman of the Board of Judges",0,1,'C');	
	}	
    // Position at 1.5 cm from bottom	
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->SetTextColor(66,66,66);	
    // $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function winners($header, $data)
{

    $this->Ln(5);	
    // Colors, line width and bold font
    $this->SetFillColor(60,159,223);
    $this->SetTextColor(66,66,66);
    $this->SetDrawColor(17,87,133);
    $this->SetLineWidth(.3);
    $this->SetFont('','B',16);

    // Header
	$closingLine = 0;
	foreach ($header as $i => $h) {
		$this->Cell(array_keys($header[$i])[0],12,$header[$i][array_keys($header[$i])[0]],1,0,'C',true);
		$closingLine += array_keys($header[$i])[0];
	}
    $this->Ln();
	
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(66,66,66);
	$this->SetFont('Arial','',16);
    // Data
	
    $fill = false;
    foreach($data as $key => $row) {
		foreach ($header as $i => $h) {
			$this->Cell(array_keys($header[$i])[0],12,$row[array_keys($row)[$i]],'LR',0,'C',$fill);
		}
        $this->Ln();
        $fill = !$fill;		
    }	
    $this->Cell($closingLine,0,'','T');

}

}

$preferences = ($con->getData("SELECT * FROM preferences WHERE id = 1"))[0];

$title = $preferences['title'];
$subtitle = "Consolation Prize";

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);

$header = array(
	array(25=>"No"),
	array(130=>"Contestant"),
	array(35=>"Score")
);

$sql = "SELECT (SELECT no FROM contestants WHERE id = contestant_id) no, (SELECT cluster_name FROM contestants WHERE id = contestant_id) contestant, overall_score FROM consolation_prizes";
$data = $con->getData($sql);

$pdf->winners($header,$data);
$pdf->isFinished = true;
$pdf->Output();

?>