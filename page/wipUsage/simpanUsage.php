<?php

include "../../connection.php";
include "../../assets/phpqrcode/qrlib.php";
@$regu 	    	 		= $_POST['regu'];
@$shift 		 			= $_POST['shift'];
@$jam 			 		= $_POST['jam'];	
@$tanggal_produksi	= $_POST['tanggal_produksi'];
@$kode_material 		= $_POST['kode_material'];
@$batch			 		= $_POST['batch'];		
@$jumlah 				= $_POST['jumlah'];
@$operator				= $_POST['user_serah'];
@$simpan 				= $_POST['simpan'];
@$status					= $_POST['status'];
// Cek nomer label
$cekNoLabel = pg_query($conn,"SELECT * FROM serah_terima WHERE nomor_label='$batch' AND status=2");
$cekRows = pg_num_rows($cekNoLabel);
if($cekRows > 0 && $status == "on"){	
	//echo "Simpan Label";
	$insertWipUsage = pg_query($conn,"INSERT INTO tbl_wip_usage (id, tanggal_usage, shift, regu, kode_material, batch, jumlah_usage, operator, jam) VALUES (DEFAULT, '$tanggal_produksi', '$shift', '$regu', '$kode_material', '$batch', '$jumlah', '$operator', '$jam');");
		
	$deleteLoadFg = pg_query($conn,"DELETE FROM tbl_load_fg WHERE nomor_label='$batch'");
	
	$updateStatusSerahTerima = pg_query($conn,"UPDATE serah_terima SET status=3 WHERE nomor_label='$batch'");
	?>
	<script>
		window.location.href="../../index.php?page=wipUsage"
	</script>
<?php
}if($cekRows > 0 && $status == "off"){
	//echo "Cetak Label";
	header("Location: cetakLabelUsage.php?regu=$regu&shift=$shift&jam=$jam&tanggal=$tanggal_produksi&kode_material=$kode_material&batch=$batch&jumlah=$jumlah&operator=$operator"); 
}