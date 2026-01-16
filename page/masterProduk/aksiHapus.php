<?php 
	$id1 = $_GET['id1'];
	$id2 = $_GET['id2'];
	$id3 = $_GET['id3'];
	$deleteData = mysqli_query($conn3,"DELETE FROM detil_jadwal WHERE tanggal_jadwal='$id1' && kode_material='$id2' && kode_line='$id3'");
	
	header("location:index.php?page=jadwalProduksi&aksi=detail&id=$id1");
?>
