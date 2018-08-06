<?php
require('fpdf.php');

class PDF extends FPDF
{

//Page header
function Header()
{
    global $title;
    if($this->DefOrientation == 'P'){
    //Logo
    $this->Image('../../vistas/imagenes/cinSuvinca.jpg',10,5,195);
    //$this->Line(10,38,205,38);
    $this->Image('../../vistas/imagenes/fondoReporte.jpg',5,40,205);
    //Arial bold 15
    $this->SetY(5);
    $this->SetFont('Arial','B',12);
    //Title
    $this->Cell(0,70,$title,0,0,'C');
    //Line break
    $this->SetY(55);
  }
  if($this->DefOrientation == 'L'){
    $this->Image('../../vistas/imagenes/cinSuvinca.jpg',10,10,260,19);
    $this->Image('../../vistas/imagenes/fondoReporte.jpg',60,30,160,160);
    $this->SetY(35);
    $this->SetFont('Arial','B',12);
    //Title
    $this->Cell(0,0,$title,0,0,'C');
    //Line break
    $this->SetY(45);
  }
}

//Page footer
function Footer()
{
	$this->SetFont('Arial','B',7);
	$this->SetY(260);
	$this->AliasNbPages("pgn");
    $this->Cell(0,0,utf8_decode('Página ').$this->PageNo().' de '."pgn",0,0,'R',0);
    $this->SetY(260);
    date_default_timezone_set('UTC');
    //$this->Cell(0,0,utf8_decode('Fecha de Elaboración '.date("d-m-Y")),0,0,'L',0);
   // $this->Cell(0,0,utf8_decode('Página ').$this->PageNo(),0,0,'C',0);
    //Position at 1.5 cm from bottom
    $this->SetY(266);
    //Arial italic 8
    $this->SetFont('Arial','B',7);
    //Page number
    $this->MultiCell(190,3,utf8_decode('IMCP  Instituto Municipal de Credito Popular, Caracas - Dtto. Capital - Venezuela'),0,'C');

    $this->Line(10,265,205,265);
}


function cabecera($cabecera,$anchos){
    //Colors, line width and bold font
    $this->SetFillColor(204,204,204);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','B',10);
    //Header
    for($i=0;$i<count($cabecera);$i++){
        $this->Cell($anchos[$i],5,utf8_decode($cabecera[$i]),1,0,'C',true);
    }
    $this->Ln();

}


function creaTabla($cabecera,$datos,$anchos,$alineaciones,$distX,$distY){
    $this->cabecera($cabecera,$anchos);
    //Color and font restoration
    $this->SetFont('Arial','',9);
    $acumX =$distX;
    $preY = $this->GetY();
    $postY = $this->GetY();
    $j=0;
    for($i=0;$i<count($datos);$i++){
        $this->SetY($preY);
        $this->SetX($acumX);
        if($datos[$i]) $cadena = $datos[$i];
        else $cadena = ' - ';
        $this->MultiCell($anchos[$j],4,utf8_decode($cadena),0,$alineaciones[$j],0);
        if($this->GetY() > $postY)$postY = $this->GetY();
        $acumX = $acumX + $anchos[$j];
        $j++;
        if($j == count($anchos)){
           $this->Ln();
           $j=0;
           $fill=!$fill;
           $this->SetX($distX);
           $acumX = $distX;
           for($k=0;$k<=count($anchos);$k++){
               $this->Line($acumX,$preY,$acumX,$postY);
               $acumX = $acumX + $anchos[$k];
           }
           $this->Line($distX,$postY,$acumX,$postY);
           $acumX = $distX;
           $preY = $postY;
           if($this->GetY() >= $distY){
              $this->AddPage();
              $this->cabecera($cabecera,$anchos);
              $this->SetFont('Arial','',9);
              $acumX =$distX;
              $preY = $this->GetY();
              $postY = $this->GetY();
           }
        }
    }

}

}
?>
