<?php
	include "connection.php";
	include "assets/phpqrcode/qrlib.php";
	date_default_timezone_set('Asia/Jakarta');
	$time 		= date("H:i:s");
	$date	 	= date("Y-m-d");
	session_start();

	
	if(@$_SESSION['status']!= "login"){
		header("location:login.php");
	}
?>
<!doctype html>
<html lang="en">
  <head>
	<link rel="icon" type="image/png" href="assets/img/wholesale.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ProdIT | Serah Terima</title>
    <!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
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
	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
     <a class="navbar-brand" href="index.php" style="color:white">Production Departement - Serah Terima</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown"><a class="dropdown-toggle" type="" data-toggle="dropdown"><img style="border-radius:50%" src="assets/img/user/avatar5.png" width="20px"/> User</a>
			<ul class="dropdown-menu">
			  <li><a href="#" data-target="#changePassword" data-toggle="modal"><span class="fa fa-gears"></span> Change Password</a></li>
			  <li class="divider"></li>
			  <li><a href="#"><span class="fa fa-book"></span> Documentation</a></li>
			</ul>
		</li>
      </ul>
    </div>
  </div>
</nav>
    <div class="container" style="">
		<?php
		// DASHBOARD
		if(@$_GET['page'] == '' || @$_GET['page'] == 'home'){
			include 'page/dashboard/dashboard.php';
		}
		// Page Lokal OR Import 
		elseif(@$_GET['page'] == 'cetakLabel' && @$_GET['aksi'] == 'jenisProduk'){
			include 'page/serah_terima/jenisProduk.php';
		}
		// Page Label
		elseif(@$_GET['page'] == 'cetakLabel' && @$_GET['aksi'] == 'scanBarcode'){
			include 'page/serah_terima/scanBarcode.php';
		}
		// Print Label
		elseif(@$_GET['page'] == 'cetakLabel' && @$_GET['aksi'] == 'printDirect'){
			include 'page/serah_terima/printDirect.php';
		}
		//Re - Print
		elseif(@$_GET['page'] == 'cetakLabel' && @$_GET['aksi'] == 'reprint'){
			include 'page/serah_terima/indexReprint.php';
		}
		//Koreksi label
		elseif(@$_GET['page'] == 'cetakLabel' && @$_GET['aksi'] == 'koreksiLabel'){
			include 'page/serah_terima/indexKoreksiLabel.php';
		}
		// Monitoring Serah Terima Produksi ke FG
		elseif(@$_GET['page'] == 'monitoringSerahTerima' && @$_GET['aksi'] == 'produksiToFg'){
			include 'page/monitoringSerahTerima/indexMonitoring.php';
		}
		// Gate FG
		elseif(@$_GET['page'] == 'gateFG' && @$_GET['aksi'] == 'barcode'){
			include 'page/gateFG/indexGateFG.php';
		}
		// Gate Logistik
		elseif(@$_GET['page'] == 'gateLog' && @$_GET['aksi'] == 'index'){
			include 'page/gateLog/indexGateLog.php';
		}
		elseif(@$_GET['page'] == 'gateLog' && @$_GET['aksi'] == 'barcode'){
			include 'page/gateLog/barcodeLogistik.php';
		}
		// Laporan Serah Terima FG
		elseif(@$_GET['page'] == 'laporanSerahTerima' && @$_GET['aksi'] == 'master'){
			include 'page/laporanSerahTerima/laporanSerahTerima.php';
		}
		elseif(@$_GET['page'] == 'laporanSerahTerima' && @$_GET['aksi'] == 'print'){
			include 'page/laporanSerahTerima/printLaporanSerahTerima.php';
		}
		// FG to Logistik
		elseif(@$_GET['page'] == 'monitoringSerahTerimaLog' && @$_GET['aksi'] == 'fgToLog'){
			include 'page/monitoringSerahTerimaLog/indexMonitoringLog.php';
		}
		// Page Not Found
		elseif(@$_GET['page'] == 'pageNotFound'){
			include 'page/pageNotFound/pageNotFound.php';
		}
		// Laporan Serah Terima Logistik
		elseif(@$_GET['page'] == 'laporanSerahTerimaLog' && @$_GET['aksi'] == 'master'){
			include 'page/laporanSerahTerimaLog/laporanSerahTerimaLog.php';
		}
		// Mapping Posisi Pallet
		elseif(@$_GET['page'] == 'posisi'){
			include 'page/posisi/indexPosisi.php';
		}
		// Mapping Posisi Pallet
		elseif(@$_GET['page'] == 'resumeLoad'){
			include 'page/posisi/resumeLoad.php';
		}
		// Mapping Posisi Pallet
		elseif(@$_GET['page'] == 'mappingPalet'){
			include 'page/mapingPalet/indexMapingPalet.php';
		}elseif($_GET['page'] == 'deleteMapping'){
			include 'page/mapingPalet/deleteMapping.php';
		}
		// Master GI
		elseif(@$_GET['page'] == 'masterGis' && @$_GET['aksi'] == 'index'){
			include 'page/masterGI/indexGis.php';
		}
		elseif(@$_GET['page'] == 'masterGis' && @$_GET['aksi'] == 'hapus'){
			include 'page/masterGI/hapusGis.php';
		}
		
		elseif(@$_GET['page'] == 'masterGI' && @$_GET['aksi'] == 'index'){
			include 'page/masterGI/indexMasterGI.php';
		}elseif(@$_GET['page'] == 'masterGI' && @$_GET['aksi'] == 'detail'){
			include 'page/masterGI/detailMasterGI.php';
		}elseif(@$_GET['page'] == 'masterGI' && @$_GET['aksi'] == 'hapus'){
			include 'page/masterGI/aksiHapus.php';
		}
		// Jadwal Produksi
		elseif(@$_GET['page'] == 'jadwalProduksi' && @$_GET['aksi'] == 'index'){
			include 'page/jadwalProduksi/indexMasterJadwalProduksi.php';
		}elseif(@$_GET['page'] == 'jadwalProduksi' && @$_GET['aksi'] == 'detail'){
			include 'page/jadwalProduksi/detailMasterJadwalProduksi.php';
		}elseif(@$_GET['page'] == 'jadwalProduksi' && @$_GET['aksi'] == 'hapus'){
			include 'page/jadwalProduksi/aksiHapus.php';
		}
		// Master Produk
		elseif(@$_GET['page'] == 'masterProduk' && @$_GET['aksi'] == 'index'){
			include 'page/masterProduk/indexMasterProduk.php';
		}elseif(@$_GET['page'] == 'masterProduk' && @$_GET['aksi'] == 'tambahProduk'){
			include 'page/masterProduk/tambahProduk.php';
		}elseif(@$_GET['page'] == 'masterProduk' && @$_GET['aksi'] == 'hapusProduk'){
			include 'page/masterProduk/hapusProduk.php';
		}elseif(@$_GET['page'] == 'masterProduk' && @$_GET['aksi'] == 'ubahProduk'){
			include 'page/masterProduk/ubahProduk.php';
		}
		// Stock Opname
		elseif(@$_GET['page'] == 'stockOpname' && @$_GET['aksi'] == 'index'){
			include 'page/stockOpname/indexStockOpname.php';
		}
		// Master User
		elseif(@$_GET['page'] == 'masterUser' && @$_GET['aksi'] == 'index'){
			include 'page/masterUser/indexMasterUser.php';
		}elseif(@$_GET['page'] == 'masterUser' && @$_GET['aksi'] == 'tambahUser'){
			include 'page/masterUser/tambahUser.php';
		}elseif(@$_GET['page'] == 'masterUser' && @$_GET['aksi'] == 'hapusUser'){
			include 'page/masterUser/hapusUser.php';
		}elseif(@$_GET['page'] == 'masterUser' && @$_GET['aksi'] == 'ubahUser'){
			include 'page/masterUser/ubahUser.php';
		}
		//WIP Produce
		elseif(@$_GET['page'] == 'wip'){
			 include 'page/wip/indexWip.php';
		}elseif(@$_GET['page'] == 'posisiWip'){
			 include 'page/wip/indexPosisiWip.php';
		}elseif(@$_GET['page'] == 'cetakLabelWip' && @$_GET['aksi'] == 'scanBarcode'){
			include 'page/wip/scanBarcode.php';
		}elseif(@$_GET['page'] == 'cetakRekapUsage'){
			 include 'page/wip/cetakRekapUsage.php';
		}
		
		//WIP Usage
		elseif(@$_GET['page'] == 'wipUsage'){
			 include 'page/wipUsage/indexWipUsage.php';
		}elseif(@$_GET['page'] == 'scanUsage'){
			 include 'page/wipUsage/scanUsage.php';
		}
		//WIP Stock
		elseif(@$_GET['page'] == 'wipStock'){
			 include 'page/wipStock/indexWipStock.php';
		}elseif(@$_GET['page'] == 'cekHasilPromina'){
			 include 'page/wipStock/cekHasilPromina.php';
		}elseif(@$_GET['page'] == 'detailPakaiWip'){
			 include 'page/wipStock/detailPakaiWip.php';
		}
		// Master Export
		elseif(@$_GET['page'] == 'masterExport' && @$_GET['aksi'] == 'index'){
			include 'page/masterExport/indexMasterExport.php';
		}elseif(@$_GET['page'] == 'masterExport' && @$_GET['aksi'] == 'tambahExport'){
			include 'page/masterExport/tambahExport.php';
		}elseif(@$_GET['page'] == 'masterExport' && @$_GET['aksi'] == 'hapusExport'){
			include 'page/masterExport/hapusExport.php';
		}elseif(@$_GET['page'] == 'masterExport' && @$_GET['aksi'] == 'ubahExport'){
			include 'page/masterExport/ubahExport.php';
		}
		// Monitoring Export
		elseif(@$_GET['page'] == 'monitoringExport' && @$_GET['aksi'] == 'index'){
			include 'page/masterExport/indexMonitoringExport.php';
		}elseif(@$_GET['page'] == 'statusEkspor' && @$_GET['updateStatus'] == 'index'){
			include 'page/masterExport/updateStatusEkspor.php';
		}
	  ?>
    </div>
	<footer class="footer" style="margin-top:20px;background-color:black;padding-top:10px" >
      <div class="container">
        <div class="row">
			<a href="index.php" style="color:white" class="col-xs-4"><span style="font-size:20px;padding-bottom:5px" class="fa fa-home"></span></a>
			<a href="javascript:history.back()" style="color:white" class="col-xs-4"><span style="font-size:20px" class="fa fa-undo"></span></a>
			<a href="login.php" style="color:white" class="col-xs-4"><span style="font-size:20px" class="fa fa-power-off"></span></a>
		</div>
      </div>
    </footer>
	
	 <!-- Modal -->
	  <div class="modal fade" id="changePassword" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title"><span class="fa fa-gears"></span> Change Password</h4>
			</div>
			<div class="modal-body">
			  <form class="form-horizontal" action="changePassword.php" method="post">
				<div class="form-group" hidden>
				  <label class="control-label col-sm-3">Username :</label>
				  <div class="col-sm-9">
					<input type="text" class="form-control" value="<?=$_SESSION['Username']?>" name="username">
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-3">Old Password :</label>
				  <div class="col-sm-9">
					<input type="password" class="form-control" placeholder="Enter Old Password" name="oldPassword">
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-3">New Password :</label>
				  <div class="col-sm-9">
					<input type="password" class="form-control" placeholder="Enter New Password" name="newPassword">
				  </div>
				</div>
			  
			</div>
			<div class="modal-footer">
			  <button type="submit" class="btn btn-danger">Change Password</button>
			</div>
			</form>
		  </div>
		  
		</div>
	  </div>
    <!-- Bootstrap core JavaScript-->
    <script src="assets/jquery/jquery.min.js"></script>
	<script src="assets/jquery/jquery.sparkline.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>	
	<script src="assets/js/jquery-3.3.1.js"></script>
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/bootstrap-toggle.min.js"></script>
	<script src="assets/js/highcharts/highcharts.js"></script>
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
