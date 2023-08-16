$(function() {
    let fields = document.querySelectorAll("#filters .form-control");
    let exportBtn = document.querySelector("#export");

    let href = exportBtn.href;
    let values = {};

    if (exportBtn.dataset.qurbani) {
        values['qurbani'] = true;
    }
    for (let field of fields) {
        values[field.name] = field.value;
        let event =
            field.tagName === "INPUT" && field.name !== "daterange"
                ? "keyup"
                : "change";
        if (field.name === "daterange") {
            $('input[name="daterange"]').on("apply.daterangepicker", function(
                ev,
                picker
            ) {
                $(this).val(
                    picker.startDate.format("DD/MM/YYYY hh:mm:ss A") +
                        " - " +
                        picker.endDate.format("DD/MM/YYYY hh:mm:ss A")
                );
                values[field.name] = field.value;
                exportBtn.href = href + "?" + valuesToQuery(values);
            });
        } else {
            field.addEventListener(event, function(e) {
                values[field.name] = field.value;
                exportBtn.href = href + "?" + valuesToQuery(values);
            });
        }
    }
    exportBtn.href = href + "?" + valuesToQuery(values);

    function valuesToQuery(values) {
        let string = "";
        for (let filter in values) {
            string = `${string}${filter}=${values[filter]}&`;
        }

        return string;
    }
});
