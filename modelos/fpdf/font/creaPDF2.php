<?php
require('fpdf.php');

class PDF extends FPDF
{

//Page header
function Header()
{
    global $title;
    //Logo
    $this->Image('imagenes/b.jpg',10,15,260,19);
    //$this->Line(10,38,205,38);
    //$this->Image('imagenes/fondoReporte.jpg',5,40,205);
    //Arial bold 15
    //$this->SetY(10);
    //$this->SetFont('Arial','B',12);
    //Title
    //$this->Cell(0,70,$title,0,0,'C');
    //Line break
    //$this->SetY(55);
}

//Page footer
function Footer()
{
   $this->Image('imagenes/h.jpg',10,191,260);
   //$this->SetDrawColor(231,0,11);
   //$this->SetLineWidth(1.2);
   //$this->Line(10,190,270,190);
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

function crearCatalogo($datos){
   for($i=0;$i<count($datos);$i+=32){
       //cuadro 1
       $this->SetDrawColor(0,0,0);
       $this->SetLineWidth(0.2);
       $this->Image('imagenes/cuadro.jpg',18,36);

       $this->SetY(37);
       $this->SetX(20);
       $this->SetTextColor(255,255,255);
       $this->SetFont('Arial','B',10);
       $this->Cell(110,4,utf8_decode($datos[$i+4]),'0',0,'C',0,0);

       $this->Image('fotos/'.$datos[$i+7],50,43,50,37);
       $this->SetTextColor(0,0,0);

       $this->SetY(87);
       $this->SetX(20);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Cod. Artículo'),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,3,utf8_decode('Cod. Proveedor'),'0',0,'J',0,0);

       $this->SetY(90);
       $this->SetX(20);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i]),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,4,utf8_decode($datos[$i+1]),'0',0,'J',0,0);

       $this->SetY(95);
       $this->SetX(20);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Categoría'),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,3,utf8_decode('Marca'),'0',0,'J',0,0);

