function initWysiwyg() {
    jQuery.fn.reverse = [].reverse;

    $("[wysiwyg-editor]")
        .reverse()
        .each(function() {
            let toolbar = $(this).attr("toolbar");
            if (toolbar === undefined) {
                toolbar =
                    "styleselect | bold italic underline |  fontsizeselect | align | bullist numlist | link forecolor backcolor | image media | table | hr | monikers | removeformat| code";
            }

            let menubar = $(this).attr("menubar");
            if (menubar === undefined) {
                menubar = true;
            }

            let height = $(this).attr("height");
            if (height === undefined) {
                height = 500;
            }

            let selector = "#" + $(this).attr("id");

            tinymce.remove(selector);
            tinymce.init({
                selector: selector,
                auto_focus: false,
                height: height,
                toolbar: toolbar,
                plugins:
                    "image, imagetools, table, lists, hr, code, link, media",
                image_advtab: true,
                images_upload_url: "/admin/media/upload_mce",
                images_upload_credentials: true,
                relative_urls: false,
                menubar: menubar,
                statusbar: true,
                fontsize_formats:
                    "8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 24pt 36pt",
                valid_styles: {
                    "*":
                        "color,font-size,font-weight,font-style,text-decoration"
                },
                extended_valid_elements: "script[type|src]",
                inline_styles: true,
                setup: function(editor) {
                    editor.on("init", function() {
                        editor.execCommand("fontName", false, "Arial");
                    });
                    editor.on("BeforeSetContent", function(e) {
                        if (e.content.startsWith("<img")) {
                            e.content = `<div class="blog-article-image-container">${e.content}</div>`;
                        }
                    });
                }
            });

            $(this).removeAttr("wysiwyg-editor");
        });
}

export { initWysiwyg };
