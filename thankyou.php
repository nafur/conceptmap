<!doctype html>
<html>
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="static/bootstrap.min.css" />
        <script	src="static/jquery-1.9.0-min.js"></script>
	</head>
	<body style="padding: 10px;">
		<div class="panel panel-default">
			<div class="panel-heading">Vielen Dank!</div>
			<div class="panel-body">
			Deine ConceptMap wurde gespeichert!
<?php
	if (isset($_REQUEST["continueWith"])) {
?>
			<br />
			Falls du später nochmal daran weiterarbeiten willst, benutze bitten folgenden Link:<br />
			<a href="<?php print($_REQUEST["continueWith"]); ?>"><?php print($_REQUEST["continueWith"]); ?></a>
<?php
	}
?>
			</div>
		</div>
	</body>
</html>
