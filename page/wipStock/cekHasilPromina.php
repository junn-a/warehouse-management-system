<script src="assets/js/jquery.min.js"></script>	
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<table class="table table-bordered">
					<form method="POST">
						<tr>
							<td>Start Date</td>
							<td>Finish Date</td>
							<td>Flavour</td>							
						</tr>
						<tr>
							<td><input type="date" name="tgl_start" id="tgl_start" class="form-control "  value=""/></td>
							<td><input type="date" name="tgl_finish" id="tgl_finish" class="form-control "  value=""/></td>
							<td>
								<select class="form-control" id="kode_material" name="kode_material">
									<option value="">-Pilih Rasa-</option>
									<option value="179834">BLUEBERRY</option>
									<option value="179835">BANANA</option>
									<option value="195498">SWEAT POTATO</option>
									<option value="195497">STRAWBERRY APPLE</option>
									<option value="418696">PEACH</option>									
								</select>
							</td>
						</tr>
					</form>
				</table>
		</div>
		<div class="output">
			
		</div>
		
		
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#kode_material').change(function(){
			//var regu 	= document.getElementById("regu").value;
			//var shift 	= document.getElementById("shift").value;
			var tgl_start 	= document.getElementById("tgl_start").value;
			var tgl_finish 	= document.getElementById("tgl_finish").value;
			//var start 	= document.getElementById("start").value;
			//var end 	= document.getElementById("end").value;
			var kode_material = $(this).val();
			var post = 'kode_material='+ kode_material+'&tgl_start='+ tgl_start+'&tgl_finish='+ tgl_finish;
			$.ajax({
				type 	: "POST",
				url 	: "page/wipStock/loaderCekHasilPromina.php",
				data 	: post,
				success :function(ok){
					$(".output").html(ok);
				}
			});
		});
	});
</script>