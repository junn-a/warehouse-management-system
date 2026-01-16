<!doctype html>
<html lang="en">
  <head>
	<link rel="icon" type="image/png" href="assets/img/Z00.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ProdIT | Serah Terima</title>
    <!-- Bootstrap core CSS -->
	<link href="../../assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../../assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../../assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
	<style>
	.garisBawahNone{
		text-decoration: none;
	}
	.dropdown-submenu {
	  position: relative;
	}

	.dropdown-submenu .dropdown-menu {
	  top: 0;
	  left: 100%;
	  margin-top: -1px;
	}
	
	html, body {
	margin:0;
	padding:0;
	height:100%;
	}

	.container {
	  position:relative;
	  min-height: 100%;
	}
	.footer {
	   position: fixed;
	   left: 0;
	   bottom: 0;
	   width: 100%;
	   background-color: red;
	   color: white;
	   text-align: center;
	}
	.btn-outline{
		border: 2px solid black;
		background-color: white;
		color: black;
		padding: 10px 28px;
		font-size: 16px;
		cursor: pointer;
		border-radius:10px;
	}
	.success {
	  border-color: #4CAF50;
	  color: green;
	}
	</style>
  </head>
  <body>
	<?php
		include "../../connection.php";
		session_start();
		$date   = date("Y-m-d");
		$no     = 1;
		$shift  = $_SESSION['shift'];
		$regu  	= $_SESSION['regu'];
		$kode_material 		= $_GET['id1'];
		$kode_line			= $_GET['id4'];
		$tanggal_produksi 	= $_GET['id5'];
		$tujuan 			= $_GET['id3'];
		$jenis_produk		= $_GET['id2'];
		
		$selectNamaProduk 	= mysqli_query($conn3,"SELECT nama_produk FROM master_produk WHERE kode_material='$kode_material'");
		$fetchNamaProduk 	= mysqli_fetch_assoc($selectNamaProduk); 
		
		$selectLine 		= mysqli_query($conn3,"SELECT * FROM master_line WHERE kode_line='$kode_line'");
		$fetchLine		 	= mysqli_fetch_assoc($selectLine); 
	?>
    <h3 style="text-align:center">F02 /SFCKP - WH - 03</h3>
	<p style="font-size:15px">PT INDOFOOD FRITOLAY MAKMUR</p>
	<p style="font-size:10px">PLANT CIKUPA</p>
	<h4 style="text-align:center">TANDA TERIMA BARANG JADI</h4>
	<table class="">
		<tr>
			<td width="120px">Kode Material</td>
			<td width="20px">:</td>
			<td width="250px"><?=$kode_material?></td>
			<td width="120px">Line</td>
			<td width="20px">:</td>
			<td><?=$fetchLine['nama_line']?></td>
		</tr>
		<tr>
			<td>Nama Produk</td>
			<td>:</td>
			<td><?=$fetchNamaProduk['nama_produk']?></td>
			<td>Jenis Produksi</td>
			<td>:</td>
			<td><?php if($jenis_produk == 1){echo "Lokal";}else{echo "Ekspor";}?></td>
		</tr>
		<tr>
			<td>Tanggal Produksi</td>
			<td>:</td>
			<td><?=$tanggal_produksi?></td>
			<td>Tujuan</td>
			<td>:</td>
			<td><?=$tujuan?></td>
		</tr>
		<tr>
			<td>Regu/ Shift</td>
			<td>:</td>
			<td><?=$regu."/".$shift?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<table class="table" style="font-size:10px">
		<tr>
			<th>No</th>
			<th>Label</th>
			<th>Print Out</th>
			<th>Terima FG</th>
			<th>Jml</th>
		</tr>
		<?php
			$arrayData = array();
			$selectLabel = mysqli_query($conn3,"SELECT * FROM serah_terima WHERE kode_material='$kode_material' && tanggal_produksi='$tanggal_produksi' && kode_line='$kode_line' && regu='$regu' && shift='$shift' && jenis_produk='$jenis_produk' ORDER BY nomor_palet ASC");
			$data = mysqli_fetch_all($selectLabel, MYSQLI_ASSOC);
			foreach($data AS $key => $value){
				$arrayData[$value['nomor_label']] = array(
					'jam' 		=> $value['jam'],
					'jumlah' 	=> $value['jumlah'],
					'nomor_label' => $value['nomor_label']
				);
				$selectJam = mysqli_query($conn3,"SELECT * FROM tbl_gate_fg WHERE nomor_label='$value[nomor_label]'");
				$row = mysqli_fetch_array($selectJam);
				$isi = "-";
				if(!empty($row)){
					$isi = $row['jam'];
				}
				$arrayData[$value['nomor_label']]['jamTerima'] = $isi;
			}
			foreach($arrayData AS $table => $tab){
		?>
		<tr>
			<td><?=$no++?></td>
			<td><?=$tab['nomor_label'];?></td>
			<td><?=$tab['jam'];?></td>
			<td><?=$tab['jamTerima'];?></td>
			<td><?=$tab['jumlah'];?></td>
		</tr>
		<?php }?>
	</table>
	<div class="col-md-6">
	
	</div>
	<table class="table" style="float:left;width:30%">
		<tr>
			<td>Jumlah Di Serahkan</td>
			<?php
			$selectJmlPrint = mysqli_query($conn3,"SELECT SUM(jumlah) AS jmlPrint FROM serah_terima WHERE kode_material='$kode_material' && tanggal_produksi='$tanggal_produksi' && kode_line='$kode_line' && regu='$regu' && shift='$shift' && jenis_produk='$jenis_produk'");
			$fetchJmlPrint = mysqli_fetch_array($selectJmlPrint);
			?>
			<td><?=$fetchJmlPrint['jmlPrint']?></td>
		</tr>
		<tr>
			<td>Jumlah Di Terima</td>
			<?php
			$selectJmlSerah = mysqli_query($conn3,"SELECT SUM(jumlah) AS jmlSerah FROM serah_terima WHERE kode_material='$kode_material' && tanggal_produksi='$tanggal_produksi' && kode_line='$kode_line' && regu='$regu' && shift='$shift' && status='2' && jenis_produk='$jenis_produk'");
			$fetchJmlSerah = mysqli_fetch_array($selectJmlSerah);
			?>
			<td><?=$fetchJmlSerah['jmlSerah']?></td>
		</tr>
		<tr>
			<td>Selisih</td>
			<td><?=$fetchJmlPrint['jmlPrint']-$fetchJmlSerah['jmlSerah']?></td>
		</tr>
	</table>
	<table class="" style="">
		<tr>
			<td width="200px" style="text-align:center">Shift SPV/ Kasie</td>
			<td width="200px" style="text-align:center">Checker (Prod)</td>
		</tr>
	</table>
    <!-- Bootstrap core JavaScript-->
    <script src="assets/jquery/jquery.min.js"></script>
	<script src="assets/jquery/jquery.sparkline.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>	
	<script src="assets/js/jquery-3.3.1.js"></script>
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/bootstrap-toggle.min.js"></script>
	<script>
		
		$(document).ready(function() {
			$('#dataTable').DataTable( {
				"paging"	: true,
				"ordering"	: true,
				"info"		: true
			} );
			$('#dataTableReport').DataTable( {
				"searching"	:   false,
				"paging"	:   true,
				"ordering"	: 	false,
				"info"		:   false
			} );
		} );
		
		$(document).ready(function(){
		  $('.dropdown-submenu a.test').on("click", function(e){
			$(this).next('ul').toggle();
			e.stopPropagation();
			e.preventDefault();
		  });
		});
	</script>
  </body>
</html>
