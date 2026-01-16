	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Detail Good Issue Doc No #<?=$_GET['id']?></b>
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
			<h4 class="modal-title">Add Product</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post">
				<div class="form-group">
				  <label class="control-label col-sm-2">No Doc :</label>
				  <div class="col-sm-10">
					<input type="number" class="form-control" name="id_doc" value="<?=$_GET['id']?>" readonly>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">Line :</label>
				  <div class="col-sm-3">          
					<select name="line" id="line" class="form-control line" required>
						<option value="">- Pilih Line -</option>
						<?php
							$selectLine = pg_query($conn,"SELECT * FROM master_line");
							while($fetchLine = pg_fetch_array($selectLine)){
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
			var id = <?=$_GET['id']?>;
			var post = 'id='+id;
			
			$.ajax({
				type : "POST",
				url : "page/masterGI/loaderDetailMasterGI.php",
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
		@$id_doc 		= $_POST['id_doc'];
		@$kode_material	= $_POST['kode_material'];
		@$jumlah		= $_POST['jumlah'];
		@$save			= $_POST['save'];
		
		if(isset($save)){
			$selectProduk 	= pg_query($conn,"SELECT * FROM tbl_detail_master_gi WHERE id_doc='$id_doc' AND kode_material='$kode_material'");
			$cek 			= pg_num_rows($selectProduk);
			if($cek > 0){
				
			}else{
				$insertData = pg_query($conn,"INSERT INTO tbl_detail_master_gi VALUES(DEFAULT, '$id_doc', '$kode_material', '$jumlah')");
			}
		}
	?>