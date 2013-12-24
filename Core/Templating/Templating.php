<?php

namespace Core\Templating;

use Core\DirectoryResolver;

class Templating
{
    private $defaultProperties = array(
        'title' => '',
        'page_title' => ''
    );

    public function render($template, $variables, $layout = 'layout.html.php')
    {
        $content = '';

        extract($this->defaultProperties, EXTR_OVERWRITE);
        extract($variables, EXTR_OVERWRITE);


        if(!empty($template)) {
            list($directory, $templateName) = split('::', $template);

            $template = DirectoryResolver::instance()->getTemplatePath($templateName . '.html.php', $directory);

            ob_start();
            include $template;
            $content = ob_get_clean();
        }

        if(!empty($layout)) {
            $layout = DirectoryResolver::instance()->getTemplatePath($layout);
            ob_start();
            include $layout;
            $content = ob_get_clean();
        }

        return $content;
    }
}
