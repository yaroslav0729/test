window._ = require('lodash');
window.Popper = require('popper.js').default;

window.$ = window.jQuery = require('jquery');
require('bootstrap');

require('tinymce');

window.toastr  = require ('toastr');

/*import Swiper from 'swiper';
window.Swiper = Swiper*/

require('bootstrap-input-spinner');

import Swiper from 'swiper';
import SwiperCore, { Navigation, Pagination } from 'swiper';

SwiperCore.use([Navigation, Pagination]);

import { initWysiwyg } from './admin_parts/init_tiny-mce';

require('./parts/project_tiles.js')
require('./parts/donate_module.js')
require('./parts/cart.js')
require('./functions.js')

var MODAL_FORM_LOCK = false

$(function () {

    $(document).on('submit', '[modal-form]', function (event) {
        event.preventDefault();

        if (MODAL_FORM_LOCK) {
            return false;
        }

        MODAL_FORM_LOCK = true;

        let stub = $('[stub-fields] input, [stub-fields] select, [stub-fields] textarea', this);
        stub.attr('disabled', 'disabled');

        $('#modal-errors').closest('div').hide();
        $('#modal-message-success').closest('div').hide();
        $('[data-error].text-danger,.invalid-feedback', this).hide();

        var form = $(this);
        var formData = new FormData(form[0]);

        $.ajax({
            url     : form.attr('action'),
            type    : form.attr('method'),
            data    : formData,
            processData: false,
            contentType: false,
            success : function (response, textStatus, jqXHR)
            {
                stub.removeAttr('disabled');
                MODAL_FORM_LOCK = false;

                if ('content' in response) {
                    let element = $('#response-content');
                    element.html(response.content);
                    element.trigger('process');
                    $('#modal-wrap').modal('hide');

                    return;
                }

                if (response.trigger_click) {
                    $('#modal-wrap').modal('hide');
                    $(response.trigger_click).trigger('click');
                    return;
                }

                if (response.blank) {
                    var win = window.open(response.blank, '_blank');
                }

                if (response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }

                if (response.messageSuccess) {
                    $('#modal-message-success').html(response.messageSuccess);
                    $('#modal-message-success').closest('div').show();
                    $('#modal-wrap').animate({ scrollTop: 0 }, 'slow');
                    return;
                }

                window.location.reload();
            },
            error: function(response)
            {
                stub.removeAttr('disabled');
                MODAL_FORM_LOCK = false;

                if (response.status === 422) {

                    // Hide previous errors
                    $('#modal-errors').closest('div').hide();
                    $('*', form).removeClass('is-invalid');
                    $('.invalid-feedback', form).removeClass('d-block');

                    let message = '';
                    let showed = [];
                    let control, feedback, controlMessages;

                    $.each(response.responseJSON.errors, function (field, errors) {

                        // Field can be dotted (array-input)
                        let original = field;
                        let parts = original.split('.');
                        if (parts.length > 1) {
                            field = parts.shift() + '[' + parts.join('][') + ']';
                        }

                        // Try to find field with error container.
                        control = $('[name="' + field + '"]', form);
                        feedback = $('.invalid-feedback', control.parents('div.form-group'));
                        if (!feedback.length) {
                            feedback = $('[data-error="'+original+'"]');
                        }
                        controlMessages = [];

                        $.each(errors, function (i, error) {

                            if (feedback.length) {
                                controlMessages[controlMessages.length] = error;

                            } else {
                                if (showed.indexOf(error) < 0) {
                                    message += '<li>'+error+'</li>';
                                    showed[showed.length] = error;
                                }
                            }
                        });

                        if (control.length) {
                            control.addClass('is-invalid');
                        }

                        if (feedback.length && controlMessages.length) {
                            feedback.html(controlMessages.join('<br>'));
                            feedback.addClass('d-block');
                        }
                    });

                    if (message) {
                        $('#modal-errors').html(message);
                        $('#modal-errors').closest('div').show();
                    }

                    $('html, body').animate({ scrollTop: 0 }, 100);

                } else {
                    $('#modal-wrap').modal('hide');
                }
            }
        })
    })

    initWysiwyg();
    initSwiper();

    setTimeout(resizeRelatedTopicsItems, 100);
    setTimeout(initTriggers, 100);

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('change', '[name="template"]', selectTemplateRequest);

    function selectTemplateRequest(event) {

        let url = '/admin/get_template_form/' + event.target.value
        var data = {};
        data['current_page_instance_id'] = $('#page_parameters').data('current_page_instance_id')
        $.get(url, data, templateResponse, 'json');
    }

    function templateResponse(response) {
        $('#page_parameters').html(response.html);

        initWysiwyg()
    }
    //~~~~~~~~~~~~~~~~~~~~~~ Filter Events type on Events page ~~~~~~~~~~~~~~~~

    $(document).on('click', '.filter', function () {
        let pathName = window.location.pathname;
        let data = {};

        data['type'] = $('#filter-type').val();
        data['participate'] = $('#filter-participate').val();
        data['perPage'] = $('#per-page').val();

        let existUlrParams = getUrlVars()

        if (existUlrParams.length > 1) {
          data['name'] = existUlrParams.name;
          data['location'] = existUlrParams.location;
          data['date'] = existUlrParams.date;
        }

        $.ajax({
            url     : pathName,
            methods : 'GET',
            data    : data,
            success : function (response) {
                if (response.status === 'success') {
                    $('#events-content').html(response.html);
                }
            },
            error: function() {
                toastr.error('Unknown error ','Error');
            }
        });

    });

    /**
     * Split QueryString to params
     */
    function getUrlVars()
    {
        let vars = [], hash;
        let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

        for(let i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }

        return vars;
    }

    //~~~~~~~~~~~~~~~~~~~~~~~~~~ Video-carousel widget ~~~~~~~~~~~~~~~~

    $(document).on('click', '.blog-video .view-more', nextVideoClickHandler);

    function nextVideoClickHandler() {
        let paramsBlock = $(this).next('.blog-video-parameters');
        let iframeBlock = $(this).closest('.blog-video');

        let current = parseInt(paramsBlock.data('current'))
        let linksLenght = paramsBlock.find('li').length

        current++
        if (current>=linksLenght) {
            current = 0
        }

        paramsBlock.data('current', current)

        let link = paramsBlock.find('li:eq(' + current + ')').text()
        link = "https://www.youtube.com/embed/" + link
        iframeBlock.find('iframe').attr('src', link)
    }

    //~~~~~~~~~~~~ Join the cause - subscribe form ~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '#join_the_cause_show_form', function(e) {

        e.preventDefault();

        let mainForm =  $('.join-cause-main')
        let hiddenForm = $('.join-cause-hidden')

        mainForm.addClass('d-none')
        hiddenForm.removeClass('d-none')
    })

    function validateEmail(email)
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    $(document).on('click', '#subscription_sbmt', function(e) {

        e.preventDefault()

        var form = $('#subscription_form');
        var formData = new FormData(form[0]);

        let email = form.find('input[name="email"]').val()
        let validate = validateEmail(email)

        if (!validate) {
            toastr.warning('Enter valid email address','Wrong email')
            return
        }

        $.ajax({
            url     : form.attr('action'),
            type    : form.attr('method'),
            data    : formData,
            processData: false,
            contentType: false,
            success : function (response, textStatus, jqXHR)
            {
                if (response.success) {
                    toastr.success(response.message)
                } else {
                    toastr.error(response.message)
                }
            },
            error: function(response) {

                if (response.responseJSON.errors) {
                    toastr.error(response.responseJSON.errors['email'][0])
                } else {
                    toastr.error('Unknown error ','Error')
                }
            }
        });

    });

    //~~~~~~~~~~~~~~~~~ Related topics module ~~~~~~~~~~~~~~~~~~

    $( window ).on('resize', function() {
        resizeRelatedTopicsItems();
    });

    function resizeRelatedTopicsItems() {

        let max = 0

        for (let i = 1; i<4; i++) {
            let els = $('.current-projects-list span.descr')
            els.height('auto');

            els.each(function( index ) {
                let el = $(this)

                let h1 = el.height()
                if (h1 > max) {
                    max = h1
                }
            });
        }

        $('.current-projects-list span.descr').height(max)
    }

    //~~~~~~~~~~~~~~~~ add prices ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('submit', '[prices-form]', function (event) {
        //event.preventDefault();

        // remove stup items
        let stub = $('[stub-fields] input, [stub-fields] select, [stub-fields] textarea', this);
        stub.attr('disabled', 'disabled');

        return true
    });

    $(document).on('click', '[price-add]', function () {
        let wrap = $(this).closest('[price-container]');
        let priceList = $('[price-list]', wrap);
        priceList.append($('[price-stub]', wrap).html());
    });

    $(document).on('click', '[price-delete]', function () {
        let wrap = $(this).closest('.price').remove();
    });

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('submit', '[options-form]', function (event) {
        //event.preventDefault();

        // remove stup items
        let stub = $('[stub-fields] input, [stub-fields] select, [stub-fields] textarea', this);
        stub.attr('disabled', 'disabled');

        return true
    });

    $(document).on('click', '[option-add]', function () {
        let wrap = $(this).closest('[options-container]');
        let optionsList = $('[options-list]', wrap);
        let html = $('[option-stub]', wrap).html()


        //let len = $('.option', optionsList).length // length in current list
        let len = $('.option', '[options-list]').length // length in all page

        html = html.replace(/{new}/gi, len);
        optionsList.append(html);
    });

    $(document).on('click', '[option-delete]', function () {
        let wrap = $(this).closest('.option').remove();
    });

    //~~~~~~~~~~~~~~~~~~ change map in the who we are page ~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '#btn-view-global-work', function (event) {
        event.preventDefault()

        let mapBlock = $(this).parent();
        let altSrc = $(mapBlock).attr('alt-src');
        $(mapBlock).attr('style', 'background-image: url("' + altSrc + '")');
        this.remove();
        $('.gw-map-btn').css('margin-top', 0);
    });

    //~~~~~~~~~~~~~~~~~~ input type=date manipulation ~~~~~~~~~~~~~~~~~~~~

    initDate();

    $(document).on('focus', '#date-picker', function (event) {
        let valStr = $(this).val();
        $(this).attr('type', 'date');

        if (valStr !== '') {
            let replaceStr = valStr.replace(/\./g, '-');
            $(this).val(reverseDate(replaceStr));
        }

    });

    $(document).on('blur', '#date-picker', function (event) {
        let valStr = $(this).val();
        $('#date-picker-real').val(valStr);
        $(this).attr('type', 'text');

        $(this).val(reverseDate(valStr).replace(/\-/g, '.'));

    });

    function reverseDate(strDate) {
        if (strDate !== '') {
            let splitedStrArr = strDate.split('-');
            strDate = splitedStrArr.reverse().join('-');
        }

        return strDate;
    }

    function initDate() {
        let dateField = ('#date-picker');

        if ($(dateField).val() !== undefined) {
            $('#date-picker-real').val($(dateField).val());
            let reverseStr = reverseDate($(dateField).val());
            $(dateField).val(reverseStr.replace(/\-/g, '.'));
        }
    }


    //~~~~~~~~~~~~~~~~~~ toggle search button on the Events page ~~~~~~~~~~~~~~~~~~~~

    $(document).on('input', '#events input', function (event) {
        const section = $('#events');
        const inputs = $('#events input');

        if (areElementsEmpty('#events input') === true) {
            $(section).removeClass('view-btn');
            $('.swiper').show();
        }
        else {
            $(section).addClass('view-btn');
            $('.swiper').hide();
        }
    });


    //~~~~~~~~~~~~~~~~~~ toggle value currency on the Calculator page ~~~~~~~~~~~~~~~~~~~~

    $(document).on('change', '#currency', function () {
        let btnCurrency = $('#btn-currency');
        let value = $(this).val();

        $(btnCurrency).html('£' + value);
    });


    //~~~~~~~~~~~~~~~~~~ toggle value currency on the Calculator page ~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '#btn-calculate', function () {
        const totalAssets = $('#total-assets');
        const zakatPayable = $('.zakat-payable');
        const btnDonateMobile = $('#btn-donate-mobile');
        const sectionProjects = $('.donate-projects-list');

        let debitCollection = $('.debit-money');
        let creditCollection = $('.credit-money');
        let metalPrice = isNaN(+($('#currency').val())) ? 0 : +($('#currency').val());

        let zakat = 0;

        let debit = multiplyVal(debitCollection);
        let credit = multiplyVal(creditCollection);

        let asset = debit - credit;

        $(totalAssets).addClass('bg-primary-light');
        const divAssets = $(totalAssets).find('.money-val').addClass('text-info');
        $(divAssets).find('b').html('£' + convertMonetary(asset.toFixed(2)));

        const divZakat = $(zakatPayable).find('.money-val');

        if (asset >= metalPrice) {
            sectionProjects.removeClass('d-none');

            zakat = asset * 0.025;

            $('#zakat-pay').addClass('bg-danger-light');
            $(divZakat).addClass('text-danger');

            $('#total-zakat').find('.money-val').addClass('text-danger');

            let zakatValue = convertMonetary(zakat.toFixed(2));

            $(divZakat).find('b').html('£' + zakatValue);
            $(divZakat).find('input[name="zakat_value"]').val(zakat.toFixed(2));
            $(btnDonateMobile).removeClass('disabled');
        } else {
            $('#zakat-pay').removeClass('bg-danger-light');
            sectionProjects.addClass('d-none');

            $(divZakat).removeClass('text-danger');
            $(divZakat).find('b').html('£0.00');
            $(divZakat).find('input[name="zakat_value"]').val(0)
            $(btnDonateMobile).addClass('disabled');
        }
    });

    //~~~~~~~~~~~~~~~~~~ Set empty and clear Class for input fields ~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '#btn-reset', function () {
        const totalAssets = $('#total-assets');
        const zakatPayable = $('.zakat-payable');
        const btnDonateMobile = $('#btn-donate-mobile');
        const sectionProjects = $('.donate-projects-list');

        let debitCollection = $('.debit-money');
        let creditCollection = $('.credit-money');

        $('#total-zakat').find('.money-val').removeClass('text-danger');
        $(totalAssets).removeClass('bg-primary-light');
        $('#zakat-pay').removeClass('bg-danger-light');
        sectionProjects.addClass('d-none');

        const divVal = $(totalAssets).find('.money-val').removeClass('text-info');
        $(divVal).find('b').html('£0.00');
        const divZakat = $(zakatPayable).find('.money-val').removeClass('text-danger');
        $(divZakat).find('b').html('£0.00');

        $(btnDonateMobile).addClass('disabled');
        $(divZakat).find('input[name="zakat_value"]').val('0.00');

        setElementsInputEmpty(debitCollection);
        setElementsInputEmpty(creditCollection);


        //~~~~~~~~~~~~~~~~~~ Set input collection empty~~~~~~~~~~~~~~~~~~~~
        function setElementsInputEmpty(selector)
        {
            $(selector).filter(function() {
                return $(this).val() !== '';
            }).val('');
        }

    });


