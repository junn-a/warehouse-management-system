<?php
	$username = $_GET['id'];
	$queryUser= pg_query($conn,"SELECT * FROM tbl_user WHERE username='$username'");
	//$queryDetil = pg_query($conn,"SELECT * FROM detil_line WHERE kode_material='$kode_material'");
	$data = pg_fetch_assoc($queryUser);
	//$dataDetil = pg_fetch_assoc($queryDetil);
?>
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
							  <input type="text" class="form-control" name="username" value="<?=$data['username']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Nama User</label>
							  <input type="text" class="form-control" name="nama" value="<?=$data['nama_user']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Regu</label>
							  <input type="text" class="form-control" name="regu" value="<?=$data['regu']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Password</label>
							  <input type="text" class="form-control" name="password" value="<?=$data['password']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Level</label>
							  <input type="text" class="form-control" name="level" value="<?=$data['level']?>" required>
							</div>
							<div class="mb-3">
							<label for="" class="form-label"></label>
							  <button type="submit" name="new" class="btn btn-primary btn-block">Ubah</button>
							</div>
						</div>
					</div>
				</form>
	</div>
</div>

<?php
	@$username 	= $_POST['username'];
	@$nama 			= $_POST['nama'];
	@$regu 			= $_POST['regu'];
	@$password 	= $_POST['password'];
	@$level 			= $_POST['level'];
	
	if(isset($_POST['new'])){
		//Insert master user
		$updateData = pg_query($conn, "UPDATE tbl_user SET  nama_user='$nama', regu='$regu', password='$password', level='$level' WHERE username='$username'");
		
		echo "<script>alert('Data berhasil diubah');window.location.href='index.php?page=masterUser&aksi=index';</script>";
	}
	
?>