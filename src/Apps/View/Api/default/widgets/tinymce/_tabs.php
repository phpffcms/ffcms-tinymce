<?php
/** @var \Ffcms\Templex\Template\Template $this */
/** @var string $callbackId */
?>

<?= $this->bootstrap()->nav('ul', ['class' => 'nav-tabs nav-fill'])
    ->menu(['text' => '<i class="fa fa-file-image-o"></i> ' . __('Images'), 'link' => ['tinymce/browse', ['images'], ['callbackId' => $callbackId]], 'html' => true])
    ->menu(['text' => '<i class="fa fa-file-movie-o"></i> ' . __('Video'), 'link' => ['tinymce/browse', ['video'], ['callbackId' => $callbackId]], 'html' => true])
    ->menu(['text' => '<i class="fa fa-file-text-o"></i> ' . __('Files'), 'link' => ['tinymce/browse', ['files'], ['callbackId' => $callbackId]], 'html' => true])
    ->menu(['text' => '<i class="fa fa-upload"></i> ' . __('Upload'), 'link' => ['tinymce/upload', null, ['callbackId' => $callbackId]], 'html' => true]) ?>