//~~~~~~~~~~~~~~~~~~ Open dropdown menu 'What do I need'  ~~~~~~~~~~~~~~~~~~~~
    $(document).on('click', '.calculator .title .toggle-title', function () {
        $(this).toggleClass('open');
        $('.calculator .title .bottom').toggleClass('open');
    });


//~~~~~~~~~~~~~~~~~~ Close dropdown menu 'What do I need'  ~~~~~~~~~~~~~~~~~~~~
    $(document).on('click', '.calculator .title .bottom .toggle-title', function () {
        $('.calculator .title .top .toggle-title').removeClass('open');
        $('.calculator .title .bottom').removeClass('open');
    });


    //~~~~~~~~~~~~~~~~~~ Set disabled input link if group ~~~~~~~~~~~~~~~~~~~~
    $(document).on('change', '#create-menu-item #is_group', function () {
        $('#create-menu-item #link').prop("disabled", this.checked );
    });

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $('.toggle-manual-address').on('click', function (e) {
        e.preventDefault();
        $('.manual-address').toggle()
    })

    $(function() {
        $('.toggle-view-donation-info').on('click', function (e) {
            e.preventDefault();
            $('.toggle-view-donation').toggleClass('open')
            $('.donated-page .info-col').toggleClass('hide')
        })
    } );
