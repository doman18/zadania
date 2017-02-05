<?php
class Procedura {
	//stała podawana w minutach
	private $klasa= null;
	private $h_opad = null;
	private $d = null;
	private $p = null;
	private $q = null;
	private $arr_flambda = null;
	private $A = null;
	
	
	public function __construct($_klasa,$_h_opad, $_d,$_arr_flambda) {
		$this->klasa = $_klasa;
		$this->h_opad = $_h_opad;
		$this->d = $_d;
		$this->arr_flambda = $_arr_flambda;
		switch ($_klasa){
			case 'A':
			case 'S':
				$this->p = 10;
				$this->q = 225;
				if ($_h_opad<800) $this->A = 1013;
				elseif ($_h_opad<1000) $this->A = 1083;
				elseif ($_h_opad<1200) $this->A = 1134;
				elseif ($_h_opad<1500) $this->A = 1202;
				break;
			case 'Gp':
				$this->p = 20;
				$this->q = 180;
				if ($_h_opad<800) $this->A = 804;
				elseif ($_h_opad<1000) $this->A = 920;
				elseif ($_h_opad<1200) $this->A = 980;
				elseif ($_h_opad<1500) $this->A = 1202;
				break;
			case 'G':
			case 'Z':
				$this->p = 50;
				$this->q = 130;
				if ($_h_opad<800) $this->A = 592;
				elseif ($_h_opad<1000) $this->A = 720;
				elseif ($_h_opad<1200) $this->A = 750;
				elseif ($_h_opad<1500) $this->A = 796;
				break;
			case 'L':
			case 'D':
				$this->p = 100;
				$this->q = 100;
				if ($_h_opad<800) $this->A = 470;
				elseif ($_h_opad<1000) $this->A = 572;
				elseif ($_h_opad<1200) $this->A = 593;
				elseif ($_h_opad<1500) $this->A = 627;
				break;
			default:
			echo "error";
		}
		
	}
	
	public function fz($n) {
		$i=1;
		$licznik=0;
		$mianownik=0;
		foreach ($this->arr_flambda as $value){
			$licznik += $value['F']*$value['lambda'];
			$mianownik += $value['F'];
			if ($i == $n) break;
			else $i++;
		}
		
		return $licznik/$mianownik;
		
	}
	
	public function FI() {
		return 1 / pow($this->fz()*pow(10,-4),1/6);
	}
	
	public function q15() {
		return max($this->q, $this->A/pow($this-d,0.667));
	}
	
	public function C() {
		return 100/$this->p;
	}
	
	public function Opad() {
		return $this->q15()*$this->fz()*pow(10,-4);
	}
	
	public function Q() {
		return $this->Opad()*$this->FI();
	}
	
	public function QQ() {
		return $this->Q() * $this->d * 60;
	}
}

//-------SPRAWDZENIE------------
	
//tablica przekazywana do funkcji
$tab_Flambda [1]['F'] = 100;
$tab_Flambda [1]['lambda'] = 0.9;
$tab_Flambda [2]['F'] = 20;
$tab_Flambda [2]['lambda'] = 0.8;
$tab_Flambda [3]['F'] = 12000;
$tab_Flambda [3]['lambda'] = 0.05;




$obliczenia = new Procedura('G',1400, 15,$tab_Flambda);

echo $obliczenia->fz(1);