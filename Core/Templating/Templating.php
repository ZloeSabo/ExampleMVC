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
            list($directory, $templateName) = explode('::', $template);

            $template = DirectoryResolver::instance()->getTemplatePath($templateName . '.html.php', $directory);
            if(!file_exists($template)) {
                throw new TemplatingException(sprintf("Template does not exist: %s/%s", $directory, $templateName));
            }
            

            ob_start();
            include $template;
            $content = ob_get_clean();
        }

        if(!empty($layout)) {
            $layout = DirectoryResolver::instance()->getTemplatePath($layout);
            if(!file_exists($template)) {
                throw new TemplatingException(sprintf("Layout does not exist: %s", $layout));
            }
            ob_start();
            include $layout;
            $content = ob_get_clean();
        }

        return $content;
    }
}
