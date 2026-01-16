<div class="panel panel-default">
	<div class="panel-heading">
		<b>OTF Export</b>
	</div>
	<div class="panel-body">
		<form method="post">
					<div class="row">
						<div class="col-md-4">
							<div class="mb-3">
							  <label for="" class="form-label">OTF</label>
							  <input type="text" class="form-control" name="otf" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Kode Material FG</label>
							  <input type="text" class="form-control" name="kode_material" required>
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Negara Tujuan</label>
							  <select class="form-control" name="nama_negara" required>
									<?php 
										$queryNegara = pg_query($conn,"SELECT * FROM master_eksport");
										while($dataNegara = pg_fetch_assoc($queryNegara)){
									?>
									<option value="<?=$dataNegara['nama_tujuan']."|".$dataNegara['singkatan']?>"><?=$dataNegara['nama_tujuan']?></option>
									<?php }?>
							  </select>	
							</div>
							<div class="mb-3">
							  <label for="" class="form-label">Target</label>
							  <input type="number" class="form-control" name="target" required>
							</div>
							<div class="mb-3">
							<label for="" class="form-label"></label>
							  <button type="submit" name="new" class="btn btn-primary btn-block">Submit</button>
							</div>
						</div>
						
					</div>
				</form>
	</div>
</div>

<?php
	
	@$nama 				= $_POST['nama_negara'];
	@$nama_negara 	= explode("|", $nama);

    // Memeriksa apakah array memiliki dua elemen
    if (count($nama_negara) == 2) {
        $nama_lengkap = $nama_negara[0];
        $singkatan = $nama_negara[1];
	}
	
	//list($nama, $singkatan) = explode($nama);
	@$otf 					= $_POST['otf'];
	$queryId 				= pg_query($conn,"SELECT COUNT(otf) AS new_id FROM tbl_export WHERE otf ='$otf' ");
	$dataId 				= pg_fetch_assoc($queryId);
	$no_urut 				= str_pad($dataId['new_id'] + 1, 2, "0", STR_PAD_LEFT);
	
	@$id_otf			 	= $_POST['otf'].$no_urut;
	 @$kode_material 	= $_POST['kode_material'];
	$selectProduk 		= pg_query($conn,"SELECT * FROM master_produk WHERE kode_material='$kode_material'");
	$data 					= pg_fetch_assoc($selectProduk);
	$nama_produk 		= $data['nama_produk'];
	$barcode 				= $data['barcode_karton'];
	@$target 				= $_POST['target'];
	
	//echo $nama."-".$singkatan;
	
	if(isset($_POST['new'])){
		//Insert master produk
		$insertData= pg_query($conn,"INSERT INTO tbl_export (id, id_otf, otf, nama_negara, singkatan, kode_produk, nama_produk, target, status, barcode) VALUES (DEFAULT, '$id_otf', '$otf', '$nama_lengkap', '$singkatan', '$kode_material', '$nama_produk', $target, 'AKTIF', '$barcode')");
		echo "<script>alert('Data berhasil ditambah');window.location.href='index.php?page=masterExport&aksi=index';</script>";
	}
	
?>