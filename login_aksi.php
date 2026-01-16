<?php
	include 'connection.php';
	
	@$username 	= $_POST['username'];
	@$password 		= $_POST['password'];
	@$shift 				= $_POST['shift'];
	@$regu 			= $_POST['regu'];
	@$kasie_prod 	= $_POST['kasie_prod'];
	
	
	$query 	= pg_query($conn,"SELECT * FROM tbl_user WHERE username = '$username' AND password = '$password'");
	$fetch 	= pg_fetch_assoc($query);
	$cek 	= pg_num_rows($query);
	
	if($cek >0){
		session_start();
		$_SESSION['status'] 		= "login";
		$_SESSION['username']	= $fetch['username'];
		$_SESSION['level']			= $fetch['level'];		
		$_SESSION['shift']			= $shift;	
		$_SESSION['regu']			= $regu;
		$_SESSION['kasie_prod'] = $kasie_prod;
		
		?>
			<script>
				alert('Login Successfully');
				window.location.href="index.php";
			</script>
		<?php
	}else{
		?>
			<script>
				alert('Login Failed');
				window.location.href="index.php";
			</script>
		<?php
	}
?>