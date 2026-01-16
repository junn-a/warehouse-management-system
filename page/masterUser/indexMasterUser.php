	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Master User</b>
		</div>
		<div class="panel-body">
			<a href="?page=masterUser&aksi=tambahUser" class="btn btn-primary"	 style="margin-bottom:5px">Add</a>
			<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama </th>
						<th>Regu</th>
						<th style="text-align:center">Edit</th>
						<th style="text-align:center">Delete</th>
                    </tr>
                </thead>
				<tbody>
				<?php
				$no 			= 1;
					$arrayData 		= array(); 
					
					
					$selectData = pg_query($conn,"SELECT * FROM tbl_user ORDER BY nama_user ASC");
					$data	= pg_fetch_all($selectData);
					
					foreach($data AS $key => $value){
						$arrayData[$value['username']]=array(
							'username' 	=> $value['username'],
							'nama_user' 	=> $value['nama_user'],
							'regu' 			=> $value['regu'],
							'password' 	=> $value['password'],
							'level' 			=> $value['level']
						);
					}
					foreach($arrayData AS $table => $tab){
				   ?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$tab['username']?></td>
						<td><?=$tab['nama_user']?></td>
						<td><?=$tab['regu']?></td>
						<td style="text-align:center"><a href="?page=masterUser&aksi=ubahUser&id=<?=$tab['username']?>" class="btn btn-warning"><span class="fa fa-edit"></span></a></td>
						<td style="text-align:center"><a href="?page=masterUser&aksi=hapusUser&id=<?=$tab['username']?>" class="btn btn-danger"><span class="fa fa-trash"></span></a></td>
					</tr>
					<?php }?>
                </tbody>
            </table>
		</div>
		</div>
		
		
	</div>
	
	<!-- Modal Add-->
	<div id="add" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post">
				<div class="form-group">
				  <label class="control-label col-sm-2">Kode Material :</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="kode_material" value="">
				  </div>
				   <label class="control-label col-sm-2">Nama Produk :</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="nama_produk" value="">
				  </div>
				   <label class="control-label col-sm-2">Kode Material :</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="user_create" value="<?=$_SESSION['Username']?>">
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
		@$user_create 	= $_POST['user_create'];
		@$week 			= $_POST['week'];
		@$tanggal		= $_POST['tanggal'];
		@$jam			= $_POST['jam'];
		@$save			= $_POST['save'];
		
		if(isset($save)){
			$insertData = pg_query($conn,"INSERT INTO master_jadwal VALUES('$tanggal', '$jam', '$week', '1', '0', '$user_create')");
		}
	?>