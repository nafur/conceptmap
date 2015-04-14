jsPlumb.ready(function () {

	var logdata = new Array();
	var base = $.now();
	
    function stateName(s) {
    	return $("#" + s + "-name").html();
    }
	function log(s, c, d1, d2, d3) {
		var t = $.now() - base;
		var data = [s, t, stateName(c.sourceId), c.sourceId, stateName(c.targetId), c.targetId];
		if (d1) data.push(d1);
		if (d2) data.push(d2);
		if (d3) data.push(d3);
		logdata.push(data);
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
		var options = {name: "springy", animate: false, padding: 100, infinite: false, maxSimulationTime: 1000, random: true, fit: true, boundingBox: {x1: 0,y1: 0,w: $("#conceptmap").width()-100,h: $("#conceptmap").height()-100}};
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

	function undo() {
		if (logdata.length == 0) return;
		var a = logdata.pop();
		if (a[0] == "connect") {
			var c = instance.getConnections({source: a[3], target: a[5]})[0];
			jsPlumb.detach(c);
		} else if (a[0] == "detach") {
			var c = instance.connect({source: a[3], target: a[5]});
		} else if (a[0] == "rename") {
			var c = instance.getConnections({source: a[3], target: a[5]})[0];
			c.getOverlay("label").setLabel(a[6]);
		}
	}
	$("#undo").click(undo);
	function redo(data) {
		for (var i = 0; i < data.length; i++) {
			var c = data[i];
			if (c[0] == "connect") {
				instance.connect({source: c[3], target: c[5]});
			} else if (c[0] == "detach") {
				var conn = instance.getConnections({source: c[3], target: c[5]})[0];
				jsPlumb.detach(conn);
			} else if (c[0] == "rename") {
				var conn = instance.getConnections({source: c[3], target: c[5]})[0];
				conn.getOverlay("label").setLabel(c[6]);
			}
		}
		logdata = data;
	}
	
	
	function finish() {
		if (session != "") {
			$.ajax({
    			type: "POST",
    			url: "ajax.php",
    			data: { "session": experiment + "-" + session, "finish": "1", "data": logdata },
	    		success: function(data,status,xhr) {
    				alert("Thank you! You are being redirected...");
    				$(location).attr("href", "index.php");
    			}
	    	});
		}
	}
	$("#finish").click(finish);

    // initialise draggable elements.
    instance.draggable(windows, {containment: "parent"});

    // On create connection
    instance.bind("connection", function (info) {
    	log("connect", info);
        info.connection.getOverlay("label").setLabel("");
        $(".edit").editable(function(value,settings){ 
        	var c = instance.getConnections({source: info.sourceId, target: info.targetId});
        	for (i = 0; i < c.length; i++) {
        		if (c[i].id == info.connection.id) {
        			c = c[i];
        			break;
        		}
        	}
        	log("rename", info, c.getOverlay("label").label, value);
        	return (value); 
		},{});
		//info.connection.getOverlay("label").canvas.trigger("click");
    });
    
    // Send data to server every few seconds
    function sendData() {
    	if (session != "") {
	    	$.ajax({
    			type: "POST",
    			url: "ajax.php",
    			data: { "session": experiment + "-" + session, "data": logdata },
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
            connector: [ "StateMachine", { curviness: 20 } ],
            connectorStyle: { strokeStyle: "#5c96bc", lineWidth: 2, outlineColor: "transparent", outlineWidth: 4 },
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
    redo(restore_data);
    
    //$("#draggable").draggable();
});
