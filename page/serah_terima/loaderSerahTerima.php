
	<?php
	include '../../connection.php';
		$tujuan = $_POST['tujuan'];
		$shift = $_POST['shift'];
		$regu = $_POST['regu'];
		$line = $_POST['line'];
		$kode_material = $_POST['kode_material'];
		$tanggal_produksi = $_POST['tanggal_produksi'];
		$jenis_produk = $_POST['jenis_produk'];
	
	$selectNoPallet = pg_query($conn,"SELECT MAX(nomor_palet) AS no_update FROM serah_terima WHERE kode_material='$kode_material' AND shift='$shift' AND tanggal_produksi='$tanggal_produksi' AND jenis_produk='$jenis_produk' AND tujuan='$tujuan'");
	$fetch = pg_fetch_array($selectNoPallet);
	echo$fetch['no_update']+1;
	?>