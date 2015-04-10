jsPlumb.ready(function () {

	var logdata = new Array();
	
    function stateName(s) {
    	return $("#" + s + "-name").html();
    }
	function log(s, c, data) {
		if (data) logdata.push([s, stateName(c.sourceId), c.sourceId, stateName(c.targetId), c.targetId, data]);
		else logdata.push([s, stateName(c.sourceId), c.sourceId, stateName(c.targetId), c.targetId]);
	}

    // setup some defaults for jsPlumb.
    var instance = jsPlumb.getInstance({
        Endpoint: ["Dot", {radius: 2}],
        /*HoverPaintStyle: {strokeStyle: "#1e8151", lineWidth: 2 },*/
        ConnectionOverlays: [
            [ "Arrow", { location: 1, id: "arrow", length: 14, foldback: 0.8 } ],
            [ "Label", { label: "", id: "label", cssClass: "aLabel edit", location: 0.6 }],
            [ "Label", { label: "x", id: "delete", cssClass: "aLabel", location: 0.25,
            	events:{click:function(overlay,event){
            		var c = overlay.component;
            		log("detach", c);
            		jsPlumb.detach(c);
				}}
            }]
        ],
        Container: "conceptmap"
    });

    window.jsp = instance;
    var windows = jsPlumb.getSelector(".conceptmap .w");

    // initialise draggable elements.
    instance.draggable(windows, {containment: "parent"});
    
    // On create connection
    instance.bind("connection", function (info) {
    	log("connect", info);
        info.connection.getOverlay("label").setLabel("???");
        $(".edit").editable(function(value,settings){ 
        	log("rename", info, value);
        	return (value); 
		},{});
    });
    
    // Send data to server every few seconds
    function sendData() {
    	$.ajax({
    		type: "POST",
    		url: "ajax.php",
    		data: { "session": "test", "data": logdata },
    		success: function(data,status,xhr) {}
    	});
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
});
