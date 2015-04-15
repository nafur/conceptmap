<!doctype html>
<?php
	include("config.php");

	if (file_exists("finished/{$session_filename}")) {
		$data = json_decode(file_get_contents("finished/{$session_filename}"));
	} else $data = Array();
?>
<html>
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
		<link rel="stylesheet" href="jsplumb.css" />
		<link rel="stylesheet" href="demo.css.php?experiment=<?php print($experiment_name); ?>" />
		<script	src="js/jquery-1.9.0-min.js"></script>
		<script	src="js/jquery-ui-1.9.2.min.js"></script>
		<script src="js/jquery.ui.touch-punch-0.2.2.min.js"></script>
		<script src="js/jquery.jsPlumb-1.7.5.js"></script>
		<script src="js/jquery.jeditable.js"></script>
		<script src="js/jquery.simulate.js"></script>
		<script src="js/springy.js"></script>
		<script src="js/cytoscape.min.js"></script>
		<script>
var experiment = "";
var session = "";
var restore_data = JSON.parse('<?php print(json_encode($data)); ?>');
		</script>
		<script src="js/demo.js"></script>
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
		<div class="demo conceptmap" id="conceptmap">
<?php
	foreach ($experiment as $key => $name) {
		print("\t\t\t<div class=\"w\" id=\"state{$key}\"><span id=\"state{$key}-name\">{$name}</span> <div class=\"ep\"></div></div>\n");
	}
?>
    	</div>
    </div>
	</body>
</html>