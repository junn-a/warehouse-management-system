<?php 
	$id1 = $_GET['id1'];
	$id2 =  $_GET['id2'];
	$deleteData =pg_query($conn,"DELETE FROM tbl_detail_master_gi WHERE id_detail='$id2'");
	header("location:index.php?page=masterGI&aksi=detail&id=$id1");
?>
