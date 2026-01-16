<?php
	include "../../connection.php";
	$updateData = pg_query($conn,"UPDATE tbl_master_gi SET status=1 WHERE id_doc='$_POST[id]'");
?>