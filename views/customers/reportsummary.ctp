<?php
App::import('Vendor','xtcpdf');
$tcpdf = new XTCPDF();
$textfont = 'freesans';

$tcpdf->SetAuthor("");
$tcpdf->SetAutoPageBreak( false );
$tcpdf->setHeaderFont(array($textfont,'',10));
$tcpdf->xheadercolor = array(255,255,255);
$tcpdf->xheadertext = 'Fecha: '. date('d-m-Y',time());
$tcpdf->xfootertext = 'www.elmec.com';

// Ahora imprimimos el contenido de la pagina en una posición determinada
// estos datos son un ejemplo, y en mi ejemplo hay un pequeño texto y una imagen.
$tcpdf->AddPage();
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont,'B',10);
$tcpdf->Cell(10,20,'Nombre: Elmec S.A', 0, 0);

$txt = '';
$i = 20;
foreach ($datos_pdf as $value) {
//$pdf->Write(0, 'Fill text', '', 0, '', true, 0, false, false, 0);	
	foreach ($value as $data) {
//		$tcpdf->Cell(20,$i,$data, 0, 0);
		$tcpdf->Write(0, $data, '', 0, '', $ln=false, 0, false, false, 0);
//$i = $i + 10;
	}
	
	
}

$tcpdf->Cell(20,30,'No Hay datos para el rango de fechas', 0, 0);

// configuramos la calidad de JPEG
$tcpdf->setJPEGQuality(100);
$tcpdf->Image($imagen, 0, 50, 200, 200, '', '', '', false, 150);  

// se pueden asignar mas datos, ver la documentación de TCPDF

echo $tcpdf->Output('mi_archivo.pdf', 'I'); //el pdf se muestra en el navegador
//echo $tcpdf->Output('mi_archivo.pdf', 'I'); //el pdf se descarga

?>