       $this->SetY(98);
       $this->SetX(20);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+2]),'0',0,'L',0,0);
       $this->SetX(77);
       $this->Cell(53,4,utf8_decode($datos[$i+3]),'0',0,'L',0,0);

       $this->SetY(103);
       $this->SetX(20);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Cantidad'),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,3,utf8_decode('Precio'),'0',0,'J',0,0);

       $this->SetY(106);
       $this->SetX(20);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+5]),'0',0,'L',0,0);
       $this->SetX(77);
       $this->Cell(53,4,utf8_decode($datos[$i+6]),'0',0,'L',0,0);

     if($datos[$i+8]){
       //cuadro 2
       $this->Image('imagenes/cuadro.jpg',148,36);

       $this->Image('fotos/'.$datos[$i+15],180,43,50,37);

       $this->SetY(37);
       $this->SetX(150);
       $this->SetTextColor(255,255,255);
       $this->SetFont('Arial','B',10);
       $this->Cell(110,4,utf8_decode($datos[$i+12]),'0',0,'C',0,0);


       $this->SetTextColor(0,0,0);
       $this->SetY(87);
       $this->SetX(150);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Cod. Artículo'),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,3,utf8_decode('Cod. Proveedor'),'0',0,'J',0,0);

       $this->SetY(90);
       $this->SetX(150);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+8]),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,4,utf8_decode($datos[$i+9]),'0',0,'J',0,0);


       $this->SetY(95);
       $this->SetX(150);
       $this->SetFont('Arial','',8);
       $this->Cell(53,3,utf8_decode('Categoría'),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,3,utf8_decode('Marca'),'0',0,'J',0,0);

       $this->SetY(98);
       $this->SetX(150);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+2]),'0',0,'L',0,0);
       $this->SetX(207);
       $this->Cell(53,4,utf8_decode($datos[$i+3]),'0',0,'L',0,0);

       $this->SetY(103);
       $this->SetX(150);
       $this->SetFont('Arial','',8);
       $this->Cell(53,3,utf8_decode('Cantidad'),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,3,utf8_decode('Precio'),'0',0,'J',0,0);

       $this->SetY(106);
       $this->SetX(150);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+13]),'0',0,'L',0,0);
       $this->SetX(207);
       $this->Cell(53,4,utf8_decode($datos[$i+14]),'0',0,'L',0,0);
     }
     if($datos[$i+16]){
       //cuadro 3
       $this->Image('imagenes/cuadro.jpg',18,114);

       $this->Image('fotos/'.$datos[$i+23],50,121,50,37);

       $this->SetY(115);
       $this->SetX(20);
       $this->SetTextColor(255,255,255);
       $this->SetFont('Arial','B',10);
       $this->Cell(110,4,utf8_decode($datos[$i+20]),'0',0,'C',0,0);

       $this->SetY(164);
       $this->SetX(20);
       $this->SetTextColor(0,0,0);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Cod. Artículo'),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,3,utf8_decode('Cod. Proveedor'),'0',0,'J',0,0);

       $this->SetY(167);
       $this->SetX(20);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+16]),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,4,utf8_decode($datos[$i+17]),'0',0,'J',0,0);

       $this->SetY(172);
       $this->SetX(20);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Categoría'),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,3,utf8_decode('Marca'),'0',0,'J',0,0);

       $this->SetY(175);
       $this->SetX(20);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+18]),'0',0,'L',0,0);
       $this->SetX(77);
       $this->Cell(53,4,utf8_decode($datos[$i+19]),'0',0,'L',0,0);

       $this->SetY(181);
       $this->SetX(20);
       $this->SetFont('Arial','',8);
       $this->Cell(53,3,utf8_decode('Cantidad'),'0',0,'J',0,0);
       $this->SetX(77);
       $this->Cell(53,3,utf8_decode('Precio'),'0',0,'J',0,0);

       $this->SetY(184);
       $this->SetX(20);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+21]),'0',0,'L',0,0);
       $this->SetX(77);
       $this->Cell(53,4,utf8_decode($datos[$i+22]),'0',0,'L',0,0);
    }
    if($datos[$i+24]){
       //cuadro 4
       $this->Image('imagenes/cuadro.jpg',148,114);
       $this->Image('fotos/'.$datos[$i+31],180,121,50,37);

       $this->SetY(115);
       $this->SetX(150);
       $this->SetTextColor(255,255,255);
       $this->SetFont('Arial','B',10);
       $this->Cell(110,4,utf8_decode($datos[$i+28]),'0',0,'C',0,0);

       $this->SetY(164);
       $this->SetX(150);
       $this->SetTextColor(0,0,0);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Cod. Artículo'),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,3,utf8_decode('Cod. Proveedor'),'0',0,'J',0,0);

       $this->SetY(167);
       $this->SetX(150);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+24]),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,4,utf8_decode($datos[$i+25]),'0',0,'J',0,0);

       $this->SetY(172);
       $this->SetX(150);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Categoría'),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,3,utf8_decode('Marca'),'0',0,'J',0,0);

       $this->SetY(175);
       $this->SetX(150);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+26]),'0',0,'L',0,0);
       $this->SetX(207);
       $this->Cell(53,4,utf8_decode($datos[$i+27]),'0',0,'L',0,0);

       $this->SetY(181);
       $this->SetX(150);
       $this->SetFont('Arial','',7);
       $this->Cell(53,3,utf8_decode('Cantidad'),'0',0,'J',0,0);
       $this->SetX(207);
       $this->Cell(53,3,utf8_decode('Precio'),'0',0,'J',0,0);

       $this->SetY(184	);
       $this->SetX(150);
       $this->SetFont('Arial','B',10);
       $this->Cell(53,4,utf8_decode($datos[$i+29]),'0',0,'L',0,0);
       $this->SetX(207);
       $this->Cell(53,4,utf8_decode($datos[$i+30]),'0',0,'L',0,0);
      }
       if($datos[$i+32])$this->AddPage();

   }

}

}
?>
