<?php 
	$id = $_GET['id'];
	$deleteData = pg_query($conn,"DELETE FROM tbl_export WHERE id='$id'");
	echo "<script>alert('Data berhasil dihapus');window.location.href='index.php?page=masterExport&aksi=index';</script>";
	//header("location:index.php?page=masterProduk&aksi=index");
?>
