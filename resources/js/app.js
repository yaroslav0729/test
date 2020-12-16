window._ = require('lodash');
window.Popper = require('popper.js').default;

window.$ = window.jQuery = require('jquery');
require('bootstrap');

require('tinymce');

window.toastr  = require ('toastr');

/*import Swiper from 'swiper';
window.Swiper = Swiper*/

require('bootstrap-input-spinner');

import { initWysiwyg } from './admin_parts/init_tiny-mce';

window.Vue = require('vue')

require('../assets/vendor/MediaManager/js/manager')

require('./parts/project_tiles.js')
require('./parts/donate_module.js')
require('./parts/cart.js')

var MODAL_FORM_LOCK = false

$(function () {

    new Vue({
        el: '#app'
    })

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

                /*if (response.html) {
                    showModalResponse(response);
                    return;
                }*/

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

    $(document).on('click', '#join_the_cause_show_form', function() {

        let mainForm =  $('.join-cause-main')
        let hiddenForm = $('.join-cause-hidden')

        mainForm.addClass('d-none')
        hiddenForm.removeClass('d-none')
    })

    $(document).on('click', '#subscription_sbmt', function(e) {

        e.preventDefault()

        var form = $('#subscription_form');
        var formData = new FormData(form[0]);

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

    //~~~~~~~~~~~~~~~~~ Current projects slider ~~~~~~~~~~~~~~~~~~

    var currentSlide = 0;

    $(document).on('click', '#current-proj-next-slide', function(e) {
        e.preventDefault()

        currentSlide++;
        if (currentSlide >= 4) {
            currentSlide = 0;
        }

        let data = [];
        for (let i=0; i<4; i++) {

            let dataEl = $('.slider_data .slide_' + i)
            let title = dataEl.find('.slider_data_title').text()
            let text = dataEl.find('.slider_data_text').text()
            let img = dataEl.find('.slider_data_img').text()
            let readmore = dataEl.find('.slider_data_readmore').text()

            data.push({
                'title': title,
                'text': text,
                'img': img,
                'readmore': readmore,
            })
        }

        let el1 = $('.current-projects')

        el1.find('.slide-title').html(data[currentSlide].title)
        el1.find('.slide-text').html(data[currentSlide].text)
        el1.find('.slide-img').css('background-image', "url(" + data[currentSlide].img + ")")
        el1.find('.slide-readmore').attr('href', data[currentSlide].readmore)

        var dataCou = currentSlide + 1
        if (dataCou >= 4) dataCou = 0;

        for (let i = 1; i<4; i++) {
            let el2 = $('.current-projects-list .slide_' + i)

            dataCou = currentSlide + i
            if (dataCou >= 4) dataCou = dataCou - 4;

            el2.find('.slide-title').html(data[dataCou].title)
            el2.find('.slide-text').html(data[dataCou].text)
            el2.find('.slide-img').css('background-image', "url(" + data[dataCou].img + ")")
            el2.find('.slide-readmore').attr('href', data[dataCou].readmore)
        }


    })

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
    });

    //~~~~~~~~~~~~~~~~~~ toggle search button on the Events page ~~~~~~~~~~~~~~~~~~~~

    $(document).on('input', '#events input', function (event) {
        const section = $('#events');
        const inputs = $('#events input');

        areElementsEmpty('#events input') === true ? $(section).removeClass('view-btn') : $(section).addClass('view-btn')
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

        if (asset > metalPrice) {
            zakat = asset * 0.025;

            $('#zakat-pay').addClass('bg-danger-light');
            $(divZakat).addClass('text-danger');

            $('#total-zakat').find('.money-val').addClass('text-danger');

            let zakatValue = convertMonetary(zakat.toFixed(2))
            $(divZakat).find('b').html('£' + zakatValue);
            $(divZakat).find('input[name="zakat_value"]').val(zakatValue)

        } else {
            $('#zakat-pay').removeClass('bg-danger-light');

            $(divZakat).removeClass('text-danger');
            $(divZakat).find('b').html('£0.00');
            $(divZakat).find('input[name="zakat_value"]').val(0)
        }
    });

    //~~~~~~~~~~~~~~~~~~ Set empty and clear Class for input fields ~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '#btn-reset', function () {
        const totalAssets = $('#total-assets');
        const zakatPayable = $('.zakat-payable');

        let debitCollection = $('.debit-money');
        let creditCollection = $('.credit-money');

        $('#total-zakat').find('.money-val').removeClass('text-danger');
        $(totalAssets).removeClass('bg-primary-light');
        $('#zakat-pay').removeClass('bg-danger-light');

        const divVal = $(totalAssets).find('.money-val').removeClass('text-info');
        $(divVal).find('b').html('£0.00');
        const divZakat = $(zakatPayable).find('.money-val').removeClass('text-danger');
        $(divZakat).find('b').html('£0.00');

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

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

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
    $('[swiper-wrapper]').each(function() {
        let key = '[swiper-wrapper="'+ $(this).attr('swiper-wrapper') +'"]';

        let swiper = new Swiper(key + ' .swiper-container', {
            loop: function (){
                return !!$(this).hasClass('loop');
            },
            navigation: {
                nextEl: key + ' .swiper-button-next',
                prevEl: key + ' .swiper-button-prev',
            },
            pagination: {
                el: key + ' .swiper-pagination'
            }
        });
    })
}

//require('./functions');
