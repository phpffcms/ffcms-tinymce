<?php
/** @var \Ffcms\Templex\Template\Template $this */

?>

<?= $this->bootstrap()->nav('ul', ['class' => 'nav-tabs nav-fill'])
    ->menu([
        'text' => '<i class="far fa-file-image"></i> ' . __('Images'), 
        'link' => ['tinymce/browse', ['images'], ['lang' => App::$Request->getLanguage()]], 
        'html' => true])
    ->menu([
        'text' => '<i class="far fa-file-video"></i> ' . __('Video'), 
        'link' => ['tinymce/browse', ['video'], ['lang' => App::$Request->getLanguage()]], 
        'html' => true])
    ->menu([
        'text' => '<i class="far fa-file-alt"></i> ' . __('Files'), 
        'link' => ['tinymce/browse', ['files'], ['lang' => App::$Request->getLanguage()]], 
        'html' => true])
    ->menu([
        'text' => '<i class="fas fa-upload"></i> ' . __('Upload'), 
        'link' => ['tinymce/upload', null, ['lang' => App::$Request->getLanguage()]], 
        'html' => true]); 
?>