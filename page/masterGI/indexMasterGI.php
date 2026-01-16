	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Master Good Issue Doc</b>
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
					$("#data").load('page/masterGI/loaderMasterGI.php');
				});
			</script>
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
				  <label class="control-label col-sm-2">No Doc :</label>
				  <div class="col-sm-10">
					<input type="number" class="form-control" name="id_doc" required>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">Shift :</label>
				  <div class="col-sm-4">          
					<select name="shift" class="form-control" required>
						<option value="">- Pilih Shift -</option>
						<?php
							for($i=1;$i<=3;$i++){
						?>
							<option value="<?=$i?>"><?=$i?></option>
						<?php }?>
					</select>
				  </div>
				  <label class="control-label col-sm-2" for="pwd">Regu :</label>
				  <div class="col-sm-4">          
					<select name="regu" class="form-control" required>
						<option value="">- Pilih Regu -</option>
						<?php
							for($r="A";$r<="D";$r++){
						?>
							<option value="<?=$r?>"><?=$r?></option>
						<?php }?>
					</select>
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
		@$id_doc 		= $_POST['id_doc'];
		@$shift 		= $_POST['shift'];
		@$regu			= $_POST['regu'];
		@$tanggal		= $_POST['tanggal'];
		@$jam			= $_POST['jam'];
		@$save			= $_POST['save'];
		
		if(isset($save)){
			$insertData = pg_query($conn,"INSERT INTO tbl_master_gi VALUES('$id_doc', '$tanggal', '$jam', '$user_create', '$shift', '$regu','0')");
		}
	?>