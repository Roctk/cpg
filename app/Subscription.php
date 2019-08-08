<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'course_id'];

    protected $datesConvert = ['created_at', 'updated_at'];

//    public function save(array $options = [])
//    {
//        if(isset($this->datesConvert)){
//            foreach($this->datesConvert as $date){
//                $this->attributes[$date] = \Carbon\Carbon::parse($this->attributes[$date])->format('d.m.Y G:i');
//            }
//        }
//
//        parent::save($options);
//
//    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if(isset($this->attributes[$key])){
            if(isset($this->datesConvert)  &&  in_array($key, $this->datesConvert)){
                $value = \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y G:i');
            }
        }

        return $value;
    }
}
