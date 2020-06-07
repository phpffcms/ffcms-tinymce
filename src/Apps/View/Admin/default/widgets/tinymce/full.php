<?php
/** @var \Ffcms\Templex\Template\Template $this */
?>

<script src="<?= \App::$Alias->scriptUrl ?>/vendor/tinymce/tinymce/tinymce.min.js"></script>

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
            'insertdatetime media table paste wordcount pagebreak codesample'
        ],
        toolbar: 'formatselect | insert | bold italic subscript superscript forecolor backcolor blockquote | removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | pagebreak code',
        image_advtab: true,
        visualblocks_default_state: true,
        end_container_on_empty_block: true,
        default_link_target: "_blank",
        paste_as_text: true,
        extended_valid_elements: 'i[class|id],span[class,id]',
        pagebreak_separator: "<div style=\"page-break-after: always;\">&nbsp;</div>",
        pagebreak_split_block: true,
        convert_urls: false,
        relative_urls: false,
        language_url: '<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-tinymce/assets/js/langs/' + script_lang + '.js',
        language: script_lang,
        file_picker_types: 'file image media',
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
        }
    });
</script>