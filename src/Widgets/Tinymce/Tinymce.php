<?php

namespace Widgets\Tinymce;

use Ffcms\Core\App;
use Ffcms\Core\Arch\Widget as AbstractWidget;
use Ffcms\Core\Helper\Type\Arr;

/**
 * Class Tinymce. TinyMCE widget for FFCMS
 * @package Widgets\Tinymce
 */
class Tinymce extends AbstractWidget
{
    const VERSION = '4.8.2';

	public $targetClass;
    public $language;
    public $config;

    private $baseUrl;
    private $root;
    private $env;

    /**
     * Pass init params and initialize object
     * @return void
     */
	public function init(): void
	{
		if (!$this->language) {
			$this->language = App::$Request->getLanguage();
		}
        if (!$this->targetClass) {
            $this->targetClass = 'wysiwyg';
        }
        if (!$this->config || !Arr::in($this->config, ['small', 'full', 'medium'])) {
            $this->config = 'small';
        }

        $this->baseUrl = App::$Alias->scriptUrl . '/vendor/phpffcms/ffcms-tinymce/assets';
        $this->root = realpath(__DIR__ . '/../../');
        $this->env = env_name ?? 'Front';
    }
    
    /**
     * Render tinymce html/js features 
     * @return string|null
     */
	public function display(): ?string 
	{
	    App::$View->addFallback($this->root . '/Apps/View/' . $this->env . '/default');
        return App::$View->render('widgets/tinymce/' . $this->config);
	}
}