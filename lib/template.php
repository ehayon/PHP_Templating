<?php
/**
 * User: ethanhayon
 * Date: 11/7/12
 * Time: 6:36 PM
 */
class Template
{
    public $file;
    public $contents;
    protected $attributes = array();

    public function __construct($f) {
        $file = $f;
        if(($this->contents = @file_get_contents($this->file)) === false) {
            throw new Exception("Template file $f not found");
        }
    }

    public function set($attr, $value) {
        $this->attributes[$attr] = $value;
    }

    public function render() {
        foreach($this->attributes as $attr => $value) {
            $this->contents = str_replace($attr, $value, $this->contents);
        }
        return $this->contents;
    }

}
