<!doctype html>
<?php
	include("config.php");
?>
<html>
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="jsplumb.css" />
		<link rel="stylesheet" href="demo.css.php" />
		<script	src="jquery-1.9.0-min.js"></script>
		<script	src="jquery-ui-1.9.2.min.js"></script>
		<script src="jquery.ui.touch-punch-0.2.2.min.js"></script>
		<script src="jquery.jsPlumb-1.7.5-min.js"></script>
		<script src="jquery.jeditable.js"></script>
		<script src="demo.js"></script>
	</head>
	<body>
	<div id="main">
		<div class="demo conceptmap" id="conceptmap">
<?php
	foreach ($states as $key => $name) {
		print("\t\t\t<div class=\"w\" id=\"state{$key}\"><span id=\"state{$key}-name\">{$name}</span> <div class=\"ep\"></div></div>\n");
	}
?>
    	</div>
    </div>
	</body>
</html>