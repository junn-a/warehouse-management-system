<?php
	session_start();
	session_destroy(); 
?>
<script>
	alert("Anda Telah logout");
	window.location.href="index.php";
</script>