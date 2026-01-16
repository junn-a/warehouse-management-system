	<?php
		$selectMapping 	= pg_query($conn,"SELECT * FROM tbl_load_fg  ORDER BY id");
		$no = 1;
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Master Mapping Pallet</b>
		</div>
		<div class="panel-body">
			<?php if(@$_SESSION['hasil']==1){?>
				<div class="alert alert-success alert-dismissible">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  <strong>Success!</strong> Indicates a successful or positive action.
				</div>
			<?php }elseif(@$_SESSION['hasil']==2){?>
				<div class="alert alert-danger alert-dismissible">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  <strong>Success!</strong> Indicates a successful or positive action.
				</div>
			<?php }else{echo "";}?>
			<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add" style="margin-bottom:5px">Add</a>
			<table class="table table-striped" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>ID</th>
                        <th>Zone</th>
                        <th>No Label</th>
						<th style="text-align:center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
					while($fetchMapping = pg_fetch_assoc($selectMapping)){
				   ?>
					<tr>
						<td><?=$fetchMapping['id']?></td>
						<td><?=$fetchMapping['zone']?></td>
						<td><?=$fetchMapping['nomor_label']?></td>
						<td style="text-align:center"><a href="?page=deleteMapping&id=<?=$fetchMapping['id']?>"  class="btn btn-danger"><span class="fa fa-trash"></span></a></td>
					</tr>
				   <?php 
					}
				   ?>
                </tbody>
            </table>
		</div>
	</div>
	<div id="add" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Modal Header</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post">
				<div class="form-group">
				  <label class="control-label col-sm-2">ID :</label>
				  <div class="col-sm-10">
					<input type="number" class="form-control" name="id" required >
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">Zone:</label>
				  <div class="col-sm-10">          
					<select name="zone" class="form-control" required>
						<option value="">- Pilih Zone -</option>
						<?php
							for($i=1;$i<=8;$i++){
						?>
							<option value="<?=$i?>"><?=$i?></option>
						<?php }?>
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">Shift:</label>
				  <div class="col-sm-10">          
					<select name="shift" class="form-control" required>
						<option value="">- Pilih Shift -</option>
						<?php
							for($i=1;$i<=4;$i++){
						?>
							<option value="<?=$i?>"><?=$i?></option>
						<?php }?>
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pwd">No Label:</label>
				  <div class="col-sm-10">          
					<input type="text" class="form-control" name="nomor_label">
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
		@$save 	= $_POST['save'];
		@$id 	= $_POST['id'];
		@$zone 	= $_POST['zone'];
		@$shift = $_POST['shift'];
		@$nomor_label = $_POST['nomor_label'];
		if(isset($save)){
			$insertData = pg_query($conn,"INSERT INTO tbl_load_fg VALUES('$id', '$zone', '$nomor_label', '$shift')");
			if($insertData){
				$_SESSION['hasil'] = '1';
			}else{
				$_SESSION['hasil'] = '2';
			}
		}
		
	?>