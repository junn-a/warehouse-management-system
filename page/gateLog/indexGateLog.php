	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Good Issue List</b>
		</div>
		<div class="panel-body">
			<div id="data">
			
			</div>
		</div>
	</div>
	<script src="assets/js/jquery-3.3.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#data").load('page/gateLog/loader.php');
		});
	</script>