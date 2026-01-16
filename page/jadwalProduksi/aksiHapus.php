<?php 
	$id1 = $_GET['id1'];
	$id2 = $_GET['id2'];
	$id3 = $_GET['id3'];
	$deleteData = pg_query($conn,"DELETE FROM detil_jadwal WHERE tanggal_jadwal='$id1' AND kode_material='$id2' AND kode_line='$id3'");
	
	header("location:index.php?page=jadwalProduksi&aksi=detail&id=$id1");
?>
