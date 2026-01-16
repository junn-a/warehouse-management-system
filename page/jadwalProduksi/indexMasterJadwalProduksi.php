	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Master Jadwal Produksi</b>
		</div>
		<div class="panel-body">
			<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add" style="margin-bottom:5px">Add</a>
			<div id="data">
			
			</div>
		</div>
	</div>
	<script src="assets/js/jquery-3.3.1.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#data").load('page/jadwalProduksi/loaderMasterJadwalProduksi.php');
				});
			</script>
	<!-- Modal Add-->
	<div id="add" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add</h4>
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
				  <label class="control-label col-sm-2">Date :</label>
				  <div class="col-sm-4">          
					<input type="text" class="form-control" name="tanggal" value="<?=$date?>">
				  </div>
				  <label class="control-label col-sm-2">Time :</label>
				  <div class="col-sm-4">          
					<input type="text" class="form-control" name="jam" value="<?=$time?>" readonly>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2">Week :</label>
				  <div class="col-sm-10">
					<input type="number" class="form-control" name="week" required>
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
		@$user_create = $_POST['user_create'];
		@$week 			= $_POST['week'];
		@$tanggal		= $_POST['tanggal'];
		@$jam				= $_POST['jam'];
		@$save			= $_POST['save'];
		
		if(isset($save)){
			$insertData = pg_query($conn,"INSERT INTO master_jadwal VALUES('$tanggal', '$jam', '$week', '1', '0', '$user_create')");
		}
	?>