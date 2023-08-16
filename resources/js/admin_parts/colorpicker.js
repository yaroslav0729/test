require("bootstrap-colorpicker");

$(function() {
    const color = $("#colorpicker").data("color");
    $("#colorpicker").colorpicker({ color: color });

    $("#colorpicker").on("colorpickerChange", function(event) {
        $("#demo").css("background-color", event.color.toString());
    });
});
