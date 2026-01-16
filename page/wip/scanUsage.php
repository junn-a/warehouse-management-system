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
				<input class="form-control" id="txtInput" name="kode_produk" type="text" autofocus required/>
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
			
			@$selectProduk 	= pg_query($conn,"SELECT * FROM serah_terima WHERE nomor_label='$id' AND status=2");
			@$fetchProduk 	= pg_fetch_array($selectProduk);
			
			@$selectLokasi 	= pg_query($conn,"SELECT * FROM tbl_load_fg WHERE nomor_label='$id'");
			@$fetchLokasi	= pg_fetch_array($selectLokasi);
			if($fetchLokasi['zone'] == 10){
				$area = "PC 32";
			}elseif($fetchLokasi['zone'] == 11){
					$area = "PC 14";
			}elseif($fetchLokasi['zone'] == 12){
					$area = "TS";
			}elseif($fetchLokasi['zone'] == 13){
					$area = "FCP";
			}elseif($fetchLokasi['zone'] == 14){
					$area = "TWS 5.6";
			}elseif($fetchLokasi['zone'] == 15){
					$area = "STANDING POUCH";
			}elseif($fetchLokasi['zone'] == 16){
					$area = "TWS 7.2";
			}elseif($fetchLokasi['zone'] == 17){
					$area = "CASSAVA";
			}
			
			@$selectZone 	= pg_query($conn,"SELECT nama FROM tbl_master_zone WHERE id='$_GET[idUrut]'");
			@$fetchZone 		= pg_fetch_array($selectZone);
			
			@$cekProduk 	= pg_num_rows($selectProduk);
			@$selectTujuan 	= pg_query($conn,"SELECT * FROM master_eksport");
			
			if($cekProduk > 0 ){
				?>
			<div class="panel-body" style="">
				<form class="form-horizontal" method="post" action="page/wip/cetakLabelUsage.php" onsubmit="updateStatus()">
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
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="tanggal_produksi" value="<?=$tgl?>"  readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Kode Material:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control" id="" name="kode_material" value="<?=$fetchProduk['kode_material'] ?>" readonly required>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">No Batch:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control" id="" name="batch" value="<?=$id ?>" readonly required>
							  </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Jumlah/Pallet:</label>
							  <div class="col-sm-4">
								<input type="hidden" id="status-input" name="status" value="">
								<input type="checkbox" id="jumlah-pallet" checked data-toggle="toggle" data-class="fast"  data-on="Full" data-off="Parsial" data-onstyle="info" data-offstyle="danger" data-width="100%">
								
							  </div>
							  <label class="control-label col-sm-2" style="text-align:left">Jumlah:</label>
							  <div class="col-sm-3" id="jumlah">
								
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Operator:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="user_serah" value="<?=$_SESSION['username']?>" readonly>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-3" style="text-align:left">Lokasi Simpan:</label>
							  <div class="col-sm-9">
								<input type="text" class="form-control"  name="zone" value="<?=$area?>" readonly>
							  </div>
							</div>
						</div>
						
						<div class="row" style="margin-left:25px;margin-right:25px">
							<div class="form-group">
							  <button name="simpan" class="btn btn-block btn-warning"><b style="font-size:15px"><i class="fa fa-save"></i> Pakai WIP</b></button>
							</div>
						</div>
					</div>
				</form>
			</div>	
			<?php }?>
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
			
$(document).ready(function(){
$('#jumlah-pallet').change(function() {
	
	if($(this).is(":checked")){
	   //do something
	   $('#jumlah').html('<input type="text" class="form-control"  name="jumlah" value="<?=$fetchProduk['jumlah']?>" readonly required>');
	} else{
	   $('#jumlah').html('<input type="text" class="form-control"  name="jumlah" value="<?=$fetchProduk['jumlah']?>" required>');        
	}
	

	})  
$('#jumlah-pallet').ready(function() {
	$('#jumlah').html('<input type="text" class="form-control"  name="jumlah" value="<?=$fetchProduk['jumlah']?>" readonly>');
	
	})  
});				

// status
function updateStatus() {
  var checkbox = document.getElementById("jumlah-pallet");
  var statusInput = document.getElementById("status-input");

  if (checkbox.checked) {
    statusInput.value = "on";
  } else {
    statusInput.value = "off";
  }
}

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
		