<?php 
	$id = $_GET['id'];
	$deleteData = pg_query($conn,"DELETE FROM master_produk WHERE kode_material='$id'");
	echo "<script>alert('Data berhasil ditambah');window.location.href='index.php?page=masterProduk&aksi=index';</script>";
	//header("location:index.php?page=masterProduk&aksi=index");
?>
