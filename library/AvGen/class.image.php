<?php

/**
 * Class GDImage
 * Created Images with GD Library
 */
class GDImage extends stdClass {
    public $height      = 780;
    public $width       = 400;

    public function __construct() {

    }

    /**
     * Creates a Rectangle Background
     * defaults to white
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return resource
     */
    protected function _rectangleBackground(&$bg, $red = 255, $green = 255, $blue = 255) {
        /*$background = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($background, $red, $green, $blue);
        return imagefilledrectangle($background, 0, 0, $this->width, $this->height, $color);*/
    }
}