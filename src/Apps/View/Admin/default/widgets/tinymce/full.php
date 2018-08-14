<?php
/** @var \Ffcms\Templex\Template\Template $this */
?>

<script src="<?= \App::$Alias->scriptUrl ?>/vendor/tinymce/tinymce/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: '.wysiwyg',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image imagetools charmap print preview anchor textcolor',
            'searchreplace visualblocks code',
            'insertdatetime media table contextmenu paste wordcount pagebreak codesample'
        ],
        toolbar: 'formatselect | insert | bold italic subscript superscript forecolor backcolor blockquote codesample | removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | pagebreak code',
        image_advtab: true,
        visualblocks_default_state: true,
        end_container_on_empty_block: true,
        default_link_target: "_blank",
        paste_as_text: true,
        extended_valid_elements: 'i[class|id],span[class|id]'
    });
</script>