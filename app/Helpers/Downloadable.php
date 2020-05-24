<?php


namespace App\Helpers;


class Downloadable{
    /** @var string $filename */
    public $filename;
    /**
     * @var string
     */
    public $content;

    public function __construct($filename, $content = '')
    {
        $this->filename = $filename;
        $this->content = $content;
    }

    public function __toString()
    {
        return $this->content;
    }

    public function download(){
        header('Content-Disposition: attachment; filename="' . $this->filename . '"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");
        echo $this->content;
    }
}

