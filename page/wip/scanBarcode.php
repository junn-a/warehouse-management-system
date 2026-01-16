<?php

// code agar tidak double print 
if (!isset($_SESSION['submit'])) {
	$_SESSION['submit'] = true;
}
?>
	<script src="assets/js/jquery.min.js"></script>	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Scan Barcode WIP<h4>
		</div>
		<div class="panel-body">
			<form method="post">
				<input class="form-control" id="" name="kode_produk" type="text" autofocus required/>
			</form>
		</div>
		<script>
			var delay = (function(){
			var timer = 0;
			   return function(callback, ms){
				  clearTimeout (timer);
				  timer = setTimeout(callback, ms);
			   };
			})();

			$("#txtInput").on("input", function() {
			   delay(function(){
				  if ($("#txtInput").val().length < 8) {
					  $("#txtInput").val("");
				  }
			   }, 20 );
			});
			
		</script>
		<?php
			$jam 			= date("Gis");
			if(@$_SESSION['shift']==3 AND $jam > 0 AND $jam <70000){
				$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
				$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
				
			}else{
				$tgl = date('Y-m-d');
				$dateNoLabel 	= date('dm');
			}
			if(isset($_POST['kode_produk'])){
				 @$id 			= $_POST['kode_produk'];
			}else{
				@$id 			= "SALAH";
			}
			$selectZone 			= pg_query($conn,"SELECT nama FROM tbl_master_zone WHERE id='$_GET[idUrut]'");
			$fetchZone 			= pg_fetch_array($selectZone);
			@$selectProduk 	= pg_query($conn,"SELECT * FROM master_produk WHERE barcode_karton='$id' AND status='A'");
			@$fetchProduk 	= pg_fetch_array($selectProduk);
			@$cekProduk 		= pg_num_rows($selectProduk);
			@$selectTujuan 	= pg_query($conn,"SELECT * FROM master_eksport");
			if($cekProduk > 0 AND @$_GET['id'] == 1){
				?>
			<div class="panel-body" style="">
				<form class="form-horizontal" method="post" action="page/wip/cetakLabel.php">
					<div class="row">
						<div class="col-md-6" >
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Regu:</label>
							  <div class="col-sm-2">
								<input type="text" class="form-control"  id="regu" name="regu" value="<?=$_SESSION['regu']?>" readonly>
							  </div>
							  <label class="control-label col-sm-1" >Shift:</label>
							  <div class="col-sm-2">
								<input type="text" class="form-control" id="shift"  name="shift" value="<?=$_SESSION['shift']?>" readonly>
							  </div>
							  <label class="control-label col-sm-1">Jam:</label>
							  <div class="col-sm-3">
								<input type="text" class="form-control"  name="jam" value="<?=$time?>" readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Tanggal:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  name="tanggal_produksi" value="<?=$tgl?>"  readonly>
							  </div>
							  <label class="control-label col-sm-1">Line:</label>
							  <div class="col-sm-3">
								<select class="form-control" id="kode_line" name="kode_line" required>
									<?php
										//$selectLine = pg_query($conn, "SELECT detil_line.kode_line, master_line.nama_line FROM detil_line, master_line WHERE detil_line.kode_material='$fetchProduk[kode_material]' GROUP BY detil_line.kode_line");
										$selectLine = pg_query($conn, "SELECT detil_line.kode_line,nama_line FROM detil_line INNER JOIN master_line ON master_line.kode_line=detil_line.kode_line WHERE kode_material='$fetchProduk[kode_material]'");
										while($showLine = pg_fetch_array($selectLine)){
											?>
											<option value="<?=$showLine['kode_line']?>"><?=$showLine['nama_line']?></option>
											<?php
										}
									?>
								</select>	
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Nama Produk:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  name="kode_material" value="<?=$fetchProduk['kode_material']?>"  readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Nama Produk:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  name="nama_produk" value="<?=$produk =$fetchProduk['nama_produk']?>"  readonly>
							  </div>
							  <label class="control-label col-sm-2" style="text-align:left">No Pallet:</label>
							  <div class="col-sm-2">
								<?php
									$selectNoPallet = pg_query($conn,"SELECT MAX(nomor_palet) AS no_update FROM serah_terima WHERE kode_material='$fetchProduk[kode_material]' AND shift='$_SESSION[shift]' AND tanggal_produksi='$tgl' AND regu='$_SESSION[regu]'");
									$fetchNoPallet = pg_fetch_array($selectNoPallet);
									
								?>
								<input type="text" class="form-control" id="no_pallet"  name="no_pallet" value="<?=$no_pallet = $fetchNoPallet['no_update']+1;?>" readonly>
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Nama Produk:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  id="nama_produk" value="<?=str_replace(' ', '',$produk)?>" hidden>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">No Label:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control output" id="output" name="no_label" readonly required>
							  </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Jumlah/Pallet:</label>
							  <div class="col-sm-4">
								<input type="checkbox" id="jumlah-pallet" checked data-toggle="toggle" data-class="fast"  data-on="Standart" data-off="Akhiran" data-onstyle="info" data-offstyle="danger" data-width="100%" value="1">
							  </div>
							  <label class="control-label col-sm-2" style="text-align:left">Jumlah:</label>
							  <div class="col-sm-3" id="jumlah">
								
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Checker:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="user_serah" value="<?=$_SESSION['username']?>" readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Shift SPV/Kasie:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="user_terima" value="<?=$_SESSION['kasie_prod']?>" readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Lokasi Simpan:</label>
							  <div class="col-sm-9">
								<select class="form-control" name="id_zona" required>
									<option value="10"> PC 32 </option>
									<option value="11"> PC 14 </option>
									<option value="12"> TS </option>
									<option value="13"> FCP </option>
									<option value="14"> TWS 5.6</option>
									<option value="15"> STANDING POUCH </option>
									<option value="16"> TWS 7.2 </option>
									<option value="17"> CASSAVA </option>
								</select>
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Lokasi Simpan:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="lokasi_simpan" value="<?=$_GET['idUrut']?>" readonly>
							  </div>
							</div>
							
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Jenis produk:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="jenis_produk" value="<?=$_GET['id']?>">
							  </div>
							</div>
						</div>
						
						<div class="row" style="margin-left:25px;margin-right:25px">
							<div class="form-group">
							  <button name="simpan" class="btn btn-block btn-success"><b style="font-size:15px"><i class="fa fa-save"></i> Simpan</b></button>
							</div>
						</div>
					</div>
				</form>
			</div>	
			<script type="text/javascript">
			$(document).ready(function(){
				var regu 				= document.getElementById("regu").value;
				var shift 				= document.getElementById("shift").value;
				var line 				= document.getElementById("kode_line").value;
				var nama_produk			= document.getElementById("nama_produk").value;
				var no_pallet			= document.getElementById("no_pallet").value;
				
				
				
				$(document).ready(function(){
					$(".output").val('<?=$dateNoLabel?>'+regu+shift+line+nama_produk+'-'+no_pallet);
				});
			});
			</script>
				<?php
			}elseif($cekProduk > 0 AND @$_GET['id'] == 2){
				?>
			<div class="panel-body" style="">
				<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel.php">
					<div class="row">
						<div class="col-md-12" >
							<div class="form-group">
								  <div class="col-sm-12">
									<select class="form-control" id="tujuan" name="tujuan" required>
										<option value="">- Pilih Negara Tujuan -</option>
										<?php
											while($showTujuan = pg_fetch_array($selectTujuan)){
												?>
												<option value="<?=$showTujuan['singkatan']?>"><?=$showTujuan['singkatan']?></option>
												<?php
											}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6" >
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Regu:</label>
							  <div class="col-sm-2">
								<input type="text" class="form-control"  id="regu" name="regu" value="<?=$_SESSION['regu']?>" readonly>
							  </div>
							  <label class="control-label col-sm-1" >Shift:</label>
							  <div class="col-sm-2">
								<input type="text" class="form-control" id="shift"  name="shift" value="<?=$_SESSION['shift']?>" readonly>
							  </div>
							  <label class="control-label col-sm-1">Jam:</label>
							  <div class="col-sm-3">
								<input type="text" class="form-control"  name="jam" value="<?=$time?>" readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Tanggal:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control" id="tanggal_produksi"  name="tanggal_produksi" value="<?=$tgl?>"  readonly>
							  </div>
							  <label class="control-label col-sm-1">Line:</label>
							  <div class="col-sm-3">
									<?php
										//$selectLine = pg_query($conn, "SELECT detil_line.kode_line, master_line.nama_line FROM detil_line, master_line WHERE detil_line.kode_material='$fetchProduk[kode_material]' GROUP BY detil_line.kode_line");
										$selectLine = pg_query($conn, "SELECT detil_line.kode_line,nama_line FROM detil_line INNER JOIN master_line ON master_line.kode_line=detil_line.kode_line WHERE kode_material='$fetchProduk[kode_material]'");
										$showLine = pg_fetch_array($selectLine);?>	
								<input type="text" class="form-control" id="kode_line" name="kode_line" value="<?=$showLine['kode_line']?>"  readonly>
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Nama Produk:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  id="kode_material" name="kode_material" value="<?=$fetchProduk['kode_material']?>"  readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Nama Produk:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  name="nama_produk" value="<?=$produk =$fetchProduk['nama_produk']?>"  readonly>
							  </div>
							  <label class="control-label col-sm-2" style="text-align:left">No Pallet:</label>
							  
							  <div class="col-sm-2">
								<input type="text" class="form-control value" id="no_pallet" name="no_pallet" value="" required readonly>
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Nama Produk:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  id="nama_produk" value="<?=str_replace(' ', '',$produk)?>" hidden>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">No Label:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control output" id="output" name="no_label" readonly required>
							  </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Jumlah/Pallet:</label>
							  <div class="col-sm-4">
								<input type="checkbox" id="jumlah-pallet" checked data-toggle="toggle" data-class="fast"  data-on="Standart" data-off="Akhiran" data-onstyle="info" data-offstyle="danger" data-width="100%" value="1">
							  </div>
							  <label class="control-label col-sm-2" style="text-align:left">Jumlah:</label>
							  <div class="col-sm-3" id="jumlah">
								
							  </div>
							</div>
							
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Checker:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="user_serah" value="<?=$_SESSION['username']?>" readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Shift SPV/Kasie:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="user_terima" value="<?=$_SESSION['kasie_prod']?>" readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Lokasi Simpan:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="zone" value="<?=$fetchZone['nama']?>" readonly>
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Lokasi Simpan:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="lokasi_simpan" value="<?=$_GET['idUrut']?>" readonly>
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Id Zone:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="id_zona" value="<?=$_GET['idSec']?>">
							  </div>
							</div>
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Jenis produk:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control" id="jenis_produk" name="jenis_produk" value="<?=$_GET['id']?>">
							  </div>
							</div>
						</div>
						
						<div class="row" style="margin-left:25px;margin-right:25px">
							<div class="form-group">
							  <button type="submit" name="simpan" class="btn btn-block btn-success"><b style="font-size:15px"><i class="fa fa-save"></i> Simpan</b></button>
							</div>
						</div>
						
					</div>
				</form>
			</div>	
			<script type="text/javascript">
			$(document).ready(function(){
				var regu 				= document.getElementById("regu").value;
				var shift 				= document.getElementById("shift").value;
				var line 				= document.getElementById("kode_line").value;
				var nama_produk			= document.getElementById("nama_produk").value;
				var no_pallet			= document.getElementById("no_pallet").value;
				var kode_material		= document.getElementById("kode_material").value;
				var tanggal_produksi 	= document.getElementById("tanggal_produksi").value;
				var jenis_produk	 	= document.getElementById("jenis_produk").value;
				
				$("#tujuan").change(function(){
						
						//$(".output").val('<?=$dateNoLabel?>'+regu+shift+line+nama_produk+'-'+no_pallet+'E'+tujuan);
						var tujuan 	= $(this).val();
						
						//var post 	= 'id='+ id+'&id2='+id2;
						var post 	= 'tujuan='+ tujuan+'&regu='+regu+'&shift='+shift+'&line='+line+'&kode_material='+kode_material+'&tanggal_produksi='+tanggal_produksi+'&jenis_produk='+jenis_produk;
						$.ajax({
							type : "POST",
							url : "page/serah_terima/loaderSerahTerima.php",
							data : post,
							success :function(ok){
								$("#tampil-data").html(ok);
								$(".value").val(ok);
								$(".output").val('<?=$dateNoLabel?>'+regu+shift+line+nama_produk+'-'+no_pallet+'E'+tujuan);
							}
						});
					});
				
				$(document).ready(function(){
					$(".output").val('<?=$dateNoLabel?>'+regu+shift+line+nama_produk+'-'+no_pallet);
				});
			});
			</script>
				<?php
			}
		?>
	</div>
	
	<script type="text/javascript">
					$(document).ready(function(){
					$('#jumlah-pallet').change(function() {
						
						if($(this).is(":checked")){
						   //do something
						   $('#jumlah').html('<input type="text" class="form-control"  name="jumlah" value="<?=$fetchProduk['per_palet']?>" readonly required>');
						} else{
						   $('#jumlah').html('<input type="text" class="form-control"  name="jumlah" value="<?=$fetchProduk['per_palet']?>" required>');        
						}
						

						})  
					$('#jumlah-pallet').ready(function() {
						$('#jumlah').html('<input type="text" class="form-control"  name="jumlah" value="<?=$fetchProduk['per_palet']?>" readonly>');
						
						})  
					});				
		
		$(document).ready(function(){
			$('#toggle-event').change(function() {

				if($(this).is(":checked")){
				   //do something
				   $('#console-event').html('');
				} else{
				   $('#console-event').html('off');        
				} 

			}) 
		  });
	</script>
		