window._ = require('lodash');
window.Popper = require('popper.js').default;

window.$ = window.jQuery = require('jquery');
require('bootstrap');

import Swiper from 'swiper';
window.Swiper = Swiper

require('bootstrap-input-spinner');

$(function () {

    // jQuery.fn.swapWith = function(to) {
    //     return this.each(function() {
    //         var copy_to = $(to).clone(true);
    //         var copy_from = $(this).clone(true);
    //         $(to).replaceWith(copy_from);
    //         $(this).replaceWith(copy_to);
    //     });
    // };

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

    function showModalResponse(response) 
    {
        $('#modal-wrap').html(response.html);
        $('#modal-wrap').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });   
    }

    // $(document).on('click', '#modal-wrap .close', function() {
    //     //console.log('close')
    //     $('#modal-wrap').modal('hide')
    // });

    $(document).on('click', '#submit_modal_form', function() {
        $('form#modal-form').submit()
    });

    var MODAL_FORM_LOCK = false

    $(document).on('submit', '#modal-form', function (event) {
        event.preventDefault();

        if (MODAL_FORM_LOCK) {
            return false;
        }

        MODAL_FORM_LOCK = true;

        var form = $(this);
        var formData = new FormData(form[0]);

        console.log('formData', formData)

        $.ajax({
            url     : form.attr('action'),
            type    : form.attr('method'),
            data    : formData,
            processData: false,
            contentType: false,
            success : function (response, textStatus, jqXHR)
            {
                MODAL_FORM_LOCK = false;

                if ('content' in response) {
                    let element = $('#response-content');
                    element.html(response.content);
                    element.attr('wrapper-id', response.wrapper_id);
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

                if (response.html) {
                    showModalResponse(response);
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
                MODAL_FORM_LOCK = false;

                if(response.status === 422) {

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

                    $('#modal-wrap').animate({ scrollTop: 0 }, 'slow');


                } else {
                    $('#modal-wrap').modal('hide');
                }
            }
        })
    })
})

//require('./functions');