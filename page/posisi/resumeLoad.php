	<div class="panel panel-default" >
		<div class="panel-heading">
			<b>Transit Area</b>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<span class="label label-info">Floor 1</span>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Zone</th>
							<th>Space</th>
							<th>Free Space</th>
							<th>View Map</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>I</td>
							<?php 
								$loadA = 330;
								$selectA = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE id<=330");
								$cekA = pg_num_rows($selectA);
							?>
							<td><?=$loadA?></td>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=100-($persenFreeA = $cekA/$loadA*100)?>%">
									  <?=$spaceA=$loadA-$cekA?>
									</div>
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$persenFreeA?>%">
									  <?=$cekA?>
									</div>
								</div>
							</td>
							<td><a href="?page=posisi&idSec=1" class="btn btn-info">View</a></td>
						</tr>
						<tr>
							<td>II</td>
							<?php 
								$loadB = 330;
								$selectB = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE zone=2 AND id<=660 AND id>331 AND shift<4");
								$cekB = pg_num_rows($selectB);
							?>
							<td><?=$loadB?></td>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=100-($persenFreeB = $cekB/$loadB*100)?>%">
									  <?=$spaceB=$loadB-$cekB?>
									</div>
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$persenFreeB?>%">
									  <?=$cekB?>
									</div>
								</div>
							</td>
							<td><a href="?page=posisi&idSec=2" class="btn btn-info">View</a></td>
						</tr>
						<tr>
							<td>III</td>
							<?php 
								$loadC = 132;
								$selectC = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE zone=3 AND id<=794 AND id>661 AND shift<4");
								$cekC = pg_num_rows($selectC);
							?>
							<td><?=$loadC?></td>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=100-($persenFreeC = $cekC/$loadC*100)?>%">
									  <?=$spaceC=$loadC-$cekC?>
									</div>
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$persenFreeC?>%">
									  <?=$cekC?>
									</div>
								</div>
							</td>
							<td><a href="?page=posisi&idSec=3" class="btn btn-info">View</a></td>
						</tr>
						<tr>
							<td>IV</td>
							<?php 
								$loadD = 90;
								$selectD = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE zone=4 AND id<=884 AND id>795 AND shift<4");
								$cekD = pg_num_rows($selectD);
							?>
							<td><?=$loadD?></td>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=100-($persenFreeD = $cekD/$loadD*100)?>%">
									  <?=$spaceD=$loadD-$cekD?>
									</div>
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$persenFreeD?>%">
									  <?=$cekD?>
									</div>
								</div>
							</td>
							<td><a href="?page=posisi&idSec=4" class="btn btn-info">View</a></td>
						</tr>
						<tr>
							<td>TOTAL</td>
							<?php 
								$selectTotal = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE shift=1 OR shift=2 OR shift=3 AND id<=4000");
								$cekTotal = pg_num_rows($selectTotal);
								$isiTotal = $cekA+$cekB+$cekC+$cekD;
								$freeSpaceTotal = $spaceA+$spaceB+$spaceC+$spaceD;
							?>
							<td><?=$loadTotal =$loadA+$loadB+$loadC+$loadD?></td>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=100-($persenTotal = $isiTotal/$loadTotal*100)?>%">
									  <?=$freeSpaceTotal?>
									</div>
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$persenTotal?>%">
									  <?=$isiTotal?>
									</div>
								</div>
							</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="col-md-6">
				<span class="label label-primary">Floor 2</span>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Zone</th>
							<th>Space</th>
							<th>Free Space</th>
							<th>View Map</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>IA</td>
							<?php 
								$load1A 	= 330;
								$select1A 	= pg_query($conn,"SELECT * FROM tbl_load_fg WHERE id>1104 AND id<=1440 AND shift<4");
								$cek1A	 	= pg_num_rows($select1A);
							?>
							<td><?=$loadA?></td>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=100-($persenFree1A = $cek1A/$load1A*100)?>%">
									  <?=$loadA-$cek1A?>
									</div>
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$persenFree1A?>%">
									  <?=$cek1A?>
									</div>
								</div>
							</td>
							<td><a href="?page=posisi&idSec=5" class="btn btn-info">View</a></td>
						</tr>
						<tr>
							<td>IIA</td>
							<?php 
								$load2A 	= 330;
								$select2A 	= pg_query($conn,"SELECT * FROM tbl_load_fg WHERE id>1440 AND id<=1776 AND shift<4");
								$cek2A	 	= pg_num_rows($select2A);
							?>
							<td><?=$load2A?></td>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=100-($persenFree2A = $cek2A/$load2A*100)?>%">
									  <?=$load2A-$cek2A?>
									</div>
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$persenFree2A?>%">
									  <?=$cek2A?>
									</div>
								</div>
							</td>
							<td><a href="?page=posisi&idSec=6" class="btn btn-info">View</a></td>
						</tr>
						<tr>
							
						</tr>
					</tbody>
				</table>
			</div>
			<!--
			<div class="col-md-6">
				<img src="assets/img/mapingGudangNew.png" width="100%"/>
			</div>-->
		</div>	
	</div>
