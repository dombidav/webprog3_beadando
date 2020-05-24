<?php


namespace App\Helpers;


use Illuminate\Http\UploadedFile;

class JsonUtil
{
    /**
     * @param UploadedFile $file
     * @return mixed
     */
    public static function objectFrom(UploadedFile $file)
    {
        //$file->move(storage_path('upload/json/'), $file->getClientOriginalName()); //Igazából nem is kell tárolni...
        $stream = $file->openFile();
        $stream->next();
        $line = $stream->getCurrentLine();
        return json_decode($line);
    }
}
