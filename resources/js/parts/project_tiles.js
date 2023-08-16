const { data } = require("jquery");

$(function() {
    //~~~~~~~~~~~~~~~~~~ Project tiles ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on("click", ".donate-projects-list .add", function(e) {
        e.stopPropagation();
        const fakePopup = $(".fake-popup");
        let projId = $(this).data("id");
        let popup;

        if ($(fakePopup).length) {
            const tilesPopup = $(this)
                .closest(".descr")
                .find(".tiles-popup-mobile");

            let contentTiles = $(tilesPopup).html();
            let classAttr = $(tilesPopup).attr("class");
            let tilesPopupWidth = $(tilesPopup).width();

            let dpl = $(this).closest(".donate-projects-list");
            let dplHeight = $(dpl).height();

            let thisPosition = $(this)
                .closest(".col-12")
                .position();
            let thisHeight = $(this)
                .closest(".col-12")
                .height();

            $(fakePopup).html(contentTiles);
            $(fakePopup).addClass(classAttr);
            $(fakePopup).removeClass("d-none");

            setTimeout(() => {
                let movePositionTop = thisPosition.top - dplHeight - 26;
                let movePositionLeft = thisPosition.left;
                let descrBlock = this.closest(".descr");
                let blockRects = descrBlock.getClientRects()[0];
                let movePositionRight = blockRects.left;

                $(fakePopup).css("top", movePositionTop);
                $(fakePopup).css("left", movePositionRight);
                $(fakePopup).width(blockRects.width);
            }, 0);

            $(document).on("click", ".fake-popup .close", function(e) {
                e.preventDefault();
                // $(".fake-popup").addClass("d-none");
                $(".fake-popup").removeClass("open");
                $(".fake-popup").css("min-height", 0);
            });
            popup = $(".fake-popup-wrapper .tiles-popup_" + projId);
        } else {
            popup = $(".tiles-popup_" + projId);
        }

        // $("[tiles-popup]").addClass("d-none");
        $("[tiles-popup]").removeClass("open");
        $("[tiles-popup]").css("min-height", 0);

        let el = $(".tiles-popup_" + projId + " form");
        let options = [];

        options = getPopupOptions(projId);
        $(".project_popup_options").text(JSON.stringify(options));

        restoreOptions(el, options);
        changeCampaignsDropdown(el);
        changeCategoriesDropdown(el);

        popup.removeClass("d-none");
        popup.addClass("open");
        popup.css("min-height", popup.closest(".item").height() + "px");

        /*$('#proj_tiles_modal_popup').modal('show')*/ // for mobile version
    });

    $(document).on("click", "[tiles-popup] .close", function() {
        // $("[tiles-popup]").addClass("d-none");
        $("[tiles-popup]").removeClass("open");
        $("[tiles-popup]").css("min-height", 0);
    });

    function restoreOptions(el, options) {
        let htmlOptions = "";
        if (options.single) {
            options.single.forEach(function(item, i, arr) {
                htmlOptions =
                    htmlOptions +
                    "<option value=" +
                    item.price +
                    ">" +
                    "£ " +
                    item.price +
                    "</option>";
            });

            el.find('select[name="price_single"]').html(htmlOptions);
        }

        htmlOptions = "";
        if (options.monthly) {
            options.monthly.forEach(function(item, i, arr) {
                htmlOptions =
                    htmlOptions +
                    "<option value=" +
                    item.price +
                    ">" +
                    "£ " +
                    item.price +
                    "</option>";
            });

            el.find('select[name="price_monthly"]').html(htmlOptions);
        }

        if (options.single && options.single.length) {
            let firstPrice = options.single[0].campaigns;

            htmlOptions = "";
            for (key in firstPrice) {
                htmlOptions =
                    htmlOptions +
                    "<option value=" +
                    key +
                    ">" +
                    "£ " +
                    firstPrice[key].name +
                    "</option>";
            }

            el.find('select[name="campaigns"]').html(htmlOptions);
        }
    }

    function getPopupOptions(projId) {
        let url = "/api/get_proj_options/" + projId;

        let options = [];

        $.ajax({
            async: false,
            type: "GET",
            url: url,
            success: function(response) {
                options = response.popup_options;
            },
            error: function(e) {}
        });

        return options;
    }

    //~~~~~~~~~~~~~~~~ Project tiles filters ~~~~~~~~~~~~~~~~~~~~~~

    $(document).on("click", "[donate-filter]", function() {
        let filter = $(this).data("filter");

        $("[filter-projects]").addClass("filter-projects--hidden");
        $(".filter_projects_" + filter).removeClass("filter-projects--hidden");
    });

    //~~~~~~~~~~~~~~~~ Project tiles after change type donate ~~~~~~~~~~~~~~~~~~~~~~
    $(document).on("change", "[tiles-options-type]", function() {
        let key = $(this).data("key");
        let val = $(this).val();
        $(".tiles-popup_" + key + " [tiles-option-price]").addClass("d-none");

        $(".tiles_options_" + val + "_" + key).removeClass("d-none");
    });

    $(document).on("change", "[tiles-form-options]", function() {
        changeCampaignsDropdown(this);
    });

    $(document).on("change", "[tiles-campaigns]", function() {
        changeCategoriesDropdown(this);
    });

    function changeCategoriesDropdown(element) {
        let form = $(element).closest("form");
        let type = form.find('select[name="period"]').val();
        let price = form.find('select[name="price_' + type + '"]').val();
        let campaign = form.find('select[name="campaigns"]').val();

        let options = $(".project_popup_options").html();
        options = JSON.parse(options);
        options = options[type];

        let campaigns = null;

        if (options === undefined) return;

        for (let i = 0; i < options.length; i++) {
            if (options[i]["price"] === price) {
                campaigns = options[i]["campaigns"];
                break;
            }
        }
        campaigns = campaigns[campaign];

        let categHtml = "";
        let categories = [];

        for (var campaigIndex in campaigns) {
            categories = campaigns[campaigIndex];
        }

        for (var categoryIndex in categories) {
            let category = categories[categoryIndex];
            categHtml =
                categHtml +
                '<option value="' +
                category +
                '">' +
                category +
                "</option>";
        }

        let categEl = $(element)
            .closest(".form")
            .find("[tiles-categories]");
        categEl.html(categHtml);

        if (categories.length < 2) {
            categEl.addClass("d-none");
        } else {
            categEl.removeClass("d-none");
        }
    }

    function changeCampaignsDropdown(element) {
        let form = $(element).closest("form");
        let type = form.find('select[name="period"]').val();
        let price = form.find('select[name="price_' + type + '"]').val();

        let options = $(".project_popup_options").html();
        options = JSON.parse(options);
        options = options[type];

        let campaigns = null;

        if (options === undefined) return;

        for (let i = 0; i < options.length; i++) {
            if (options[i]["price"] === price) {
                campaigns = options[i]["campaigns"];
                break;
            }
        }

        let campSelectHtml = "";

        for (var campaigIndex in campaigns) {
            let optName = campaigns[campaigIndex]["name"];
            campSelectHtml =
                campSelectHtml +
                '<option value="' +
                campaigIndex +
                '">' +
                optName +
                "</option>";
        }

        let campEl = $(element)
            .closest(".form")
            .find("[tiles-campaigns]");
        campEl.html(campSelectHtml);

        if (campaigns !== null) {
            if (Object.keys(campaigns).length < 2) {
                campEl.addClass("d-none");
            } else {
                campEl.removeClass("d-none");
            }
        }
    }
});
