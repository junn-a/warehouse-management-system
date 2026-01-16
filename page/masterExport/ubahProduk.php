<?php
	$kode_material = $_GET['id'];
	$queryProduk = pg_query($conn,"SELECT * FROM master_produk WHERE kode_material='$kode_material'");
	$queryDetil = pg_query($conn,"SELECT * FROM detil_line WHERE kode_material='$kode_material'");
	$data = pg_fetch_assoc($queryProduk);
	$dataDetil = pg_fetch_assoc($queryDetil);
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<b>Form Ubah Data Produk</b>
	</div>
	<div class="panel-body">
		<form method="post">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
							  <label for="" class="form-label">Kode FG</label>
							  <input type="text" class="form-control" name="kode_material" value="<?=$data['kode_material']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Nama FG</label>
							  <input type="text" class="form-control" name="nama_produk" value="<?=$data['nama_produk']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Size</label>
							  <input type="number" class="form-control" name="size" value="<?=$data['size']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Isi Per Karton</label>
							  <input type="number" class="form-control" name="isi" value="<?=$data['isi']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Rasa</label>
							  <input type="text" class="form-control" name="rasa" value="<?=$data['rasa']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Singkatan</label>
							  <input type="text" class="form-control" name="singkatan" value="<?=$data['singkatan']?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
							  <label for="" class="form-label">Brand</label>
							  <input type="text" class="form-control" name="brand" value="<?=$data['brand']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Karton Per Pallet</label>
							  <input type="text" class="form-control" name="per_palet" value="<?=$data['per_palet']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Barcode Karton</label>
							  <input type="text" class="form-control" name="barcode_karton" value="<?=$data['barcode_karton']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Barcode Pack</label>
							  <input type="text" class="form-control" name="barcode_pack" value="<?=$data['barcode_pack']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Satuan</label>
							  <input type="text" class="form-control" name="satuan" value="<?=$data['satuan']?>" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Status</label>
							  <input type="text" class="form-control" name="status" value="<?=$data['status']?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
							  <label for="" class="form-label">BOM Seasoning</label>
							  <input type="number" step="any" class="form-control" name="seasoning" pattern=".{12,}"   required title="12 characters minimum">
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">BOM Etiket</label>
							  <input type="number" step="any" class="form-control" name="etiket" pattern=".{12,}"   required title="12 characters minimum">
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Line</label>
							  <?php
								$queryDetil = pg_query($conn,"SELECT * FROM detil_line WHERE kode_material='$kode_material'");
								$detilLine = array();
								while ($row = pg_fetch_assoc($queryDetil)) {
								  $detilLine[] = $row['kode_line'];
								}

								$selectData = pg_query($conn,"SELECT * FROM master_line");
								while($data = pg_fetch_assoc($selectData)){
								  ?>
								  <div class="form-check">
									<input type="checkbox" <?php if(in_array($data['kode_line'], $detilLine)){echo "checked";}?> class="form-check-input" id="check1" name="kode_line[]" value="<?=$data['kode_line']?>">
									<label class="form-check-label" for="check1"><?=$data['nama_line']?></label>
								  </div>
								  <?php
								}
								?>
								
							</div>
							<div class="mb-3">
							  <button type="submit" name="new" class="btn btn-primary btn-block">New</button>
							</div>
						</div>
					</div>
				</form>
	</div>
</div>

<?php
	@$kode_material 	= $_POST['kode_material'];
	@$nama_produk 	= $_POST['nama_produk'];
	@$size 				= $_POST['size'];
	@$isi 					= $_POST['isi'];
	@$rasa 				= $_POST['rasa'];
	@$singkatan 		= $_POST['singkatan'];
	@$brand 				= $_POST['brand'];
	@$per_palet 			= $_POST['per_palet'];
	@$barcode_karton = $_POST['barcode_karton'];
	@$barcode_pack 	= $_POST['barcode_pack'];
	@$satuan 			= $_POST['satuan'];
	@$status 				= $_POST['status'];
	@$etiket				= $_POST['etiket'];
	@$seasoning				= $_POST['seasoning'];
	@$kode_line = $_POST['kode_line'];
	@$jumlah_dipilih = count($kode_line);
	
	if(isset($_POST['new'])){
		//Insert master produk
		//$updateData= pg_query($conn,"INSERT INTO master_produk (kode_material, nama_produk, size, isi, rasa, singkatan, brand, per_palet, barcode_karton, barcode_pack, satuan, status) VALUES ('$kode_material', '$nama_produk', '$size', '$isi','$rasa', '$singkatan', '$brand', '$per_palet','$barcode_karton','$barcode_pack','$satuan','$status')");
		$updateData= pg_query($conn,"UPDATE master_produk SET nama_produk='$nama_produk', size='$size', isi='$isi', rasa='$rasa', singkatan='$singkatan', brand='$brand', per_palet='$per_palet', barcode_karton='$barcode_karton', barcode_pack='$barcode_pack', satuan='$satuan', status='$status' WHERE kode_material='$kode_material'");
		
		//Insert ke detil line
		if (!empty($kode_line) && !empty($kode_material)) {
			for ($x = 0; $x < $jumlah_dipilih; $x++) {
				$kode_line_x = $kode_line[$x];
				$kode_material_x = $kode_material;
				$query = "SELECT * FROM detil_line WHERE kode_line = '$kode_line_x' AND kode_material = '$kode_material_x'";
				$result = pg_query($conn, $query);

				if (pg_num_rows($result) == 0) {
					$insertLine = pg_query($conn, "INSERT INTO detil_line (kode_line, kode_material) VALUES('$kode_line_x', '$kode_material_x')");
				}
			}
		} else {
			// Jika tidak ada data yang dipilih, maka hapus semua data di tabel detil_line
			$deleteLine = pg_query($conn, "DELETE FROM detil_line WHERE kode_material = '$kode_material'");
		}
		//cek data bom
		$selectBom = pg_query($conn,"SELECT * FROM tbl_rm_per_karton_fg WHERE kode_material='$kode_material'");
		$cekQuery = pg_num_rows($selectBom);
		if($cekQuery > 0){
			$updateBom = pg_query($conn,"UPDATE tbl_rm_per_karton_fg SET seasoning='$seasoning', etiket='$etiket' WHERE kode_material='$kode_material'");
		}else{
			$insertBom = pg_query($conn,"INSERT INTO tbl_rm_per_karton_fg (id, kode_material, seasoning, etiket) VALUES(DEFAULT,'$kode_material','$seasoning','$etiket')");
		}
		
		if($updateData){
			echo "<script>alert('Data berhasil ditambah');window.location.href='index.php?page=masterProduk&aksi=ubahProduk&id=$kode_material';</script>";
		}
	}
	
?>