$(function () {

    //~~~~~~~~~~~~~~~~~~ Project tiles ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '.donate-projects-list .add', function () {
        
        let popupKey = $(this).data('popup')
        let popup = $('.tiles-popup_' + popupKey)

        $('[tiles-popup]').addClass('d-none')

        let el = $('.tiles-popup_' + popupKey + ' form')

        changeCampaignsDropdown(el)
        changeCategoriesDropdown(el)

        popup.removeClass('d-none')
    });

    $(document).on('click', '[tiles-popup] .close', function () {
        
        $('[tiles-popup]').addClass('d-none')
    });

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
        let type = form.find('select[name="type"]').val()
        let price = form.find('select[name="price_' + type + '"]').val()
        let campaign = form.find('select[name="campaign"]').val()

        let options = $(element).closest('.form').find('.project_popup_options').html()
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
            category = categories[categoryIndex]
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
        let type = form.find('select[name="type"]').val()
        let price = form.find('select[name="price_' + type + '"]').val()

        let options = $(element).closest('.form').find('.project_popup_options').html()
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