<?php
/** @var \Ffcms\Templex\Template\Template $this */
/** @var string $callbackId */
?>

<?= $this->bootstrap()->nav('ul', ['class' => 'nav-tabs nav-fill'])
    ->menu(['text' => '<i class="far fa-file-image"></i> ' . __('Images'), 'link' => ['tinymce/browse', ['images'], ['callbackId' => $callbackId]], 'html' => true])
    ->menu(['text' => '<i class="far fa-file-video"></i> ' . __('Video'), 'link' => ['tinymce/browse', ['video'], ['callbackId' => $callbackId]], 'html' => true])
    ->menu(['text' => '<i class="far fa-file-alt"></i> ' . __('Files'), 'link' => ['tinymce/browse', ['files'], ['callbackId' => $callbackId]], 'html' => true])
    ->menu(['text' => '<i class="fas fa-upload"></i> ' . __('Upload'), 'link' => ['tinymce/upload', null, ['callbackId' => $callbackId]], 'html' => true]) ?>