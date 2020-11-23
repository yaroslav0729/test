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

$(function () {

    new Vue({
        el: '#app'
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
        console.log('show form')

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
        console.log(len)

        html = html.replace(/{new}/gi, len);
        optionsList.append(html);   
    });

    $(document).on('click', '[option-delete]', function () {
        let wrap = $(this).closest('.option').remove();
    });

    //~ donate-module - show countries dropdown if click on amount ~

    $(document).on('click', '[select-amount]', function () {
        let amountId = $(this).data('amount_id')
        $('[amount-countries]').addClass('d-none')
        let countriesEl = $('[amount-countries][data-countries_amount_id="' + amountId +'"]');
        countriesEl.removeClass('d-none')
    });

    //~~~~~~~~~~~~~~~~~~ change map in the who we are page ~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '#btn-view-global-work', function (event) {
        event.preventDefault()

        let mapBlock = $(this).parent();
        let altSrc = $(mapBlock).attr('alt-src');
        $(mapBlock).attr('style', 'background-image: url("' + altSrc + '")');
        this.remove();
    });

    //~~~~~~~~~~~~~~~~~~ Project tiles ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '.donate-projects-list .add', function () {
        
        let popupKey = $(this).data('popup')
        let popup = $('.tiles-popup_' + popupKey)

        $('[tiles-popup]').addClass('d-none')

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


});
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
