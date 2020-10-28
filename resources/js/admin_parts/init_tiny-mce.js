function initWysiwyg()
{
    jQuery.fn.reverse = [].reverse;

    $('[wysiwyg-editor]').reverse().each(function() {

        let toolbar = $(this).attr('toolbar');
        if (toolbar === undefined) {
            toolbar = "styleselect | bold italic underline | fontselect |  fontsizeselect | align | bullist numlist | link forecolor backcolor | image media | table | hr | monikers | code"
        }

        let menubar = $(this).attr('menubar');
        if (menubar === undefined) {
            menubar = true;
        }

        let height = $(this).attr('height');
        if (height === undefined) {
            height = 500;
        }

        let selector = '#' + $(this).attr('id');

        tinymce.remove(selector);
        tinymce.init({
            selector: selector,
            auto_focus: false,
            height: height,
            toolbar: toolbar,
            plugins: "image, table, lists, hr, code, link, media",
            images_upload_url: '/images/upload',
            images_upload_credentials: true,
            relative_urls :false,
            menubar: menubar,
            statusbar: true,
            content_css: ['/css/fonts.css'],
            font_formats: "Arial=arial;Arial Black=arial black;Impact=impact;Sofia Pro=Sofia Pro;Tahoma=tahoma;",
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 24pt 36pt",
            image_list: [
                {title: 'Logo', value: '/images/pts_logo.png'},
                {title: 'Accredited Business', value: '/images/acc_bus.png'},
                {title: 'Greg Hilton', value: '/images/greg_hilton.jpg'},
                {title: 'Signature', value: '/images/signature.png'},
                {title: 'Arrow (right, red)', value: '/images/arrow_right_red.png'},
                {title: 'Round Logo', value: '/images/pts_round_logo.png'},
            ],
            setup: function (editor) {

                editor.on('init', function() {
                    editor.execCommand("fontName", false, "Arial");
                });
            }
        });

        $(this).removeAttr('wysiwyg-editor');
    });
}

export { initWysiwyg }