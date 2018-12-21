<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Layout_library
{

    public $layoutFolder = 'template';
    public $layout = 'main';
    public $pageTitle = '';
    public $link = array();
    public $linksStyleSheet = array();
    public $linksJavascript = array();
    public $module = null;
    public $controller = null;
    public $CI;

    public function __construct()
    {
        if (!is_object($this->CI)) {
            $this->CI = &get_instance();
        }

        if ($this->module === null) {
            $this->module = $this->CI->router->fetch_module();
        }

        if ($this->controller === null) {
            $this->controller = $this->CI->router->fetch_class();
        }
    }

    public function setLayout($layout)
    {
        $this->layout = &$layout;
        return $this;
    }

    public function setLayoutFolder($layoutFolder)
    {
        $this->layoutFolder = &$layoutFolder;
        return $this;
    }

    public function setTitle($title)
    {
        $this->pageTitle = &$title;
        return $this;
    }

    public function setLink($attributes = array())
    {
        $this->link[] = '<link ' . join(' ', array_map(function ($key) use ($attributes) {
            if (is_bool($attributes[$key])) {
                return $attributes[$key] ? $key : '';
            }
            return $key . '="' . $attributes[$key] . '"';
        }, array_keys($attributes))) . '>';
        return $this;
    }

    public function setStyleSheet($link)
    {
        $this->linksStyleSheet[] = $link;
        return $this;
    }

    public function setJavascript($link)
    {
        $this->linksJavascript[] = $link;
        return $this;
    }

    public function view($v, $data = array())
    {
        $data['contentPath'] = ($this->module) ? $this->module . '/' . $v : $this->controller . '/' . $v;
        $data['pageTitle'] = $this->pageTitle;
        $data['linksStyleSheet'] = $this->linksStyleSheet;
        $data['linksJavascript'] = $this->linksJavascript;
        $data['links'] = $this->link;
        $this->CI->load->view($this->layoutFolder . '/' . $this->layout, $data);

    }

}
