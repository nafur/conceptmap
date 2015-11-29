<!doctype html>
<?php
	include("include/config.php");
	if (isset($_GET["delete"])) {
		unlink("sessions/" . base64_encode($_GET["delete"]));
	}
?>
<html>
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="static/bootstrap.min.css" />
        <script	src="static/jquery-1.9.0-min.js"></script>
		<script>
function validateForm() {
	var code = $("#sessioncode").val();
	if (code.length == 4) return true;
	else {
		alert("Der Code muss vierstellig sein!");
		return false;
	}
}
		</script>
	</head>
	<body style="padding: 10px;">
<?php if(!$admin) { ?>
		<div class="pull-right">
			<a class="btn btn-default" href="admin.php">Admin</a>
		</div>
<?php } ?>
		<h2>Concept Map starten</h2>
		<form action="test.php" onsubmit="return validateForm()" class="form-horizontal">
			<div class="form-group">
				<label for="experiment" class="col-sm-2 control-label">Thema</label>
				<div class="col-sm-10">
				<select name="experiment" id="experiment" class="form-control">
<?php
	foreach ($experiments as $key => $val) {
		print("\t\t\t<option>{$key}</option>\n");
	}
?>
				</select>
				</div>
			</div>
            <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
            <table class="table table-bordered">
            	<tr>
                	<td>Daraus besteht Ihr Code:</td>
                    <td>Die ersten zwei Buchstaben im Vornamen Ihrer Mutter:</td>
                    <td>Die ersten zwei Buchstaben im Vornamen Ihres Vaters:</td>
                </tr>
                <tr>
                	<td>Beispiel:</td>
                    <td>Renate</td>
                    <td>Wolfgang</td>
                </tr>
                <tr>
                	<td>Beispiel-Code:</td>
                    <td>RE</td>
                    <td>WO</td>
                </tr>
            </table>
            </div>
            </div>
			<div class="form-group">
				<label for="newsession" class="col-sm-2 control-label" style="font-size: 24px;">Ihr Code</label>
				<div class="col-sm-3">
				<input type="text" size="4" class="form-control input-lg" style="font-size: 24px;" id="sessioncode" name="newsession" placeholder="Ihr Code..." maxlength="4" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Start</button>
				</div>
			</div>
		</form>
<?php
	if ($admin) {
?>		
		<h2>Current sessions</h2>

		<h4>Download all:
<?php
	foreach ($experiments as $key => $val) {
		print("\t\t\t<a class=\"btn btn-default\" href=\"export.php?type=group&folder=sessions&experiment={$key}\">{$key} <span class=\"glyphicon glyphicon-download-alt\"></span></a>\n");
	}
?>
		</h4>

		<table class="table">
			<thead>
				<tr>
					<th>Experiment</th>
					<th>Session</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach (scandir("sessions/") as $file) {
		if (preg_match("/(.*)-(.*)/", base64_decode($file), $m)) {
			print("\t\t\t\t<tr>\n");
			print("\t\t\t\t\t<td>{$m[1]}</td>\n");
			print("\t\t\t\t\t<td>{$m[2]}</td>\n");
			print("\t\t\t\t\t<td><div class=\"btn-group\" role=\"group\">\n");
			print("<a class=\"btn btn-default\" href=\"test.php?experiment={$m[1]}&session={$m[2]}\"><span class=\"glyphicon glyphicon-pencil\"></span> edit</a>\n");
			print("<a class=\"btn btn-default\"  href=\"?delete={$m[1]}-{$m[2]}\"><span class=\"glyphicon glyphicon-remove\"></span> delete</a>\n");
			print("<a class=\"btn btn-default\" href=\"export.php?type=single&folder=sessions&file={$m[1]}-{$m[2]}&download=1\"><span class=\"glyphicon glyphicon-download-alt\"></span> download</a>\n");
			print("<a class=\"btn btn-default\" href=\"export.php?type=dot&folder=sessions&session={$m[1]}-{$m[2]}&download=1\"><span class=\"glyphicon glyphicon-picture\"></span> dot</a>\n");
			print("\t\t\t\t\t</div></td>\n");
			print("\t\t\t\t</tr>\n");
		}
	}
?>
			</tbody>
		</table>

		<h2>Finished sessions</h2>
		
		<h4>Download all:
<?php
	foreach ($experiments as $key => $val) {
		print("\t\t\t<a class=\"btn btn-default\" href=\"export.php?type=group&folder=finished&experiment={$key}\">{$key} <span class=\"glyphicon glyphicon-download-alt\"></span></a>\n");
	}
?>
		</h4>
		
		<table class="table">
			<thead>
				<tr>
					<th>Experiment</th>
					<th>Session</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach (scandir("finished/") as $file) {
		if (preg_match("/(.*)-(.*)/", base64_decode($file), $m)) {
			print("\t\t\t\t<tr>\n");
			print("\t\t\t\t\t<td>{$m[1]}</td>\n");
			print("\t\t\t\t\t<td>{$m[2]}</td>\n");
			print("\t\t\t\t\t<td><div class=\"btn-group\" role=\"group\">\n");
			print("<a class=\"btn btn-default\" href=\"show.php?experiment={$m[1]}&session={$m[2]}\"><span class=\"glyphicon glyphicon-search\"></span> show</a>\n");
			print("<a class=\"btn btn-default\" href=\"export.php?type=single&folder=finished&file={$m[1]}-{$m[2]}&download=1\"><span class=\"glyphicon glyphicon-download-alt\"></span> download</a>\n");
			print("<a class=\"btn btn-default\" href=\"export.php?type=dot&folder=finished&file={$m[1]}-{$m[2]}&download=1\"><span class=\"glyphicon glyphicon-picture\"></span> dot</a>\n");
			print("\t\t\t\t\t</div></td>\n");
			print("\t\t\t\t</tr>\n");
		}
	}
?>
			</tbody>
		</table>
<?php
	}
?>
	</body>
</html>