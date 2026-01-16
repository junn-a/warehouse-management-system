<?php
	$jam 			= date("Gis");
	if(@$_SESSION['shift']==3 AND $jam > 0 AND $jam <70000){
		$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
		$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
		
	}else{
		$tgl = date('Y-m-d');
		$dateNoLabel 	= date('dm');
	}

?>
<div class="col-md-12">
	<!--<span class="label label-info">Floor 1</span>-->
	<div class="bg-primary" style="text-align:center;height:100px;width:100%">
		<a href="?page=posisiWip" class=""  style="text-decoration:none">
			<div style="font-size:70px;color:white">WIP Produce</div>
		</a>
	</div>
	<a href="page/wip/cetakRekapHasilWip.php" class="btn btn-success btn-sm" style="margin-top:10px"><i class="fa fa-file"></i> Cetak Rekap Hasil WIP</a>
	<table class="table table-striped table-bordered" style="font-size:12px;margin-top:10px">
		
		<thead>
			<tr>
				<th>Tanggal</th>
				<th><?=$tgl?></th>
				<th>Shift / Regu</th>
				<th><?=$_SESSION['shift']." / ".$_SESSION['regu']?></th>
				<th>Operator</th>
				<th><?=$_SESSION['username']?></th>
			</tr>
		</thead>
	</table>
	<table class="table table-striped table-bordered" style="font-size:12px;margin-top:10px">
		
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor Label</th>
				<th>Qty Car/ Box</th>
				<th>Qty Kg</th>
			</tr>
		</thead>
		<tbody>
			<?php
			/**
				$no = 1;
				$arrayData = array();
				
				$query = pg_query($conn, "SELECT zone,
                          SUBSTRING(nomor_label, 10, LENGTH(nomor_label)-11) AS substring_label
                          FROM tbl_load_fg
                          WHERE zone > 9
                          GROUP BY zone, substring_label");
						  
				
				
				$queryJoin = pg_query($conn, "SELECT tbl_load_fg.zone, 
                              SUBSTRING(tbl_load_fg.nomor_label, 10, LENGTH(tbl_load_fg.nomor_label) - 11) AS substring_label, 
                              SUM(serah_terima.jumlah) AS total_jumlah,
							  COUNT(serah_terima.jumlah) AS jumlah_pallet,
                              master_produk.isi,
							  master_produk.size
                              FROM tbl_load_fg, serah_terima, master_produk
                              WHERE tbl_load_fg.nomor_label = serah_terima.nomor_label 
                              AND tbl_load_fg.zone > 9 
                              AND master_produk.kode_material = serah_terima.kode_material
                              GROUP BY tbl_load_fg.zone, substring_label, master_produk.isi, master_produk.size");

						 		
				
				while($data = pg_fetch_assoc($queryJoin)){
					if($data['zone'] == 10){
						$area = "PC 32";
					}elseif($data['zone'] == 11){
							$area = "PC 14";
					}elseif($data['zone'] == 12){
							$area = "TS";
					}elseif($data['zone'] == 13){
							$area = "FCP";
					}elseif($data['zone'] == 14){
							$area = "TWS 5.6";
					}elseif($data['zone'] == 15){
							$area = "STANDING POUCH";
					}elseif($data['zone'] == 16){
							$area = "TWS 7.2";
					}elseif($data['zone'] == 17){
							$area = "CASSAVA";
					}
				
					**/
			$no=1;		
			$query = pg_query($conn,"SELECT serah_terima.nomor_label, serah_terima.jumlah, master_produk.isi, master_produk.size FROM serah_terima, master_produk WHERE serah_terima.kode_material=master_produk.kode_material AND serah_terima.nomor_label ILIKE '%WIP%' AND serah_terima.tanggal_produksi='$tgl' AND serah_terima.shift='$_SESSION[shift]' AND serah_terima.regu='$_SESSION[regu]'");
    
			$totalQtyKg = 0; // Inisialisasi variabel totalQtyKg

			while($data = pg_fetch_assoc($query)){
				$qtyKg = $data['jumlah'] * $data['isi'] * $data['size'] / 1000;
				$totalQtyKg += $qtyKg; // Menambahkan qtyKg ke totalQtyKg
				
				?>
				<tr>
					<td><?=$no++;?></td>
					<td><?=$data['nomor_label']?></td>
					<td><?=$data['jumlah']?></td>
					<td><?=number_format($qtyKg)?></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="3">Total</td>
				<td><?=number_format($totalQtyKg)?></td>
			</tr>
		</tbody>
	</table>
</div>