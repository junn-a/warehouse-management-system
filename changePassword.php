<?php
	include "connection.php";
	$username 		= $_POST['username'];
	$oldPassword 	= $_POST['oldPassword'];
	$newPassword 	= $_POST['newPassword'];
	// Cek Data
	$queryCek 	= mysqli_query($conn3,"SELECT * FROM user WHERE Username='$username' && Password='$oldPassword'");
	$cek 		= mysqli_num_rows($queryCek);
	if($cek >0){
		$queryUpdate = mysqli_query($conn3,"UPDATE user SET Password='$newPassword' WHERE Username='$username'");
		?>
		<script>
			alert("Success !");
			window.location.href="index.php";
		</script>
		<?php
	}else{
		?>
		<script>
			alert("Failed !");
			window.location.href="index.php";
		</script>
		<?php
	}
?>