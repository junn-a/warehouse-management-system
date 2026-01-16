<?php
	$time 		= date("His");
	if($_SESSION['shift'] == 3 AND $time >0 AND $time < 70000){
		$date = date('Y-m-d', strtotime("-1 day", strtotime($date )));
		 $selectLabel = pg_query($conn,"SELECT serah_terima.*, master_produk.nama_produk  FROM serah_terima INNER JOIN master_produk ON serah_terima.kode_material=master_produk.kode_material WHERE serah_terima.tanggal_produksi='$date' AND serah_terima.shift='$_SESSION[shift]' AND serah_terima.regu='$_SESSION[regu]' AND serah_terima.jam<='22:00:00' ORDER BY serah_terima.jam DESC LIMIT 20");
	}else{
		$date	 	= date("Y-m-d");
		$selectLabel = pg_query($conn,"SELECT serah_terima.*, master_produk.nama_produk  FROM serah_terima INNER JOIN master_produk ON serah_terima.kode_material=master_produk.kode_material WHERE serah_terima.tanggal_produksi='$date' AND serah_terima.shift='$_SESSION[shift]' AND serah_terima.regu='$_SESSION[regu]' ORDER BY serah_terima.jam DESC LIMIT 20");
	}
    $no     = 1;   
?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Monitoring Serah Terima</b>
		</div>
		<div class="panel-body">
			<div id="loaderData"></div>
		</div>
	</div>
	
<script src="assets/js/jquery-3.3.1.js"></script>
 <script type="text/javascript">
	$(document).ready(function(){
		setInterval(function(){
			$("#loaderData").load('page/monitoringSerahTerima/loader.php');
		},1000); 
	});
</script>
			