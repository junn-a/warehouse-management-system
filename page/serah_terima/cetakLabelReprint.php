<?php
	include "../../connection.php";
	
	$data = substr($_GET['id'],16,3);
	$cariAngka = intval($data);
	$hitungString = strlen($cariAngka);
	
	if($hitungString == 2){
		$data1 = substr($_GET['id'],0,16);
		$data3 = substr($_GET['id'],16,10);
		$data =$data1."*".$data3;
	}else{
		$data = $_GET['id'];
	}
	$selectData 	= pg_query($conn,"SELECT serah_terima.*, master_produk.nama_produk, master_line.nama_line FROM serah_terima, master_produk,  master_line
	WHERE serah_terima.nomor_label='$data' AND
	serah_terima.kode_material=master_produk.kode_material AND
	serah_terima.kode_line=master_line.kode_line
	");
	$showData 		= pg_fetch_array($selectData);
	require __DIR__ . '/../../assets/pos/vendor/autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	//use Mike42\Escpos\Printer;
	//use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	use Mike42\Escpos\CapabilityProfile;

	$profile = CapabilityProfile::load("SP2000");
	$connector = new WindowsPrintConnector("smb://10.126.48.216/Thermal");
	$printer = new Printer($connector, $profile);
	
	//$connector = new WindowsPrintConnector("Thermal");
	// use Mike42\Escpos\CapabilityProfile;
	//$connector = new NetworkPrintConnector("10.130.48.123", 9100);
	//$printer = new Printer($connector);
	//$printer 	= new Printer($connector, $profile);

	/*Print a "Hello world" receipt" */
    //$printer = new Printer($connector);
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> setTextSize(1,1);
	$printer -> text("\n");
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> setTextSize(4,4);
    $printer -> text("$showData[regu]/$showData[shift]\n");
    $printer -> setTextSize(1,1);
    $printer -> text("$showData[nomor_label]\n");
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
    $printer -> text("$showData[nama_line]\n");
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
    $printer -> text("$showData[jumlah]");
    $printer -> setPrintLeftMargin(300);
    $printer -> text("No Pallet :");
    $printer -> setPrintLeftMargin(450);
    $printer -> text("$showData[nomor_palet]\n");
    // Waktu
    $printer -> setPrintLeftMargin(0);
    $printer -> text("Waktu");
    $printer -> setPrintLeftMargin(128);
    $printer -> text(":");
    $printer -> setPrintLeftMargin(150);
    $printer -> text("$showData[tanggal_produksi]");
    $printer -> setPrintLeftMargin(300);
    $printer -> text("- $showData[jam]\n");
    // Barcode
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $testStr = "$data";
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
    /* Close printer */
    $printer -> feed();
	$printer -> cut();
	$printer -> close();
	
?>

<script>
	window.location.href="../../index.php?page=cetakLabel&aksi=reprint";
</script>	
