<?php
include "../../connection.php";
$id =  $_POST['idLine'];
$selectProduk = pg_query($conn,"SELECT detil_line.* , master_produk.nama_produk FROM detil_line INNER JOIN master_produk ON master_produk.kode_material=detil_line.kode_material  WHERE detil_line.kode_line='$id' AND master_produk.status='A' ORDER BY master_produk.brand, master_produk.singkatan, master_produk.size");
while($fetchProduk = pg_fetch_array($selectProduk)){
?>
<option value="<?=$fetchProduk['kode_material']?>"><?=$fetchProduk['kode_material']."|".$fetchProduk['nama_produk']?></option>
<?php }?>