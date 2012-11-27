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
        $this->file = $f;
        if(($this->contents = @file_get_contents($this->file)) === false) {
            throw new Exception("Template file $f not found");
        }

    }

    public function set($attr, $value) {
        $this->attributes[$attr] = $value;
    }
    public function render() {
		// check to see if there is a layout defined
		// look for %%layout:<path>%%
        foreach($this->attributes as $attr => $value) {
            $this->contents = str_replace('['.$attr.']', $value, $this->contents);
        }

		$matches = array();
		preg_match('/\%\%layout:(.+)\%\%/', $this->contents, $matches);
		if(count($matches) > 1) {
			$this->contents = preg_replace('/\%\%layout:(.+)\%\%/', '', $this->contents);

			preg_match_all('/{(.+)}(.*){\/\1}/s', $this->contents, $m);
			$layout = new Template($matches[1]);
			foreach($m[0] as $key) {
				preg_match('/{(.+)}(.*){\/\1}/s', $key, $tmp);
				$layout->set($tmp[1], $tmp[2]);
			}
			return $layout->render();	
		}
        return $this->contents;
    }

    public function values($attributes) {
        $this->attributes = $attributes;
    }

}
