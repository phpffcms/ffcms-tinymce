<?php

namespace Widgets\Tinymce;

use Ffcms\Core\App;
use Ffcms\Core\Arch\Widget as AbstractWidget;


class Tinymce extends AbstractWidget
{
    const VERSION = '4.5.1';
	public $targetClass;
    public $language;
    public $config;
    public $jsConfig;
    private $baseUrl;

    /**
     * Pass init params and initialize object
     * @return void
     */
	public function init(): void
	{
		if ($this->language === null) {
			$this->language = App::$Request->getLanguage();
		}
        if ($this->targetClass === null) {
            $this->targetClass = 'wysiwyg';
        }
        if ($this->config === null || !Arr::in($this->config, ['config-small', 'config-full', 'config-medium'])) {
            $this->config = 'config-default';
        }
        $this->baseUrl = App::$Alias->scriptUrl . '/vendor/phpffcms/ffcms-ckeditor/assets';
    }
    
    /**
     * Render tinymce html/js features 
     * @return string|null
     */
	public function display(): ?string 
	{
        return null;
	}
}