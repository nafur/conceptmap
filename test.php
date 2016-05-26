<!doctype html>
<?php
	include("include/config.php");
	include("include/utils.php");

	$data = loadData("sessions/{$session_filename}");
?>
<html>
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="static/bootstrap.min.css" />
		<link rel="stylesheet" href="static/jsplumb.css" />
		<link rel="stylesheet" href="static/bootstrap-editable.css" />
		<link rel="stylesheet" href="conceptmap.css.php?experiment=<?php print($experiment_name); ?>" />
		<script	src="static/jquery-1.11.3.js"></script>
		<script	src="static/jquery-ui-1.9.2.min.js"></script>
		<script src="static/jquery.ui.touch-punch-0.2.2.min.js"></script>
		<script src="static/dom.jsPlumb-1.7.6.js"></script>
		<script	src="static/bootstrap.min.js"></script>
		<script src="static/bootstrap-editable.js"></script>
		<script src="static/jquery.simulate.js"></script>
		<script src="static/springy.js"></script>
		<script src="static/html2canvas.js"></script>
		<script src="static/html2canvas.svg.js"></script>
		<script src="static/cytoscape.min.js"></script>
		<script>
var experiment = "<?php print($experiment_name); ?>";
var session = "<?php print($session); ?>";
var restore_data = JSON.parse('<?php print(json_encode($data)); ?>');
		</script>
		<script src="static/conceptmap.js"></script>

	</head>
	<body>
		<div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Informationen</h4>
					</div>
					<div class="modal-body">
Bei der Erstellung einer Concept Map ist zu beachten:
- Begriffe sind durch beschriftete Pfeile zu verbinden, die den Zusammenhang darstellen.
- Jeder Pfeil muss beschriftet sein und ein Verb enthalten.
- Beziehungen sollten nur zwischen direkten Nachbarn bestehen. Bilden Sie keine Sätze über drei oder mehr Begriffe!
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
					</div>
				</div>
			</div>
		</div>
	<div class="navbar navbar-fluid navbar-inverse navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<span class="navbar-brand">ConceptMap</span>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li><button data-toggle="modal" data-target="#modal-info"><span class="glyphicon glyphicon-info-sign"></span> Info</button></li>
				<!-- Button trigger modal -->
				<!--<li><a href="#" id="backward"><span class="glyphicon glyphicon-arrow-left"></span> Rückwärts</a></li>
				<li><a href="#" id="forward"><span class="glyphicon glyphicon-arrow-right"></span> Vorwärts</a></li>-->
				<li><a href="#" id="finish"><span class="glyphicon glyphicon-ok"></span> Fertig</a></li>
				<!--<li><a href="#" id="screenshot"><span class="glyphicon glyphicon-ok"></span> Screenshot</a></li>-->
               <li><a href="#"><span class="glyphicon glyphicon-time"></span>	 <span id="zeit"></span></a> </li>
			</ul>
		</div>
	</div>
	<div id="main">
		<div class="conceptmap" id="conceptmap">
<?php
	foreach ($experiment as $key => $name) {
		print("\t\t\t<div class=\"w\" id=\"state{$key}\"><div class=\"w-drag w-drag-box\"><span id=\"state{$key}-name\" class=\"w-drag\">{$name}</span></div> <div class=\"ep\"></div></div>\n");
	}
?>
    	</div>
    </div>
	</body>
</html>
