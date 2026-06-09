<?php
require_once('../fpdf/fpdf.php'); 
class PDF extends FPDF
{
    function Header()
    {

        $this->Image('../img/logo.png', 89, 10, 28); 
        $this->SetFont('Arial', 'B', 9); 
        $this->Cell(140);
        $this->Cell(120,5, utf8_decode('Dirección: Cra. 10 #11-28'), 0, 1, 'L');
        $this->Cell(140);
        $this->Cell(120,5, utf8_decode('Teléfono: +57 3112048186'), 0, 1, 'L');
        $this->Cell(140);
        $this->Cell(120,5, 'Correo: Animalheart.vet@gmail.com', 0, 1, 'L');

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(30);
        $this->Ln(20);

    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','B', 9);
        $this->Cell(5,10,utf8_decode('ANIMAL HEART |  TUNJA'),0,0,'L');
        $this->Cell(0,10,utf8_decode('página'). $this->PageNo().'/{nb}',0,0,'R');
    }
}
?>