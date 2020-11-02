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
            plugins: "image, imagetools, table, lists, hr, code, link, media",
            images_upload_url: '/admin/media/upload_mce',
            images_upload_credentials: true,
            relative_urls :false,
            menubar: menubar,
            statusbar: true,
            font_formats: "Arial=arial;Arial Black=arial black;Impact=impact;Sofia Pro=Sofia Pro;Tahoma=tahoma;",
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 24pt 36pt",
            setup: function (editor) {

                editor.on('init', function() {
                    editor.execCommand("fontName", false, "Arial");
                });
            },
            //images_upload_handler: image_upload_handler
        });

        // function image_upload_handler (blobInfo, success, failure, progress) {
        //     var xhr, formData;

        //     xhr = new XMLHttpRequest();
        //     xhr.withCredentials = false;
        //     xhr.open('POST', '/admin/media/upload_mce');

        //     xhr.upload.onprogress = function (e) {
        //         progress(e.loaded / e.total * 100);
        //     };

        //     xhr.onload = function() {
        //         var json;

        //         if (xhr.status === 403) {
        //         failure('HTTP Error: ' + xhr.status, { remove: true });
        //         return;
        //         }

        //         if (xhr.status < 200 || xhr.status >= 300) {
        //         failure('HTTP Error: ' + xhr.status);
        //         return;
        //         }

        //         json = JSON.parse(xhr.responseText);

        //         if (!json || typeof json.location != 'string') {
        //         failure('Invalid JSON: ' + xhr.responseText);
        //         return;
        //         }

        //         success(json.location);
        //     };

        //     xhr.onerror = function () {
        //         failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        //     };

        //     formData = new FormData();
        //     formData.append('file', blobInfo.blob(), blobInfo.filename());

        //     xhr.send(formData);
        // }

        $(this).removeAttr('wysiwyg-editor');
    });
}

export { initWysiwyg }