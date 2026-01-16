<?php
	include "../../connection.php";
	include "../../assets/phpqrcode/qrlib.php";
	date_default_timezone_set('Asia/Jakarta');
	
	require __DIR__ . '/../../assets/pos/vendor/autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	use Mike42\Escpos\CapabilityProfile;

	$profile = CapabilityProfile::load("SP2000");
	$connector = new WindowsPrintConnector("smb://10.125.48.35/Thermal");
	$printer = new Printer($connector, $profile);
	
	session_start();
	$jam 				= date("Gis");
	$jamNow 		= date("G:i:s");
	$date 				= date('Y-m-d');
	if(@$_SESSION['shift']==3 && $jam > 0 && $jam <70000){
		$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
		$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
				
	}else{
		$tgl = date('Y-m-d');
		$dateNoLabel 	= date('dm');
	}
	$nomor_label 	= $_POST['nomor_label'];
	$id_doc 		= $_POST['id_doc'];
	$selectData = pg_query($conn,"SELECT * FROM tbl_gate_logistik WHERE nomor_label='$nomor_label'");
     $cek = pg_num_rows($selectData);
    if($cek < 1 ){
        
        if(isset($nomor_label)){
            $insertData 	= pg_query($conn,"INSERT INTO tbl_gate_logistik VALUES(DEFAULT,'$tgl','$jamNow', '$nomor_label', '$_SESSION[shift]','$_SESSION[regu]','$id_doc')");
			$updateStatus 	= pg_query($conn,"UPDATE serah_terima SET status=3 WHERE nomor_label='$nomor_label'");
			$delete 		= pg_query($conn,"DELETE FROM tbl_load_fg WHERE nomor_label='$nomor_label'");
			
			$selectData 	= pg_query($conn,"SELECT * FROM serah_terima WHERE nomor_label='$nomor_label'");
			$fetchData 		= pg_fetch_assoc($selectData );
			@$regu 	    	 	= $fetchData['regu'];
			@$shift 		 	= $fetchData['shift'];
			@$jam 			 	= $fetchData['jam'];	
			@$tanggal_produksi	= $fetchData['tanggal_produksi'];
			@$kode_line			= $fetchData['kode_line'];
			@$kode_material 	= $fetchData['kode_material'];
			@$nomor_palet 		= $fetchData['nomor_palet'];
			@$no_label 			= $fetchData['nomor_label'];
			@$jumlah 			= $fetchData['jumlah'];
			@$tujuan	 		= $fetchData['tujuan'];
			@$nama_penyerah		= $_SESSION['Username'];
			@$nama_penerima 	= $_SESSION['user_terima'];
			@$jenis_produk  	= $fetchData['jenis_produk'];
			@$selectLine 		= pg_query($conn,"SELECT nama_line FROM master_line WHERE kode_line='$kode_line'");
			@$showLine 			= pg_fetch_array($selectLine);
			@$selectData 		= pg_query($conn,"SELECT * FROM master_produk WHERE kode_material='$kode_material'");
			@$showData 			= pg_fetch_array($selectData);
			@$nama_produk 	= $showData['nama_produk'];
            $id = 1;
			$jumlah_qr = str_pad($jumlah, 3, '0', STR_PAD_LEFT);
			$nomor_palet_qr = str_pad($nomor_palet, 3, '0', STR_PAD_LEFT);
            echo "<script>alert('Gate Opened');</script>";
			echo $brand = substr($no_label, 9, 3);
				
				$printer -> setJustification(Printer::JUSTIFY_CENTER);
				$printer -> setTextSize(1,1);
				$printer -> text("\n");
				$printer -> setJustification(Printer::JUSTIFY_CENTER);
				$printer -> setTextSize(4,4);
				$printer -> text("$_SESSION[regu]/$_SESSION[shift]\n");
				$printer -> setTextSize(2,2);
				$printer -> text("$no_label\n");
				$printer -> setTextSize(1,1);
				//$printer -> text("Zone $lokasi_label\n");
				$printer -> text("\n");
				$printer -> setTextSize(1,1);
				$printer -> text("LABEL FINISH GOOD\n");
				$printer -> text("PT INDOFOOD FORTUNA MAKMUR\n");
				$printer -> text("PLANT 1405\n");
				$printer -> text("\n");

				// Nama Line
				$printer -> setJustification(Printer::JUSTIFY_LEFT);
				$printer -> text("   ");
				$printer -> text("Line");
				$printer -> setPrintLeftMargin(170);
				$printer -> text(":");
				$printer -> setPrintLeftMargin(180);
				$printer -> text("$showLine[nama_line]");
				$printer -> setPrintLeftMargin(300);
				$printer -> text("$regu/$shift\n");
				// Nama Produk
				$printer -> setJustification(Printer::JUSTIFY_LEFT);
				$printer -> setPrintLeftMargin(0);
				$printer -> text("   ");
				$printer -> text("Produk");
				$printer -> setPrintLeftMargin(170);
				$printer -> text(":");
				$printer -> setPrintLeftMargin(180);
				$printer -> setTextSize(2,2);
				$printer -> text("$nama_produk\n");

				// Jumlah
				$printer -> setTextSize(1,1);
				$printer -> setPrintLeftMargin(0);
				$printer -> text("   ");
				$printer -> text("Jumlah");
				$printer -> setPrintLeftMargin(170);
				$printer -> text(":");
				$printer -> setPrintLeftMargin(180);
				$printer -> text("$jumlah");
				$printer -> setPrintLeftMargin(300);
				$printer -> text("No Pallet :");
				$printer -> setPrintLeftMargin(450);
				$printer -> text("$nomor_palet\n");

				// Waktu
				$printer -> setPrintLeftMargin(0);
				$printer -> text("   ");
				$printer -> text("InTrans");
				$printer -> setPrintLeftMargin(170);
				$printer -> text(":");
				$printer -> setPrintLeftMargin(180);
				$printer -> text("$tanggal_produksi");
				$printer -> setPrintLeftMargin(300);
				$printer -> text("- $jam\n");

				// Trf Log
				$printer -> setPrintLeftMargin(0);
				$printer -> text("   ");
				$printer -> text("Trf Log");
				$printer -> setPrintLeftMargin(170);
				$printer -> text(":");
				$printer -> setPrintLeftMargin(180);
				$printer -> text("$tgl");
				$printer -> setPrintLeftMargin(300);
				$printer -> text("- $jamNow\n");
				

				$printer -> feed();
				$printer -> cut();
				$printer -> close();	
				
				$printer -> setJustification(Printer::JUSTIFY_CENTER);
				$printer -> setTextSize(1,1);
				$printer -> text("\n");
				$printer -> setJustification(Printer::JUSTIFY_CENTER);
				$printer -> setTextSize(4,4);
				$printer -> text("$_SESSION[regu]/$_SESSION[shift]\n");
				$printer -> setTextSize(1,1);
				$printer -> text("$no_label\n");
				$printer -> setTextSize(1,1);
				//$printer -> text("Zone $lokasi_label\n");
				$printer -> text("\n");
				$printer -> setTextSize(3,3);
				$printer -> text("$nama_produk\n");
				$printer -> text("$jumlah\n");
				$printer -> text("\n");
				$printer -> setJustification(Printer::JUSTIFY_CENTER);
				$testStr = "$kode_material$jumlah_qr$nomor_palet_qr";
				$printer -> qrCode($testStr, Printer::QR_ECLEVEL_L, 8);
				$printer -> text("\n");
				
				$printer -> feed();
				$printer -> cut();
				$printer -> close();	
				
			
        }else{
            $id = 0;
            echo "<script>alert('Kode Salah');</script>";            
        }
        
    }		
	
?>
<script>
	window.location.href="../../index.php?page=gateLog&aksi=barcode&id=<?=$id_doc;?>"
</script>	
