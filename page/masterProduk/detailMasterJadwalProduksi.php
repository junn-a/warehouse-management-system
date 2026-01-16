	<?php
	
	 $date = $_GET['id'];
	 //"<br>";
	 $dateNum = date('Ymd',strtotime($date));
	 $dateIndo = date('d-M-Y',strtotime($date));
	?>	
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Detail Jadwal Produksi Tanggal #<?=$dateIndo?></b>
		</div>
		<div class="panel-body">
			<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add" style="margin-bottom:5px">Add</a>
			<div id="data">
			
			</div>
		</div>
	</div>
	
	<!-- Modal Add-->
	<div id="add" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Jadwal Produksi</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post">
				<div class="form-group">
				  <label class="control-label col-sm-2">Tanggal :</label>
				  <div class="col-sm-10">
					<input type="text" class="form-control" name="tanggal_jadwal" value="<?=$_GET['id']?>" readonly>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">Line :</label>
				  <div class="col-sm-3">          
					<select name="kode_line" id="line" class="form-control line" required>
						<option value="">- Pilih Line -</option>
						<?php
							$selectLine = mysqli_query($conn3,"SELECT * FROM master_line");
							while($fetchLine = mysqli_fetch_array($selectLine)){
						?>
							<option value="<?=$fetchLine['kode_line']?>"><?=$fetchLine['nama_line']?></option>
						<?php }?>
					</select>
				  </div>
				  <label class="control-label col-sm-2" for="pwd">Produk :</label>
				  <div class="col-sm-5">          
					<select name="kode_material" class="form-control data-produk" required>
						
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2">Jumlah :</label>
				  <div class="col-sm-10">          
					<input type="text" class="form-control" name="jumlah" required/>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2">Note :</label>
				  <div class="col-sm-10">          
					<input type="text" class="form-control" name="keterangan"/>
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
	
	<script src="assets/js/jquery-3.3.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var id = <?=$dateNum?>;
			var post = 'id='+id;
			
			$.ajax({
				type : "POST",
				url : "page/jadwalProduksi/loaderDetailJadwalProduksi.php",
				data : post,
				success :function(ok){
					$("#data").html(ok);
				}
			});
		});
		$(document).ready(function(){
			$("#line").change(function(){
				var idLine = $(this).val();
				var postLine = 'idLine='+idLine;
				
				$.ajax({
					type : "POST",
					url : "page/masterGI/loaderProduk.php",
					data : postLine,
					success :function(line){
						$(".data-produk").html(line);
					}
				});
			});
		});
		
		
	</script>
	<?php
		@$tanggal_jadwal 	= $_POST['tanggal_jadwal'];
		@$kode_material		= $_POST['kode_material'];
		@$kode_line			= $_POST['kode_line'];
		@$jumlah			= $_POST['jumlah'];
		@$keterangan		= $_POST['keterangan'];
		@$save				= $_POST['save'];
		
		
		if(isset($save)){
			$selectProduk 	= mysqli_query($conn3,"SELECT * FROM detil_jadwal WHERE tanggal_jadwal='$tanggal_jadwal' && kode_material='$kode_material' && kode_line='$kode_line'");
			$cek 			= mysqli_num_rows($selectProduk);
			if($cek > 0){
				
			}else{
				$insertData = mysqli_query($conn3,"INSERT INTO detil_jadwal VALUES('$tanggal_jadwal', '$kode_line', '$kode_material', '$jumlah', '00:00:00', '00:00:00', '$keterangan')");
			}
		}
	?>