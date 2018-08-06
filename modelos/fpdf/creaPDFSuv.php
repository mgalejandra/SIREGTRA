<?php
require('fpdf.php');

class PDF extends FPDF
{

//Page header
function Header()
{
    global $title;
    //Logo
    $this->Image('../../vistas/imagenes/b.jpg',10,3,195);

    //$this->Line(10,38,205,38);
   $this->Image('../../vistas/imagenes/fondoReporte.jpg',5,30,205);
    $this->SetY(10);

    //Line break
    $this->SetY(55);
}

//Page footer
function Footer(){
  $this->AliasNbPages("pgn");

  if($this->DefOrientation == 'P'){

  /*  $this->SetY(260);
    date_default_timezone_set('UTC');
    //$this->Cell(0,0,utf8_decode('Fecha de Elaboración '.date("d-m-Y")),0,0,'L',0);
    $this->Cell(0,0,utf8_decode('Página ').$this->PageNo().' de '."pgn",0,0,'R',0);*/

    //Position at 1.5 cm from bottom
    $this->SetY(262);
    //Arial italic 8
    $this->SetFont('Arial','B',7);
    $this->MultiCell(190,3,utf8_decode('SUMINISTROS VENEZOLANOS INDUSTRIALES, C.A. (SUVINCA)'),0,'C');
    $this->SetFont('Arial','',7);
    $this->MultiCell(190,3,utf8_decode('Gran Avenida, Torre Phelps, Piso 27, Oficina A, Urb. Los Caobos'),0,'C');
    $this->MultiCell(190,3,utf8_decode('Tlfs.:(0212) 708.08.85'),0,'C');
    $this->MultiCell(190,3,utf8_decode('Página Web: www.suvinca.gob.ve'),0,'C');
    $this->Line(10,265,205,265);
  }

  if($this->DefOrientation == 'L'){
    $this->SetY(190);
    date_default_timezone_set('UTC');
    //$this->Cell(0,0,utf8_decode('Fecha de Elaboración '.date("d-m-Y")),0,0,'L',0);
    $this->Cell(0,0,utf8_decode('Página ').$this->PageNo().' de '."pgn",0,0,'R',0);

    //Position at 1.5 cm from bottom
    $this->SetY(198);
    //Arial italic 8
    $this->SetFont('Arial','B',7);
    //Page number
    $this->MultiCell(260,3,utf8_decode('SUMINISTROS VENEZOLANOS INDUSTRIALES, C.A. (SUVINCA), Caracas - Dtto. Capital - Venezuela.Gran Avenida, Torre Phelps, Piso 27, Oficina A, Urb. Los Caobos'),0,'C');
    $this->MultiCell(260,3,utf8_decode('Tlfs.:(0212) 708.08.85'),0,'C');
    $this->Line(10,195,265,195);
  }

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

function cabecera1($cabecera,$anchos){
    //Colors, line width and bold font
    $this->SetFillColor(204,204,204);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','B',6);
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
