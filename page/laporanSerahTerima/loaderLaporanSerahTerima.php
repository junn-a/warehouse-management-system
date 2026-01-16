<?php
	include "../../connection.php";
	session_start();
	$id = $_POST['id'];
	//$selectData = mysqli_query();
	//$cek = mysqli_num_rows($selectData);
	
    $no     		= 1;
	$shift  	= $_POST['shift'];
	$regu  	= $_POST['regu'];
	$tgl  		= $_POST['tgl'];
	//echo $start  	= $_POST['start'];
	//echo $end  	= $_POST['end'];
	//$selectLabel = pg_query($conn,"SELECT SUM(serah_terima.jumlah) AS jml, serah_terima.*, master_produk.nama_produk  FROM serah_terima, master_produk WHERE serah_terima.kode_material=master_produk.kode_material AND serah_terima.tanggal_produksi='$tgl' AND  serah_terima.shift='$shift' AND serah_terima.regu='$regu' ANDserah_terima.kode_line='$id' GROUP BY serah_terima.kode_material, serah_terima.jenis_produk, serah_terima.tujuan");
	
	$selectLabel = pg_query($conn,"SELECT SUM(serah_terima.jumlah) AS jml , serah_terima.kode_material, serah_terima.jenis_produk, serah_terima.tujuan, master_produk.nama_produk FROM serah_terima  INNER JOIN master_produk ON serah_terima.kode_material=master_produk.kode_material WHERE serah_terima.tanggal_produksi='$tgl' AND  serah_terima.shift='$shift' AND serah_terima.regu='$regu' AND serah_terima.kode_line='$id'  GROUP BY master_produk.nama_produk, serah_terima.kode_material, serah_terima.jenis_produk, serah_terima.tujuan");
	
	if(!empty($id)){
?>	
<div class="table-responsive">
<table class="table table-bordered" >
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>Kode Matrial</th>
                        <th>Nama Produk</th>
                        <th>Jenis Produk</th>
                        <th>Tujuan</th>
						<th>Jumlah</th>
						<th>Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
						while($showdata = pg_fetch_assoc($selectLabel)){
					?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$showdata['kode_material']?></td>
                        <td><?=$showdata['nama_produk']?></td>
						<td><?php if($showdata['jenis_produk'] == 1){echo "Lokal";}elseif($showdata['jenis_produk'] == 2){echo "Export";}elseif($showdata['jenis_produk'] == 3){echo "Lokal Cut Off";}?></td>
                        <td><?=$showdata['tujuan']?></td>
						<td><?=$showdata['jml']?></td>
						<td style="text-align:center"><a href="javascript: w=window.open('page/laporanSerahTerima/printLaporanSerahterimaPdf.php?id1=<?=$showdata['kode_material']?>&id2=<?=$showdata['jenis_produk']?>&id3=<?=$showdata['tujuan']?>&id4=<?=$id?>&id5=<?=$tgl?>&id7=<?=$shift?>&id8=<?=$regu?>');w.print();" class="btn btn-warning"><i class="fa fa-print"></i></a>
						
						</td>
                    </tr>
					<?php }?>
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