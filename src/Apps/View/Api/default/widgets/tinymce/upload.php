<?php

use Ffcms\Core\Helper\Type\Str;

/** @var \Ffcms\Templex\Template\Template $this */
/** @var string $callbackId */
/** @var string $root */
/** @var \Apps\Model\Api\Tinymce\FormUploadFile $model */
/** @var string|null $path */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/components/font-awesome/css/font-awesome.min.css" />
    <title><?= __('FFCMS file browser') ?></title>
    <style>
        @media (min-width: 768px) {
            label.control-label {
                padding-top: 7px;
                text-align: right;
                font-weight: bolder;
            }
        }
    </style>
    <script>
        var path = '<?= $path ?>';
        if (path.length > 0 && path !== '') {
            window.opener.setResponseUrl('<?= $callbackId ?>', '<?= \App::$Alias->scriptUrl . $path ?>');
            window.close();
        }
    </script>
</head>
<body>

<div class="container-fluid">
    <h2 class="text-center"><?= __('File browser') ?></h2>
    <?= \App::$View->render('widgets/tinymce/_tabs', ['callbackId' => $callbackId], $root) ?>

    <div class="row">
        <div class="col-md-12">
            <?php $form = $this->form($model, ['class' => 'form-horizontal mt-3', 'enctype' => 'multipart/form-data', 'method' => 'POST']);
            echo $form->start();

            echo $form->fieldset()->file('file', null, __('Choice file from local machine and upload it to server'));
            echo '<div class="col-md-9 offset-md-3">' .  $form->button()->submit(__('Send'), ['class' => 'btn btn-primary']) . '</div>';

            echo $form->stop()
            ?>
        </div>
    </div>
</div>

</body>
</html>