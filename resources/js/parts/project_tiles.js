const { data } = require("jquery");

$(function () {

    //~~~~~~~~~~~~~~~~~~ Project tiles ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '.donate-projects-list .add', function () {

        let projId = $(this).data('id')
        let popup = $('.tiles-popup_' + projId)
        $('[tiles-popup]').addClass('d-none')

        let el = $('.tiles-popup_' + projId + ' form')

        let options = [];
        options = getPopupOptions(projId)
        $('.project_popup_options').text(JSON.stringify(options))

        restoreOptions(el, options)
        changeCampaignsDropdown(el)
        changeCategoriesDropdown(el)

        popup.removeClass('d-none')

        $('#proj_tiles_modal_popup').modal('show') // for mobile version
    });

    $(document).on('click', '[tiles-popup] .close', function () {

        $('[tiles-popup]').addClass('d-none')
    });

    function restoreOptions(el, options) {

        let htmlOptions = ''
        options.single.forEach(function(item, i, arr) {
            htmlOptions = htmlOptions + '<option value=' + item.price + '>' + item.price + '</option>'
        });

        el.find('select[name="price_single"]').html(htmlOptions)

        htmlOptions = ''
        options.monthly.forEach(function(item, i, arr) {
            htmlOptions = htmlOptions + '<option value=' + item.price + '>' + item.price + '</option>'
        });

        el.find('select[name="price_monthly"]').html(htmlOptions)

        let firstPrice = options.single[0].campaigns

        htmlOptions = ''
        for (key in firstPrice) {
            htmlOptions = htmlOptions + '<option value=' + key + '>' + firstPrice[key].name + '</option>'
        }

        el.find('select[name="campaigns"]').html(htmlOptions)
    }

    function getPopupOptions(projId) {
        let url = '/api/get_proj_options/' + projId

        let options = []

        $.ajax({
            async: false,
            type: 'GET',
            url: url,
            success: function(response) {
                options = response.popup_options
            },
            error: function(e) {
            },
       });

       return options
    }

    //~~~~~~~~~~~~~~~~ Project tiles filters ~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '[donate-filter]', function () {

        let filter = $(this).data('filter')

        $('[filter-projects]').addClass('d-none')
        $('.filter_projects_' + filter).removeClass('d-none')
    });

    $(document).on('change', '[tiles-options-type]', function () {

        let key = $(this).data('key')
        let val = $(this).val()
        $('.tiles-popup_' + key + ' [tiles-option-price]').addClass('d-none')

        $('.tiles_options_' + val +  '_' + key).removeClass('d-none')
    });

    $(document).on('change', '[tiles-form-options]', function () {

        changeCampaignsDropdown(this)
    });

    $(document).on('change', '[tiles-campaigns]', function () {

        changeCategoriesDropdown(this)
    });

    function changeCategoriesDropdown(element)
    {
        let form = $(element).closest('form')
        let type = form.find('select[name="period"]').val()
        let price = form.find('select[name="price_' + type + '"]').val()
        let campaign = form.find('select[name="campaigns"]').val()

        let options = $('.project_popup_options').html()
        options = JSON.parse(options)
        options = options[type]

        let campaigns = null;

        if (options === undefined) return

        for (let i=0;i<options.length; i++) {
            if (options[i]['price'] === price) {
                campaigns = options[i]['campaigns'];
                break;
            }
        }
        campaigns = campaigns[campaign]

        let categHtml = ''
        let categories = []

        for (var campaigIndex in campaigns) {
            categories = campaigns[campaigIndex]
        }

        for (var categoryIndex in categories) {
            let category = categories[categoryIndex]
            categHtml = categHtml + '<option value="' + category +  '">' + category  + '</option>'
        }

        let categEl = $(element).closest('.form').find('[tiles-categories]')
        categEl.html(categHtml)

        if (categories.length < 2) {
            categEl.addClass('d-none')
        } else {
            categEl.removeClass('d-none')
        }
    }

    function changeCampaignsDropdown(element)
    {
        let form = $(element).closest('form')
        let type = form.find('select[name="period"]').val()
        let price = form.find('select[name="price_' + type + '"]').val()

        let options = $('.project_popup_options').html()
        options = JSON.parse(options)
        options = options[type]

        let campaigns = null;

        if (options === undefined) return

        for (let i=0;i<options.length; i++) {
            if (options[i]['price'] === price) {
                campaigns = options[i]['campaigns'];
                break;
            }
        }

        let campSelectHtml = ''

        for (var campaigIndex in campaigns) {
            let optName = campaigns[campaigIndex]['name']
            campSelectHtml = campSelectHtml + '<option value="' + campaigIndex +  '">' + optName  + '</option>'
        }

        let campEl = $(element).closest('.form').find('[tiles-campaigns]')
        campEl.html(campSelectHtml)

        if (campaigns !== null) {
            if (Object.keys(campaigns).length < 2) {
                campEl.addClass('d-none')
            } else {
                campEl.removeClass('d-none')
            }
        }
    }

})
