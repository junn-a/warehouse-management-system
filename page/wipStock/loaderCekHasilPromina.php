<?php
	include "../../connection.php";
	session_start();
	//$id = $_POST['id'];
	//$selectData = mysqli_query();
	//$cek = mysqli_num_rows($selectData);
	//echo $start  	= $_POST['start'];
	//echo $end  	= $_POST['end'];
	//$selectLabel = pg_query($conn,"SELECT SUM(serah_terima.jumlah) AS jml, serah_terima.*, master_produk.nama_produk  FROM serah_terima, master_produk WHERE serah_terima.kode_material=master_produk.kode_material AND serah_terima.tanggal_produksi='$tgl' AND  serah_terima.shift='$shift' AND serah_terima.regu='$regu' ANDserah_terima.kode_line='$id' GROUP BY serah_terima.kode_material, serah_terima.jenis_produk, serah_terima.tujuan");
	
    $no     					= 1;
	$kode_material  	= $_POST['kode_material'];
	$tgl_start  			= $_POST['tgl_start'];
	$tgl_finish				= $_POST['tgl_finish'];
	
	
	$selectLabel = pg_query($conn,"SELECT SUM(serah_terima.jumlah) AS jml , serah_terima.tanggal_produksi, serah_terima.shift, serah_terima.regu, master_produk.nama_produk FROM serah_terima  INNER JOIN master_produk ON serah_terima.kode_material=master_produk.kode_material WHERE serah_terima.tanggal_produksi>='$tgl_start' AND  serah_terima.tanggal_produksi<='$tgl_finish' AND serah_terima.kode_material='$kode_material'  GROUP BY master_produk.nama_produk, serah_terima.tanggal_produksi, serah_terima.shift, serah_terima.regu ORDER BY serah_terima.tanggal_produksi ASC,  serah_terima.shift ASC");
	
	if(!empty($kode_material)){
?>	
<div class="table-responsive" style="margin-bottom:20px">
<table class="table table-bordered" >
	<thead style="background-color:#8bc34a;color:white">
		<tr>
			<th>No</th>
			<th>Produk</th>
			<th>Tanggal</th>
			<th>Shift</th>
			<th>Regu</th>
			<th>Jumlah (karton)</th>
			<!--<th>Kg</th>-->
			<th>Pakai WIP</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while($showdata = pg_fetch_assoc($selectLabel)){
			$wipKode = substr($showdata['nama_produk'], 0, 7);
			$jumlahKg = $showdata['jml'] * 24 * 15;
			@$totalKg += $jumlahKg; // Mengakumulasi nilai ke totalKg
		?>
		<tr>
			<td><?=$no++?></td>
			<td><?=$showdata['nama_produk']?></td>
			<td><?=$showdata['tanggal_produksi']?></td>
			<td><?=$showdata['shift']?></td>
			<td><?=$showdata['regu']?></td>
			<td><?=$showdata['jml']?></td>
			<!--<td><?=number_format($jumlahKg / 1000, 2, '.', ',')?></td>-->
			<td style="text-align:center"><a href="javascript: w=window.open('?page=detailPakaiWip&id1=<?=$wipKode."300"?>&id2=<?=$showdata['tanggal_produksi']?>&id3=<?=$showdata['shift']?>');" class="btn btn-warning"><i class="fa fa-files-o"></i></a></td>
		</tr><?php }?>
		<!--
		<tr>
			<td colspan="6" style="text-align:right; font-weight:bold;">Total Kg:</td>
			<td><?=number_format($totalKg / 1000, 2, '.', ',')?></td>
			<td></td>
		</tr>
		-->
	</tbody>
	
</table>
</div>
<?php }else{
	?>
	<div class="table-responsive">
		<h3 style="text-align:center">Data Not Found</h3>
	</div>
	<?php
}?>