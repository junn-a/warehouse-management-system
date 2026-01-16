<?php

include "../../connection.php";
include "../../assets/phpqrcode/qrlib.php";
@$regu 	    	 		= $_POST['regu'];
@$shift 		 			= $_POST['shift'];
@$jam 			 		= $_POST['jam'];	
@$tanggal_produksi= $_POST['tanggal_produksi'];
@$kode_material 	= $_POST['kode_material'];
@$batch			 	= $_POST['batch'];		
@$jumlah 				= $_POST['jumlah'];
@$operator			= $_POST['user_serah'];
@$simpan 				= $_POST['simpan'];
echo @$status					= $_POST['status'];
// Cek nomer label
$cekNoLabel = pg_query($conn,"SELECT * FROM serah_terima WHERE nomor_label='$batch' AND status=2");
$cekRows = pg_num_rows($cekNoLabel);
if($cekRows > 0 && $status == "on"){	
	if(isset($simpan)){
		$insertWipUsage = pg_query($conn,"INSERT INTO tbl_wip_usage (id, tanggal_usage, shift, regu, kode_material, batch, jumlah_usage, operator) VALUES (DEFAULT, '$tanggal_produksi', '$shift', '$regu', '$kode_material', '$batch', '$jumlah', '$operator');");
		
		$deleteLoadFg = pg_query($conn,"DELETE FROM tbl_load_fg WHERE nomor_label='$batch'");
		
		$updateStatusSerahTerima = pg_query($conn,"UPDATE serah_terima SET status=3 WHERE nomor_label='$batch'");
	}
}if($cekRows > 0 && $status == "off"){	
	if(isset($simpan)){
		require __DIR__ . '/../../assets/pos/vendor/autoload.php';
		use Mike42\Escpos\Printer;
		use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
		
		use Mike42\Escpos\CapabilityProfile;
		
		//Cetak 
		$profile = CapabilityProfile::load("SP2000");
		$connector = new WindowsPrintConnector("smb://".$_SERVER['REMOTE_ADDR']."/Thermal");
		$printer = new Printer($connector, $profile);
		$insertWipUsage = pg_query($conn,"INSERT INTO tbl_wip_usage (id, tanggal_usage, shift, regu, kode_material, batch, jumlah_usage, operator) VALUES (DEFAULT, '$tanggal_produksi', '$shift', '$regu', '$kode_material', '$batch', '$jumlah', '$operator')");
		$selectOldLabel = pg_query($conn,"SELECT * FROM serah_terima WHERE nomor_label='$batch'");
		$data = pg_fetch_assoc($selectOldLabel);
		$newJumlah = $data['jumlah']-$jumlah;
		$insertNewLabel = pg_query($conn, "INSERT INTO public.serah_terima(nomor_label, tanggal_produksi, jam, regu, shift, nomor_palet, jumlah, jenis_produk, tujuan, nama_penyerah, nama_penerima, kode_material, kode_line, status) VALUES ('$data[nomor_label]P', '$data[tanggal_produksi]', '$data[jam]', '$data[regu]', $data[shift], $data[nomor_palet], $newJumlah, '$data[jenis_produk]', '$data[tujuan]', '$data[nama_penyerah]', '$data[nama_penerima]', '$data[kode_material]', '$data[kode_line]', '$data[status]')");
		$updateOldLabel = pg_query($conn,"UPDATE public.serah_terima SET jumlah=$jumlah WHERE nomor_label='$batch'");
		
		$selectLine 	= pg_query($conn,"SELECT nama_line FROM master_line WHERE kode_line='$kode_line'");
		$showLine 		= pg_fetch_array($selectLine);
		$selectData 	= pg_query($conn,"SELECT * FROM master_produk WHERE kode_material='$kode_material'");
		$showData 	= pg_fetch_array($selectData);
		$selectLokasi 	= pg_query($conn,"SELECT * FROM tbl_load_fg WHERE nomor_label='$data[nomor_label]'");
		$showLokasi 	= pg_fetch_array($selectLokasi);
		if($showLokasi['zone'] == 10){
				$area = "PC 32";
		}elseif($showLokasi['zone']  == 11){
				$area = "PC 14";
		}elseif($showLokasi['zone']  == 12){
				$area = "TS";
		}elseif($showLokasi['zone']  == 13){
				$area = "FCP";
		}elseif($showLokasi['zone']  == 14){
				$area = "TWS 5.6";
		}elseif($showLokasi['zone']  == 15){
				$area = "STANDING POUCH";
		}elseif($showLokasi['zone']  == 16){
				$area = "TWS 7.2";
		}elseif($showLokasi['zone']  == 17){
				$area = "CASSAVA";
		}
		
		
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		$printer -> setTextSize(1,1);
		$printer -> text(" \n");
		$printer -> text("Label WIP Parsial\n");
		$printer -> setTextSize(1,1);
		$printer -> text("PT INDOFOOD FORTUNA MAKMUR\n");
		$printer -> text("PLANT 1405\n");
		$printer -> text("\n");
		$printer -> setTextSize(1,1);
		$printer -> text("\n");
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		
		$printer -> setTextSize(8,8);
		$printer -> text("$showData[singkatan]\n");
		$printer -> setTextSize(1,1);
		$printer -> text($data['regu']."/".$data['shift']);
		$printer -> text("\n");
		$printer -> text($data['nomor_label']."P");
		$printer -> setTextSize(1,1);
		$printer -> text("Area $area\n");
		$printer -> text("\n");
		/**
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
		
		// Jumlah Kg
		$printer -> setPrintLeftMargin(0);
		$printer -> text("Jumlah Kg");
		$printer -> setPrintLeftMargin(128);
		$printer -> text(":");
		$printer -> setPrintLeftMargin(150);
		$printer -> text("$jumlahKg Kg \n");
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
		$printer -> text("(Operator)");
		$printer -> setPrintLeftMargin(300);
		$printer -> text("(Kasie)\n");
		**/
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
		//$printer -> cut();
		$printer -> close();
	}
}else{
	echo "data tidak ada";
}
	
?>
<script>
	//window.location.href="../../index.php?page=wip"
</script>	
