<script src="assets/js/jquery.min.js"></script>	
<?php
	//session_start();
    $no     = 1;
	$jam 			= date("Gis");
			if(@$_SESSION['shift']==3 && $jam > 0 && $jam <70000){
				$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
				$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
				
			}else{
				$tgl = date('Y-m-d');
				$dateNoLabel 	= date('dm');
			}
?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Rekap Laporan Serah Terima FG</b>
		</div>
		<div class="panel-body">
			<?php
				if($_SESSION['level']=="Developer" || $_SESSION['level']=="Supervisor"){
			?>
				<table class="table table-bordered">
					<form>
						<tr>
							<td>
								<select class="form-control" id="regu">
									<option>-Pilih Regu-</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</td>
							<td>
								<select class="form-control" id="shift">
									<option>-Pilih Shift-</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
							</td>
							<td><input type="date" id="tgl" class="form-control "  value=""/></td>
							<td width="">
								<select class="form-control" id="line">
									<option>- Pilih Line -</option>
									<?php 
										$query = pg_query($conn,"SELECT * FROM master_line ORDER BY kode_line ASC");
										while($data = pg_fetch_assoc($query)){
									?>
									<option value="<?=$data['kode_line']?>"><?=$data['nama_line']?></option>
										<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<!--<td>
								<select class="form-control" id="start">
									<option>-Jam Start-</option>
									<option value="14:30:00">14:30</option>
									<option value="19:00:00">19:00</option>
									<option value="22:00:00">22:00</option>
									<option value="03:00:00">03:00</option>
								</select>
							</td> -->
							<td>
								<select class="form-control" id="end">
									<option>-Jam End-</option>
									<option value="14:30:00">14:30</option>
									<option value="19:00:00">19:00</option>
									<option value="22:00:00">22:00</option>
									<option value="03:00:00">03:00</option>
								</select>
							</td>
						</tr>

					</form>
				</table>
			<?php
				}else{
			?>
				<table class="table table-bordered">
					<tr>
						<td>
							<select class="form-control" id="regu" readonly>
								<option>-Pilih Regu-</option>
								<option <?php if($_SESSION['regu']=="A"){echo "selected";}?>>A</option>
								<option <?php if($_SESSION['regu']=="B"){echo "selected";}?>>B</option>
								<option <?php if($_SESSION['regu']=="C"){echo "selected";}?>>C</option>
								<option <?php if($_SESSION['regu']=="D"){echo "selected";}?>>D</option>
							</select>
						</td>
						<td>
							<select class="form-control" id="shift" readonly>
								<option>-Pilih Shift-</option>
								<option <?php if($_SESSION['shift']==1){echo "selected";}?>>1</option>
								<option <?php if($_SESSION['shift']==2){echo "selected";}?>>2</option>
								<option <?php if($_SESSION['shift']==3){echo "selected";}?>>3</option>
							</select>
						</td>
						<td><input type="date" id="tgl" class="form-control line"  value="<?=$tgl?>" readonly/></td>
						<td width="">
							<select class="form-control" id="line">
								<option>- Pilih Line -</option>
								<?php 
										$query = pg_query($conn,"SELECT * FROM master_line ORDER BY kode_line ASC");
										while($data = pg_fetch_assoc($query)){
									?>
									<option value="<?=$data['kode_line']?>"><?=$data['nama_line']?></option>
										<?php } ?>
							</select>
						</td>
					</tr>
				</table>
			<?php
				}
			?>
			
			<div class="output">
			
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#line').change(function(){
				var regu 	= document.getElementById("regu").value;
				var shift 	= document.getElementById("shift").value;
				var tgl 	= document.getElementById("tgl").value;
				//var start 	= document.getElementById("start").value;
				//var end 	= document.getElementById("end").value;
				var id = $(this).val();
				var post = 'id='+ id+'&regu='+ regu+'&shift='+ shift+'&tgl='+ tgl;
				$.ajax({
					type 	: "POST",
					url 	: "page/laporanSerahTerima/loaderLaporanSerahTerima.php",
					data 	: post,
					success :function(ok){
						$(".output").html(ok);
					}
				});
			});
		});
	</script>