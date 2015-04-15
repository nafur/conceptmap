<?php
	header("Content-Type: text/css");
	include("config.php");
?>
.demo {
    /* for IE10+ touch devices */
    touch-action:none;
}

.w {
    padding: 0px;
    padding-left: 7px;
    padding-right: 25px;
    position: absolute;
    z-index: 4;
    width: 13em;
    border: 1px solid #2e6f9a;
    box-shadow: 2px 2px 19px #e0e0e0;
    -o-box-shadow: 2px 2px 19px #e0e0e0;
    -webkit-box-shadow: 2px 2px 19px #e0e0e0;
    -moz-box-shadow: 2px 2px 19px #e0e0e0;
    -moz-border-radius: 8px;
    border-radius: 8px;
    opacity: 0.8;
    filter: alpha(opacity=80);
    cursor: move;
    background-color: white;
    font-size: 11px;
    -webkit-transition: background-color 0.25s ease-in;
    -moz-transition: background-color 0.25s ease-in;
    transition: background-color 0.25s ease-in;
}

.w:hover {
    //background-color: #5c96bc;
    //color: white;

}

.aLabel {
    -webkit-transition: background-color 0.25s ease-in;
    -moz-transition: background-color 0.25s ease-in;
    transition: background-color 0.25s ease-in;
}

.aLabel._jsPlumb_hover, ._jsPlumb_source_hover, ._jsPlumb_target_hover {
    //background-color: #1e8151;
    //color: white;
}

.aLabel {
    background-color: white;
    opacity: 0.8;
    padding: 0.3em;
    border-radius: 0.5em;
    border: 1px solid #346789;
    cursor: pointer;
}

.ep {
    position: absolute;
    top: 3px;
    bottom: 3px;
    right: 5px;
    width: 15px;
    background-color: orange;
    cursor: pointer;
    box-shadow: 0 0 2px black;
    -webkit-transition: -webkit-box-shadow 0.25s ease-in;
    -moz-transition: -moz-box-shadow 0.25s ease-in;
    transition: box-shadow 0.25s ease-in;
}

.ep:hover {
    box-shadow: 0px 0px 6px black;
}

.conceptmap ._jsPlumb_endpoint {
    z-index: 3;
}

<?php
	var_dump($css);
	for ($i = 0; $i < $maxexp; $i++) {
		print("#state{$i} {\n");
		print("\tleft: 10px;\n");
		print("\theight: {$css["height"]}px;\n");
		print("\tline-height: " . ($css["height"]) . "px;\n");
		print("\ttop: " . ($i * ($css["height"]+2)) . "px;\n");
		print("}\n");
		print("#state$i span { line-height: 12px; vertical-align: middle; display: inline-block; }");
	}
?>

.dragHover {
    border: 2px solid orange;
}

path, ._jsPlumb_endpoint { cursor:pointer; }
