<?php

namespace Apps\Model\Api\Tinymce;

use Apps\Controller\Api\Tinymce;
use Ffcms\Core\Arch\Model;
use Ffcms\Core\Exception\SyntaxException;
use Ffcms\Core\Helper\Crypt;
use Ffcms\Core\Helper\Date;
use Ffcms\Core\Helper\FileSystem\Directory;
use Ffcms\Core\Helper\Type\Arr;

/**
 * Class FormUploadFile. Upload file via api tinymce over file browser
 * @package Apps\Model\Api\Tinymce
 */
class FormUploadFile extends Model
{
    /** @var \Symfony\Component\HttpFoundation\File\UploadedFile */
    public $file;

    // 20mb
    const MAX_SIZE = 20971520;

    /**
     * Validation rules
     * @return array
     */
    public function rules(): array
    {
        $extByTypes = Tinymce::UPLOAD_TYPES;
        $allExt = [];
        foreach ($extByTypes as $extArray) {
            foreach ($extArray as $ext) {
                $allExt[] = trim($ext, '.');
            }
        }

        return [
            ['file', 'required'],
            ['file', 'isFile', $allExt],
            ['file', 'sizeFile', [1, static::MAX_SIZE]]
        ];
    }

    /**
     * Define sources of input data
     * @return array
     */
    public function sources(): array
    {
        return [
            'file' => 'file'
        ];
    }

    /**
     * @return array
     */
    public function labels(): array
    {
        return [
            'file' => __('File')
        ];
    }

    /**
     * @throws SyntaxException
     */
    public function make(): ?string
    {
        $ext = $this->file->guessExtension();
        if (!$ext) {
            throw new SyntaxException(__('File has unknown type!!! Hack attempt!'));
        }

        $uploadFolder = null;
        foreach (Tinymce::UPLOAD_TYPES as $folder => $extArray) {
            if (Arr::in('.' . $ext, $extArray)) {
                $uploadFolder = $folder;
            }
        }

        // generate file path and random file name
        $path = '/upload/' . $uploadFolder . '/' . Date::convertToDatetime(time(), 'd-m-Y');
        if (!Directory::exist($path)) {
            Directory::create($path);
        }

        $fileName = Crypt::randomString(mt_rand(12, 32)) . '.' . $ext;

        $this->file->move(root . $path, $fileName);
        return $path . '/' . $fileName;
    }
}