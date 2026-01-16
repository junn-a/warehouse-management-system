<?php 
	$id1 = $_GET['id1'];
	$deleteData = pg_query($conn,"DELETE FROM tbl_master_gis_new WHERE id_gis='$id1'");
	header("location:index.php?page=masterGis&aksi=index");
?>