//~~~~~~~~~~~~~~~~~~ Menu control ~~~~~~~~~~~~~~~~~~~~
    $('.open-head-menu').click(function (e) {
        openHeadMenu(e, $(this).attr('data-id'));
    });

    $('[menu-group-show]').on('click', function (e) {
        toggleMenuGroup(true, e);
    });

    $('[menu-group-back]').on('click', function (e) {
        toggleMenuGroup(false, e);
    });

    $('[opened-menu-item]').on('click', function (e) {
        openHeadMenu(e, $(this).attr('data-id'));
        $('[menu-group]').hide();
    });

    function openHeadMenu(e, id = null)
    {
        e.preventDefault();

        let blocks = $('.block-dropdown-menu');

        $.each($(blocks), function (key, block) {
            if (id ===  $(block).attr('data-id')) {

                $(block).css({'display': 'block'})

                if (hasSwiper($(block))) {
                    if (!isSwiperInitialized($(block))) {
                        initMenuSwiper($(block), {
                            slidesPerView: 3,
                            spaceBetween: 4,
                            navigation: {
                                nextEl: $(block).find('.swiper-button-next').get(0),
                                prevEl: $(block).find('.swiper-button-prev').get(0),
                            }
                        });
                    }
                }

            } else {
                $(block).css({'display': 'none'})
            }
        });

        toggleOpenedHeaderMenuItems(id);

        $('.header-menu').addClass('open')
    }

    function toggleOpenedHeaderMenuItems(id)
    {
        $(`[opened-menu-item][data-id=${id}]`).hide();
        $('[opened-menu-item]').not(`[data-id=${id}]`).show();
    }

    function toggleMenuGroup(state, event) {

         event.preventDefault();

        let menuGroupId = $(event.target).closest('[data-menu-group-id]').data('menu-group-id');
        let menuGroupContainer = $(`[menu-group][data-menu-group-id=${menuGroupId}]`);

        menuGroupContainer.css({
            'display': state ? 'block' : 'none'
        });

        if (state) {
            if (!isSwiperInitialized(menuGroupContainer)) {
                initMenuSwiper(menuGroupContainer, {
                    slidesPerView: 3,
                    spaceBetween: 4,
                    navigation: {
                        nextEl: menuGroupContainer.find('.swiper-button-next').get(0),
                        prevEl: menuGroupContainer.find('.swiper-button-prev').get(0)
                    }
                });
            }
        }

        $(`.block-dropdown-menu`).has(`[menu-group-show][data-menu-group-id=${menuGroupId}]`).css({
            'display': state ? 'none' : 'block'
        });
    }

    function isSwiperInitialized(element) {
        return element.find('.swiper-container-initialized').length > 0;
    }

    function hasSwiper(element) {
        return element.find('.swiper-container').length > 0;
    }

    function initMenuSwiper(element, options) {
        new Swiper(element.find('.swiper-container').get(0), options);
    }

    $('.mobile-template .header-menu .open-submenu').on('click', function (e) {
        e.preventDefault();

        let menuContainer = $(e.target).closest('[class^=level-]').get(0);

        if (menuContainer) {

            let level = Number(menuContainer.className.split('level-')[1]);
            let targetGroup = $(this).attr('data-target');
            let targetMenuContainer = $(`.header-menu .level-${ level + 1 }`).filter(`[data-group-id=${ targetGroup }]`).get(0);

            if (targetMenuContainer) {

                $(e.target).closest('.header-menu')
                    .attr('level', level + 1)
                    .attr('prev-group', level ? $(e.target).closest('[data-group-id]').data('group-id') : null);

                if (level === 0) {
                    $('.header-menu .top .back').show();
                }

                if ($(targetMenuContainer).has('.projects-group-swiper').length) {
                    $('.header-menu').removeClass('dark-theme');

                    $('.icon_left_1').removeClass('d-none')
                    $('.icon_search_1').removeClass('d-none')
                    $('.icon_left_2').addClass('d-none')

                } else {
                    $('.header-menu').addClass('dark-theme');

                    $('.icon_left_1').addClass('d-none')
                    $('.icon_search_1').addClass('d-none')
                    $('.icon_left_2').removeClass('d-none')
                }

                $(menuContainer).hide();
                $(targetMenuContainer).show();
            }
        }
    });

    $('.mobile-template .header-menu .back').on('click', function (e) {

        e.preventDefault();

        let headerMenuContainer = $(e.target).closest('.header-menu');
        let currentLevel = Number(headerMenuContainer.attr('level'));
        let parentGroup = headerMenuContainer.attr('prev-group');
        let targetContainer = headerMenuContainer.find(`[class^=level-${currentLevel - 1}]`);

        if (parentGroup) {
            targetContainer = targetContainer.filter(`[data-group-id=${parentGroup}]`);
        }

        if (currentLevel) {

            let prevGroup = headerMenuContainer.find(`[data-target=${parentGroup}]`).closest(`[data-group-id]`);

            headerMenuContainer
                .attr('level', currentLevel - 1)
                .attr('prev-group', prevGroup.data('group-id') || null)
                .find('[class^=level-]')
                .not(targetContainer)
                .hide()

            targetContainer.show();
        }

        if ($(targetContainer).has('.projects-group-swiper').length || currentLevel === 1) {
            headerMenuContainer.removeClass('dark-theme');

            $('.icon_left_1').removeClass('d-none')
            $('.icon_search_1').removeClass('d-none')
            $('.icon_left_2').addClass('d-none')

        } else {
            headerMenuContainer.addClass('dark-theme');

            $('.icon_left_1').addClass('d-none')
            $('.icon_search_1').addClass('d-none')
            $('.icon_left_2').removeClass('d-none')
        }

        if (currentLevel - 1 <= 0) {
            headerMenuContainer.find('.top .back').hide();
            $('.icon_search_1').addClass('d-none')
        }
    });

    $('.mobile-template .toggle-menu').on('click', function (e) {
        $('.mobile-template .toggle-menu').next().toggle();
    });

    //~~~~~~~~~~~~~~~~~~~~~~~ Close Main menu ~~~~~~~~~~~~~~~~~~~~~~~

    $('.header-menu .close-menu').click(function (e) {
        e.preventDefault();
        closeMenu();
    });

    $(document).mouseup(function(e)
    {
        let container = $('.header-menu');
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            closeMenu();
        }
    });

    //~~~~~~~~~~~~~~~~~~~~~~~ Close Main when click on the sliders!!! ~~~~~~~~~~~~~~~~~~~~~~~
    $(document).on('click', '[swiper-wrapper]', function (e) {
        closeMenu();
    });

    function closeMenu()
    {
        $('.header-menu').removeClass('open')
        if ($('body').hasClass('mobile-template')) {
            $('.header-menu').removeClass('dark-theme')
            $('.header-menu [class^=level-]').not('.level-0').hide();
            $('.header-menu .level-0').show();
            $('.header-menu .top .back').hide();
            $('.header-menu').attr('level', '0').attr('prev-group', null);
        } else {
            $('[menu-group]').hide();
        }
    }


    $('header .top-bar .ico-menu').on('click', function () {
        $('header .expand-bar').toggleClass('open');
    })

    //~~~~~~~~~~~~~~~~~~~~~~~ Play menu video in modal ~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '.trigger', function (e) {
       e.preventDefault();

       let theModal = $(this).data("target");
       let videoSRC = $(this).attr("src");
       let videoSRCauto = videoSRC + "?autoplay=1";

       $(theModal + ' iframe').attr('src', videoSRCauto);
       $(theModal).on('hidden.bs.modal', function(e) {
           $(theModal + ' iframe').attr('src', '');
       });
    });

    //~~~~~~~~~~~~~~~~~~~~~~~ Trending articles module ~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '[trending-articles] .pagination a', function (e) {
        e.preventDefault()

        let path = $(this).attr('href');

        const url = new URL(path);
        let page = url.searchParams.get('trending_articles')
        let data = {}
        let apiUrl = '/api/get_trending_articles/' + page

        $.get(apiUrl, data, refreshTrendingArticles, 'json');

    });

    function refreshTrendingArticles(response) {

        let newBody = $('[trending-articles-body]', response.html)
        $('[trending-articles-body]').html(newBody.html())

        let newPagination = $('[trending-articles-pagination]', response.html)
        $('[trending-articles-pagination]').html(newPagination.html())
    }


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $("[input_number_spinner]").inputSpinner()

    $('.important-information .read-more').click(function (e) {
        e.stopPropagation();
        $(this).prev().find('.descr').toggleClass('open')
    })

    $('footer .menu > li > a').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).parent().toggleClass('open');
    })

    $(window).scroll(function() {
        if ( $(window).scrollTop() > 115 ) {
            $('.wrapper').addClass('header-fixed')
        } else {
            $('.wrapper').removeClass('header-fixed')
        }
    });

});


