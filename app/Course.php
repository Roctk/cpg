<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Course extends Model
{
    use CrudTrait;

    const DATE_FORMAT = 'd.m.Y G:i';

    protected $fillable = ['name', 'description', 'photo', 'price', 'date_time', 'date_time_end', 'is_adv'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            if(!empty($obj->photo)) {
                \Storage::disk('uploads')->delete('uploads/' . $obj->photo);
            }
        });
    }

//    public function getDateFormatString()
//    {
//        return 'd.m.Y G:i';
//    }

    public static function uploadPhoto(UploadedFile $value)
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

//            // 0. Make the image
//            $image = \Image::make($value);
//            // 1. Generate a filename.
//            $filename = md5($value.time()).'.jpg';
//            // 2. Store the image on disk.
//            \Storage::disk($disk)->put($filename, $image->stream());
//            // 3. Save the path to the database
//            $this->attributes[$attribute_name] = 'uploads/'.$filename;

    }

//    public function setPhotoAttribute($value)
//    {
//        $attribute_name = "photo";
//        $disk = 'uploads';
//
//
//        // if the image was erased
//        if ($value==null) {
//            // delete the image from disk
//            \Storage::disk($disk)->delete($this->{$attribute_name});
//
//            // set null in the database column
//            $this->attributes[$attribute_name] = null;
//        }
//
//        // if a base64 was sent, store it in the db
//        if (starts_with($value, 'data:image'))
//        {
//            $splited = explode(',', substr( $value , 5 ) , 2);
//            $mime=$splited[0];
//            $data=$splited[1];
//
//            $mime_split_without_base64=explode(';', $mime,2);
//            $mime_split=explode('/', $mime_split_without_base64[0],2);
//            if(count($mime_split)==2)
//            {
//                $extension=$mime_split[1];
//                if($extension=='jpeg')$extension='jpg';
//                //if($extension=='javascript')$extension='js';
//                //if($extension=='text')$extension='txt';
//                $filename=md5(str_random().time()).'.'.$extension;
//                \Storage::disk($disk)->put($filename, base64_decode($data));
//                $this->attributes[$attribute_name] = 'uploads/'.$filename;
//            } else {
//                throw new \Exception('incorrect image data');
//            }
//
////            // 0. Make the image
////            $image = \Image::make($value);
////            // 1. Generate a filename.
////            $filename = md5($value.time()).'.jpg';
////            // 2. Store the image on disk.
////            \Storage::disk($disk)->put($filename, $image->stream());
////            // 3. Save the path to the database
////            $this->attributes[$attribute_name] = 'uploads/'.$filename;
//        }
//    }
}
