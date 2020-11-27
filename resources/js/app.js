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


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

});

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