//~~~~~~~~~~~~~~~~~~ Convert float value to string format "1'000.00" ~~~~~~~~~~~~~~~~~~~~
function convertMonetary(value) {
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "'");
}

//~~~~~~~~~~~~~~~~~~ Summarizes input fields ~~~~~~~~~~~~~~~~~~~~
function multiplyVal(collection)
{
    let sum = 0;
    collection.each(function (){
        sum += $(this).val() === '' ? 0 : parseFloat($(this).val());
    });

    return sum;
}

/**
 * Check all elements are empty
 *
 * @param selector
 * @returns {boolean}
 */
function areElementsEmpty(selector)
{
    return ($(selector).filter(function() {
        return $(this).val() !== '';
    }).length === 0)
}

function initSwiper(){
    setTimeout(function () {
        $('[swiper-wrapper]').each(function() {
            let key = '[swiper-wrapper="'+ $(this).attr('swiper-wrapper') +'"]';
            let autoHeight = $(this).attr('swiper-autoHeight');

            let options = {
                loop: function (){
                    return !!$(this).hasClass('loop');
                },
                autoHeight: (autoHeight ? true : false),
                spaceBetween:  parseInt($(this).attr('space-between') ?? 0),
                centeredSlides: ($(this).attr('centered-slides') ?? false),
                slidesPerView:  ($(this).attr('slides-per-view') ?? 1),
                navigation: {
                    nextEl: key + ' .swiper-button-next',
                    prevEl: key + ' .swiper-button-prev',
                },
                pagination: {
                    el: key + ' .swiper-pagination',
                }
            };

            let swiper = new Swiper(key + ' .swiper-container', options);
        })
    }, 200)
}

function initTriggers() {
    $('[run-trigger]').each(function() {
        $(this).trigger($(this).attr('run-trigger')).removeAttr('run-trigger');
    });
}

function initMenuSwiper(){
    $('[swiper-wrapper-menu]').each(function() {
        let key = '[swiper-wrapper-menu="'+ $(this).attr('swiper-wrapper-menu') +'"]';

        var swiper = new Swiper(key + ' .swiper-container', {
            slidesPerView: 3,
            spaceBetween: 4,
            navigation: {
                nextEl: '.projects-group-swiper .swiper-button-next',
                prevEl: '.projects-group-swiper .swiper-button-prev',
            },
        });
    })
}
