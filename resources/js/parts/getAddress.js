$(function() {
    let url = `https://api.getAddress.io/find/`;
    const API_KEY = "0zeBgC6w_EOZzWrPUkHY5w32518";
    const resultsContainer = document.querySelector("#postcode-results");
    const formFields = {
        line_1: "address_1",
        line_2: "address_2",
        city: "city",
        post_code: "post_code"
    };
    let addressList = [];

    function searchByPostCode(postCode) {
        $.ajax({
            url: `${url}${postCode}?api-key=${API_KEY}&expand=true`,
            method: "GET",
            success: function(response) {
                addressList = [];
                for (let address of response.addresses) {
                    addressList.push({
                        line_1: address.line_1,
                        line_2: address.line_2,
                        city: address.town_or_city,
                        country:
                            address.country === "England"
                                ? "United Kingdom (UK)"
                                : address.country,
                        post_code: postCode
                    });
                }
                insertList(addressList);
                setTimeout(() => {
                    addClickListenersToList();
                });
                showResultsContainer();
            }
        });
    }

    function initPostCodeField() {
        let timer = null;
        $("#postcode-finder").on("keyup", function(e) {
            clearTimeout(timer);
            timer = setTimeout(() => {
                searchByPostCode(this.value);
            }, 1000);
        });
        $("#postcode-finder").on("focus", function() {
            if (addressList.length) {
                showResultsContainer();
            }
        });
        $("#postcode-finder").on("blur", function() {
            setTimeout(() => {
                hideResultsContainer();
            }, 200);
        });
    }

    function insertList(addresses) {
        let listContainer = '<ul class="postcode-results__list">';
        let i = 0;
        for (let address of addresses) {
            let line1 = `${address.line_1}${
                address.line_2 ? ", " + address.line_2 : ""
            }`;
            let addressString = `${line1}, ${address.city}, ${address.country}`;
            let listItem = `<li class="postcode-results__list-item" data-index="${i}" data-postcode="${address.post_code}" data-line1="${address.line_1}" data-line2="${address.line_2}" data-city="${address.city}" data-country="${address.country}">${addressString}</li>`;
            listContainer += listItem;
            i++;
        }

        listContainer = `${listContainer}</ul>`;
        resultsContainer.innerHTML = listContainer;
    }

    function addClickListenersToList() {
        let listItems = document.querySelectorAll(
            ".postcode-results__list-item"
        );
        for (let item of listItems) {
            item.addEventListener("click", function(e) {
                hideResultsContainer();
                fillForm(addressList[e.target.dataset.index]);
                $(".manual-address").show();
            });
        }
    }

    function showResultsContainer() {
        resultsContainer.classList.remove("d-none");
    }

    function hideResultsContainer() {
        resultsContainer.classList.add("d-none");
    }

    function fillForm(address) {
        for (let key in address) {
            if (key === "country") {
                $("#country option:contains('" + address[key] + "')").prop(
                    "selected",
                    true
                );
            } else {
                document.querySelector(`[name="${formFields[key]}"]`).value =
                    address[key];
            }
        }
    }

    initPostCodeField();
});
