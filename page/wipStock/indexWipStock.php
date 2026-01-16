<script src="assets/js/highcharts/highcharts.js"></script>
<?php
	if(@$_SESSION['shift']==3 AND $jam > 0 AND $jam <70000){
		$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
		$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
		
	}else{
		$tgl = date('Y-m-d');
		$dateNoLabel 	= date('dm');
	}
	$queryBar = pg_query($conn,"SELECT kode_material,  SUM(jumlah) AS jml FROM serah_terima WHERE nomor_label ILIKE '%WIP%' GROUP BY kode_material");
	$dataBar = pg_fetch_array($queryBar);

?>
<a href="?page=cekHasilPromina" class="btn btn-info">Cek Hasil Promina</a>
<div class="row">
	
	<div class="col-md-6">
		<div class="card">
			<figure class="highcharts-figure">
				<div id="container"></div>
			</figure>
		</div>
	</div>
	<div class="col-md-6">
		<table class="table table-striped table-bordered" style="font-size:12px;margin-top:10px;margin-bottom:20px">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Kode Material</th>
					<th>Qty Car/ Box</th>
					<th>Qty Kg</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$query = pg_query($conn, "SELECT serah_terima.kode_material, SUM(serah_terima.jumlah) AS jml, master_produk.nama_produk,master_produk.isi, master_produk.size FROM serah_terima, master_produk WHERE serah_terima.nomor_label ILIKE '%WIP%' AND serah_terima.status = 2 AND serah_terima.kode_material = master_produk.kode_material GROUP BY serah_terima.kode_material, master_produk.isi, master_produk.size, master_produk.nama_produk");

			$totalQtyKg = 0; // Inisialisasi variabel totalQtyKg

			while ($data = pg_fetch_assoc($query)) {
				$qtyKg = $data['jml'] * $data['isi'] * $data['size'] / 1000;
				//$totalQtyKg += $qtyKg; // Menambahkan qtyKg ke totalQtyKg

				?>
				<tr>
					<td><?= $no++; ?></td>
					<td><?= $data['nama_produk'] ?></td>
					<td><?= $data['kode_material'] ?></td>
					<td><?= number_format($data['jml']) ?></td>
					<td><?= number_format($qtyKg)?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	</div>
</div>
<div class="row" style="margin-bottom:20px">
	<div class="col-md-12">
		<div class="card">
			<table class="table table-bordered">
					<form method="POST">
						<tr>
							<td>Start Date</td>
							<td>Finish Date</td>
							<td>Flavour</td>
							<td></td>
							
						</tr>
						<tr>
							<td><input type="date" name="tgl_start" class="form-control "  value=""/></td>
							<td><input type="date" name="tgl_finish" class="form-control "  value=""/></td>
							<td>
								<select class="form-control" name="rasa">
									<option value="">-Pilih Rasa-</option>
									<option value="PRP-BLU300">BLUEBERRY</option>
									<option value="PRP-BAN300">BANANA</option>
									<option value="PRP-SWP300">SWEAT POTATO</option>
									<option value="PRP-STA300">STRAWBERRY APPLE</option>
									<option value="PRP-PEA300">PEACH</option>									
								</select>
							</td>
							<td><input type="submit" name="cari" value="Search" class="btn btn-primary"></td>
						</tr>
					</form>
				</table>
		</div>
		<?php 
			
			
			if(@$_POST['cari']){
				echo $rasa = $_POST['rasa'];
				@$tgl_start = $_POST['tgl_start'];
				@$tgl_finish = $_POST['tgl_finish'];
				
				?>
				<div class="card">
					<table class="table table-bordered" >
							<form method="POST">
								<thead>
									<tr>
										<th>No</th>
										<th>Nomor Label</th>
										<th>Jumlah Box/Karton</th>
										<th>Jumlah Kg</th>
										<th>Lokasi</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$arrayData = array();
									$queryProduksiWip = pg_query($conn, "SELECT serah_terima.nomor_label, serah_terima.jumlah, serah_terima.status, master_produk.size, master_produk.isi FROM serah_terima, master_produk WHERE serah_terima.kode_material=master_produk.kode_material AND serah_terima.nomor_label ILIKE '%$rasa%' AND serah_terima.tanggal_produksi>='$tgl_start' AND serah_terima.tanggal_produksi<='$tgl_finish' ORDER BY serah_terima.tanggal_produksi ASC, serah_terima.shift ASC");
									$data =  pg_fetch_all($queryProduksiWip);
									foreach($data AS $key => $value){
										$arrayData[$value['nomor_label']] = array(
											'nomor_label' 	=> $value['nomor_label'],
											'jumlah' 			=> $value['jumlah'],
											'isi' 					=> $value['isi'],
											'size' 				=> $value['size'],
											'status'				=> $value['status']
										);
										
										$queryLokasi = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE nomor_label='$value[nomor_label]'");
										$row = pg_fetch_array($queryLokasi);
										$isi = "-";
										if(!empty($row)){
											$isi = $row['zone'];
										}
										$arrayData[$value['nomor_label']]['lokasi'] = $isi;
									}
									$area = ''; 	
									foreach($arrayData AS $table => $tab){
										$wipKg = $tab['jumlah']*$tab['isi']*$tab['size']/1000;
										@$totalWipKg += $wipKg;
										//lokasi simpan
										/**
										if($tab['lokasi'] == 10){
												 $area = "PC 32";
										}elseif($tab['lokasi'] == 11){
												 $area = "PC 14";
										}elseif($tab['lokasi'] == 12){
												 $area = "TS";
										}elseif($tab['lokasi'] == 13){
												 $area = "FCP";
										}elseif($tab['lokasi'] == 14){
												 $area = "TWS 5.6";
										}elseif($tab['lokasi'] == 15){
												 $area = "STANDING POUCH";
										}elseif($tab['lokasi'] == 16){
												 $area = "TWS 7.2";
										}elseif($tab['lokasi'] == 17){
												 $area = "CASSAVA";
										}**/
								?>
									<tr>
										<td><?=$no++?></td>
										<td><?=$tab['nomor_label']?></td>
										<td><?=$tab['jumlah']?></td>
										<td><?=number_format($wipKg)?></td>
										<td><?php
											if($tab['lokasi'] == 10){
													echo $area = "PC 32";
											}elseif($tab['lokasi'] == 11){
													echo $area = "PC 14";
											}elseif($tab['lokasi'] == 12){
													echo $area = "TS";
											}elseif($tab['lokasi'] == 13){
													echo $area = "FCP";
											}elseif($tab['lokasi'] == 14){
													echo $area = "TWS 5.6";
											}elseif($tab['lokasi'] == 15){
													echo $area = "STANDING POUCH";
											}elseif($tab['lokasi'] == 16){
													echo $area = "TWS 7.2";
											}elseif($tab['lokasi'] == 17){
													echo $area = "CASSAVA";
											}
										?></td>
										<td><?php if($tab['status']==3){echo "Sudah dipakai";}?></td>
									</tr>
									<?php }?>
									<tr>
										<td colspan="3" style="text-align:right; font-weight:bold;">Total Kg:</td>
										<td><?=number_format($totalWipKg)?></td>
										<td></td>
									</tr>
								</tbody>
							</form>
						</table>
				</div>
				<?php
			}
		?>
		
	</div>
</div>
<script>
  <?php
    $queryBar = pg_query($conn,"SELECT kode_material,  SUM(jumlah) AS jml FROM serah_terima WHERE nomor_label ILIKE '%WIP%' AND status=2 GROUP BY kode_material");
    $kode_material = array();
    $jumlah = array();
    while ($dataBar = pg_fetch_assoc($queryBar)) {
        $kode_material[] = $dataBar['kode_material'];
        $jumlah[] = (int)$dataBar['jml'];
    }
  ?>

  // Inisialisasi grafik Highcharts
  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Data Stock WIP',
      align: 'left'
    },
    subtitle: {
      text:'',
      align: 'left'
    },
	credits: {
        enabled: false
    },
    xAxis: {
      categories: <?php echo json_encode($kode_material); ?>,
      crosshair: true,
      accessibility: {
        description: 'Countries'
      }
    },
    yAxis: {
      min: 0,
      title: {
        text: 'in Car / Box'
      }
    },
    tooltip: {
      valueSuffix: ' (car / box)'
    },
    plotOptions: {
      column: {
        pointPadding: 0.2,
        borderWidth: 0
      }
    },
    series: [
      {
        name: 'Kode Material', // Set the name to 'Kode Material'
        data: <?php echo json_encode($jumlah); ?>
      }
    ]
  });
</script>