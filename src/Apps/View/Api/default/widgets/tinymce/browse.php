<?php

use Ffcms\Core\Helper\Type\Str;

/** @var \Ffcms\Templex\Template\Template $this */
/** @var array|null $files */
/** @var string $type */
/** @var string $callbackId */
/** @var string $root */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/components/font-awesome/css/font-awesome.min.css" />
    <title><?= __('FFCMS file browser') ?></title>
    <script>
        function callBack(url) {
            var callbackId = '<?= $callbackId ?>';
            window.opener.setResponseUrl(callbackId, url);
            window.close();
        }
    </script>
    <style>
        .image-item {
            height: 100px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <h2 class="text-center"><?= __('File browser') ?></h2>
    <?= \App::$View->render('widgets/tinymce/_tabs', ['callbackId' => $callbackId], $root) ?>

    <div class="row">
        <?php if ($files && count($files) > 0): ?>
            <?php foreach ($files as $file): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="card">
                        <?php if ($type === 'images'): ?>
                            <img src="<?= \App::$Alias->scriptUrl . '/' . $file ?>" class="card-img-top" />
                        <?php elseif ($type === 'flash'): ?>
                            <div class="text-center"><i class="fa fa-file-video-o fa-5x"></i></div>
                        <?php else: ?>
                            <div class="text-center"><i class="fa fa-file fa-5x"></i></div>
                        <?php endif; ?>
                        <div class="m-1">
                            <div class="row text-center">
                                <div class="col-12">
                                    <small class="text-center"><?= Str::lastIn($file, '/', true) ?></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript::void(0)" onclick="return callBack('<?= \App::$Alias->scriptUrl . '/' . $file ?>')" class="btn btn-success btn-sm btn-block"><i class="fa fa-check"></i> <?= __('Select') ?></a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= \App::$Alias->scriptUrl . '/' . $file ?>" target="_blank" class="btn btn-secondary btn-sm btn-block"><i class="fa fa-eye"></i> <?= __('Preview') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12"><p class="alert alert-warning"><?= __('Files not found') ?></p></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>