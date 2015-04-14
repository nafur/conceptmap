<!doctype html>
<?php
	if (isset($_GET["delete"])) {
		unlink("sessions/{$_GET["delete"]}");
	}
	include("config.php");
?>
<html>
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
	</head>
	<body style="padding: 10px;">
<?php if(!$admin) { ?>
		<div class="pull-right">
			<a class="btn btn-default" href="admin.php">Admin</a>
		</div>
<?php } ?>
		<h2>Create new session</h2>
		<form action="test.php" class="form-horizontal">
			<div class="form-group">
				<label for="experiment" class="col-sm-2 control-label">Experiment</label>
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
			<div class="form-group">
				<label for="session" class="col-sm-2 control-label">Session</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" name="session" placeholder="Session name" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Create</button>
				</div>
			</div>
		</form>
<?php
	if ($admin) {
?>		
		<h2>Current sessions</h2>
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
		if (preg_match("/(.*)-(.*)/", $file, $m)) {
			print("\t\t\t\t<tr>\n");
			print("\t\t\t\t\t<td>{$m[1]}</td>\n");
			print("\t\t\t\t\t<td>{$m[2]}</td>\n");
			print("\t\t\t\t\t<td><div class=\"btn-group\" role=\"group\">\n");
			print("<a class=\"btn btn-default\" href=\"test.php?experiment={$m[1]}&session={$m[2]}\"><span class=\"glyphicon glyphicon-pencil\"></span> edit</a>\n");
			print("<a class=\"btn btn-default\"  href=\"?delete={$m[1]}-{$m[2]}\"><span class=\"glyphicon glyphicon-remove\"></span> delete</a>\n");
			print("\t\t\t\t\t</div></td>\n");
			print("\t\t\t\t</tr>\n");
		}
	}
?>
			</tbody>
		</table>

		<h2>Finished sessions</h2>
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
		if (preg_match("/(.*)-(.*)/", $file, $m)) {
			print("\t\t\t\t<tr>\n");
			print("\t\t\t\t\t<td>{$m[1]}</td>\n");
			print("\t\t\t\t\t<td>{$m[2]}</td>\n");
			print("\t\t\t\t\t<td><div class=\"btn-group\" role=\"group\">\n");
			print("<a class=\"btn btn-default\" href=\"show.php?experiment={$m[1]}&session={$m[2]}\"><span class=\"glyphicon glyphicon-search\"></span> show</a>\n");
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