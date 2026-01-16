<script src="assets/js/jquery.min.js"></script>	
<?php
    $no     = 1;
	$jam 			= date("Gis");
	if(@$_SESSION['shift']==3 AND $jam > 0 AND $jam <70000){
		//$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
		$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
	}else{
		//$tgl			= date('Y-m-d');
		$tgl				= date('Y-m-d');
		$dateNoLabel 	= date('dm');
	}
	/*
	$arrayData = array();
	$selectData = pg_query($conn3,"SELECT tbl_master_gi.*, tbl_detail_master_gi.*, master_produk.nama_produk FROM tbl_master_gi, tbl_detail_master_gi, master_produk WHERE tbl_detail_master_gi.id_doc=tbl_master_gi.id_doc AND tbl_master_gi.tanggal='$tgl' AND tbl_master_gi.shift='$_SESSION[shift]' AND tbl_master_gi.regu='$_SESSION[regu]' AND tbl_detail_master_gi.kode_material=master_produk.kode_material");
	$fetchData = pg_fetch_all($selectData,pg_ASSOC);
	foreach($fetchData AS $key => $value){
		$arrayData[$value['kode_material']]= array(
			'no_doc' 		=> $value['id_doc'],
			'kode_material' => $value['kode_material'],
			'nama_produk' 	=> $value['nama_produk'],
			'jumlah' 		=> $value['jumlah']
		);
		
		// Act Carton - Act Pallet - Jenis Produk
		$selectJmlAct = pg_query($conn3,"SELECT SUM(serah_terima.jumlah) AS jmlAct, COUNT(serah_terima.jumlah) AS actPallet, serah_terima.jenis_produk FROM serah_terima, tbl_gate_logistik WHERE serah_terima.nomor_label=tbl_gate_logistik.nomor_label AND tbl_gate_logistik.id_doc='$value[id_doc]' AND serah_terima.kode_material='$value[kode_material]' GROUP BY serah_terima.kode_material");
		$row = pg_fetch_array($selectJmlAct);
		$isi ="-";
		if(!empty($row)){
			$isi = $row['jmlAct'];
		}
		$arrayData[$value['kode_material']]['jmlAct'] = $isi;
		
		$isi2 ="-";
		if(!empty($row)){
			$isi2 = $row['actPallet'];
		}
		$arrayData[$value['kode_material']]['actPallet'] = $isi2;		
		
		$isi3 ="-";
		if(!empty($row)){
			$isi3 = $row['jenis_produk'];
		}
		$arrayData[$value['kode_material']]['jenis_produk'] = $isi3;
		
	}
		*/
