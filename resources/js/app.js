window._ = require('lodash');
window.Popper = require('popper.js').default;

window.$ = window.jQuery = require('jquery');
require('bootstrap');

import Swiper from 'swiper';
window.Swiper = Swiper

require('bootstrap-input-spinner');

$(function () {

    jQuery.fn.swapWith = function(to) {
        return this.each(function() {
            var copy_to = $(to).clone(true);
            var copy_from = $(this).clone(true);
            $(to).replaceWith(copy_from);
            $(this).replaceWith(copy_to);
        });
    };

    $(document).on('click', '[modal-call]', modalCall);

    function modalCall(event)
    {
        event.preventDefault();        

        var data = {};

        $.each($(this).data(), function (key, value) {
            data[key] = value;
        });

        modalRequest($(this).attr('path'), data);
    }

    function modalRequest(url, data)
    {
        $.get(url, data, showModalResponse, 'json');
    }

    function showModalResponse(response, textStatus) 
    {
        console.log(response)

        $('#modal-wrap').html(response.html);
        $('#modal-wrap').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });   
    }

    $(document).on('click', '#modal-wrap .close', function() {
        console.log('close')
        $('#modal-wrap').modal('hide')
    });
})

//require('./functions');