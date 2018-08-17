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
        height: 150,
        menubar: false,
        plugins: [
            'advlist autolink lists link image imagetools charmap textcolor',
            'visualblocks code',
            'media table contextmenu paste codesample'
        ],
        toolbar: 'bold italic subscript superscript forecolor backcolor blockquote codesample | removeformat | bullist numlist | table | insert',
        image_advtab: false,
        visualblocks_default_state: false,
        end_container_on_empty_block: true,
        default_link_target: "_blank",
        paste_as_text: true,
        valid_elements: 'strong,i,em,sup,sub,span[class,style,id],a[class,style,id,href],img[src,alt,class],ul[class,style,id],li[class,style,id],ol[class,style],table[class,style],tr[class,style],td[class,style],thead,tbody',
        extended_valid_elements: 'i[class|id],span[class,id]',
        convert_urls: false,
        relative_urls: false,
        language_url: '<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-tinymce/assets/js/langs/' + script_lang + '.js',
        setup: function(e) { // save values to textarea hidden
            e.on('change', function(){
                e.save();
            });
        }
    });
</script>