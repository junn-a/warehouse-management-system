<?php
	require __DIR__ . '/../../assets/pos/vendor/autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	
	use Mike42\Escpos\CapabilityProfile;
	include "../../connection.php";
	include "../../assets/phpqrcode/qrlib.php";
	session_start();
	
	$jam 			= date("Gis");
	if(@$_SESSION['shift']==3 AND $jam > 0 AND $jam <70000){
		$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
		$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
		
	}else{
		$tgl = date('Y-m-d');
		$dateNoLabel 	= date('dm');
	}
	//Cetak 
	function getClientIP() {
		$ip = '';
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		// Stripping port number if present
		$pos = strpos($ip, ':');
		if ($pos !== false) {
			$ip = substr($ip, 0, $pos);
		}
		return $ip;
	}
	$profile = CapabilityProfile::load("SP2000");
	$ip 		= getClientIP();
	//$ip = '10.130.48.108'; // IP komputer dengan printer terkoneksi
	$printerShareName = 'wip'; // Nama share printer di komputer tersebut
	$username = 'User'; // Nama pengguna dengan otorisasi
	$password = 'User'; // Kata sandi pengguna dengan otorisasi

	// Membuat URL SMB dengan informasi login
	$url = "smb://{$username}:{$password}@{$ip}/{$printerShareName}";
	// Membuat koneksi dengan printer
	$connector = new WindowsPrintConnector($url);
	$printer = new Printer($connector, $profile);
	
	//$connector = new WindowsPrintConnector("smb://".$ip."/wip");
	//$printer = new Printer($connector, $profile);
	
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> setTextSize(1,1);
	$printer -> text(" \n");
	$printer -> text("REKAP HASIL WIP\n");
	$printer -> setTextSize(1,1);
	$printer -> text("PT INDOFOOD FORTUNA MAKMUR\n");
	$printer -> text("PLANT 1405\n");
	$printer -> setPrintLeftMargin(0);
	$printer -> text("Tanggal");
	$printer -> setPrintLeftMargin(128);
	$printer -> text(":");
	$printer -> setPrintLeftMargin(150);
	$printer -> text("$tgl");
	$printer -> setPrintLeftMargin(300);
	$printer -> text("/ ");
	$printer -> setPrintLeftMargin(310);
	$printer -> text($_SESSION['shift']."/".$_SESSION['regu']);
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	//WIP BOX
	$no = 1;
	$queryWipBox = pg_query($conn,"SELECT * FROM serah_terima WHERE shift='$_SESSION[shift]' AND regu='$_SESSION[regu]' AND tanggal_produksi = '$tgl' AND nomor_label ILIKE '%WIPBOX%'");
	if(pg_num_rows($queryWipBox)){
		// Tabel Rekap
		$printer -> setPrintLeftMargin(0);
		$printer -> text("No");
		$printer -> setPrintLeftMargin(80);
		$printer -> text("Jam");
		$printer -> setPrintLeftMargin(230);
		$printer -> text("Box\n");	
		while($dataWipBox  = pg_fetch_assoc($queryWipBox)){
			$printer -> setPrintLeftMargin(0);
			$printer -> text($no++);
			$printer -> setPrintLeftMargin(80);
			$printer -> text($dataWipBox['jam']);
			$printer -> setPrintLeftMargin(230);
			$printer -> text($dataWipBox['jumlah']);
			$printer -> text("\n");
			
		}
		$queryTotalWipBox = pg_query($conn, "SELECT SUM(serah_terima.jumlah) AS total_wip_box, master_produk.isi, master_produk.size FROM serah_terima JOIN master_produk ON serah_terima.kode_material = master_produk.kode_material WHERE serah_terima.shift = '$_SESSION[shift]' AND serah_terima.regu = '$_SESSION[regu]' AND serah_terima.tanggal_produksi = '$tgl' AND serah_terima.nomor_label ILIKE '%WIPBOX%' GROUP BY master_produk.isi, master_produk.size");
		$dataTotalWipBox 	= pg_fetch_assoc($queryTotalWipBox);
		$totalWipBoxKg 		= $dataTotalWipBox['total_wip_box'];
		$totalWipBoxKg 		= $dataTotalWipBox['total_wip_box']*$dataTotalWipBox['isi']*$dataTotalWipBox['size']/1000;
		// Total WIP BOX
		$printer -> setPrintLeftMargin(0);
		$printer -> text("---------------------\n");
		$printer -> setPrintLeftMargin(0);
		$printer -> text("");
		$printer -> setPrintLeftMargin(80);
		$printer -> text("");
		$printer -> setPrintLeftMargin(230);
		$printer -> text($dataTotalWipBox['total_wip_box']." Box");
		$printer -> text("\n");
		$printer -> setPrintLeftMargin(0);
		$printer -> text("");
		$printer -> setPrintLeftMargin(80);
		$printer -> text("");
		$printer -> setPrintLeftMargin(230);
		$printer -> text(number_format($dataTotalWipBox['total_wip_box']*$dataTotalWipBox['isi']*$dataTotalWipBox['size']/1000)." Kg");
		$printer -> text("\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> setTextSize(1,1);
		$printer -> text("\n");
		$printer -> text("********");
		$printer -> text("\n");
		$printer -> text("\n");
		$printer -> text("\n");
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		$printer -> setTextSize(1,1);
	}
	
	// WIP CAR
	$queryWipCar = pg_query($conn,"SELECT * FROM serah_terima WHERE shift='$_SESSION[shift]' AND regu='$_SESSION[regu]' AND tanggal_produksi = '$tgl' AND nomor_label ILIKE '%WIPCAR%'");
	if(pg_num_rows($queryWipCar)){
		// Tabel Rekap
		$printer -> setPrintLeftMargin(0);
		$printer -> text("No");
		$printer -> setPrintLeftMargin(80);
		$printer -> text("Jam");
		$printer -> setPrintLeftMargin(230);
		$printer -> text("Car\n");	
		while($dataWipCar  = pg_fetch_assoc($queryWipCar)){
			$printer -> setPrintLeftMargin(0);
			$printer -> text($no++);
			$printer -> setPrintLeftMargin(80);
			$printer -> text($dataWipCar['jam']);
			$printer -> setPrintLeftMargin(230);
			$printer -> text($dataWipCar['jumlah']);
			$printer -> text("\n");
			
		}
		$queryTotalWipCar = pg_query($conn, "SELECT SUM(serah_terima.jumlah) AS total_wip_car, master_produk.isi, master_produk.size FROM serah_terima JOIN master_produk ON serah_terima.kode_material = master_produk.kode_material WHERE serah_terima.shift = '$_SESSION[shift]' AND serah_terima.regu = '$_SESSION[regu]' AND serah_terima.tanggal_produksi = '$tgl' AND serah_terima.nomor_label ILIKE '%WIPCAR%' GROUP BY master_produk.isi, master_produk.size");
		$dataTotalWipCar 	= pg_fetch_assoc($queryTotalWipCar);
		$totalWipCar 			= $dataTotalWipCar['total_wip_car'];
		$totalWipCarKg 		= $dataTotalWipCar['total_wip_car']*$dataTotalWipCar['isi']*$dataTotalWipCar['size']/1000;
		// Total WIP BOX
		$printer -> setPrintLeftMargin(0);
		$printer -> text("---------------------\n");
		$printer -> setPrintLeftMargin(0);
		$printer -> text("");
		$printer -> setPrintLeftMargin(80);
		$printer -> text("");
		$printer -> setPrintLeftMargin(230);
		$printer -> text($dataTotalWipCar['total_wip_car']." Car");
		$printer -> text("\n");
		$printer -> setPrintLeftMargin(0);
		$printer -> text("");
		$printer -> setPrintLeftMargin(80);
		$printer -> text("");
		$printer -> setPrintLeftMargin(230);
		$printer -> text(number_format($dataTotalWipCar['total_wip_car']*$dataTotalWipCar['isi']*$dataTotalWipCar['size']/1000)." Kg");
		$printer -> text("\n");
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> setTextSize(1,1);
		$printer -> text("\n");
		$printer -> text("********");
		$printer -> text("\n");
	}
	
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> setPrintLeftMargin(0);
	$printer -> text("Total Kg");
	$printer -> setPrintLeftMargin(80);
	$printer -> text("");
	$printer -> setPrintLeftMargin(230);
	$printer -> text(@$totalWipBoxKg+@$totalWipCarKg." Kg");	
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> setPrintLeftMargin(0);
	$printer -> text($_SESSION['username']);
	$printer -> setPrintLeftMargin(300);
	$printer -> text($_SESSION['kasie_prod']);
	$printer -> text("\n");
	$printer -> setPrintLeftMargin(0);
	$printer -> text("(Operator)");
	$printer -> setPrintLeftMargin(300);
	$printer -> text("(Kasie)\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> feed();
	$printer -> cut();
	$printer -> close();

?>
<script>
	window.location.href="../../index.php?page=wip"
</script>	
