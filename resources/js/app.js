window._ = require('lodash');
window.Popper = require('popper.js').default;

window.$ = window.jQuery = require('jquery');
require('bootstrap');

require('tinymce');

window.toastr  = require ('toastr');

import Swiper from 'swiper';
window.Swiper = Swiper

require('bootstrap-input-spinner');

import { initWysiwyg } from './admin_parts/init_tiny-mce';

window.Vue = require('vue')

require('../assets/vendor/MediaManager/js/manager')

$(function () {

    new Vue({
        el: '#app'
    })

    initWysiwyg()

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

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '#subscription_modal_sbmt', function() {

        var form = $('#subscription_modal form');
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
                console.log(response)
                toastr.error('Unknown error ','Error')
            }
        });

    });

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
})

//require('./functions');