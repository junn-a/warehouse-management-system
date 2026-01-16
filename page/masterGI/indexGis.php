	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Master Good Issue Doc</b>
		</div>
		<div class="panel-body">
			<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add" style="margin-bottom:5px">Add</a>
			<div id="">
				<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>No GIS</th>
                        <th>Nama Produk</th>
						<th>Jumlah</th>
						<th style="text-align:center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					$no = 1;
					$query = pg_query($conn,"SELECT * FROM tbl_master_gis_new, master_produk WHERE tbl_master_gis_new.kode_material=master_produk.kode_material ORDER BY tbl_master_gis_new.id DESC");
					while($data = pg_fetch_assoc($query)){
				?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$data['id_gis']?></td>
						<td><?=$data['nama_produk']?></td>
						<td><?=$data['jumlah']?></td>
						<td style="text-align:center"><a href="?page=masterGis&aksi=hapus&id1=<?=$data['id_gis']?>" class="btn btn-danger"><span class="fa fa-trash"></span></button></td>
					</tr>
				<?php }?>
                </tbody>
            </table>
			</div>
		</div>
	</div>
	
	<!-- Modal Add-->
	<div id="add" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Good Issue Doc</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post">
				<div class="form-group" hidden>
				  <label class="control-label col-sm-2">User Create :</label>
				  <div class="col-sm-10">
					<input type="text" class="form-control" name="user_create" value="<?=$_SESSION['username']?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">Shift :</label>
				  <div class="col-sm-4">          
					<input type="text" class="form-control" name="shift" value="<?=$_SESSION['shift']?>" readonly>
				  </div>
				  <label class="control-label col-sm-2" for="pwd">Regu :</label>
				  <div class="col-sm-4">          
					<input type="text" class="form-control" name="regu" value="<?=$_SESSION['regu']?>" readonly>
				  </div>
				</div>
				
				
				<div class="form-group">
				  <label class="control-label col-sm-2">Date :</label>
				  <div class="col-sm-4">      
					<?php
						$jam 			= date("Gis");
						if(@$_SESSION['shift']==3 && $jam > 0 && $jam <70000){
							$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
							
						}else{
							$tgl = date('Y-m-d');
						}
					?>
					<input type="text" class="form-control" name="tanggal" value="<?=$tgl?>" readonly>
				  </div>
				  <label class="control-label col-sm-2">Time :</label>
				  <div class="col-sm-4">          
					<input type="text" class="form-control" name="jam" value="<?=$time?>" readonly>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2">No Doc :</label>
				  <div class="col-sm-10">
					<input type="number" class="form-control" name="id_doc" required>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2">Produk :</label>
				  <div class="col-sm-10">
					<?php
						$query = pg_query($conn,"SELECT nama_produk, kode_material  FROM master_produk");
					?>
					
					<select class="form-control" required name="kode_fg">
					<?php 
						while($data = pg_fetch_assoc($query)){
					?>
						<option value="<?=$data['kode_material']?>"><?=$data['nama_produk']?></option>
					<?php }?>
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">Jumlah :</label>
				  <div class="col-sm-4">          
					<input type="text" class="form-control" name="jumlah" required>
				  </div>
				  <label class="control-label col-sm-2" for="pwd">Jenis :</label>
				  <div class="col-sm-4">          
					<select class="form-control" required name="jenis_produk">
						<option value="1">Lokal</option>
						<option value="3">Ekspor</option>
						<option value="3">Cut Off</option>
					</select>
				  </div>
				</div>
				
			  
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-success" name="save">Save</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	 
	
	<?php
		@$user_create 	= $_POST['user_create'];
		@$id_doc 			= $_POST['id_doc'];
		@$shift 				= $_POST['shift'];
		@$regu				= $_POST['regu'];
		@$tanggal			= $_POST['tanggal'];
		@$jam				= $_POST['jam'];
		@$kode_fg			= $_POST['kode_fg'];
		@$jumlah			= $_POST['jumlah'];
		@$jenis_produk	= $_POST['jenis_produk'];
		
		@$save				= $_POST['save'];
		
		if(isset($save)){
			$insertData = pg_query($conn,"INSERT INTO tbl_master_gis_new VALUES('$id_doc', '$tanggal', '$shift', '$regu', '$user_create', '$jumlah','$jenis_produk', '$jam', '$kode_fg',1)");
			
			if($insertData){
				?>
				<script>
					alert("Tambah Data Berhasil");
					window.location.href="?page=masterGis&aksi=index";
				</script>
				<?php
			}
		}
	?>