<?php
require('../../assets/phppdf/fpdf.php');
require('../../connection.php');
		session_start();
		$date   = date("Y-m-d");
		$no     = 1;
		$shift  = $_SESSION['shift'];
		$regu  	= $_SESSION['regu'];
		$noGis	= $_GET['id1'];
		$kodeMaterial 	= $_GET['id2'];
		
class PDF extends FPDF
{
// Page header


// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
	 $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$tglNow 			= date("Y-m-d");
$pdf = new FPDF('P', 'mm','Letter');
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
//Baris Ke 1
$pdf->SetFont('Courier','B',14);
$pdf->Cell(0,10,'F02 /SFCKP - WH - 03',0,1,'C');
//Baris Ke 2

$pdf->SetFont('Arial','',8);
$pdf->Cell(135,4,'PT INDOFOOD FORTUNA MAKMUR',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,4,'No GIS',0,0,'L');
$pdf->Cell(40,4,': '.$noGis,0,1,'L');
//$pdf->Cell(25,4,'Jumlah',0,0,'L');
//$pdf->Cell(40,4,': Line 1',0,1,'L');
// Baris ke 3
$pdf->SetFont('Arial','',8);
$pdf->Cell(135,4,'PLANT 1405',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,4,'Kode Material',0,0,'L');
$pdf->Cell(40,4,': '.$kodeMaterial,0,1,'L');
//$pdf->Cell(25,4,'Jenis Produksi',0,0,'L');
//$pdf->Cell(40,4,': Lokal',0,1,'L');
// Baris ke 4
$pdf->Cell(135,4,'',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,4,'Tanggal Kirim',0,0,'L');
$pdf->Cell(40,4,': '.date("Y-m-d"),0,1,'L');
//$pdf->Cell(25,4,'Tujuan',0,0,'L');
//$pdf->Cell(40,4,': -',0,1,'L');

$pdf->SetFont('','B',14);
$pdf->Cell(0,10,'REKAP PENGIRIMAN BARANG JADI',0,1,'C');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(8,6,'NO',1,0,'C');
$pdf->Cell(125,6,'NO LABEL',1,0,'C');
$pdf->Cell(30,6,'TERIMA LOG',1,0,'C');
$pdf->Cell(20,6,'JUMLAH',1,1,'C');

// SCRIPT OUTPUT
$arrayData 	= array();
$selectData = pg_query($conn,"SELECT * FROM tbl_gate_logistik WHERE id_doc='$noGis' AND shift='$shift' AND regu='$regu'");
$data 		= pg_fetch_all($selectData);
foreach($data AS $key => $value){
	$arrayData[$value['nomor_label']] = array(
		'tanggal' 		=> $value['tanggal'],
		'jam'			=> $value['jam'],
		'nomor_label' 	=> $value['nomor_label'],
		'shift' 		=> $value['shift'],
		'regu' 			=> $value['regu']
	);
	$selectDetail = pg_query($conn,"SELECT * FROM serah_terima WHERE nomor_label='$value[nomor_label]' AND kode_material='$kodeMaterial'");
	$row = pg_fetch_array($selectDetail);
	$isiJml ="-";
	if(!empty($row)){
		$isiJml = $row['jumlah'];
	}
	$arrayData[$value['nomor_label']]['jumlah'] = $isiJml;
}
foreach($arrayData AS $table => $tab){
	if($tab['jumlah'] != "-"){
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(8,4,$no++,1,0,'C');
		$pdf->Cell(125,4,$tab['nomor_label'],1,0,'L');
		$pdf->Cell(30,4,$tab['jam'],1,0,'C');
		$pdf->Cell(20,4,$tab['jumlah'],1,1,'C');
	}
}
$pdf->Cell(0,20,'',0,1,'C');
// Jumlah Kirim
// Baris ke 1
$pdf->SetFont('Arial','',8);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(20,4,'Karton',1,0,'C');
$pdf->Cell(20,4,'Pallet',1,0,'C');
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(30,4,'',0,0,'L');
$pdf->Cell(30,4,'',0,0,'L');
$pdf->Cell(30,4,'',0,0,'L');
$pdf->Cell(30,4,'',0,1,'L');
// Baris ke 2
$pdf->SetFont('Arial','',8);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,4,'Jumlah Dikirim',1,0,'L');
$pdf->Cell(20,4,'',1,0,'L');
$pdf->Cell(20,4,'',1,0,'L');
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(30,4,'Shift SPV/ Kasie',0,0,'C');
$pdf->Cell(30,4,'Checker',0,0,'C');
$pdf->Cell(25,4,'Shift SPV/ Kasie',0,0,'C');
$pdf->Cell(20,4,'Checker',0,1,'C');
// Baris ke 3
$pdf->SetFont('Arial','',8);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(60,4,'(Produksi)',0,0,'C');
$pdf->Cell(45,4,'(Logistik)',0,0,'C');
$pdf->Output();

?>