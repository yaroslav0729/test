$(function() {
    const calculator = document.querySelector(".calculator");

    if (calculator) {
        initCalculatorForm();
    }

    function initCalculatorForm() {
        const inputs = document.querySelectorAll(
            '.calculator input[type="number"]'
        );

        for (let input of inputs) {
            input.addEventListener("keydown", e => {
                if (
                    e.keyCode == 189 ||
                    e.keyCode == 187 ||
                    e.keyCode == 109 ||
                    e.keyCode == 107
                ) {
                    e.preventDefault();
                }
            });
        }
    }
});
