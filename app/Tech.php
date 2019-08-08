<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Tech extends Model
{
    use CrudTrait;

    protected $fillable = [
        'type',
        'urgency',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserPhone()
    {
        try {
            $phone = $this->user->phone;
            return $phone;
        } catch (\Exception $e) {
            return '';
        }
    }

    public function getUserOrganization()
    {
        try {
            $name = $this->user->name;
            return $name;
        } catch (\Exception $e) {
            return '';
        }
    }

    public function openComments($crud = false)
    {
        return '<a class="btn btn-xs btn-default" href="' . route('tech.comments', ['id'=>$this->id]) . '" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i>Коментарі</a>';
    }

    public function calculateStatus()
    {
        $count = Comment::select(\DB::raw('DISCTINCT user_id'))->where('type', 'tech')
            ->where('commentable_id', $this->id)
            ->count();

        if($count >= 2) {
            $this->status = 1;
            $this->save();
        }
    }

    public function getStatusString()
    {
        if($this->status == 1) {
            return 'Завершено';
        }

        return 'В роботі';
    }
}
