<?php
$experiments = Array(
	"Blutkreislauf" => Array(
		"Blut",
		"Serienschaltung",
		"Blutkreislauf",
		"Herz",
		"Paraffinöl",
		"Parallelschaltung",
		"Strömungsmechanik",
		"Aorta",
		"Kolbenpumpe",
		"Strömung",
		"Druck",
		"Windkessel",
		"Verschlussventil",
		"Blutgefäße",
		"Ventilklappe",
		"Rohre",
		"Herzklappen",
		"Modell",
	),
	"Ionenkanone" => Array(
		"Ionen",
		"Kanone",
	),
);
$maxexp = 0;
foreach ($experiments as $key => $val) $maxexp = max($maxexp, count($val));

if (isset($_GET["experiment"])) {
	$experiment = $experiments[$_GET["experiment"]];
	$experiment_name = $_GET["experiment"];
} else {
	$experiment = Array();
	$experiment_name = "";
}
if (isset($_GET["session"])) {
	$session = $_GET["session"];
} else {
	$session = "";
}

?>