?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Rekap Laporan Serah Terima FG to Logistik</b>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="text-align:center">No</th>
							<th style="text-align:center">No Document</th>
							<th style="text-align:center">Product</th>
							<th style="text-align:center">Local/Export</th>
							<th style="text-align:center">Qty GI (car)</th>
							<th style="text-align:center">Qty Act (car)</th>
							<th style="text-align:center">Qty Act (Pallet)</th>
							<th style="text-align:center">Cetak</th>
						</tr>
					</thead>
					<tbody>
					<?php
						//foreach($arrayData AS $table => $tab){
							//$selectData = pg_query($conn,"SELECT tbl_gate_logistik.*, serah_terima.*, SUM(serah_terima.jumlah) AS jml_car, COUNT(serah_terima.jumlah) AS jml_pal, master_produk.nama_produk FROM tbl_gate_logistik, serah_terima, master_produk WHERE master_produk.kode_material=serah_terima.kode_material AND serah_terima.nomor_label=tbl_gate_logistik.nomor_label AND tbl_gate_logistik.regu='$_SESSION[regu]' AND tbl_gate_logistik.shift='$_SESSION[shift]' AND tbl_gate_logistik.tanggal='$tgl' GROUP BY serah_terima.kode_material ORDER BY tbl_gate_logistik.id_doc");
						$arrayData 	= array();
						
						//$selectData = pg_query($conn,"SELECT tbl_gate_logistik.id_doc, SUM(serah_terima.jumlah) AS jml_car, COUNT(serah_terima.jumlah) AS jml_pal, master_produk.nama_produk  FROM tbl_gate_logistik INNER JOIN serah_terima ON serah_terima.nomor_label=tbl_gate_logistik.nomor_label INNER JOIN master_produk ON master_produk.kode_material=serah_terima.kode_material WHERE  tbl_gate_logistik.regu='$_SESSION[regu]' AND tbl_gate_logistik.shift='$_SESSION[shift]' AND tbl_gate_logistik.tanggal='$tgl'  GROUP BY serah_terima.kode_material , tbl_gate_logistik.id_doc, master_produk.nama_produk  ORDER BY tbl_gate_logistik.id_doc");
						
						//$selectData = pg_query($conn, "SELECT tbl_gate_logistik.id_doc, serah_terima.kode_material, master_produk.jenis_produk, SUM(serah_terima.jumlah) AS jml_car, COUNT(serah_terima.jumlah) AS jml_pal, master_produk.nama_produk  FROM tbl_gate_logistik INNER JOIN serah_terima ON serah_terima.nomor_label=tbl_gate_logistik.nomor_label INNER JOIN master_produk ON master_produk.kode_material=serah_terima.kode_material WHERE  tbl_gate_logistik.regu='$_SESSION[regu]' AND tbl_gate_logistik.shift='$_SESSION[shift]' AND tbl_gate_logistik.tanggal='$tgl'  GROUP BY serah_terima.kode_material, master_produk.jenis_produk, tbl_gate_logistik.id_doc, master_produk.nama_produk  ORDER BY tbl_gate_logistik.id_doc");
						$selectData = pg_query($conn, "SELECT tbl_gate_logistik.id_doc, serah_terima.kode_material, SUM(serah_terima.jumlah) AS jml_car, COUNT(serah_terima.jumlah) AS jml_pal, master_produk.nama_produk, serah_terima.jenis_produk FROM tbl_gate_logistik INNER JOIN serah_terima ON serah_terima.nomor_label = tbl_gate_logistik.nomor_label INNER JOIN master_produk ON master_produk.kode_material = serah_terima.kode_material WHERE tbl_gate_logistik.regu = '$_SESSION[regu]' AND tbl_gate_logistik.shift = '$_SESSION[shift]' AND tbl_gate_logistik.tanggal = '$tgl' GROUP BY serah_terima.kode_material, tbl_gate_logistik.id_doc, master_produk.nama_produk, serah_terima.jenis_produk ORDER BY tbl_gate_logistik.id_doc");
						$fetchData = pg_fetch_all($selectData);
						
						if(is_array($fetchData) || is_object($fetchData)){
							foreach($fetchData AS $key => $value){
								$arrayData[$value['kode_material']] = array(
									'id_doc' 		=> $value['id_doc'],
									'kode_material' => $value['kode_material'],
									'jenis_produk' 	=> $value['jenis_produk'],
									'jmlCar' 		=> $value['jml_car'],
									'jmlPal'		=> $value['jml_pal'],
									'nama_produk'	=> $value['nama_produk']
								);
								// Jumlah QTY GI
								$selectGi = pg_query($conn,"SELECT tbl_detail_master_gi.jumlah FROM tbl_detail_master_gi WHERE tbl_detail_master_gi.id_doc='$value[id_doc]' AND tbl_detail_master_gi.kode_material='$value[kode_material]'");
								$row = pg_fetch_array($selectGi);
								$isi ="-";
								if(!empty($row)){
									$isi = $row['jumlah'];
								}
								$arrayData[$value['kode_material']]['jumlah'] = $isi;
							}
						}
						foreach($arrayData AS $table =>$tab){
					?>
						<tr>
							<td><?=$no++?></td>
							<td><?=$tab['id_doc']?></td>
							<td><?=$tab['kode_material']." | ".$tab['nama_produk']?></td>
							<td><?php if($tab['jenis_produk'] == 1){echo "Lokal";}else{echo "Ekspor";}?></td>
							
							<td style="text-align:right"><?= number_format(floatval($tab['jumlah'])) ?></td>

							<td style="text-align:right"><?=number_format($tab['jmlCar'])?></td>
							<td style="text-align:right"><?=number_format($tab['jmlPal'])?></td>
							<td style="text-align:center"><a href="javascript: w=window.open('page/laporanSerahTerimaLog/printLaporanSerahterimaLogPdf.php?id1=<?=$tab['id_doc']?>&id2=<?=$tab['kode_material']?>');w.print();" class="btn btn-warning"><i class="fa fa-print"></i></a>
						
						</td>
						</tr>
					<?php }?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4">Total</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	