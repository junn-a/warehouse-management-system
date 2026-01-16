<script src="assets/js/jquery.min.js"></script>	
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Koreksi Label FG</b>
		</div>
		<div class="panel-body">
			<?php
				if($_SESSION['level'] == "Administrator"){
			?>
			<table class="table table-bordered">
				<form method="GET">
					<tr>
						<td>
							<select class="form-control" readonly>
								<option>-Pilih Regu-</option>
								<option <?php if($_SESSION['regu']=="A"){echo "selected";}?>>A</option>
								<option <?php if($_SESSION['regu']=="B"){echo "selected";}?>>B</option>
								<option <?php if($_SESSION['regu']=="C"){echo "selected";}?>>C</option>
								<option <?php if($_SESSION['regu']=="D"){echo "selected";}?>>D</option>
							</select>
						</td>
						<td>
							<select class="form-control" readonly>
								<option>-Pilih Shift-</option>
								<option <?php if($_SESSION['shift']==1){echo "selected";}?>>1</option>
								<option <?php if($_SESSION['shift']==2){echo "selected";}?>>2</option>
								<option <?php if($_SESSION['shift']==3){echo "selected";}?>>3</option>
							</select>
						</td>
						<td><input type="date" class="form-control line"  value="<?=$date?>" readonly/></td>
					</tr>
				</form>
			</table>
			<?php 
				
				$time 		= date("Gis");
				if($_SESSION['shift'] == 3 && $time >0 && $time < 70000){
					$date = date('Y-m-d', strtotime("-1 day", strtotime($date )));
				}else{$date	 	= date("Y-m-d");}
				
				$no     = 1;
				$shift  = $_SESSION['shift'];
				$regu  	= $_SESSION['regu'];
				$selectLabel = pg_query($conn,"SELECT serah_terima.* FROM serah_terima WHERE  
				serah_terima.tanggal_produksi='$date' AND 
				serah_terima.shift='$shift' AND
				serah_terima.regu='$regu'
				");
			
			}else{?>
			<table class="table table-bordered">
				<form method="POST">
					<tr>
						<td><input type="date" class="form-control line" name="date"  value="" /></td>
						<td><input type="submit" class="btn btn-info btn-block"  value="Cari" /></td>
					</tr>
				</form>
			</table>
			<?php
				@$date = $_POST['date'];
				if(empty($date)){
					
				}else{
				$no     = 1;
				$selectLabel = pg_query($conn,"SELECT * FROM serah_terima WHERE tanggal_produksi='$date'"); 
				}
			}
			?>
			<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>No Label</th>
                        <th>Tanggal</th>
						<th>Shift</th>
						<th>Regu</th>
                        <th>Jam</th>
                        <th>No Pallet</th>
						<th>Jumlah</th>
						<th>Koreksi</th>
						<th>Re-Print</th>
						<th>Hapus</th>
                    </tr>
                </thead>
			
                <tbody>
                    <?php
					if(empty($date)){
					
					}else{

						while($showdata = pg_fetch_assoc($selectLabel)){
						$label = 	$showdata['nomor_label'];
						$trimLabel = str_replace('*','',$label);
					?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$showdata['nomor_label']?></td>
                        <td><?=$showdata['tanggal_produksi']?></td>
						<td><?=$showdata['shift']?></td>
						<td><?=$showdata['regu']?></td>
                        <td><?=$showdata['jam']?></td>
                        <td><?=$showdata['nomor_palet']?></td>
						<td><?=$showdata['jumlah']?></td>
						<td style="text-align:center">
							<button data-toggle="modal" data-target="#koreksiJumlah<?=$trimLabel?>" class="btn btn-warning"><i class="fa fa-edit" ></i></button>
						</td>
						<td style="text-align:center">
							<a href="page/serah_terima/cetakLabelReprint.php?id=<?=$trimLabel?>" class="btn btn-info"><i class="fa fa-print" ></i></a>
						</td>
						<td style="text-align:center">
							<a href="?page=cetakLabel&aksi=reprint&id=<?=$showdata['nomor_label']?>&id2=hapus" class="btn btn-danger"><i class="fa fa-trash" ></i></a>
						</td>
                    </tr>
						<?php }?>
					<!-- Modal -->
					<div id="koreksiJumlah<?=$trimLabel?>" class="modal fade" role="dialog">
					  <div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Koreksi Jumlah</h4>
						  </div>
						  <div class="modal-body">
							<form method="post">
							<label class="control-label" >Nomor Label:</label>
							<input type="text" name="nomor_label" value="<?=$showdata['nomor_label']?>" class="form-control" style="margin-bottom:5px" readonly>
							<label class="control-label" >Jumlah:</label>
							<input type="number" name="jumlah" value="<?=$showdata['jumlah']?>" class="form-control"/>
							
						  </div>
						  <div class="modal-footer">
							<button type="submit" name="simpan" class="btn btn-default">Simpan</button>
						  </div>
						  </form>
						</div>

					  </div>
					</div>
					<?php }?>
                </tbody>
            </table>
		</div>
		</div>
	</div>
	<?php
		@$no_label 	= $_POST['nomor_label'];
		@$jumlah 	= $_POST['jumlah'];
		@$simpan 	= $_POST['simpan'];
		@$hapus 	= $_GET['id2'];
		@$no_label_hapus 	= $_GET['id'];
		if(isset($hapus)){
			$deleteLabel = pg_query($conn,"DELETE FROM serah_terima WHERE nomor_label='$no_label_hapus'");
			$deleteMap	 = pg_query($conn,"DELETE FROM tbl_load_fg WHERE nomor_label='$no_label_hapus'");
			if($deleteLabel){
				?>
				<script>
					alert("Data Berhasil di Hapus");
					window.location.href="index.php?page=cetakLabel&aksi=reprint";
				</script>
				<?php
			}
		}
		if(isset($simpan)){
			$updateJumlah = pg_query($conn,"UPDATE serah_terima SET jumlah='$jumlah' WHERE nomor_label='$no_label'");
			if($updateJumlah){
				?>
				<script>
					alert("Data Berhasil di ubah");
					window.location.href="index.php?page=cetakLabel&aksi=reprint";
				</script>
				<?php
			}
		}
	?>
	
	