<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text', 'type', 'user_id', 'commentable_id', 'photo'];

    public function user()
    {
        return $this->belongsTo(AdminUser::class, 'user_id');
    }
}
