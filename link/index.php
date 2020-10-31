<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">
	
	<script  src="jquery-1.12.4.js"></script>
	<script   src="jquery.dataTables.min.js"></script>
	<script  src="dataTables.buttons.min.js"></script>
	<script  src="buttons.flash.min.js"></script>
	<script  src="jszip.min.js"></script>
	<script  src="pdfmake.min.js"></script>
	<script  src="vfs_fonts.js"></script>
	<script  src="buttons.html5.min.js"></script>
	<script  src="buttons.print.min.js"></script>

	
	<script type="text/javascript" class="init">
	
$(document).ready(function() {
	$('#example').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );
} );

	</script>
</head>
<body class="wide comments example">
	<div class="fw-container">
		<div class="fw-body">
			<div class="content">
				<h1 class="page_title">File export</h1>
				
				<table id="example" class="display nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Name</th>
							<th>Position</th>
							<th>Office</th>
							<th>Age</th>
							<th>Start date</th>
							<th>Salary</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Name</th>
							<th>Position</th>
							<th>Office</th>
							<th>Age</th>
							<th>Start date</th>
							<th>Salary</th>
						</tr>
					</tfoot>
					<tbody>
						<tr>
							<td>Tiger Nixon</td>
							<td>System Architect</td>
							<td>Edinburgh</td>
							<td>61</td>
							<td>2011/04/25</td>
							<td>$320,800</td>
						</tr>
						<tr>
							<td>Shad Decker</td>
							<td>Regional Director</td>
							<td>Edinburgh</td>
							<td>51</td>
							<td>2008/11/13</td>
							<td>$183,000</td>
						</tr>
						<tr>
							<td>Michael Bruce</td>
							<td>Javascript Developer</td>
							<td>Singapore</td>
							<td>29</td>
							<td>2011/06/27</td>
							<td>$183,000</td>
						</tr>
						<tr>
							<td>Donna Snider</td>
							<td>Customer Support</td>
							<td>New York</td>
							<td>27</td>
							<td>2011/01/25</td>
							<td>$112,000</td>
						</tr>
					</tbody>
				</table>
				</div>
			</div>
		</div>
		
	</div>
	
</body>
</html>