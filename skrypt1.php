<?php
require_once('tfpdf/tfpdf.php');

class test extends tfpdf {
	function Header(){
		//$this->Image('image.png',10,6);
		$this->AddFont('Dejavu','','DejavuSansCondensed.ttf',true);
		$this->SetFont('Dejavu','',14);
		$this->Cell(80);
		$this->Cell(30,10,'Title',1,0,'C');
		$this->Ln(20);
	
	}
	
	function Footer(){
		$this->SetY(-15);
		$this->AddFont('Dejavu','','DejavuSansCondensed.ttf',true);
		$this->SetFont('Dejavu','',14);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
}

$pdf = new test();
$pdf->AliasNbPages();
$pdf->AddFont('Dejavu','','DejavuSansCondensed.ttf',true);
$pdf->SetFont('Dejavu','',12);
$pdf->Cell(0,10,'Wyraz ',0,1,'C');
for ($i=1;$i<=10;$i++)
	$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();

?>