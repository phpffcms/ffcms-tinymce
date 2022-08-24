<?php

use Ffcms\Core\Helper\Date;
use Ffcms\Core\Helper\FileSystem\File;
use Ffcms\Core\Helper\Type\Str;
use Ffcms\Templex\Url\Url;

/** @var \Ffcms\Templex\Template\Template $this */
/** @var array|null $files */
/** @var string $type */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css" />
    <title><?= __('FFCMS file browser') ?></title>
    <script>
        function callback(url) {
            window.opener.setResponseUrl(url);
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
    <?= \App::$View->render('widgets/tinymce/_tabs') ?>

    <div class="table-responsive">
        <?php 
            $table = $this->table(['class' => 'table table-striped table-hover table-select datatable'])
                ->head([
                    ['text' => '?'],
                    ['text' => __('File')],
                    ['text' => __('Date')],
                    ['text' => __('Size, mb')],
                    ['text' => __('Actions')]
                ], ['class' => 'thead-dark']);
            if ($files && count($files) > 0) {
                $icon = '<i class="fas fa-file"></i>';
                switch ($type) {
                    case 'images':
                        $icon = '<i class="fas fa-file-image"></i>';
                    break;
                    case 'flash':
                        $icon = '<i class="fas fa-file-video"></i>';
                }
                foreach ($files as $file) {
                    $fileDate = Date::convertToDatetime(File::mTime($file), Date::FORMAT_TO_HOUR);
                    $fileSize = round(File::size($file)/1024/1024, 2);

                    $btngrp = $this->bootstrap()->btngroup(['class' => 'btn-group btn-group-sm'], 4)
                        ->add('<i class="fas fa-eye btn-preview"></i>', ['#'], ['class' => 'btn btn-light btn-preview', 'html' => true])
                        ->add('<i class="fas fa-link"></i>', ['#'], ['class' => 'btn btn-success btn-insert', 'html' => true]);


                    $table->row([
                        ['text' => $icon, 'html' => true],
                        ['text' => Url::a([\App::$Alias->scriptUrl . '/' . $file], $file, ['class' => 'link-target' . ($type === 'images' ? ' fancybox' : '')]), 'html' => true],
                        ['text' => $fileDate],
                        ['text' => $fileSize],
                        ['text' => $btngrp->display(), 'html' => true]
                    ]);
                }

                echo $table->display();
            } else {
                echo $this->bootstrap()->alert('warning', __('Files not found'));
            }
            
        ?>
    </div>
</div>

<script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<script src="<?= \App::$Alias->scriptUrl ?>/vendor/phpffcms/ffcms-assets/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>

<script>
$(function(){
    $('.table-select tr').on('click', function(e){
        if ($(e.target).hasClass('link-target')) {
            return;
        }

        var lnk = $(this).find('a.link-target').attr('href');
        if ($(e.target).hasClass('btn-preview')) {
            window.open(lnk, '_blank');
            return;
        }
        e.preventDefault();
        callback(lnk);
    });

    $('.fancybox').fancybox();

    var dt = [];
    dt['ru'] = {
        "emptyTable": "Данные не обнаружены в таблице",
        "info": "Показаны элементы от _START_ до _END_ из _TOTAL_",
        "infoEmpty": "Показано 0 элементов",
        "infoFiltered": "(выбрано из _MAX_ всего)",
        "infoPostFix": "",
        "thousands": " ",
        "lengthMenu": "Показать _MENU_ записей",
        "loadingRecords": "Загрузка...",
        "processing": "Обработка...",
        "search": "Поиск:",
        "zeroRecords": "Совпадения не найдены",
        "paginate": {
            "first": "Начало",
            "last": "Конец",
            "next": "Следующая",
            "previous": "Предыдущая"
        },
        "aria": {
            "sortAscending": ": нажмите для сортировки по возрастанию",
            "sortDescending": ": нажмите для сортировки по убыванию"
        }
    }

    $('.datatable').DataTable({
        language: dt['<?= \App::$Request->getLanguage() ?>']
    });
});
</script>
</body>
</html>