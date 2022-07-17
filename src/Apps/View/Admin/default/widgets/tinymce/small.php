<?php
/** @var \Ffcms\Templex\Template\Template $this */
?>

<script src="<?= \App::$Alias->scriptUrl ?>/vendor/tinymce/tinymce/tinymce.min.js"></script>

<script>
    function setResponseUrl(callbackId, url) {
        if (typeof(url) !== 'undefined' && url.length > 0) {
            console.log('Get callback: ' + callbackId + ', url: ' + url);
            window.document.getElementById(callbackId).value = url;
        }
    }

    tinymce.init({
        selector: '.wysiwyg',
        height: 250,
        menubar: false,
        plugins: [
            'advlist autolink lists link image imagetools charmap',
            'visualblocks code',
            'media paste codesample'
        ],
        toolbar: 'bold italic subscript superscript blockquote | removeformat | bullist numlist | code',
        image_advtab: false,
        visualblocks_default_state: false,
        end_container_on_empty_block: true,
        default_link_target: "_blank",
        paste_as_text: true,
        valid_elements: 'p,strong,i,em,sup,sub,blockquote,a[class|style|id|href],img[src|alt|class],ul[class|style|id],li[class|style|id],ol[class|style],table[class,style],tr[class|style],td[class|style],thead|tbody',
        convert_urls: false,
        relative_urls: true,
        language_url: '<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-tinymce/assets/js/langs/' + script_lang + '.js',
        language: script_lang,
        setup: function(e) { // save values to textarea hidden
            e.on('change', function(){
                e.save();
            });
        }
    });
</script>