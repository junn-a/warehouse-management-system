	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Monitoring Penanganan Produk Ekspor</b>
		</div>
		<div class="panel-body">
			
			<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Produksi</th>
                        <th>Shift / Regu</th>
						<th>Kode Produk</th>
						<th>Nama Produk</th>
						<th>OTF</th>
						<th>Tujuan</th>
						<th>Jumlah (karton)</th>
						<th>Jumlah (Pallet)</th>
						<th>Status Penanganan</th>
						<!--<th>Cek Kempes</th>
						<th>Tempel Sticker</th>
						<th>Status</th>
						<th>Action</th>-->
                    </tr>
                </thead>
				<tbody>
				<?php
				$no 			= 1;
					$arrayData 		= array(); 
					
					$selectExport = pg_query($conn,"SELECT serah_terima.status_penanganan, serah_terima.otf, serah_terima.kode_material, serah_terima.tanggal_produksi, SUM(serah_terima.jumlah) AS jml ,COUNT(serah_terima.jumlah) AS jml_pallet , master_produk.nama_produk , serah_terima.tujuan, serah_terima.shift, serah_terima.regu
					FROM serah_terima, master_produk 
					WHERE serah_terima.jenis_produk=2 AND serah_terima.status=2 AND  master_produk.kode_material=serah_terima.kode_material
					GROUP BY serah_terima.kode_material, serah_terima.tanggal_produksi, serah_terima.shift, serah_terima.regu, master_produk.nama_produk ,serah_terima.tujuan, serah_terima.otf , serah_terima.status_penanganan
					ORDER BY serah_terima.tanggal_produksi DESC");
					while($data	= pg_fetch_assoc($selectExport)){
				   ?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$data['tanggal_produksi']?></td>
						<td><?=$data['shift']."/".$data['regu']?></td>
						<td><?=$data['kode_material']?></td>
						<td><?=$data['nama_produk']?></td>
						<td><?=$data['otf']?></td>
						<td><?=$data['tujuan']?></td>
						<td><?=$data['jml']?></td>
						<td><?=$data['jml_pallet']?></td>
						<td><?php if($data['status_penanganan'] ==1){echo "Cek Kebocoran";} else if($data['status_penanganan'] ==2){echo "Cek Kebocoran & Tempel Sticker";}else{echo "";}?></td>
						<!--<td></td>
						<td></td>
						<td></td>
						<td><a href="?page=statusEkspor&aksi=updateStatus" class="btn btn-primary">Action</a></td>-->
					</tr>
					<?php }?>
                </tbody>
            </table>
		</div>
		</div>
	</div>
	