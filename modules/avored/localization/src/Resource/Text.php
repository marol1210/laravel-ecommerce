<?php
namespace AvoRed\Localization\Resource;

use \AvoRed\Localization\Contact\Material;

class Text implements Material
{

    public $title = '';
    public $content = '';
    private $type = \AvoRed\Localization\Constant::RESOURCE_TYPE_TEXT;
    

    public function __construct($title, $contents)
    {
        $this->title = $title;
        $this->content = $contents;
    }

    public function serialize()
    {
        return serialize(json_encode($this));
    }

    public function unserialize($data)
    {  
        $this->data = json_decode(unserialize($data));
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}