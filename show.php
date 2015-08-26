<!doctype html>
<?php
	include("include/config.php");
	include("include/utils.php");
	
	$data = loadData("finished/{$session_filename}");
?>
<html>
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="static/bootstrap.min.css" />
		<link rel="stylesheet" href="static/jsplumb.css" />
		<link rel="stylesheet" href="conceptmap.css.php?experiment=<?php print($experiment_name); ?>" />
		<script	src="static/jquery-1.9.0-min.js"></script>
		<script	src="static/jquery-ui-1.9.2.min.js"></script>
		<script src="static/jquery.ui.touch-punch-0.2.2.min.js"></script>
		<script src="static/dom.jsPlumb-1.7.6.js"></script>
		<script src="static/jquery.jeditable.js"></script>
		<script src="static/jquery.simulate.js"></script>
		<script src="static/springy.js"></script>
		<script src="static/cytoscape.min.js"></script>
		<script>
var experiment = "";
var session = "";
var restore_data = JSON.parse('<?php print(json_encode($data)); ?>');
		</script>
		<script src="static/conceptmap.js"></script>
	</head>
	<body>
	<div class="navbar navbar-fluid navbar-inverse navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="admin.php">ConceptMap</a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#" id="backward">Backward</a></li>
				<li><a href="#" id="forward">Forward</a></li>
				<li><a href="#" id="layout">Layout</a></li>
				<li><a href="export.php?file=<?php print("{$experiment_name}-{$session}"); ?>">Export</a></li>
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