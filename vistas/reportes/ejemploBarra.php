<?php
require ('../../modelos/fpdf/code39.php');
$pdf=new PDF_Code39();
$pdf->AddPage();
$pdf->Code39(10,10,'AQUI VA EL CODIGO QUE SE IMPRIME',1,10);
//$pdf->Code39(X,Y,'AQUI VA EL CODIGO QUE SE IMPRIME',ancho,alto);
$pdf->Output();
?>
