<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Created by PhpStorm.
 * User: Vic
 * Date: 20.06.2019
 * Time: 22:18
 */

class FileUploader
{
    public function upload(UploadedFile $value)
    {
        $attribute_name = "photo";
        $disk = 'uploads';


        // if the image was erased
        if ($value==null) {
            // delete the image from disk
//            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            return null;
        }

        $filename=md5(str_random().time()).'.'.$value->getClientOriginalExtension();
        \Storage::disk($disk)->putFileAs('uploads', $value, $filename);
        return 'uploads/'.$filename;

    }
}