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
	<div class="" style="background-color:#db8c00;text-align:center;height:100px;width:100%">
		<a href="?page=scanUsage" class=""  style="text-decoration:none">
			<div style="font-size:70px;color:white">WIP Usage</div>
		</a>
	</div>
	<a href="page/wipUsage/cetakRekapUsageWip.php" class="btn btn-warning btn-sm" style="margin-top:10px"><i class="fa fa-file"></i> Cetak Rekap Usage WIP</a>
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
				<th>Jam Pakai</th>
				<th>Qty Car/ Box</th>
				<th>Qty Kg</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=1;		
			$query = pg_query($conn,"SELECT tbl_wip_usage.jam, tbl_wip_usage.batch, tbl_wip_usage.jumlah_usage, master_produk.isi, master_produk.size FROM tbl_wip_usage, master_produk WHERE tbl_wip_usage.kode_material=master_produk.kode_material  AND tbl_wip_usage.tanggal_usage='$tgl' AND tbl_wip_usage.shift='$_SESSION[shift]' AND tbl_wip_usage.regu='$_SESSION[regu]'");
    
			$totalQtyKg = 0; // Inisialisasi variabel totalQtyKg

			while($data = pg_fetch_assoc($query)){
				$qtyKg = $data['jumlah_usage'] * $data['isi'] * $data['size'] / 1000;
				$totalQtyKg += $qtyKg; // Menambahkan qtyKg ke totalQtyKg
				
				?>
				<tr>
					<td><?=$no++;?></td>
					<td><?=$data['batch']?></td>
					<td><?=$data['jam']?></td>
					<td><?=$data['jumlah_usage']?></td>
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