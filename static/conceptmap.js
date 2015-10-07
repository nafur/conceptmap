jsPlumb.ready(function () {
	
	var past = new Array();
	var future = new Array();
	var baseTime = $.now();
	
    function stateName(s) {
    	return $("#" + s + "-name").html();
    }
	function log(s, c, d1, d2, d3) {
		var t = $.now() - baseTime;
		var data = [s, t, stateName(c.sourceId), c.sourceId, stateName(c.targetId), c.targetId];
		if (d1 !== null && d1 !== undefined) data.push(d1);
		if (d2 !== null && d2 !== undefined) data.push(d2);
		if (d3 !== null && d3 !== undefined) data.push(d3);
		past.push(data);
	}
	
	function checkTime() {
		var curTime = $.now();
		var diff = Math.floor((curTime - baseTime) / 1000);
		var min = Math.floor(diff / 60);
		var sek = Math.floor(diff % 60);
		
		if (min == 10 && sek == 0) alert("Bitte kommen Sie zum Ende.");
		
		if (sek < 10) sek = '0' + sek;
		$('#zeit').html(min + ':' + sek);		
	}

    // setup some defaults for jsPlumb.
    var instance = jsPlumb.getInstance({
        Endpoint: ["Dot", {radius: 2}],
        /*HoverPaintStyle: {strokeStyle: "#1e8151", lineWidth: 2 },*/
        ConnectionOverlays: [
            [ "Arrow", { location: 1, id: "arrow", length: 14, foldback: 0.8 } ],
			[ "Label", { label: "", id: "label", cssClass: "aLabel edit", location: 0.6 }],
            [ "Label", { label: "<span class=\"glyphicon glyphicon-remove\"></span>", id: "delete", cssClass: "aLabel", location: 0.25,
            	events:{click:function(overlay,event){
            		var c = overlay.component;
            		log("detach", c, c.getOverlay("label").getLabel());
            		jsPlumb.detach(c);
				}}
            }]
        ],
        Container: "conceptmap"
    });

    window.jsp = instance;
    var windows = jsPlumb.getSelector(".conceptmap .w");
    
    function layout() {
		var instance = window.jsp;
		var options = {name: "springy", repulsion: 10000, animate: false, padding: 100, infinite: false, maxSimulationTime: 1000, random: true, fit: true, boundingBox: {x1: 0,y1: 0,w: $("#conceptmap").width()-100,h: $("#conceptmap").height()-100}};
//		var options = {name: "cola", maxSimulationTime: 1000, randomize: true, fit: false, boundingBox: {x1: 0,y1: 0,w: $("#conceptmap").width() - 150,h: $("#conceptmap").height() - 150}};
		var cy = cytoscape({headless: true, layout: options});
		$('.w').each(function(i,obj){ cy.add({ group: "nodes", data: {id: obj.id}, position: {x: i*20, y: i*20} }); });
		var cons = instance.getAllConnections();
		$.each(cons, function(i,obj){ cy.add({ group: "edges", data: {source: obj.sourceId, target: obj.targetId} }); });
		var layout = cy.makeLayout(options);
		layout.run();
		setTimeout(function(){ 
			layout.stop();
			$.each(cy.json().elements.nodes, function(i,obj){ var o = $("#" + obj.data.id); o.css("left",obj.position.x); o.css("top", obj.position.y); o.simulate("drag", {moves: 1, dx: 1, dy: 0}); });
		}, 1000);
	}
	$("#layout").click(layout);

	function backward() {
		if (past.length == 0) return;
		var a = past.pop();
		future.push(a);
		if (a[0] == "connect") {
			var c = instance.getConnections({source: a[3], target: a[5]})[0];
			jsPlumb.detach(c);
		} else if (a[0] == "detach") {
			var c = instance.connect({source: a[3], target: a[5]});
			past.pop();
		} else if (a[0] == "rename") {
			var c = instance.getConnections({source: a[3], target: a[5]})[0];
			c.getOverlay("label").setLabel(a[6]);
		}
//		alert(past + " -- " + future);
	}
	$("#backward").click(backward);
	function forward() {
		if (future.length == 0) return;
		var c = future.pop();
		past.push(c);
		if (c[0] == "connect") {
			instance.connect({source: c[3], target: c[5]});
			past.pop();
		} else if (c[0] == "detach") {
			var conn = instance.getConnections({source: c[3], target: c[5]})[0];
			jsPlumb.detach(conn);
		} else if (c[0] == "rename") {
			var conn = instance.getConnections({source: c[3], target: c[5]})[0];
			conn.getOverlay("label").setLabel(c[7]);
		}
//		alert(past + " -- " + future);
	}
	$("#forward").click(forward);
	
	function findEmptyLabels() {
		var res = [];
		var conns = instance.getConnections();
		for (var i = 0; i < conns.length; i++) {
			var ol = conns[i].getOverlay("label");
			var str = ol.canvas.innerHTML;
			if (str == "Click to edit") res.push(ol.canvas);
		}
		return res;
	}
	
	function finish() {
		if (session != "") {
			var empty = findEmptyLabels();
			if (empty.length > 0) {
				if (!confirm("Du hast noch unbeschriftete Pfeile. Bist du dir sicher, dass du abgeben möchtest?")) {
					$.each(empty, function(i,e){$(e).css("background-color", "red");});
					setTimeout(function(){
						$.each(empty, function(i,e){$(e).css("background-color", "");});
					}, 1000);
					return;
				}
			}
			if (confirm("Möchtest du die ConceptMap wirklich abschließen?") === true) {
				$.ajax({
    				type: "POST",
    				url: "ajax.php",
    				data: { "session": experiment + "-" + session, "finish": "1", "data": past },
	    			success: function(data,status,xhr) {
    					alert("Vielen Dank!");
    					$(location).attr("href", "index.php");
    				}
	    		});
	    	}
		}
	}
	$("#finish").click(finish);
	
	function screenshot() {
		html2canvas(document.body, {
			logging: true,
			useCORS: true,
			allowTaint: true,
			onrendered: function (canvas) {
				img = canvas.toDataURL("image/png");
				console.log(img);
				window.open(img);
			}
		});
	};
	$("#screenshot").click(screenshot);

    // initialise draggable elements.
    instance.draggable(windows, {containment: "parent", handle: ".w-drag"});
    
    function triggerClick(elem) {
    	if (elem.click) elem.click();
    	else {
			var ev = document.createEvent("MouseEvents");
			ev.initEvent("click", true /* bubble */, true /* cancelable */);
			elem.dispatchEvent(ev);
    	}
    }

    // On create connection
    instance.bind("connection", function (info) {
    	log("connect", info);
		instance.recalculateOffsets("conceptmap");
		instance.repaintEverything();
        info.connection.getOverlay("label").setLabel("");
        $(".edit").editable(function(value,settings,arg){ 
        	if (arg != value) {
	        	log("rename", info, arg, value);
			}
        	return (value); 
		},{
			submitdata: function(val,settings) { return {original: this.revert}; },
			onblur: "submit"
		});
		var label = info.connection.getOverlay("label").canvas;
    	triggerClick(label);
    });
    
    // Send data to server every few seconds
    function sendData() {
    	if (session != "") {
	    	$.ajax({
    			type: "POST",
    			url: "ajax.php",
    			data: { "session": experiment + "-" + session, "data": past },
	    		success: function(data,status,xhr) {}
    		});
		}
    }
    setInterval(sendData, 3000);


    // suspend drawing and initialise.
    instance.batch(function () {
        instance.makeSource(windows, {
            filter: ".ep",
            anchor: "Continuous",
            connector: [ "Straight" ],
            connectorStyle: { strokeStyle: "#5c96bc", lineWidth: 2, outlineColor: "transparent", outlineWidth: 2 },
            maxConnections: 5,
            onMaxConnections: function (info, e) {
                alert("Maximum connections (" + info.maxConnections + ") reached");
            }
        });

        // initialise all '.w' elements as connection targets.
        instance.makeTarget(windows, {
            dropOptions: { hoverClass: "dragHover" },
            anchor: "Continuous",
            allowLoopback: false
        });

    });
    
    //while (restore_data.length > 0) {
    //	future.push(restore_data.pop());
    //}
    if ($("#zeit").length) {
		setInterval(checkTime, 500);
    }
});

