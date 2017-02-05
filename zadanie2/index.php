<?php
require_once("../ChartDirector/lib/phpchartdir.php");
require('../tfpdf/tfpdf.php');

class Wykres extends tFPDF {
	private $zakres1 = null;
	private $zakres2 = null;
	
	public function __construct($_zakres1,$_zakres2){
		parent::__construct();
		$this->zakres1 = $_zakres1;
		$this->zakres2 = $_zakres2;
	}
	
	public function rysuj($p){
		//określam zakres wykresu tak aby punkt użytkownika nie znalazł się poza nim
		$minimum=min($this->zakres1,$this->zakres2, $p);
		$maximum=max($this->zakres1,$this->zakres2, $p);
		
		
		
		//punkt
		$yp = array(sin(2*$p) + cos(3*$p));
		//$yx[] = sin(2*$x) + cos(3*$x); //ze wzoru można zrobić osobną metodę ale zostawiłem tak jak jest
		
		//linia
		$y = array();
		$x = array();
		$labels = array();
		for($i=$minimum; $i<= $maximum; $i++){
			$y[] = sin(2*$i) + cos(3*$i); //można się pokusić o dodanie indeksów do tablicy ale ja zrobiłem ją od 0
			$x[] = $i;
			$labels[$i]=(string)$i;
		}
		
		
		
		# Create a XYChart object of size 250 x 250 pixels
		$chart = new XYChart(600, 300);

		# Set the plotarea at (30, 20) and of size 200 x 200 pixels
		$chart->setPlotArea(55, 58, 520, 195);
		
		# Add a title to the y axis
		$chart->yAxis->setTitle("Y");

		# Add a title to the x axis
		$chart->xAxis->setTitle("X");

		$layer1 = $chart->addLineLayer();
		$layer1->addDataSet($y);
		$layer1->setXData($x);
		
		$layer2 = $chart->addLineLayer();
		$layer2->setXData($p);
		$dataSetObj = $layer2->addDataSet($yp);
		$dataSetObj->setDataSymbol(CircleSymbol,9);
		$dataSetObj->setDataLabelFormat("x=".$p." y={value}");
		
		
		//return $chart->makeSession("chart1"); //generowanie pliku przez sesję
		return $chart->makeChart(dirname(__FILE__).'/image.png'); //generowanie pliku
		//return $chart->makeChart2(PNG); //generowanie bezpośrednie
		//return $chart->makeChart2(PDF); //generowanie bezpośrednie
		
		
	}
	
	public function generuj($_p){
		$this->AddPage();
		$this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		$this->SetFont('DejaVu','',14);
		$this->Cell(0,10,'Bardzo ważny wykres Dominika Panasa',0,0,'C');
		$this->Image('image.png',20,20);
		$this->Output();
	}
}
//----------------------SPRAWDZENIE 1 - bezpośrednie wyświetlenie------------------------------------
//header("Content-type: image/png");
//header("Content-type: application/pdf");
$sprawdzam = new Wykres(-10,10);
$sprawdzam->rysuj(9);

//----------------------SPRAWDZENIE 2 - osadzanie i generowanie pdf------------------------------------

if (isset($_POST['generate'])){
	$sprawdzam->generuj(3);
}


echo '<img src="image.png">'; //dla makeChart */
echo '
<form action="index.php" method="post">
<input type="hidden" name="generate" value="true">
  <input type="submit" value="Generuj PDF">
</form> 
';