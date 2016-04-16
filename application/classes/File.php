<?php

namespace DataDate;


use Exception;
use SplFileInfo;

class File
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $mime;
    /**
     * @var string
     */
    private $path;
    /**
     * @var int
     */
    private $size;

    /**
     * File constructor.
     */
    private function __construct()
    {
        
    }
    
    /**
     * @param $description
     *
     * @return File
     */
    public static function fromDescription($description)
    {
        $file = new File();

        $file->name = $description['name'];
        $file->mime = $description['type'];
        $file->size = $description['size'];
        $file->path = $description['tmp_name'];

        return $file;
    }

    /**
     * @param $path
     *
     * @return File
     */
    public static function fromPath($path)
    {
        $file = new File();
        $info = new SplFileInfo($path);

        $file->path = $path;
        $file->mime = mime_content_type($path);
        $file->name = $info->getBasename();
        $file->size = $info->getSize();

        return $file;
    }

    /**
     * @param $to
     *
     * @return mixed
     * @throws Exception
     *
     */
    public function move($to)
    {
        if (!rename($this->path, $to)) {
            throw new Exception(sprintf("Failed to move file from '%s' to '%s'.", $this->path, $to));
        }

        $this->path = $to;
    }

    /**
     * @return bool
     */
    public function isImage()
    {
        return strpos($this->mime, 'image/') === 0;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        $explosion = explode('.', $this->name);

        return count($explosion) > 1 ? array_last($explosion) : '';
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}