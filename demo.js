jsPlumb.ready(function () {

    // setup some defaults for jsPlumb.
    var instance = jsPlumb.getInstance({
        Endpoint: ["Dot", {radius: 2}],
        HoverPaintStyle: {strokeStyle: "#1e8151", lineWidth: 2 },
        ConnectionOverlays: [
            [ "Arrow", {
                location: 1,
                id: "arrow",
                length: 14,
                foldback: 0.8
            } ],
            [ "Label", { label: "", id: "label", cssClass: "aLabel edit" }]
        ],
        Container: "conceptmap"
    });

    window.jsp = instance;

    var windows = jsPlumb.getSelector(".conceptmap .w");

    // initialise draggable elements.
    instance.draggable(windows);
    
    // bind a connection listener. note that the parameter passed to this function contains more than
    // just the new connection - see the documentation for a full list of what is included in 'info'.
    // this listener sets the connection's internal
    // id as the label overlay's text.
    instance.bind("connection", function (info) {
        info.connection.getOverlay("label").setLabel("???");
        $(".edit").editable(function(value,settings){ return (value); },{});
    });


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
            allowLoopback: true
        });

        // and finally, make a couple of connections
        //instance.connect({ source: "opened", target: "phone1" });
        //instance.connect({ source: "phone1", target: "phone1" });
        //instance.connect({ source: "phone1", target: "inperson" });
    });

    jsPlumb.fire("jsPlumbDemoLoaded", instance);

});
