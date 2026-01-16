<?php
	require __DIR__ . '/../../assets/pos/vendor/autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	
	use Mike42\Escpos\CapabilityProfile;
	include "../../connection.php";
	include "../../assets/phpqrcode/qrlib.php";
	@$regu 	    	 = $_POST['regu'];
	@$shift 		 = $_POST['shift'];
	@$jam 			 = $_POST['jam'];	
	@$tanggal_produksi= $_POST['tanggal_produksi'];
	@$kode_line		= $_POST['kode_line'];
	@$kode_material = $_POST['kode_material'];
	@$nomor_palet 	= $_POST['no_pallet'];
	@$tujuan	 	= $_POST['tujuan'];
	if($_POST['jenis_produk'] == 2){
		$dataLabel 		= substr($_POST['no_label'],0,22);
		$dataLabel2		= $dataLabel.$nomor_palet."E".$tujuan;
		$no_label  = preg_replace('/\s+/', "",$dataLabel2);
		$otf = $_POST['otf'];
		$status_penanganan = $_POST['status_penanganan'];
		
	}else{
		$no_label 		= $_POST['no_label'];
		$otf = 0;
		$status_penanganan = 0;
		
	}	
	@$jumlah 		= $_POST['jumlah'];
	@$nama_penyerah	= $_POST['user_serah'];
	@$nama_penerima = $_POST['user_terima'];
	@$jenis_produk  = $_POST['jenis_produk'];
	@$lokasi_label 	= $_POST['zone'];
	@$lokasi_simpan = $_POST['lokasi_simpan'];
	@$id_zone		= $_POST['id_zona'];
	//@$otf				= $_POST['id_zona'];
	
	//if($id_zone==5){echo "1A";}else{echo $id_zone;}
	@$simpan 		= $_POST['simpan'];
	
	$selectLine 	= pg_query($conn,"SELECT nama_line FROM master_line WHERE kode_line='$kode_line'");
	$showLine 		= pg_fetch_array($selectLine);
	$selectData 	= pg_query($conn,"SELECT * FROM master_produk WHERE kode_material='$kode_material'");
	$showData 		= pg_fetch_array($selectData);
	
	// Cek nomer label
	$cekNoLabel = pg_query($conn,"SELECT * FROM serah_terima WHERE nomor_label='$no_label'");
	$cekRows = pg_num_rows($cekNoLabel);
	
	if($cekRows > 0){
			echo "data sudah ada";
	}else{
		if(isset($simpan)){
			$insertData = pg_query($conn,"INSERT INTO serah_terima VALUES('$no_label', '$tanggal_produksi', '$jam', '$regu', '$shift', '$nomor_palet','$jumlah', '$jenis_produk', '$tujuan', '$nama_penyerah', '$nama_penerima', '$kode_material', '$kode_line','1', '$otf', '$status_penanganan')");
			$insertDataLokasi = pg_query($conn,"INSERT INTO tbl_load_fg VALUES('$lokasi_simpan', '$id_zone', '$no_label', '$shift')");
		}
		$profile = CapabilityProfile::load("SP2000");
		$connector = new WindowsPrintConnector("smb://10.126.48.216/Thermal");
		$printer = new Printer($connector, $profile);
		
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		$printer -> setTextSize(1,1);
		$printer -> text("\n");
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		$printer -> setTextSize(4,4);
		$printer -> text("$regu/$shift\n");
		$printer -> setTextSize(1,1);
		$printer -> text("$no_label\n");
		$printer -> setTextSize(1,1);
		$printer -> text("Zone $id_zone - $lokasi_label\n");
		$printer -> text("\n");
		$printer -> setTextSize(1,1);
		$printer -> text("LABEL FINISH GOOD\n");
		$printer -> text("PT INDOFOOD FORTUNA MAKMUR\n");
		$printer -> text("PLANT 1405\n");
		$printer -> text("\n");
		
		// Nama Line
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> text("Line");
		$printer -> setPrintLeftMargin(128);
		$printer -> text(":");
		$printer -> setPrintLeftMargin(150);
		$printer -> text("$showLine[nama_line]\n");
		// Nama Produk
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> setPrintLeftMargin(0);
		$printer -> text("OTF");
		$printer -> setPrintLeftMargin(128);
		$printer -> text(":");
		$printer -> setPrintLeftMargin(150);
		$printer -> text("$otf\n");
		// Nama Produk
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> setPrintLeftMargin(0);
		$printer -> text("Produk");
		$printer -> setPrintLeftMargin(128);
		$printer -> text(":");
		$printer -> setPrintLeftMargin(150);
		$printer -> text("$showData[nama_produk]\n");
		// Jumlah
		$printer -> setPrintLeftMargin(0);
		$printer -> text("Jumlah");
		$printer -> setPrintLeftMargin(128);
		$printer -> text(":");
		$printer -> setPrintLeftMargin(150);
		$printer -> text("$jumlah");
		$printer -> setPrintLeftMargin(300);
		$printer -> text("No Pallet :");
		$printer -> setPrintLeftMargin(450);
		$printer -> text("$nomor_palet\n");
		// Waktu
		$printer -> setPrintLeftMargin(0);
		$printer -> text("Waktu");
		$printer -> setPrintLeftMargin(128);
		$printer -> text(":");
		$printer -> setPrintLeftMargin(150);
		$printer -> text("$tanggal_produksi");
		$printer -> setPrintLeftMargin(300);
		$printer -> text("- $jam\n");
		// Barcode
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		$testStr = "$no_label";
		$printer -> qrCode($testStr, Printer::QR_ECLEVEL_L, 8);
		$printer -> text("\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> setPrintLeftMargin(0);
		$printer -> text("Dibuat");
		$printer -> setPrintLeftMargin(300);
		$printer -> text("\n");
		
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> setPrintLeftMargin(0);
		$printer -> text("$nama_penyerah");
		$printer -> setPrintLeftMargin(300);
		$printer -> text("$nama_penerima\n");
		$printer -> setPrintLeftMargin(0);
		$printer -> text("(Checker)");
		$printer -> setPrintLeftMargin(300);
		$printer -> text("(Kasie)\n");
		$printer -> text("\n");
		$printer -> text("\n");
	   
		$printer -> feed();
		$printer -> cut();
		$printer -> close();
	}
	
?>
<script>
	window.location.href="../../index.php?page=posisi&idSec=<?=$id_zone?>"
</script>	
