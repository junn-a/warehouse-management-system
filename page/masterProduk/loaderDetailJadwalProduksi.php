<?php
	$id = $_POST['id'];
	$dateNew = date('Y-m-d', strtotime($id));
?>
		
		<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>Kode Material</th>
                        <th>Nama Produk</th>
						<th>Jumlah</th>
						<th>Keterangan</th>
						<th style="text-align:center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
					include "../../connection.php";
					$selectData 	= mysqli_query($conn3,"SELECT detil_jadwal.*, master_produk.nama_produk FROM detil_jadwal, master_produk WHERE detil_jadwal.kode_material=master_produk.kode_material && detil_jadwal.tanggal_jadwal='$dateNew'");
					$no = 1;
					while($fetchData = mysqli_fetch_array($selectData)){
				   ?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$fetchData['kode_material']?></td>
						<td><?=$fetchData['nama_produk']?></td>
						<td><?=$fetchData['jumlah']?></td>
						<td><?=$fetchData['keterangan']?></td>
						<td style="text-align:center"><a href="?page=jadwalProduksi&aksi=hapus&id2=<?=$fetchData['kode_material']?>&id1=<?=$dateNew?>&id3=<?=$fetchData['kode_line']?>" class="btn btn-danger"><span class="fa fa-trash"></span></button></td>
					</tr>
				   <?php 
					}
				   ?>
                </tbody>
            </table>
			