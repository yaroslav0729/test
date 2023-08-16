$(function() {
    if (document.querySelector('input[name="daterange"]')) {
        $('input[name="daterange"]').daterangepicker({
            opens: "left",
            timePicker: true,
            autoUpdateInput: false,
            locale: {
                cancelLabel: "Clear",
                format: "DD/MM/YYYY hh:mm:ss A"
            }
        });

        $('input[name="daterange"]').on("apply.daterangepicker", function(
            ev,
            picker
        ) {
            $(this).val(
                picker.startDate.format("DD/MM/YYYY hh:mm:ss A") +
                    " - " +
                    picker.endDate.format("DD/MM/YYYY hh:mm:ss A")
            );
        });

        $('input[name="daterange"]').on("cancel.daterangepicker", function(
            ev,
            picker
        ) {
            $(this).val("");
        });
    }
});
