<div class="panel panel-default">
	<div class="panel-heading">
		<b>Form Tambah User</b>
	</div>
	<div class="panel-body">
		<form method="post">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
							  <label for="" class="form-label">Username</label>
							  <input type="text" class="form-control" name="username" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Nama User</label>
							  <input type="text" class="form-control" name="nama" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Regu</label>
							  <input type="text" class="form-control" name="regu" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Password</label>
							  <input type="text" class="form-control" name="password" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Level</label>
							  <input type="text" class="form-control" name="level" required>
							</div>
							<div class="mb-3">
							<label for="" class="form-label"></label>
							  <button type="submit" name="new" class="btn btn-primary btn-block">New</button>
							</div>
						</div>
					</div>
				</form>
	</div>
</div>

<?php
	@$username 	= $_POST['username'];
	@$nama 		= $_POST['nama'];
	@$regu 			= $_POST['regu'];
	@$password 	= $_POST['password'];
	@$level 		= $_POST['level'];
	
	if(isset($_POST['new'])){
		//Insert master user
		$insertData = pg_query($conn, "INSERT INTO tbl_user (username, nama_user, regu, password, level) VALUES ('$username', '$nama', '$regu', '$password', '$level')");
	}
	
?>