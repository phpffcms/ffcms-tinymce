<?php

namespace Apps\Controller\Api;

use Apps\Model\Api\Tinymce\FormUploadFile;
use Ffcms\Core\App;
use Ffcms\Core\Arch\Controller;
use Ffcms\Core\Exception\NativeException;
use Ffcms\Core\Helper\FileSystem\File;
use Ffcms\Core\Helper\Type\Any;
use Ffcms\Core\Helper\Type\Str;

/**
 * Class Tinymce
 * @package Apps\Controller\Admin
 */
class Tinymce extends Controller
{
    const UPLOAD_TYPES = [
        'images' => ['.jpg', '.jpeg', '.gif', '.png', '.bmp', '.svg'],
        'files' => ['.zip', '.rar', '.gz', '.tar', '.bz2', '.bz', '.doc', '.docx', '.xls', '.xlsx', '.txt', '.csv', '.odt', '.pdf', '.djvu'],
        'video' => ['.swf', '.fla', '.flv', '.mp4', 'mpeg4', '.ogg', '.mov', '.avi', '.webm', '.wmv', '.3gp']
    ];

    private $root;

    /**
     * Define current app root folder
     */
    public function before()
    {
        $this->root = realpath(__DIR__ . '/../../../');
        App::$Translate->append($this->root . '/i18n/Api/ru/Tinymce.php');
        $this->view->addFallback($this->root . '/Apps/View/Api/default/');
        parent::before();
    }

    /**
     * Browser /upload/ directory as admin or user with access rights
     * @param string $type
     * @return null|string
     * @throws NativeException
     */
    public function actionBrowse($type = 'images'): ?string
    {
        //$callbackId = $this->request->query->get('callbackId', false);
        if (!App::$User->isAuth() || !App::$User->identity()->role->can('global/file')) {
            throw new NativeException('Permission denied');
        }

        if (!array_key_exists($type, static::UPLOAD_TYPES) || !Any::isArray(static::UPLOAD_TYPES[$type])) {
            throw new NativeException('Wrong file type!');
        }

        // scan files with allowed extensions
        $files = File::listFiles('/upload/' . $type, static::UPLOAD_TYPES[$type]);
        // prepare relative URI from filesystem pathway
        $fileUri = null;
        foreach ($files as $file) {
            $newName = Str::sub($file, Str::length(root)+1);
            $fileUri[] = trim(Str::replace(DIRECTORY_SEPARATOR, '/', $newName), '/');
        }

        return $this->view->render('widgets/tinymce/browse', [
            'files' => $fileUri,
            'type' => $type
        ]);
    }

    /**
     *
     * @return null|string
     * @throws NativeException
     * @throws \Ffcms\Core\Exception\SyntaxException
     */
    public function actionUpload(): ?string
    {
        if (!App::$User->isAuth() || !App::$User->identity()->role->can('global/upload')) {
            throw new NativeException('Permission denied');
        }

        $allow = [];
        foreach (static::UPLOAD_TYPES as $extarray) {
            foreach ($extarray as $ext) {
                $allow[] = $ext;
            }
        }

        $model = new FormUploadFile();
        $path = null;
        if ($model->send() && $model->validate()) {
            $path = $model->make();
        }

        // render output view
        return $this->view->render('widgets/tinymce/upload', [
            'model' => $model,
            'path' => $path
        ]);
    }
}