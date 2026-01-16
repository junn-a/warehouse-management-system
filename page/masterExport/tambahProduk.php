<div class="panel panel-default">
	<div class="panel-heading">
		<b>Form Tambah Produk</b>
	</div>
	<div class="panel-body">
		<form method="post">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
							  <label for="" class="form-label">Kode FG</label>
							  <input type="text" class="form-control" name="kode_material" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Nama FG</label>
							  <input type="text" class="form-control" name="nama_produk" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Size</label>
							  <input type="text" class="form-control" name="size" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Isi Per Karton</label>
							  <input type="text" class="form-control" name="isi" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Rasa</label>
							  <input type="text" class="form-control" name="rasa" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Singkatan</label>
							  <input type="text" class="form-control" name="singkatan" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
							  <label for="" class="form-label">Brand</label>
							  <input type="text" class="form-control" name="brand" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Karton Per Pallet</label>
							  <input type="text" class="form-control" name="per_palet" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Barcode Karton</label>
							  <input type="text" class="form-control" name="barcode_karton" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Barcode Pack</label>
							  <input type="text" class="form-control" name="barcode_pack" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Satuan</label>
							  <input type="text" class="form-control" name="satuan" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Status</label>
							  <input type="text" class="form-control" name="status" required>
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
								$selectData = pg_query($conn,"SELECT * FROM master_line");
								while($data = pg_fetch_assoc($selectData)){
							  ?>
								<div class="form-check">
								  <input type="checkbox" class="form-check-input" id="check1" name="kode_line[]" value="<?=$data['kode_line']?>">
								  <label class="form-check-label" for="check1"><?=$data['nama_line']?></label>
								</div>
								<?php }?>
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
		$insertData= pg_query($conn,"INSERT INTO master_produk (kode_material, nama_produk, size, isi, rasa, singkatan, brand, per_palet, barcode_karton, barcode_pack, satuan, status) VALUES ('$kode_material', '$nama_produk', '$size', '$isi','$rasa', '$singkatan', '$brand', '$per_palet','$barcode_karton','$barcode_pack','$satuan','$status')");
		//Insert ke detil line
		for($x=0;$x<$jumlah_dipilih;$x++){
			$insertLine = pg_query($conn,"INSERT INTO detil_line (kode_line, kode_material) VALUES('$kode_line[$x]', $kode_material)");
		}
		//Insert BOM
		$insertBom = pg_query($conn,"INSERT INTO tbl_rm_per_karton_fg (id, kode_material, seasoning, etiket) VALUES(DEFAULT,'$kode_material','$seasoning','$etiket')");
		if($insertData){
			echo "<script>alert('Data berhasil ditambah');window.location.href='index.php?page=masterProduk&aksi=index';</script>";
		}
	}
	
?>