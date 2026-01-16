<?php
	include "../../connection.php";
	session_start();
	$id = $_POST['id'];
	//$selectData = mysqli_query();
	//$cek = mysqli_num_rows($selectData);
	$date   = date("Y-m-d");
    $no     = 1;
	$shift  = $_SESSION['shift'];
	$regu  	= $_SESSION['regu'];
	$selectLabel = mysqli_query($conn3,"SELECT SUM(serah_terima.jumlah) AS jml, serah_terima.*, master_produk.nama_produk  FROM serah_terima, master_produk WHERE serah_terima.kode_material=master_produk.kode_material && 
	serah_terima.tanggal_produksi='$date' && 
	serah_terima.shift='$shift' &&
	serah_terima.regu='$regu' &&
	serah_terima.kode_line='$id' &&
	serah_terima.status = 2
	GROUP BY serah_terima.kode_material
	");
	
	if(!empty($id)){
?>	
<div class="table-responsive">
<table class="table table-bordered" >
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>No Label</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>No Pallet</th>
						<th>Re - Print</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
						while($showdata = mysqli_fetch_assoc($selectLabel)){
					?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$showdata['kode_material']?></td>
                        <td><?=$showdata['nama_produk']?></td>
                        <td><?=$showdata['jenis_produk']?></td>
                        <td><?=$showdata['tujuan']?></td>
						<td style="text-align:center"><a href="javascript: w=window.open('page/laporanSerahTerima/printLaporanSerahterima.php?id1=<?=$showdata['kode_material']?>&id2=<?=$showdata['jenis_produk']?>&id3=<?=$showdata['tujuan']?>&id4=<?=$id?>&id5=<?=$showdata['tanggal_produksi']?>');w.print();w.close();" class="btn btn-warning"><i class="fa fa-print"></i></a>
						
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