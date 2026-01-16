	<div class="panel panel-default">
		<div class="panel-heading" style="height:auto">
			<b>Zone <?php
				if($_GET['idSec']==5){
					echo "1A";
				}elseif($_GET['idSec']==6){
					echo "2A";
				}elseif($_GET['idSec']==7){
					echo "3A";
				}elseif($_GET['idSec']==8){
					echo "4A";
				}else{
					echo $_GET['idSec'];
				}
			?> 
			</b>
			
			<a href="?page=resumeLoad" style="pading-bottom:5px" class="btn btn-warning btn-sm"><span class="fa fa-arrow-left"></span> Back</a>
			<div></div>
		</div>
		
		<div class="panel-body">
		
		<div style="float:left">
		<div style="width:40px;height:15px;background-color:white;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p>ROW</p></div>
		<?php
		if($_GET['idSec']==3){
			for($j='Q';$j<='V';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
		}
		}elseif($_GET['idSec']==4){
			for($j='S';$j<='X';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
			}
		}elseif($_GET['idSec']==1){
			for($j='A';$j<='O';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
			}
		}elseif($_GET['idSec']==2){
			for($j='A';$j<='O';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
			}
		}
		elseif($_GET['idSec']==5){
			for($j='A';$j<='N';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
			}
		}elseif($_GET['idSec']==6){
			for($j='A';$j<='N';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
			}
		}
		/*elseif($_GET['idSec']==7){
			for($j='O';$j<='W';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
			}
		}elseif($_GET['idSec']==8){
			for($j='O';$j<='W';$j++){
			?>
			<div style="width:40px;height:40px;background-color:white;margin-top:4px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$j?></p></div>
			<?php
			}
		}*/
		
			?>
		</div>
		<div>
		<?php
		// Header
		if($_GET['idSec']==1){
			for($h=1;$h<=24;$h++){
				if($h>22){
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
					}else{
						?>
						<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
						<?php
						
					}
				}
		}elseif($_GET['idSec']==2){
			for($h=23;$h<=46;$h++){
				if($h>44){
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
				}else{
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
					
				}
			}
		}elseif($_GET['idSec']==3){
			for($h=23;$h<=46;$h++){
				if($h>44){
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
				}else{
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
					
				}
			}
		}elseif($_GET['idSec']==4){
			for($h=1;$h<=24;$h++){
				if($h>22){
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
					}else{
						?>
						<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
						<?php
						
					}
				}
			 
		}elseif($_GET['idSec']==5){
			for($h=1;$h<=24;$h++){
				if($h>56){
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
				}else{
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
					
				}
				}
		}elseif($_GET['idSec']==6){
			for($h=25;$h<=48;$h++){
				if($h>46){
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
				}else{
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
					
				}
			}
		}elseif($_GET['idSec']==7){
			for($h=25;$h<=48;$h++){
				if($h>42){
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
				}else{
					?>
					<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
					<?php
					
				}
			}
		}elseif($_GET['idSec']==8){
			for($h=1;$h<=24;$h++){?>
			<div style="width:40px;height:15px;background-color:white;float:left;margin:2px;color:black;text-align:center;text-decoration:none;font-size:12px"><p><?=$h?></p></div>
			<?php }
		}
			$id = [];
			$shift = [];
			$selectData = pg_query($conn,"SELECT * FROM tbl_load_fg");
			
			while($showData 	= pg_fetch_array($selectData)){
				$id[] = $showData['id'];
				$shift[] = $showData['nomor_label'];
			}
			//print_r($id);
			
			$arrData = array(); //array declare
			if($_GET['idSec'] == 1){
				//input data 1 s/d 200
				for($i=1;$i<=360;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}elseif($_GET['idSec'] == 2){
				for($i=361;$i<=720;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}elseif($_GET['idSec'] == 3){
				for($i=721;$i<=864;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}elseif($_GET['idSec'] == 4){
				for($i=865;$i<=1008;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}elseif($_GET['idSec'] == 5){
				for($i=1105;$i<=1440;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}elseif($_GET['idSec'] == 6){
				for($i=1441;$i<=1776;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}elseif($_GET['idSec'] == 7){
				for($i=1777;$i<=1992;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}elseif($_GET['idSec'] == 8){
				for($i=1993;$i<=2208;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			}



//database data
$noUrut = $id;


//looping data 1 s/d 200
for($i=0;$i<count($arrData);$i++){

	//check the data if same data change red to green
	for($j=0;$j<count($noUrut);$j++){
		if($arrData[$i]['number'] == $noUrut[$j]){
			$no = $arrData[$i]['number'];
			$selectNo = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE id=$no");
			$fetchShift = pg_fetch_assoc($selectNo);
			if($fetchShift['shift']==1){
				$arrData[$i]['status'] = '#0f2a10';
				$produk 		= substr($fetchShift['nomor_label'],22,7);
				$brand 			= substr($fetchShift['nomor_label'],9,3);
				$namaProduk 	= substr($fetchShift['nomor_label'],13,6);
			}elseif($fetchShift['shift']==2){
				$arrData[$i]['status'] = '#1b2b73';
				$produk 		= substr($fetchShift['nomor_label'],22,7);
				$brand 			= substr($fetchShift['nomor_label'],9,3);
				$namaProduk 	= substr($fetchShift['nomor_label'],13,6);
			}elseif($fetchShift['shift']==3){
				$arrData[$i]['status'] = '#ff9800';
				$produk 		= substr($fetchShift['nomor_label'],22,7);
				$brand 			= substr($fetchShift['nomor_label'],9,3);
				$namaProduk 	= substr($fetchShift['nomor_label'],13,6);
			}elseif($fetchShift['shift']==4){
				$arrData[$i]['status'] = 'white';
				$produk = $fetchShift['nomor_label'];
				$produk = substr($fetchShift['nomor_label'],9,-2);
			}else{
				$arrData[$i]['status'] = '#607d8b';
			}
		}
	}

	//jus print
	if($arrData[$i]['status'] == '#607d8b'){
		?>
	<a href="?page=cetakLabel&aksi=scanBarcode&idSec=<?=$_GET['idSec']?>&idUrut=<?=$arrData[$i]['number']?>&id=1" style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"><?=$arrData[$i]['number']?></a>
	<?php
	}elseif($arrData[$i]['status'] == 'white'){?>
		<div style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:white;text-align:center;text-decoration:none;" data-toggle="tooltip" data-placement="top" title="<?=$fetchShift['nomor_label']."|".$arrData[$i]['number']?>"></div>
	<?php }elseif($arrData[$i]['status'] == '#ff9800'){
		?>
	<div style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:black;text-align:center;text-decoration:none;"><div style="font-size:10px"><?=$brand?></div><div style="font-size:10px"><?=$namaProduk?></div><div style="font-size:9px"><?=$produk?></div></div>
	<?php
	}
	else{
		?>
	<div style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:white;text-align:center;text-decoration:none;"><div style="font-size:10px"><?=$brand?></div><div style="font-size:10px"><?=$namaProduk?></div><div style="font-size:9px"><?=$produk?></div></div>
	<?php
	}
} 
		?>
		</div>
	</div>
