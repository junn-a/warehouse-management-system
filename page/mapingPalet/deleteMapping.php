<?php
	$id = $_GET['id'];
	$deleteMapping = pg_query($conn,"DELETE FROM tbl_load_fg WHERE id='$id'");
	
?>
<script>
	alert("Hapus Data Berhasil");
	window.location.href="index.php?page=mappingPalet";
</script>