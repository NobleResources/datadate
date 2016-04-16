<?php

namespace DataDate\Http\Responses;

use DataDate\File;

class FileResponse extends Response
{
    /**
     * FileResponse constructor.
     *
     * @param File $file
     * @param int  $code
     */
    public function __construct(File $file, $code = 200)
    {
        ob_start();
        readfile($file->getPath());
        $content = ob_get_clean();

        parent::__construct($content, $code, [
            'Content-Type'              => 'application/octet-stream',
            'Content-Length'            => $file->getSize(),
            'Content-Disposition'       => 'attachment; filename=' . $file->getName(),
            'Content-Description'       => 'File Transfer',
            'Content-Transfer-Encoding' => 'binary',
        ]);
    }
}