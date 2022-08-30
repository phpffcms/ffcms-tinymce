<?php
/** @var \Ffcms\Templex\Template\Template $this */
?>

<script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/xss/dist/xss.min.js"></script>
<script src="<?= \App::$Alias->scriptUrl ?>/vendor/tinymce/tinymce/tinymce.min.js"></script>
<script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/standalone/tinymce-codeeditor/ce.js"></script>

<script>
    var callbackFun = null;
    function setResponseUrl(url) {
        if (typeof(url) !== 'undefined' && url.length > 0) {
            callbackFun(url, {alt: url.substring(url.lastIndexOf('/')+1)});
            
        }
    }

    tinymce.init({
        selector: '.wysiwyg',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image imagetools charmap print preview anchor',
            'searchreplace visualblocks code',
            'insertdatetime media table paste wordcount pagebreak codesample codeeditor paste'
        ],
        toolbar: 'paste | formatselect | insert | bold italic subscript superscript forecolor backcolor blockquote | removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | pagebreak codeeditor',
        image_advtab: true,
        visualblocks_default_state: true,
        end_container_on_empty_block: true,
        default_link_target: "_blank",
        //paste_as_text: true,
        extended_valid_elements: 'i[class|id],span[class,id]',
        pagebreak_separator: "<div style=\"page-break-after: always;\">&nbsp;</div>",
        pagebreak_split_block: true,
        convert_urls: false,
        relative_urls: false,
        language_url: '<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-tinymce/assets/js/langs/' + script_lang + '.js',
        language: script_lang,
        file_picker_types: 'file image media',
        paste_block_drop: true,
        file_picker_callback: function(callback, value, meta) {
            callbackFun = callback;
            /** calc new widnow size & position */
            var selectWidth = screen.width * 0.6;
            var selectHeight = screen.height * 0.7;
            if (selectWidth < 250)
                selectWidth = 250;
            if (selectHeight < 250)
                selectHeight = 250;

            var posLeft = (screen.width/2)-(selectWidth/2);
            var posTop = (screen.height/2)-(selectHeight/2);

            window.open('<?= \App::$Alias->scriptUrl ?>/api/tinymce/browse?lang=' + script_lang, '_blank', "toolbar=no, menubar=on, status=no, directories=no, width=" + selectWidth + ", height=" + selectHeight + ", top=" + posTop + ", left=" + posLeft);
        },
        setup: function(e) { // save values to textarea hidden
            e.ui.registry.addMenuButton('insert', {
                icon: 'plus',
                tooltip: 'Insert',
                fetch: (callback) => callback('image link media | inserttable | codesample | charmap')
            });
            e.on('change', function(){
                e.save();
            });
        },
        paste_preprocess: function(plugin, args) {
            let htm = args.content;
            html = filterXSS(htm, {
                whiteList: {
                    a: ['href', 'title', 'target'],
                    p: [],
                    strong: [],
                    b: [],
                    table: [],
                    tr: ['colspan'],
                    td: ['colspan'],
                    thead: [],
                    tbody: []
                },
                stripIgnoreTag: true,
                stripIgnoreTagBody: ['script'],
                onTag: function(tag, html, options) {
                    if (tag === 'table') {
                        res = html;
                        if (options.isClosing === true) {
                            res = "</div>" + res;
                        } else {
                            res = res.replace('>', ' class="table table-bordered">');
                            res = '<div class="table-responsive">' + res;
                        }
                        return res;
                    }
                }
            });

            //console.log(html);
            args.content = html;
        }
    });
</script>