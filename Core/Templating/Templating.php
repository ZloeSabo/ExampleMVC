<?php

namespace Core\Templating;

use Core\Templating\Helper\HelperInterface;
use Core\DirectoryResolver;

class Templating implements \ArrayAccess
{
    private $defaultProperties = array(
        'title' => '',
        'page_title' => ''
    );

    protected $helpers = array();

    public function render($template, $variables, $layout = 'layout.html.php')
    {
        $content = '';

        extract($this->defaultProperties, EXTR_OVERWRITE);
        extract($variables, EXTR_OVERWRITE);

        $helper = $this;

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
            if(!file_exists($layout)) {
                throw new TemplatingException(sprintf("Layout does not exist: %s", $layout));
            }
            ob_start();
            include $layout;
            $content = ob_get_clean();
        }

        return $content;
    }

    public function addHelper(HelperInterface $helper)
    {
        $this->helpers[$helper->getName()] = $helper;
    }


    /* ArrayAccess stuff */
    public function offsetExists($offset)
    {
        return isset($this->helpers[$offset]);
    }

    public function offsetGet($offset)
    {
        if(!isset($this->helpers[$offset])) {
            throw new TemplatingException(sprintf('No helper loaded with name %s', $offset));
        }

        return $this->helpers[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->helpers[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        throw new TemplatingException(sprintf('Cannot unset helper'));
    }
}
