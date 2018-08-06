<?php
require('fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
	if($this->DefOrientation == 'L'){
    global $title;
    //Logo
    $this->Image('../../vistas/imagenes/cinSuvinca.jpg',10,3,255);

    //$this->Line(10,38,205,38);
   // $this->Image('../../vistas/imagenes/fondoReporte.jpg',5,30,205);
    //Line break
    $this->SetY(40);
}
else {
    global $title;
    //Logo
    $this->Image('../../vistas/imagenes/cinSuvinca.jpg',10,3,195);

    //$this->Line(10,38,205,38);
  //  $this->Image('../../vistas/imagenes/fondoReporte.jpg',5,45,205,20,20);
    $this->SetY(10);

    //Line break
    $this->SetY(55);
}
}

//Page footer
function Footer(){
  global $title;

  if($this->DefOrientation == 'P'){
    //Position at 1.5 cm from bottom
    $this->Image('../../vistas/imagenes/pie_presentacion.jpg',10,255,195);

  }

  if($this->DefOrientation == 'L'){
      $this->Image('../../vistas/imagenes/pie_presentacion.jpg',10,185,255);
  }

}

function cabecera($cabecera,$anchos){
    //Colors, line width and bold font
    $this->SetFillColor(252,223,172);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','B',11);
    //Header
    for($i=0;$i<count($cabecera);$i++){
        $this->Cell($anchos[$i],5,utf8_decode($cabecera[$i]),1,0,'C',true);
    }
    $this->Ln();

}

function cabecera1($cabecera,$anchos){
    //Colors, line width and bold font
    $this->SetFillColor(255,244,212);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    //$this->SetLineWidth(.3);
    $this->SetFont('Arial','B',11);
    //Header
    for($i=0;$i<count($cabecera);$i++){
        $this->Cell($anchos[$i],5,utf8_decode($cabecera[$i]),1,0,'C',true);
    }
    $this->Ln();

}

function cabeceraMINCO($cabecera,$anchos){
    //Colors, line width and bold font
    $this->SetFillColor(255,244,212);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    //$this->SetLineWidth(.3);
    $this->SetFont('Arial','B',14);
    //Header
    for($i=0;$i<count($cabecera);$i++){
        $this->Cell($anchos[$i],10,utf8_decode($cabecera[$i]),1,0,'C',true);
    }
    $this->Ln();

}

function cabecera2($cabecera,$anchos){
    //Colors, line width and bold font
    $this->SetFillColor(204,204,204);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    //$this->SetLineWidth(.3);
    $this->SetFont('Arial','B',11);
    //Header
    for($i=0;$i<count($cabecera);$i++){
        $this->Cell($anchos[$i],5,utf8_decode($cabecera[$i]),1,0,'C',true);
    }
    $this->Ln();

}



function creaTabla($cabecera,$datos,$anchos,$alineaciones,$distX,$distY){
    $this->cabecera($cabecera,$anchos);
    //Color and font restoration
    $this->SetFont('Arial','',11);
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
              $this->SetFont('Arial','',12);
              $acumX =$distX;
              $preY = $this->GetY();
              $postY = $this->GetY();
           }
        }
    }

}

}
?>
