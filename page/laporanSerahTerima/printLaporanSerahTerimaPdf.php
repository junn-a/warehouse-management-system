<?php
require('../../assets/phppdf/fpdf.php');
require('../../connection.php');
		session_start();
		$date   = date("Y-m-d");
		$no     = 1;
				
		$kode_material 		= $_GET['id1'];
		$jenis_produk 		= $_GET['id2'];	
		$tujuan 			= $_GET['id3'];	
		$kode_line			= $_GET['id4'];
		$tanggal_produksi 	= $_GET['id5'];
		//$end 				= $_GET['id6'];
		$shift  			= $_GET['id7'];
		$regu  				= $_GET['id8'];
		
		$selectNamaProduk 	= pg_query($conn,"SELECT nama_produk FROM master_produk WHERE kode_material='$kode_material'");
		$fetchNamaProduk 	= pg_fetch_assoc($selectNamaProduk); 
		
		$selectLine 		= pg_query($conn,"SELECT * FROM master_line WHERE kode_line='$kode_line'");
		$fetchLine		 	= pg_fetch_assoc($selectLine); 
		
		if($jenis_produk == 1){ $type_produk = "Lokal";}elseif($jenis_produk == 2){ $type_produk = "Export";}elseif($jenis_produk == 3){ $type_produk = "Lokal Cut Off";}
		
		
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
$pdf->Cell(75,4,'PT INDOFOOD FORTUNA MAKMUR',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,4,'Kode Material',0,0,'L');
$pdf->Cell(40,4,': '.$kode_material,0,0,'L');
$pdf->Cell(25,4,'Line',0,0,'L');
$pdf->Cell(40,4,': '.$fetchLine['nama_line'],0,1,'L');
// Baris ke 3
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,4,'PLANT 1405',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,4,'Nama Produk',0,0,'L');
$pdf->Cell(40,4,': '.$fetchNamaProduk['nama_produk'],0,0,'L');
$pdf->Cell(25,4,'Jenis Produksi',0,0,'L');
$pdf->Cell(40,4,': '.$type_produk,0,1,'L');
// Baris ke 4
$pdf->Cell(75,4,'',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,4,'Tanggal Produksi',0,0,'L');
$pdf->Cell(40,4,': '.$tanggal_produksi,0,0,'L');
$pdf->Cell(25,4,'Tujuan',0,0,'L');
$pdf->Cell(40,4,': '.$tujuan,0,1,'L');

$pdf->SetFont('','B',14);
$pdf->Cell(0,10,'TANDA TERIMA BARANG JADI',0,1,'C');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(8,6,'NO',1,0,'C');
$pdf->Cell(105,6,'NO LABEL',1,0,'C');
$pdf->Cell(25,6,'PRINT OUT',1,0,'C');
$pdf->Cell(25,6,'TERIMA FG',1,0,'C');
$pdf->Cell(20,6,'JUMLAH',1,1,'C');
//Tes Dulu

			$arrayData = array();
			$selectLabel = pg_query($conn,"SELECT * FROM serah_terima WHERE kode_material='$kode_material' AND tanggal_produksi='$tanggal_produksi' AND kode_line='$kode_line' AND regu='$regu' AND shift='$shift' AND jenis_produk='$jenis_produk' AND tujuan='$tujuan' ORDER BY nomor_palet ASC");
			$data = pg_fetch_all($selectLabel);
			foreach($data AS $key => $value){
				$arrayData[$value['nomor_label']] = array(
					'jam' 		=> $value['jam'],
					'jumlah' 	=> $value['jumlah'],
					'nomor_label' => $value['nomor_label']
				);
				$selectJam = pg_query($conn,"SELECT * FROM tbl_gate_fg WHERE nomor_label='$value[nomor_label]'");
				$row = pg_fetch_array($selectJam);
				$isi = "-";
				if(!empty($row)){
					$isi = $row['jam'];
				}
				$arrayData[$value['nomor_label']]['jamTerima'] = $isi;
			}
			foreach($arrayData AS $table => $tab){
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(8,4,$no++,1,0,'C');
			$pdf->Cell(105,4,$tab['nomor_label'],1,0,'L');
			$pdf->Cell(25,4,$tab['jam'],1,0,'C');
			$pdf->Cell(25,4,$tab['jamTerima'],1,0,'C');
			$pdf->Cell(20,4,$tab['jumlah'],1,1,'C');
			}
$pdf->Cell(0,10,'',0,1,'C');
// Jumlah Serah
$selectJmlPrint = pg_query($conn,"SELECT SUM(jumlah) AS jml_print FROM serah_terima WHERE kode_material='$kode_material' AND tanggal_produksi='$tanggal_produksi' AND kode_line='$kode_line' AND regu='$regu' AND shift='$shift' AND jenis_produk='$jenis_produk' AND tujuan='$tujuan'");
$fetchJmlPrint = pg_fetch_array($selectJmlPrint);
// Baris ke 1
$pdf->SetFont('Arial','',8);
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,4,'Jumlah Di Serahkan',1,0,'L');
$pdf->Cell(20,4,$fetchJmlPrint['jml_print'],1,0,'L');
$pdf->Cell(25,4,'',0,0,'L');
$pdf->Cell(80,4,'Shift SPV/ Kasie',0,0,'L');
$pdf->Cell(40,4,'Checker',0,1,'L');

// Jumlah Diterima
$selectJmlSerah = pg_query($conn,"SELECT SUM(jumlah) AS jml_serah FROM serah_terima WHERE kode_material='$kode_material' AND tanggal_produksi='$tanggal_produksi' AND kode_line='$kode_line' AND regu='$regu' AND shift='$shift' AND status='2' AND jenis_produk='$jenis_produk' AND tujuan='$tujuan'");
$fetchJmlSerah = pg_fetch_array($selectJmlSerah);
// Baris ke 2
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,4,'Jumlah Di Terima',1,0,'L');
$pdf->Cell(20,4,$fetchJmlSerah['jml_serah'],1,1,'L');

// Baris ke 3
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,4,'Selisih',1,0,'L');
$pdf->Cell(20,4,$fetchJmlPrint['jml_print']-$fetchJmlSerah['jml_serah'],1,0,'L');
$pdf->Output();

?>