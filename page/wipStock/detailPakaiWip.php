<?php
	$kodeWip 			= $_GET['id1'];
	$tanggal_produksi = $_GET['id2'];
	$shift 					= $_GET['id3'];
	
?>
<div class="card">
	<table class="table table-bordered">
			<form method="POST">
				<thead>
					<tr>
						<th>No</th>
						<th>Nomor Label</th>
						<th>Jumlah Box/Karton</th>
						<th>Jumlah Kg</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$no = 1;
					$queryProduksiWip = pg_query($conn, "SELECT tbl_wip_usage.batch, tbl_wip_usage.jumlah_usage,  master_produk.size, master_produk.isi, tbl_wip_usage.tanggal_usage FROM tbl_wip_usage, master_produk WHERE tbl_wip_usage.kode_material=master_produk.kode_material AND tbl_wip_usage.batch ILIKE '%$kodeWip%' AND DATE(tbl_wip_usage.tanggal_usage)='$tanggal_produksi' AND tbl_wip_usage.shift='$shift' ORDER BY tbl_wip_usage.tanggal_usage ASC, tbl_wip_usage.jam ASC");
					while($dataProduksiWip = pg_fetch_array($queryProduksiWip)){
						$wipKg = $dataProduksiWip['jumlah_usage']*$dataProduksiWip['isi']*$dataProduksiWip['size']/1000;
						@$totalWipKg += $wipKg;
				?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$dataProduksiWip['batch']?></td>
						<td><?=$dataProduksiWip['jumlah_usage']?></td>
						<td><?=number_format($wipKg)?></td>
						
					</tr>
					<?php }?>
					<tr>
						<td colspan="3" style="text-align:right; font-weight:bold;">Total Kg:</td>
						<td><?=number_format($totalWipKg)?></td>
					</tr>
				</tbody>
			</form>
		</table>
</div>