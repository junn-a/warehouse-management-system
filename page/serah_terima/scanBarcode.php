<?php


// code agar tidak double print 
if (!isset($_SESSION['submit'])) {
	$_SESSION['submit'] = true;
}
?>
	<script src="assets/js/jquery.min.js"></script>	
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
			  <div class="btn-group" role="group">
				<a href="?page=cetakLabel&aksi=scanBarcode&idSec=<?=$_GET['idSec']?>&idUrut=<?=$_GET['idUrut']?>&id=1" type="button" class="btn btn-default <?php if(@$_GET['id']==1){echo 'active';}?>">Lokal</a>
			  </div>
			  <div class="btn-group" role="group">
				<a href="?page=cetakLabel&aksi=scanBarcode&idSec=<?=$_GET['idSec']?>&idUrut=<?=$_GET['idUrut']?>&id=2" type="button" class="btn btn-default <?php if(@$_GET['id']==2){echo 'active';}?>">Ekspor</a>
			  </div>
			  <div class="btn-group" role="group">
				<a href="?page=cetakLabel&aksi=scanBarcode&idSec=<?=$_GET['idSec']?>&idUrut=<?=$_GET['idUrut']?>&id=3" type="button" class="btn btn-default <?php if(@$_GET['id']==3){echo 'active';}?>">Lokal Cut Off</a>
			  </div>
			</div>
		</div>
		<?php
			if($_GET['id'] ==  1 || $_GET['id'] ==  3){
				?>
				<div class="panel-body">
					<form method="post">
						<input class="form-control" name="kode_produk" type="text" autofocus required/>
					</form>
				</div>
				<?php
			}else{
				$queryOtf = pg_query($conn,"SELECT * FROM tbl_export WHERE status='AKTIF'");
				?>
				<div class="panel-body">
					<form method="post">
						<div class="row">
							<div class="col-md-10">
								<select class="form-control" name="otf">
								<?php 
									while($dataOtf = pg_fetch_assoc($queryOtf)){
									?>
									<option value="<?= $dataOtf['otf']."|".$dataOtf['singkatan']."|".$dataOtf['barcode'] ?>">
										<?= $dataOtf['otf']."-".$dataOtf['singkatan']."-".$dataOtf['nama_produk']." TARGET:".$dataOtf['target']." Car" ?>
									</option>
									<?php }?>
								</select>
							</div>
							<div  class="col-md-2">
								<button type="submit" class="btn btn-info btn-block">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<?php
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					@$otfValue = $_POST['otf'];
					list($otf, $singkatan, $barcode) = explode('|', $otfValue);
				
				}
			}
			
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
				@$id 			= $barcode;
			}
			
			$selectZone 	= pg_query($conn,"SELECT nama FROM tbl_master_zone WHERE id='$_GET[idUrut]'");
			$fetchZone 		= pg_fetch_array($selectZone);
			
			@$selectProduk 	= pg_query($conn,"SELECT * FROM master_produk WHERE barcode_karton='$id' AND status='A'");
			@$fetchProduk 	= pg_fetch_array($selectProduk);
			@$cekProduk 	= pg_num_rows($selectProduk);
			@$selectTujuan 	= pg_query($conn,"SELECT * FROM master_eksport");
			if($cekProduk > 0 AND @$_GET['id'] == 1){
				?>
			<div class="panel-body" style="">
			<?php
				if($_GET['idSec'] >= 5){
					?>
					<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel2.php">
					<?php
				}else{
					?>
					<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel.php">
					<?php
				}
			?>
				<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel.php">
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
				var nama_produk	= document.getElementById("nama_produk").value;
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
			
				<?php
					if($_GET['idSec'] >= 5){
						?>
						<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel2.php">
						<?php
					}else{
						?>
						<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel.php">
						<?php
					}
				?>
					
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
								<?php
									$selectNoPallet = pg_query($conn,"SELECT MAX(nomor_palet) AS no_update FROM serah_terima WHERE kode_material='$fetchProduk[kode_material]' AND shift='$_SESSION[shift]' AND tanggal_produksi='$tgl' AND regu='$_SESSION[regu]' AND jenis_produk=2");
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
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">Tujuan:</label>
							  <div class="col-sm-5">
								<input type="text" class="form-control"  name="tujuan" value="<?=$singkatan?>" hidden>
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
							<div class="form-group" hidden>
							  <label class="control-label col-sm-3" style="text-align:left">OTF:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control" id="otf" name="otf" value="<?=$otf?>">
							  </div>
							</div>
							<div class="form-group" >
							  <label class="control-label col-sm-3" style="text-align:left">Status Penanganan:</label>
							  <div class="col-sm-9">
								<select class="form-control" name="status_penanganan">
									<option value="1">Cek Kempes</option>
									<option value="2">Cek Kempes & Tempel Sticker</option>
								</select>
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
				
				
				
				$(document).ready(function(){
					$(".output").val('<?=$dateNoLabel?>'+regu+shift+line+nama_produk+'-'+no_pallet+'E'+'<?=$singkatan?>');
				});
			});
			</script>
				<?php
			}elseif($cekProduk > 0 AND @$_GET['id'] == 3){
			?>
			<div class="panel-body" style="">
				<?php
					if($_GET['idSec'] >= 5){
						?>
						<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel2.php">
						<?php
					}else{
						?>
						<form class="form-horizontal" method="post" action="page/serah_terima/cetakLabel.php">
						<?php
					}
				?>
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
				var nama_produk	= document.getElementById("nama_produk").value;
				var no_pallet			= document.getElementById("no_pallet").value;
				no_pallet = no_pallet.toString().padStart(4, '0');
				
				
				
				$(document).ready(function(){
					$(".output").val('<?=$dateNoLabel?>'+regu+shift+line+nama_produk+'-'+no_pallet+'CO');
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
		